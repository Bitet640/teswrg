<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="max-w-5xl mx-auto space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Categories</h1>
        <p class="text-slate-500 text-sm">Organize your prompts by topic.</p>
    </div>

    <!-- Create Category Form -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Add New Category</h2>
        <form action="<?= BASE_URL ?>/categories/store" method="POST" class="flex flex-col md:flex-row gap-4">
            <div class="flex-grow">
                <input type="text" name="name" required placeholder="Category Name" 
                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-slate-900">
            </div>
            <div>
                <select name="color" required class="w-full md:w-32 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm">
                    <option value="slate">Slate</option>
                    <option value="red">Red</option>
                    <option value="orange">Orange</option>
                    <option value="amber">Amber</option>
                    <option value="yellow">Yellow</option>
                    <option value="lime">Lime</option>
                    <option value="green">Green</option>
                    <option value="emerald">Emerald</option>
                    <option value="teal">Teal</option>
                    <option value="cyan">Cyan</option>
                    <option value="sky">Sky</option>
                    <option value="blue">Blue</option>
                    <option value="indigo">Indigo</option>
                    <option value="violet">Violet</option>
                    <option value="purple">Purple</option>
                    <option value="fuchsia">Fuchsia</option>
                    <option value="pink">Pink</option>
                    <option value="rose">Rose</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-medium rounded-lg shadow-sm transition">
                Add
            </button>
        </form>
    </div>

    <!-- Categories List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Color</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($categories as $cat): ?>
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <span class="font-medium text-slate-700"><?= htmlspecialchars($cat['name']) ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $cat['color'] ?>-100 text-<?= $cat['color'] ?>-800 border border-<?= $cat['color'] ?>-200">
                            <?= ucfirst($cat['color']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="<?= BASE_URL ?>/categories/edit?id=<?= $cat['id'] ?>" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm transition">Edit</a>
                        <a href="<?= BASE_URL ?>/categories/delete?id=<?= $cat['id'] ?>" 
                           onclick="return confirm('Are you sure?')" 
                           class="text-red-400 hover:text-red-600 font-medium text-sm transition">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($categories)): ?>
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-slate-500">No categories found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
