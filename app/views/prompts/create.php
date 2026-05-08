<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-slate-100 p-8 space-y-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold text-slate-900">Create New Prompt</h1>
            <a href="<?= BASE_URL ?>/prompts" class="text-slate-500 hover:text-indigo-600 transition">Cancel</a>
        </div>

        <form action="<?= BASE_URL ?>/prompts/store" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-medium text-slate-700">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900 placeholder-slate-400"
                        placeholder="e.g. SEO Content Writer">
                </div>

                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-medium text-slate-700">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <option value="" disabled selected>Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="platform" class="block text-sm font-medium text-slate-700">Platform</label>
                    <select name="platform" id="platform" 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <?php foreach ($platforms as $platform): ?>
                            <option value="<?= htmlspecialchars($platform['name']) ?>"><?= htmlspecialchars($platform['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="type" class="block text-sm font-medium text-slate-700">Type</label>
                    <select name="type" id="type" 
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                        <option value="Text">Text Generation</option>
                        <option value="Image">Image Generation</option>
                        <option value="Code">Code Generation</option>
                        <option value="Audio">Audio Generation</option>
                        <option value="Video">Video Generation</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label for="image" class="block text-sm font-medium text-slate-700">Cover Image</label>
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
                <textarea name="content" id="content" rows="6" required 
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900 placeholder-slate-400 font-mono"
                    placeholder="Paste your prompt here..."></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Save Prompt
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
