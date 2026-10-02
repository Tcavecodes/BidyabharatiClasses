<?php
// admin/faqs.php
include 'header.php';

// Auto-create table if not created
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `faqs` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `question` VARCHAR(255) NOT NULL,
      `answer` TEXT NOT NULL,
      `category` VARCHAR(100) DEFAULT 'General',
      `sort_order` INT DEFAULT 0,
      `status` ENUM('active', 'inactive') DEFAULT 'active',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $count = $pdo->query("SELECT COUNT(*) FROM faqs")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `sort_order`, `status`) VALUES
        (1, 'What courses are offered at Bidyabharati Classes?', 'We offer a comprehensive range of coaching programs including Foundation batches for Classes 8 to 10, Medical Entrance (NEET-UG), Engineering Entrance (JEE Main & Advanced), Board Exam preparations (CBSE/ICSE/State Board), and specialized Crash Courses with extensive problem-solving drills.', 'Courses', 1, 'active'),
        (2, 'How to enroll in Bidyabharati Classes?', 'Enrolling is straightforward! You can apply directly through our online enrollment form, visit our admissions desk at the campus, or contact our academic counselors. Our team will guide you through batch timings, documentation, and the enrollment process.', 'Admissions', 2, 'active'),
        (3, 'What is the fee structure and scholarship options?', 'Our fee structure is transparent, affordable, and tailored to the program duration and grade level. We also offer merit-based scholarship fee waivers up to 100% based on our admission & scholarship test, along with flexible installment payment plans.', 'Fees & Scholarships', 3, 'active'),
        (4, 'What is the online coaching course format?', 'Our online coaching course combines live interactive virtual lectures with top faculties, recorded class archives for round-the-clock revision, digital study modules, live doubt-clearing sessions, and national-level online mock tests with real-time performance analytics.', 'Online Classes', 4, 'active')");
    }
} catch (Exception $e) {}

$message = '';
$error = '';

// Delete FAQ
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM faqs WHERE id = ?")->execute([$id]);
    $message = "FAQ deleted successfully!";
}

// Add / Edit FAQ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');
    $category = trim($_POST['category'] ?? 'General');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    if (!empty($question) && !empty($answer)) {
        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE faqs SET question = ?, answer = ?, category = ?, sort_order = ?, status = ? WHERE id = ?");
            $stmt->execute([$question, $answer, $category, $sort_order, $status, $edit_id]);
            $message = "FAQ updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO faqs (question, answer, category, sort_order, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$question, $answer, $category, $sort_order, $status]);
            $message = "New FAQ added successfully!";
        }
    } else {
        $error = "Question and Answer fields are required.";
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM faqs WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM faqs ORDER BY sort_order ASC, id DESC")->fetchAll();
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <span><?= htmlspecialchars($message) ?></span>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center gap-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Card -->
    <div class="glass-panel p-6 rounded-2xl h-fit">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2 border-b border-slate-800 pb-3">
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-plus-circle' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit FAQ' : 'Add New FAQ' ?>
        </h3>

        <form method="POST" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Question</label>
                <input type="text" name="question" required value="<?= htmlspecialchars($editItem['question'] ?? '') ?>"
                    placeholder="e.g. What courses are offered?"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Category</label>
                <input type="text" name="category" value="<?= htmlspecialchars($editItem['category'] ?? 'General') ?>"
                    placeholder="e.g. Courses, Admissions, Fees"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Answer</label>
                <textarea name="answer" rows="5" required
                    placeholder="Type detailed answer..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['answer'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= htmlspecialchars($editItem['sort_order'] ?? '0') ?>"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="active" <?= ($editItem['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <?= $editItem ? 'Update FAQ' : 'Save FAQ' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="faqs.php" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table List Card -->
    <div class="lg:col-span-2 glass-panel p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
            <h3 class="text-base font-bold text-white font-heading flex items-center gap-2">
                <i class="fa-solid fa-circle-question text-indigo-400"></i>
                All FAQs List (<?= count($items) ?>)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase tracking-wider text-slate-400 bg-slate-800/50 rounded-xl">
                    <tr>
                        <th class="px-4 py-3">Order</th>
                        <th class="px-4 py-3">Question & Answer</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-500">No FAQs found. Add one on the left.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-4 py-3.5 font-bold text-slate-400">
                                    #<?= (int)$item['sort_order'] ?>
                                </td>
                                <td class="px-4 py-3.5 max-w-xs">
                                    <div class="font-semibold text-white mb-1"><?= htmlspecialchars($item['question']) ?></div>
                                    <div class="text-xs text-slate-400 line-clamp-2"><?= htmlspecialchars($item['answer']) ?></div>
                                </td>
                                <td class="px-4 py-3.5 text-xs">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-800 text-indigo-300 border border-slate-700">
                                        <?= htmlspecialchars($item['category']) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <?php if ($item['status'] === 'active'): ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Active</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3.5 text-right space-x-2">
                                    <a href="faqs.php?action=edit&id=<?= $item['id'] ?>" class="p-1.5 rounded-lg bg-indigo-600/20 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all inline-block" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <a href="faqs.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this FAQ?')" class="p-1.5 rounded-lg bg-rose-600/20 text-rose-400 hover:bg-rose-600 hover:text-white transition-all inline-block" title="Delete">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
