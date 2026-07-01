<?php
// Assets/Media list
?>

<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-bold text-slate-900">Media & Assets</h3>
    <button onclick="document.getElementById('uploadForm').style.display = 'block'" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition">
        <i class="fas fa-upload mr-2"></i>Upload File
    </button>
</div>

<!-- Upload Form Modal -->
<div id="uploadForm" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl">
        <h4 class="text-lg font-bold text-slate-900 mb-4">Upload Assets</h4>
        <form method="POST" action="<?= url('admin/assets/upload') ?>" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Files *</label>
                <label id="assetDropZone" for="assetFiles" class="block border-2 border-dashed border-slate-300 rounded-xl p-8 text-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/40 transition">
                    <i class="fas fa-cloud-arrow-up text-4xl text-emerald-600 mb-3"></i>
                    <span class="block font-semibold text-slate-900">Drag and drop files here, or click to browse</span>
                    <span class="block text-xs text-slate-600 mt-1">Select multiple files. Max 5MB each. Allowed: JPG, PNG, GIF, PDF</span>
                </label>
                <input id="assetFiles" type="file" name="files[]" multiple required accept="image/jpeg,image/png,image/gif,application/pdf" class="sr-only">
            </div>

            <div id="assetPreviewList" class="hidden grid grid-cols-1 sm:grid-cols-2 gap-3"></div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Shared Alt Text</label>
                <input type="text" name="alt_text" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Image description">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-900 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Optional description"></textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg transition">
                    <i class="fas fa-upload mr-2"></i>Upload
                </button>
                <button type="button" onclick="document.getElementById('uploadForm').style.display = 'none'" class="flex-1 bg-slate-300 hover:bg-slate-400 text-slate-900 font-semibold py-2 rounded-lg transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        var dropZone = document.getElementById('assetDropZone');
        var input = document.getElementById('assetFiles');
        var previewList = document.getElementById('assetPreviewList');

        if (!dropZone || !input || !previewList) {
            return;
        }

        function renderPreviews(files) {
            previewList.innerHTML = '';
            if (!files.length) {
                previewList.classList.add('hidden');
                return;
            }

            previewList.classList.remove('hidden');
            Array.prototype.forEach.call(files, function (file) {
                var item = document.createElement('div');
                item.className = 'border border-slate-200 rounded-lg p-3 flex gap-3 items-center bg-slate-50';

                var thumb = document.createElement('div');
                thumb.className = 'w-16 h-16 rounded bg-white border border-slate-200 overflow-hidden flex items-center justify-center shrink-0';

                if (file.type.indexOf('image/') === 0) {
                    var img = document.createElement('img');
                    img.className = 'w-full h-full object-cover';
                    img.alt = '';
                    img.src = URL.createObjectURL(file);
                    img.onload = function () {
                        URL.revokeObjectURL(img.src);
                    };
                    thumb.appendChild(img);
                } else {
                    thumb.innerHTML = '<i class="fas fa-file-pdf text-red-500 text-2xl"></i>';
                }

                var details = document.createElement('div');
                details.className = 'min-w-0';
                details.innerHTML = '<p class="text-sm font-semibold text-slate-900 truncate"></p><p class="text-xs text-slate-500"></p>';
                details.querySelector('p:first-child').textContent = file.name;
                details.querySelector('p:last-child').textContent = (file.size / 1024).toFixed(2) + ' KB';

                item.appendChild(thumb);
                item.appendChild(details);
                previewList.appendChild(item);
            });
        }

        input.addEventListener('change', function () {
            renderPreviews(input.files);
        });

        ['dragenter', 'dragover'].forEach(function (eventName) {
            dropZone.addEventListener(eventName, function (event) {
                event.preventDefault();
                dropZone.classList.add('border-emerald-500', 'bg-emerald-50');
            });
        });

        ['dragleave', 'drop'].forEach(function (eventName) {
            dropZone.addEventListener(eventName, function (event) {
                event.preventDefault();
                dropZone.classList.remove('border-emerald-500', 'bg-emerald-50');
            });
        });

        dropZone.addEventListener('drop', function (event) {
            if (event.dataTransfer && event.dataTransfer.files.length) {
                input.files = event.dataTransfer.files;
                renderPreviews(input.files);
            }
        });
    })();
</script>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php if (!empty($assets)): ?>
        <?php foreach ($assets as $asset): ?>
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <?php if ($asset['asset_type'] === 'image'): ?>
                    <img src="<?= htmlspecialchars(media_url($asset['filepath'])) ?>" alt="<?= htmlspecialchars($asset['alt_text'] ?? '') ?>" class="w-full h-40 object-cover rounded-t-lg">
                <?php else: ?>
                    <div class="w-full h-40 bg-slate-200 rounded-t-lg flex items-center justify-center">
                        <i class="fas fa-file text-4xl text-slate-400"></i>
                    </div>
                <?php endif; ?>
                
                <div class="p-4">
                    <p class="font-semibold text-slate-900 text-sm truncate"><?= htmlspecialchars($asset['original_name']) ?></p>
                    <p class="text-xs text-slate-600 mb-3"><?= number_format($asset['file_size'] / 1024, 2) ?> KB</p>

                    <form method="POST" action="<?= url("admin/assets/{$asset['id']}/update") ?>" class="space-y-2">
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                        <input type="text" name="alt_text" value="<?= htmlspecialchars($asset['alt_text'] ?? '') ?>" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Alt text">
                        <textarea name="description" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Description"><?= htmlspecialchars($asset['description'] ?? '') ?></textarea>
                        <button type="submit" class="text-emerald-600 hover:text-emerald-800 font-semibold text-sm">
                            <i class="fas fa-save mr-1"></i>Save
                        </button>
                    </form>
                    
                    <div class="mt-4 flex gap-2">
                        <form method="POST" action="<?= url("admin/assets/{$asset['id']}/delete") ?>" style="display:inline;" onsubmit="return confirm('Delete this asset?');">
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                            <button type="submit" class="flex-1 text-red-600 hover:text-red-800 transition font-semibold text-sm">
                                <i class="fas fa-trash mr-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="lg:col-span-4 bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-image text-5xl text-slate-300 mb-4"></i>
            <p class="text-slate-600">No assets uploaded yet</p>
        </div>
    <?php endif; ?>
</div>
