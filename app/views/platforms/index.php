<?php require_once VIEW_PATH . 'layout/header.php'; ?>

<div class="space-y-8 max-w-5xl mx-auto">
    <!-- Header & Actions -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Platforms</h1>
            <p class="text-slate-500 mt-1">Manage AI platforms available for prompts.</p>
        </div>
        
        <!-- Add Platform Form (Inline) -->
        <form action="<?= BASE_URL ?>/platforms/store" method="POST" class="flex gap-2">
            <input type="text" name="name" required placeholder="New Platform Name" 
                class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            <button type="submit" 
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition">
                Add
            </button>
        </form>
    </div>

    <!-- Platforms List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($platforms)): ?>
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-slate-500">
                            No platforms found. Add one above.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($platforms as $platform): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-medium text-slate-900"><?= htmlspecialchars($platform['name']) ?></span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="<?= BASE_URL ?>/platforms/edit?id=<?= $platform['id'] ?>" 
                                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                <a href="<?= BASE_URL ?>/platforms/delete?id=<?= $platform['id'] ?>" 
                                   onclick="return confirm('Are you sure you want to delete this platform?')"
                                   class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . 'layout/footer.php'; ?>
