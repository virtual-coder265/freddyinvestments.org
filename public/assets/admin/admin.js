(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initMobileNav();
        initNavGroups();
        initTabs();
        initImageSelects();
        initMediaPicker();
        initConfirmForms();
        initDirtyForms();
    });

    function initMobileNav() {
        var toggle = document.getElementById('admin-menu-toggle');
        var sidebar = document.getElementById('admin-sidebar');
        var overlay = document.getElementById('admin-sidebar-overlay');

        if (!toggle || !sidebar) return;

        function open() {
            sidebar.classList.add('is-open');
            if (overlay) overlay.classList.add('is-visible');
        }

        function close() {
            sidebar.classList.remove('is-open');
            if (overlay) overlay.classList.remove('is-visible');
        }

        toggle.addEventListener('click', function () {
            sidebar.classList.contains('is-open') ? close() : open();
        });

        if (overlay) overlay.addEventListener('click', close);
    }

    function initNavGroups() {
        document.querySelectorAll('[data-nav-group-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var group = btn.closest('.admin-nav-group');
                if (group) group.classList.toggle('is-open');
            });
        });
    }

    function initTabs() {
        document.querySelectorAll('[data-admin-tabs]').forEach(function (container) {
            var tabs = container.querySelectorAll('[data-tab]');
            var panels = container.querySelectorAll('[data-tab-panel]');

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    var target = tab.getAttribute('data-tab');
                    tabs.forEach(function (t) { t.classList.remove('active'); });
                    panels.forEach(function (p) { p.classList.remove('active'); });
                    tab.classList.add('active');
                    var panel = container.querySelector('[data-tab-panel="' + target + '"]');
                    if (panel) panel.classList.add('active');
                });
            });
        });
    }

    function initImageSelects() {
        document.querySelectorAll('.cms-image-select').forEach(function (select) {
            select.addEventListener('change', function () {
                updateImagePreview(select);
            });
        });
    }

    function updateImagePreview(select) {
        var preview = document.getElementById(select.dataset.previewTarget);
        if (!preview) return;

        var option = select.options[select.selectedIndex];
        var previewUrl = option ? option.dataset.preview : '';
        var emptyLabel = preview.parentElement.querySelector('.cms-image-empty');

        if (previewUrl) {
            preview.src = previewUrl;
            preview.style.display = 'block';
            if (emptyLabel) emptyLabel.style.display = 'none';
        } else {
            preview.removeAttribute('src');
            preview.style.display = 'none';
            if (emptyLabel) emptyLabel.style.display = 'block';
        }
    }

    function initMediaPicker() {
        var modal = document.getElementById('admin-media-modal');
        if (!modal) return;

        var backdrop = modal.querySelector('.admin-modal-backdrop');
        var closeBtn = modal.querySelector('[data-media-modal-close]');
        var activeInput = null;
        var activePreview = null;

        document.querySelectorAll('[data-media-picker-trigger]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                activeInput = document.getElementById(btn.dataset.targetInput);
                activePreview = document.getElementById(btn.dataset.targetPreview);
                modal.classList.add('is-open');
            });
        });

        function closeModal() {
            modal.classList.remove('is-open');
            activeInput = null;
            activePreview = null;
        }

        if (backdrop) backdrop.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        modal.querySelectorAll('[data-media-select]').forEach(function (item) {
            item.addEventListener('click', function () {
                if (!activeInput) return;
                var id = item.dataset.mediaSelect;
                var url = item.dataset.mediaUrl || '';
                activeInput.value = id;

                var select = activeInput.closest('.admin-image-picker');
                if (select) {
                    var nativeSelect = select.querySelector('select');
                    if (nativeSelect) {
                        nativeSelect.value = id;
                        updateImagePreview(nativeSelect);
                    }
                }

                if (activePreview && url) {
                    activePreview.innerHTML = '<img src="' + url + '" alt="">';
                }

                closeModal();
            });
        });
    }

    function initConfirmForms() {
        document.querySelectorAll('[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                var msg = form.getAttribute('data-confirm') || 'Are you sure?';
                if (!window.confirm(msg)) e.preventDefault();
            });
        });
    }

    function initDirtyForms() {
        document.querySelectorAll('[data-admin-form]').forEach(function (form) {
            var dirty = false;
            form.addEventListener('change', function () { dirty = true; });
            form.addEventListener('input', function () { dirty = true; });
            window.addEventListener('beforeunload', function (e) {
                if (dirty) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
            form.addEventListener('submit', function () { dirty = false; });
        });
    }
})();
