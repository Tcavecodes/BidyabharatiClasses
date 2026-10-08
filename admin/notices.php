<?php
// admin/notices.php
include 'header.php';

// Auto-create table if not created
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `notices` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) NOT NULL,
      `category` VARCHAR(100) DEFAULT 'Academic announcement',
      `notice_date` DATE NOT NULL,
      `content` TEXT,
      `attachment_path` VARCHAR(255) DEFAULT '',
      `status` ENUM('active', 'inactive') DEFAULT 'active',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $count = $pdo->query("SELECT COUNT(*) FROM notices")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `notices` (`id`, `title`, `category`, `notice_date`, `content`) VALUES
        (1, 'IMPORTANT ANNOUNCEMENT FOR NEW ADMISSION LEARNERS', 'Academic announcement', '2026-11-15', 'Admissions open for new academic session Class III to XII. Register early for batch selection.'),
        (2, 'IMPORTANT ANNOUNCEMENT FOR ALL NEW BATCH LEARNING SESSIONS', 'Academic announcement', '2026-12-15', 'New evening batch commencing for Class IX & X Science and Mathematics.'),
        (3, 'IMPORTANT ANNOUNCEMENT FOR ALL SEMESTER EXAMINATIONS', 'Examination announcement', '2026-12-13', 'Mock Board examination schedule published. Check your syllabus coverage.'),
        (4, 'SCHOLARSHIP APPLICATION FOR MERIT STUDENTS OPEN', 'Scholarship announcement', '2026-12-08', 'Merit test applications open. Waiver up to 100% for top scorers.')");
    }
} catch (Exception $e) {}

$message = '';
$error = '';

// Delete Notice
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT attachment_path FROM notices WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['attachment_path']) && file_exists(__DIR__ . '/../' . $item['attachment_path'])) {
            @unlink(__DIR__ . '/../' . $item['attachment_path']);
        }
        $pdo->prepare("DELETE FROM notices WHERE id = ?")->execute([$id]);
        $message = "Notice deleted!";
    }
}

// Add / Edit Notice
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'Academic announcement');
    $notice_date = trim($_POST['notice_date'] ?? date('Y-m-d'));
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/notices/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $attachment_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT attachment_path FROM notices WHERE id = ?");
        $stmt->execute([$edit_id]);
        $attachment_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowedNoticeExts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp', 'zip'];
        $attCheck = validate_uploaded_file($_FILES['attachment'], '5 MB', 5 * 1024 * 1024, $allowedNoticeExts);
        if (!$attCheck['valid']) {
            $error = $attCheck['error'];
        } else {
            $ext = $attCheck['ext'];
            $fileName = 'notice_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
                $attachment_path = 'uploads/notices/' . $fileName;
            }
        }
    }

    if (empty($error)) {
        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE notices SET title = ?, category = ?, notice_date = ?, content = ?, status = ?, attachment_path = ? WHERE id = ?");
            $stmt->execute([$title, $category, $notice_date, $content, $status, $attachment_path, $edit_id]);
            $message = "Notice updated!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO notices (title, category, notice_date, content, status, attachment_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $category, $notice_date, $content, $status, $attachment_path]);
            $message = "New notice published!";
        }
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM notices WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM notices ORDER BY notice_date DESC")->fetchAll();
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
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-bullhorn' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Notice' : 'Post New Notice' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Notice Headline / Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" placeholder="IMPORTANT ANNOUNCEMENT FOR NEW ADMISSION LEARNERS"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Category</label>
                    <input type="text" name="category" value="<?= htmlspecialchars($editItem['category'] ?? 'Academic announcement') ?>" placeholder="Academic, Exam, Activity"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Date</label>
                    <input type="date" name="notice_date" required value="<?= htmlspecialchars($editItem['notice_date'] ?? date('Y-m-d')) ?>"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Notice Details / Content</label>
                <textarea name="content" rows="4" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['content'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Attachment File (Optional PDF/Doc)</label>
                <input type="file" name="attachment" accept=".pdf,.doc,.docx"
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Notice' : 'Post Notice' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="notices.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Notice Board Items (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No notices published yet. Use the form to post announcements.
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($items as $item): ?>
                    <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex items-center justify-between gap-4">
                        <div class="min-w-0 flex-1">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-500/20 text-amber-300 uppercase tracking-wide mb-1"><?= htmlspecialchars($item['category']) ?></span>
                            <h4 class="text-sm font-bold text-white truncate"><?= htmlspecialchars($item['title']) ?></h4>
                            <p class="text-xs text-slate-400 mt-0.5"><i class="fa-regular fa-calendar mr-1 text-indigo-400"></i><?= date('M d, Y', strtotime($item['notice_date'])) ?></p>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span class="text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                ● <?= ucfirst($item['status']) ?>
                            </span>
                            <a href="notices.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit</a>
                            <a href="notices.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Delete this notice?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
