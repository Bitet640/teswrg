<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="max-w-5xl mx-auto mt-12">
    <div class="bg-white rounded-xl shadow-lg border border-slate-100 p-8 space-y-6">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <h1 class="text-2xl font-bold text-slate-900">Edit Category</h1>
            <a href="<?= BASE_URL ?>/categories" class="text-slate-500 hover:text-indigo-600 transition">Cancel</a>
        </div>

        <form action="<?= BASE_URL ?>/categories/update" method="POST" class="space-y-6">
            <input type="hidden" name="id" value="<?= $category['id'] ?>">
            
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-700">Category Name</label>
                <input type="text" name="name" id="name" required value="<?= htmlspecialchars($category['name']) ?>"
                    class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
            </div>

            <div class="space-y-2">
                <label for="color" class="block text-sm font-medium text-slate-700">Color</label>
                <select name="color" id="color" required class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
                    <?php 
                    $colors = ['slate', 'red', 'orange', 'amber', 'yellow', 'lime', 'green', 'emerald', 'teal', 'cyan', 'sky', 'blue', 'indigo', 'violet', 'purple', 'fuchsia', 'pink', 'rose'];
                    foreach ($colors as $color): ?>
                        <option value="<?= $color ?>" <?= $category['color'] == $color ? 'selected' : '' ?>><?= ucfirst($color) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" 
                    class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
