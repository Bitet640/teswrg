<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="min-h-[80vh] flex flex-col items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden glass-card p-8 border border-white/20">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-500 to-purple-600 mb-2">Login</h1>
            <p class="text-slate-500 text-sm">Welcome back to your Prompt Manager</p>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 text-center">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/login" method="POST" class="space-y-6">
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                <input type="text" name="username" id="username" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition text-sm text-slate-900" 
                    placeholder="Enter your username">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required 
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition text-sm text-slate-900" 
                    placeholder="Enter your password">
            </div>

            <button type="submit" 
                class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 mt-2">
                Sign In
            </button>
        </form>
    </div>
    <div class="mt-6 text-center text-xs text-slate-400">
        <p>Default Login: admin / password</p>
    </div>
</div>
