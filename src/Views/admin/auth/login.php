<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin Login') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 to-slate-800 min-h-screen flex items-center justify-center">
    <?php $adminEntryPath = parse_url(admin_url(), PHP_URL_PATH) ?: '/admin'; ?>
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900">Freddy Admin</h1>
                <p class="text-slate-600 mt-2">Management Dashboard</p>
                <p class="text-xs text-slate-500 mt-3">
                    Direct admin access:
                    <a href="<?= admin_url() ?>" class="font-semibold text-emerald-700 hover:text-emerald-600 transition"><?= htmlspecialchars($adminEntryPath) ?></a>
                </p>
            </div>

            <?php if (isset($_SESSION['auth_message'])): ?>
                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg text-blue-700 flex items-center">
                    <i class="fas fa-circle-info mr-3"></i>
                    <?= htmlspecialchars($_SESSION['auth_message']) ?>
                </div>
                <?php unset($_SESSION['auth_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['login_error'])): ?>
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <?= htmlspecialchars($_SESSION['login_error']) ?>
                </div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['logout_message'])): ?>
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-700 flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <?= htmlspecialchars($_SESSION['logout_message']) ?>
                </div>
                <?php unset($_SESSION['logout_message']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= admin_url('login-process') ?>" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username or Email</label>
                    <input type="text" name="username" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter your username">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Enter your password">
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-lg transition duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200">
                <p class="text-xs text-slate-600 text-center">
                    <strong>⚠️ Security Notice:</strong><br>
                    Use your assigned credentials to log in.
                </p>
            </div>
        </div>

        <div class="text-center mt-6 text-slate-400 text-sm">
            <p>&copy; <?= date('Y') ?> Freddy Investments. All rights reserved.</p>
            <a href="<?= url('/') ?>" class="text-emerald-400 hover:text-emerald-300 transition">Back to Website</a>
        </div>
    </div>
</body>
</html>
