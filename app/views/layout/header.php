<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= defined('APP_NAME') ? APP_NAME : 'Prompt Management' ?></title>
    <!-- AI Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236366f1%22 stroke-width=%221.5%22><path stroke-linecap=%22round%22 stroke-linejoin=%22round%22 d=%22M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z%22 /></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen">
    <?php if(isset($_SESSION['user_id'])): ?>
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="<?= BASE_URL ?>" class="flex items-center gap-2 hover:opacity-80 transition group">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center text-white shadow-md group-hover:shadow-lg transition">
                         <!-- AI Sparkle Icon -->
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                        </svg>
                    </div>
                    <span class="font-bold text-xl bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-purple-600">PromptManager</span>
                </a>

                <!-- Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="<?= BASE_URL ?>/prompts" class="text-slate-600 hover:text-primary-600 font-medium transition">Prompts</a>
                    <a href="<?= BASE_URL ?>/categories" class="text-slate-600 hover:text-primary-600 font-medium transition">Categories</a>
                    <a href="<?= BASE_URL ?>/platforms" class="text-slate-600 hover:text-primary-600 font-medium transition">Platforms</a>
                </div>

                <!-- User Profile -->
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-slate-500 hidden sm:block">Hi, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?></span>
                    <a href="<?= BASE_URL ?>/logout" class="text-sm font-medium text-red-500 hover:text-red-600 transition">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="md:hidden border-b border-slate-200 bg-white">
         <div class="flex justify-around py-2">
            <a href="<?= BASE_URL ?>/prompts" class="text-sm font-medium text-slate-600">Prompts</a>
            <a href="<?= BASE_URL ?>/categories" class="text-sm font-medium text-slate-600">Categories</a>
            <a href="<?= BASE_URL ?>/platforms" class="text-sm font-medium text-slate-600">Platforms</a>
         </div>
    </div>
    <?php endif; ?>

    <!--Made by Jupri Maulana-->

    <main class="flex-grow container mx-auto px-4 py-8">
