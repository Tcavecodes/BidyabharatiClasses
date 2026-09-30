<?php
// admin/achievers.php
include 'header.php';

$message = '';
$error = '';

// Delete Achiever
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM achievers WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM achievers WHERE id = ?")->execute([$id]);
        $message = "Achiever record removed!";
    }
}

// Add / Edit Achiever
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = trim($_POST['student_name'] ?? '');
    $exam_name = trim($_POST['exam_name'] ?? '');
    $rank_score = trim($_POST['rank_score'] ?? '');
    $year = trim($_POST['year'] ?? date('Y'));
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/achievers/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM achievers WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = 'ach_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = 'uploads/achievers/' . $fileName;
        }
    }

    if ($edit_id > 0) {
        $stmt = $pdo->prepare("UPDATE achievers SET student_name = ?, exam_name = ?, rank_score = ?, year = ?, status = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$student_name, $exam_name, $rank_score, $year, $status, $image_path, $edit_id]);
        $message = "Achiever details updated!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO achievers (student_name, exam_name, rank_score, year, status, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$student_name, $exam_name, $rank_score, $year, $status, $image_path]);
        $message = "New achiever added!";
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM achievers WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM achievers ORDER BY id DESC")->fetchAll();
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <span><?= htmlspecialchars($message) ?></span>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Card -->
    <div class="glass-panel p-6 rounded-2xl h-fit">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2 border-b border-slate-800 pb-3">
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-award' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Achiever' : 'Add Star Achiever' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Student Name</label>
                <input type="text" name="student_name" required value="<?= htmlspecialchars($editItem['student_name'] ?? '') ?>" placeholder="Rahul Kumar"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Exam Name</label>
                <input type="text" name="exam_name" required value="<?= htmlspecialchars($editItem['exam_name'] ?? '') ?>" placeholder="NEET UG / JEE Advanced / CBSE 12th"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Rank / Score</label>
                    <input type="text" name="rank_score" required value="<?= htmlspecialchars($editItem['rank_score'] ?? '') ?>" placeholder="AIR 45 / 98.4%"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Year</label>
                    <input type="text" name="year" value="<?= htmlspecialchars($editItem['year'] ?? date('Y')) ?>" placeholder="2025"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Student Photo</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Achiever' : 'Save Achiever' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="achievers.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Achievers List (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No achievers recorded yet. Add rankers and toppers using the form.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($items as $item): ?>
                    <div class="glass-panel p-5 rounded-2xl border border-slate-800 flex gap-4 items-center">
                        <div class="w-16 h-16 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-lg overflow-hidden shrink-0 border border-amber-500/20">
                            <?php if (!empty($item['image_path'])): ?>
                                <img src="../<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fa-solid fa-trophy"></i>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 uppercase tracking-wide mb-1"><?= htmlspecialchars($item['exam_name']) ?> (<?= htmlspecialchars($item['year']) ?>)</span>
                            <h4 class="text-sm font-bold text-white font-heading truncate"><?= htmlspecialchars($item['student_name']) ?></h4>
                            <p class="text-xs text-indigo-400 font-semibold mt-0.5"><?= htmlspecialchars($item['rank_score']) ?></p>
                            
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                    ● <?= ucfirst($item['status']) ?>
                                </span>
                                <div class="flex gap-3">
                                    <a href="achievers.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit</a>
                                    <a href="achievers.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Delete achiever record?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
