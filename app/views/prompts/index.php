<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Prompts</h1>
            <p class="text-slate-500 mt-1">Manage and organize your AI prompts efficiently.</p>
        </div>
        <a href="<?= BASE_URL ?>/prompts/create" 
           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg shadow-sm hover:shadow transition transform hover:-translate-y-0.5">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            New Prompt
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200">
        <form action="<?= BASE_URL ?>/prompts" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" 
                        class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition" 
                        placeholder="Search prompts...">
                </div>
            </div>
            
            <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0">
                <select name="category_id" onchange="this.form.submit()" class="pl-3 pr-8 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($filters['category_id']) && $filters['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="type" onchange="this.form.submit()" class="pl-3 pr-8 py-2.5 border border-slate-200 rounded-lg text-sm bg-slate-50 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Types</option>
                    <option value="Text" <?= (isset($filters['type']) && $filters['type'] == 'Text') ? 'selected' : '' ?>>Text</option>
                    <option value="Image" <?= (isset($filters['type']) && $filters['type'] == 'Image') ? 'selected' : '' ?>>Image</option>
                    <option value="Code" <?= (isset($filters['type']) && $filters['type'] == 'Code') ? 'selected' : '' ?>>Code</option>
                    <option value="Audio" <?= (isset($filters['type']) && $filters['type'] == 'Audio') ? 'selected' : '' ?>>Audio</option>
                    <option value="Video" <?= (isset($filters['type']) && $filters['type'] == 'Video') ? 'selected' : '' ?>>Video</option>
                </select>
                 <?php if(!empty($search) || !empty($filters['category_id']) || !empty($filters['type'])): ?>
                    <a href="<?= BASE_URL ?>/prompts" class="px-4 py-2.5 bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 font-medium rounded-lg text-sm transition">
                        Reset
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Prompts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        <?php if (empty($prompts)): ?>
            <div class="col-span-full py-20 text-center text-slate-500 bg-white rounded-2xl shadow-sm border border-slate-100">
                <div class="bg-indigo-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">No prompts found</h3>
                <p class="text-slate-400 mb-6 max-w-sm mx-auto">Get started by creating your first prompt to build your collection.</p>
                <a href="<?= BASE_URL ?>/prompts/create" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition shadow-lg shadow-indigo-200">
                    Create New Prompt
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($prompts as $prompt): ?>
                <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_25px_-5px_rgba(0,0,0,0.1),0_10px_10px_-5px_rgba(0,0,0,0.04)] border border-slate-100 transition-all duration-300 flex flex-col items-center text-center h-full group relative overflow-hidden">
                    
                    <!-- Cover Image -->
                    <div class="w-full aspect-video bg-slate-50 relative group-hover:scale-105 transition-transform duration-500 overflow-hidden rounded-t-2xl">
                        <a href="<?= BASE_URL ?>/prompts/view?id=<?= $prompt['id'] ?>" class="block w-full h-full cursor-pointer">
                            <?php if(!empty($prompt['image_path'])): ?>
                                <img src="<?= public_url($prompt['image_path']) ?>" alt="<?= htmlspecialchars($prompt['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-<?= $prompt['category_color'] ?>-50">
                                    <span class="text-4xl font-bold text-<?= $prompt['category_color'] ?>-200">
                                        <?= substr($prompt['platform'], 0, 1) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </a>
                        
                         <!-- Favorite Toggle (Absolute) -->
                        <a href="<?= BASE_URL ?>/prompts/favorite?id=<?= $prompt['id'] ?>" class="absolute top-3 right-3 p-2 rounded-full bg-white/80 backdrop-blur-sm hover:bg-white text-slate-400 hover:text-yellow-400 transition shadow-sm z-10" title="Favorite">
                             <svg class="w-5 h-5 <?= $prompt['is_favorite'] ? 'text-yellow-400 fill-current' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </a>

                        <!-- Category Badge (Absolute) -->
                        <span class="absolute top-3 left-3 bg-<?= $prompt['category_color'] ?? 'indigo' ?>-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm z-10 uppercase tracking-wider">
                            <?= htmlspecialchars($prompt['category_name']) ?>
                        </span>
                    </div>
                    
                    <div class="p-4 flex flex-col items-center w-full">
                    
                        <!-- Title -->
                        <h3 class="font-bold text-lg text-slate-800 mb-2 line-clamp-1 w-full px-2" title="<?= htmlspecialchars($prompt['title']) ?>">
                            <a href="<?= BASE_URL ?>/prompts/view?id=<?= $prompt['id'] ?>" class="hover:text-indigo-600 transition">
                                <?= htmlspecialchars($prompt['title']) ?>
                            </a>
                        </h3>
                        
                        <!-- Key Meta Badges -->
                        <div class="flex flex-wrap justify-center gap-2 mb-5">
                            <span class="px-3 py-1 rounded-lg bg-pink-50 border border-pink-100 text-pink-500 text-xs font-semibold">
                                <?= htmlspecialchars($prompt['platform']) ?>
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-pink-50 border border-pink-100 text-pink-500 text-xs font-semibold">
                                <?= htmlspecialchars($prompt['type']) ?>
                            </span>
                        </div>
    
                        <!-- Action Buttons -->
                        <div class="w-full space-y-2 mt-auto">
                            <a href="<?= BASE_URL ?>/prompts/view?id=<?= $prompt['id'] ?>" 
                               class="block w-full py-2.5 rounded-xl bg-indigo-50 text-indigo-600 font-medium text-sm hover:bg-indigo-100 transition">
                                View Details
                            </a>
                            
                            <!-- <div class="grid grid-cols-2 gap-2">
                                 <button onclick="navigator.clipboard.writeText(`<?= str_replace('`', '\`', $prompt['content']) ?>`); this.innerText = 'Copied!'; setTimeout(() => this.innerText = 'Copy', 1500);" 
                                    class="w-full py-2.5 rounded-xl bg-slate-50 text-slate-600 font-medium text-sm hover:bg-slate-100 transition">
                                    Copy
                                </button>
                                 <a href="<?= BASE_URL ?>/prompts/edit?id=<?= $prompt['id'] ?>" 
                                    class="w-full py-2.5 rounded-xl bg-slate-50 text-slate-600 font-medium text-sm hover:bg-slate-100 transition flex items-center justify-center">
                                    Edit
                                </a>
                            </div> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <?php 
    $totalPages = $pagination['totalPages'] ?? 1;
    $page = $pagination['page'] ?? 1;
    
    if ($totalPages > 1): 
        // Build query string for pagination links
        $queryParams = $_GET;
        unset($queryParams['page']);
        $queryString = http_build_query($queryParams);
        $baseUrl = BASE_URL . '/prompts?' . ($queryString ? $queryString . '&' : '');
    ?>
    <div class="flex justify-center mt-10">
        <nav class="flex items-center space-x-2 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
            
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
                <a href="<?= $baseUrl . 'page=' . ($page - 1) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            <?php else: ?>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 cursor-not-allowed border border-slate-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php
            $range = 2; // Number of pages around current page
            $start = max(1, $page - $range);
            $end = min($totalPages, $page + $range);
            
            if ($start > 1) {
                echo '<a href="' . $baseUrl . 'page=1" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">1</a>';
                if ($start > 2) {
                    echo '<span class="px-2 text-slate-400 text-xs">...</span>';
                }
            }
            
            for ($i = $start; $i <= $end; $i++):
            ?>
                <?php if ($i == $page): ?>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white font-medium shadow-md shadow-indigo-200 cursor-default"><?= $i ?></button>
                <?php else: ?>
                    <a href="<?= $baseUrl . 'page=' . $i ?>" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php
            if ($end < $totalPages) {
                if ($end < $totalPages - 1) {
                     echo '<span class="px-2 text-slate-400 text-xs">...</span>';
                }
                echo '<a href="' . $baseUrl . 'page=' . $totalPages . '" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition">' . $totalPages . '</a>';
            }
            ?>

            <!-- Next Button -->
             <?php if ($page < $totalPages): ?>
                <a href="<?= $baseUrl . 'page=' . ($page + 1) ?>" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition border border-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            <?php else: ?>
                <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-400 cursor-not-allowed border border-slate-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            <?php endif; ?>
            
        </nav>
    </div>
    <?php endif; ?>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
