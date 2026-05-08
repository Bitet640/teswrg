<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="max-w-5xl mx-auto">
    <!-- Breadcrumb / Back -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <a href="<?= BASE_URL ?>/prompts" class="inline-flex items-center text-slate-500 hover:text-indigo-600 transition font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Sidebar: Meta Info & Actions -->
        <div class="lg:col-span-4 space-y-6 order-last lg:order-first">
            <!-- Main Info Card -->
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 p-6 text-center relative overflow-hidden">
                <!-- Cover Image -->
                <?php if(!empty($prompt['image_path'])): ?>
                     <div class="w-full aspect-video relative group mb-6 rounded-xl overflow-hidden shadow-sm">
                         <img src="<?= public_url($prompt['image_path']) ?>" class="w-full h-full object-cover">
                         <div onclick="openImageModal('<?= public_url($prompt['image_path']) ?>')" class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 cursor-pointer">
                            <div class="bg-white/20 backdrop-blur-sm p-3 rounded-full hover:bg-white/30 transition">
                                <svg class="w-8 h-8 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </div>
                         </div>
                    </div>
                <?php else: ?>
                    <div class="w-24 h-24 rounded-full bg-<?= $prompt['category_color'] ?>-50 flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <span class="text-4xl font-bold text-<?= $prompt['category_color'] ?>-600">
                            <?= substr($prompt['platform'], 0, 1) ?>
                        </span>
                    </div>
                <?php endif; ?>

                <h1 class="text-xl font-bold text-slate-900 mb-2 leading-tight"><?= htmlspecialchars($prompt['title']) ?></h1>

                <!-- Key Meta Badges -->
                <div class="flex flex-wrap justify-center gap-2 mb-8">
                    <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-100 text-slate-600 text-xs font-semibold">
                        <?= htmlspecialchars($prompt['platform']) ?>
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-slate-50 border border-slate-100 text-slate-600 text-xs font-semibold">
                        <?= htmlspecialchars($prompt['type']) ?>
                    </span>
                </div>

                <div class="border-t border-slate-100 pt-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Category</span>
                        <span class="font-medium text-<?= $prompt['category_color'] ?>-600"><?= htmlspecialchars($prompt['category_name']) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Created</span>
                        <span class="font-medium text-slate-700"><?= date('M d, Y', strtotime($prompt['created_at'])) ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Status</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                            <?= htmlspecialchars($prompt['status']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-semibold text-slate-900 mb-4 uppercase tracking-wider">Actions</h3>
                <div class="space-y-3">
                    <a href="<?= BASE_URL ?>/prompts/favorite?id=<?= $prompt['id'] ?>" 
                       class="flex items-center justify-center w-full py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 hover:text-yellow-500 transition font-medium text-sm group">
                        <svg class="w-5 h-5 mr-2 text-slate-400 group-hover:text-yellow-500 <?= $prompt['is_favorite'] ? 'text-yellow-500 fill-current' : '' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        <?= $prompt['is_favorite'] ? 'Favorited' : 'Add to Favorites' ?>
                    </a>
                    
                    <a href="<?= BASE_URL ?>/prompts/edit?id=<?= $prompt['id'] ?>" 
                       class="flex items-center justify-center w-full py-2.5 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition font-medium text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Prompt
                    </a>

                    <a href="<?= BASE_URL ?>/prompts/delete?id=<?= $prompt['id'] ?>" onclick="return confirm('Are you sure you want to delete this prompt?')"
                       class="flex items-center justify-center w-full py-2.5 rounded-xl text-red-500 hover:bg-red-50 transition font-medium text-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Prompt
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Content: Prompt & Tags -->
        <div class="lg:col-span-8 space-y-8">
            <!-- Prompt Content -->
            <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] border border-slate-100 overflow-hidden">
                <div class="bg-indigo-50 text-indigo-500 px-6 py-4 flex justify-between items-center">
                    <span class="font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Prompt
                    </span>
                    <button onclick="navigator.clipboard.writeText(document.getElementById('prompt-content').innerText); this.innerHTML = '<span class=\'flex items-center gap-1\'><svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> Copied!</span>'; setTimeout(() => this.innerHTML = '<span class=\'flex items-center gap-1\'><svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3\'></path></svg> Copy Prompt</span>', 2000);" 
                        class="text-indigo-500 bg-indigo-100 hover:bg-indigo-200 px-3 py-1.5 rounded-lg text-sm font-medium transition flex items-center gap-2">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg> 
                            Copy Prompt
                        </span>
                    </button>
                </div>
                <div class="p-8 bg-gray-800 min-h-[300px]">
                    <pre id="prompt-content" class="text-yellow-200 font-mono text-base leading-relaxed whitespace-pre-wrap selection:bg-indigo-100"><?= htmlspecialchars($prompt['content']) ?></pre>
                </div>
            </div>

            <!-- Tags -->

        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-[100] hidden" aria-modal="true" role="dialog">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/90 backdrop-blur-sm transition-opacity" onclick="closeImageModal()"></div>
    
    <!-- Content Container -->
    <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
        <div class="relative max-w-7xl max-h-[90vh] w-full flex flex-col items-center pointer-events-auto">
            <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white/70 hover:text-white transition p-2 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img id="modalImage" src="" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl bg-black" alt="Full size preview">
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        
        modalImg.src = imageSrc;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        
        // Clear src after transition to prevent flicker on reopen
        setTimeout(() => {
            document.getElementById('modalImage').src = '';
        }, 200);
    }
    
    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
</script>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
