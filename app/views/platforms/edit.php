<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header & Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Edit Platform</h1>
            <p class="text-slate-500 mt-1">Update platform details.</p>
        </div>
        <a href="<?= BASE_URL ?>/platforms" 
           class="inline-flex items-center px-4 py-2 border border-slate-300 text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Platforms
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <form action="<?= BASE_URL ?>/platforms/update" method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?= $platform['id'] ?>">
            
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" id="name" required value="<?= htmlspecialchars($platform['name']) ?>"
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" 
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm hover:shadow transition">
                    Update Platform
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
