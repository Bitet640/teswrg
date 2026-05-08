<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-slate-100 p-8 space-y-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold text-slate-900">Edit Prompt</h1>
            <a href="<?= BASE_URL ?>/prompts" class="text-slate-500 hover:text-indigo-600 transition">Cancel</a>
        </div>

        <form action="<?= BASE_URL ?>/prompts/update" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="id" value="<?= $prompt['id'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-slate-700">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required value="<?= htmlspecialchars($prompt['title']) ?>"
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                </div>

                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-medium text-slate-700">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $prompt['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="platform" class="block text-sm font-medium text-slate-700">Platform</label>
                    <select name="platform" id="platform" 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <?php foreach($platforms as $p): ?>
                            <option value="<?= htmlspecialchars($p['name']) ?>" <?= $prompt['platform'] == $p['name'] ? 'selected' : '' ?>><?= htmlspecialchars($p['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="type" class="block text-sm font-medium text-slate-700">Type</label>
                    <select name="type" id="type" 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <?php foreach(['Text', 'Image', 'Code', 'Audio', 'Video'] as $t): ?>
                            <option value="<?= $t ?>" <?= $prompt['type'] == $t ? 'selected' : '' ?>><?= $t ?> Generation</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="status" class="block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" id="status" 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <option value="Published" <?= $prompt['status'] == 'Published' ? 'selected' : '' ?>>Published</option>
                        <option value="Draft" <?= $prompt['status'] == 'Draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="Archived" <?= $prompt['status'] == 'Archived' ? 'selected' : '' ?>>Archived</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label for="image" class="block text-sm font-medium text-slate-700">Cover Image</label>
                <?php if(!empty($prompt['image_path'])): ?>
                    <div class="mb-3 relative w-48 aspect-video rounded-lg overflow-hidden border border-slate-200 group">
                        <img src="<?= public_url($prompt['image_path']) ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <span class="text-white text-xs">Current Image</span>
                        </div>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" id="image" accept="image/*" 
                    class="block w-full text-sm text-slate-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100">
                <p class="text-xs text-slate-500">Recommended size: 16:9 ratio (e.g., 1280x720px)</p>
            </div>



            <div class="space-y-2">
                <label for="content" class="block text-sm font-medium text-slate-700">Prompt Content <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="10" required 
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900 font-mono"><?= htmlspecialchars($prompt['content']) ?></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Update Prompt
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
