<?php
// admin/enrollments.php
include 'header.php';

// Auto-create table if not created
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `enrollments` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `student_name` VARCHAR(255) NOT NULL,
      `email` VARCHAR(255) NOT NULL,
      `phone` VARCHAR(50) DEFAULT '',
      `course` VARCHAR(150) NOT NULL,
      `message` TEXT,
      `status` ENUM('pending', 'contacted', 'enrolled', 'cancelled') DEFAULT 'pending',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $count = $pdo->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `enrollments` (`student_name`, `email`, `phone`, `course`, `message`, `status`) VALUES
        ('Rohan Das', 'rohan.das@gmail.com', '+91 9876543210', 'CBSE Class X - All Subjects', 'Interested in evening batch admission for 2026 session.', 'pending'),
        ('Priya Mishra', 'priya.mishra@yahoo.com', '+91 9437123456', 'Class XI - Mathematics Coaching', 'Looking for specialized mathematics guidance.', 'contacted')");
    }
} catch (Exception $e) {}

$message = '';

// Update Status Action
if (isset($_POST['update_status'])) {
    $enroll_id = (int)$_POST['enroll_id'];
    $status = $_POST['status'] ?? 'pending';
    $stmt = $pdo->prepare("UPDATE enrollments SET status = ? WHERE id = ?");
    $stmt->execute([$status, $enroll_id]);
    $message = "Enrollment lead status updated successfully!";
}

// Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM enrollments WHERE id = ?")->execute([$id]);
    $message = "Enrollment lead removed!";
}

// Filter Status
$filterStatus = $_GET['status'] ?? 'all';
if (in_array($filterStatus, ['pending', 'contacted', 'enrolled', 'cancelled'])) {
    $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE status = ? ORDER BY created_at DESC");
    $stmt->execute([$filterStatus]);
    $items = $stmt->fetchAll();
} else {
    $items = $pdo->query("SELECT * FROM enrollments ORDER BY created_at DESC")->fetchAll();
}

$countAll = $pdo->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();
$countPending = $pdo->query("SELECT COUNT(*) FROM enrollments WHERE status = 'pending'")->fetchColumn();
$countContacted = $pdo->query("SELECT COUNT(*) FROM enrollments WHERE status = 'contacted'")->fetchColumn();
$countEnrolled = $pdo->query("SELECT COUNT(*) FROM enrollments WHERE status = 'enrolled'")->fetchColumn();
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <span><?= htmlspecialchars($message) ?></span>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <a href="enrollments.php?status=all" class="p-5 rounded-2xl glass-panel border <?= $filterStatus === 'all' ? 'border-indigo-500 bg-indigo-900/20' : 'border-slate-800' ?> transition-all">
        <div class="text-xs font-medium text-slate-400">Total Applications</div>
        <div class="text-2xl font-bold text-white font-heading mt-1"><?= $countAll ?></div>
    </a>
    <a href="enrollments.php?status=pending" class="p-5 rounded-2xl glass-panel border <?= $filterStatus === 'pending' ? 'border-amber-500 bg-amber-900/20' : 'border-slate-800' ?> transition-all">
        <div class="text-xs font-medium text-amber-400">Pending Review</div>
        <div class="text-2xl font-bold text-amber-400 font-heading mt-1"><?= $countPending ?></div>
    </a>
    <a href="enrollments.php?status=contacted" class="p-5 rounded-2xl glass-panel border <?= $filterStatus === 'contacted' ? 'border-blue-500 bg-blue-900/20' : 'border-slate-800' ?> transition-all">
        <div class="text-xs font-medium text-blue-400">Contacted</div>
        <div class="text-2xl font-bold text-blue-400 font-heading mt-1"><?= $countContacted ?></div>
    </a>
    <a href="enrollments.php?status=enrolled" class="p-5 rounded-2xl glass-panel border <?= $filterStatus === 'enrolled' ? 'border-emerald-500 bg-emerald-900/20' : 'border-slate-800' ?> transition-all">
        <div class="text-xs font-medium text-emerald-400">Successfully Enrolled</div>
        <div class="text-2xl font-bold text-emerald-400 font-heading mt-1"><?= $countEnrolled ?></div>
    </a>
</div>

<!-- Table Card -->
<div class="glass-panel rounded-2xl overflow-hidden border border-slate-800">
    <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <h3 class="text-base font-bold text-white font-heading flex items-center gap-2">
            <i class="fa-solid fa-user-graduate text-indigo-400"></i> Student Enrollment Applications (<?= count($items) ?>)
        </h3>
        <div class="flex gap-2">
            <a href="enrollments.php" class="px-3 py-1.5 rounded-lg text-xs font-medium <?= $filterStatus === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:text-white' ?>">All</a>
            <a href="enrollments.php?status=pending" class="px-3 py-1.5 rounded-lg text-xs font-medium <?= $filterStatus === 'pending' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:text-white' ?>">Pending</a>
            <a href="enrollments.php?status=contacted" class="px-3 py-1.5 rounded-lg text-xs font-medium <?= $filterStatus === 'contacted' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:text-white' ?>">Contacted</a>
            <a href="enrollments.php?status=enrolled" class="px-3 py-1.5 rounded-lg text-xs font-medium <?= $filterStatus === 'enrolled' ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:text-white' ?>">Enrolled</a>
        </div>
    </div>

    <?php if (empty($items)): ?>
        <div class="p-12 text-center text-slate-400 text-sm">
            No enrollment submissions found for this filter.
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-900/80 text-xs font-semibold uppercase tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="p-4">Student Info</th>
                        <th class="p-4">Course Choice</th>
                        <th class="p-4">Message / Query</th>
                        <th class="p-4">Submitted Date</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <?php foreach ($items as $item): ?>
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-white text-sm"><?= htmlspecialchars($item['student_name']) ?></div>
                                <div class="text-xs text-indigo-400 mt-0.5"><i class="fa-solid fa-envelope mr-1"></i><?= htmlspecialchars($item['email']) ?></div>
                                <?php if (!empty($item['phone'])): ?>
                                    <div class="text-xs text-slate-400 mt-0.5"><i class="fa-solid fa-phone mr-1"></i><?= htmlspecialchars($item['phone']) ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-500/10 text-indigo-300 text-xs font-semibold border border-indigo-500/20">
                                    <?= htmlspecialchars($item['course']) ?>
                                </span>
                            </td>
                            <td class="p-4 max-w-xs">
                                <p class="text-xs text-slate-300 line-clamp-2"><?= htmlspecialchars($item['message'] ?: 'No additional comments provided.') ?></p>
                            </td>
                            <td class="p-4 text-xs text-slate-400 whitespace-nowrap">
                                <?= date('M d, Y h:i A', strtotime($item['created_at'])) ?>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="enroll_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="update_status" value="1">
                                    <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-900 border border-slate-700 text-slate-200 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                                        <option value="pending" <?= $item['status'] === 'pending' ? 'selected' : '' ?>>🟡 Pending</option>
                                        <option value="contacted" <?= $item['status'] === 'contacted' ? 'selected' : '' ?>>🔵 Contacted</option>
                                        <option value="enrolled" <?= $item['status'] === 'enrolled' ? 'selected' : '' ?>>🟢 Enrolled</option>
                                        <option value="cancelled" <?= $item['status'] === 'cancelled' ? 'selected' : '' ?>>🔴 Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-4 text-right whitespace-nowrap">
                                <a href="enrollments.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Remove this enrollment application?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
