<?php
// admin/faculties.php
include 'header.php';

$message = '';
$error = '';

// Delete Faculty
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM faculties WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM faculties WHERE id = ?")->execute([$id]);
        $message = "Faculty member removed!";
    }
}

// Add / Edit Faculty
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $qualification = trim($_POST['qualification'] ?? '');
    $experience = trim($_POST['experience'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/faculties/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM faculties WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $imgCheck = validate_uploaded_file($_FILES['image'], '2 MB', MAX_IMAGE_SIZE_BYTES, ALLOWED_IMAGE_EXTENSIONS);
        if (!$imgCheck['valid']) {
            $error = $imgCheck['error'];
        } else {
            $ext = $imgCheck['ext'];
            $fileName = 'fac_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image_path = 'uploads/faculties/' . $fileName;
            }
        }
    }

    if (empty($error)) {
        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE faculties SET name = ?, designation = ?, qualification = ?, experience = ?, bio = ?, status = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$name, $designation, $qualification, $experience, $bio, $status, $image_path, $edit_id]);
            $message = "Faculty member details updated!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO faculties (name, designation, qualification, experience, bio, status, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $designation, $qualification, $experience, $bio, $status, $image_path]);
            $message = "New faculty member added!";
        }
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM faculties WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM faculties ORDER BY id DESC")->fetchAll();
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
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-user-plus' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Faculty Member' : 'Add Faculty Member' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Faculty Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($editItem['name'] ?? '') ?>" placeholder="Dr. A. K. Sharma"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Designation / Subject</label>
                <input type="text" name="designation" required value="<?= htmlspecialchars($editItem['designation'] ?? '') ?>" placeholder="Head of Physics Department"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Qualification</label>
                    <input type="text" name="qualification" value="<?= htmlspecialchars($editItem['qualification'] ?? '') ?>" placeholder="M.Sc, Ph.D"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Experience</label>
                    <input type="text" name="experience" value="<?= htmlspecialchars($editItem['experience'] ?? '') ?>" placeholder="12+ Years"
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
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Brief Profile / Bio</label>
                <textarea name="bio" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['bio'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Profile Photo</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Faculty' : 'Save Faculty' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="faculties.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Faculty Members (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No faculty members added yet. Add teachers using the form on the left.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($items as $item): ?>
                    <div class="glass-panel p-5 rounded-2xl border border-slate-800 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-14 h-14 rounded-2xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold text-lg overflow-hidden shrink-0">
                                    <?php if (!empty($item['image_path'])): ?>
                                        <img src="../<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="fa-solid fa-user-tie"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-base font-bold text-white font-heading truncate"><?= htmlspecialchars($item['name']) ?></h4>
                                    <p class="text-xs text-indigo-400 font-medium truncate"><?= htmlspecialchars($item['designation']) ?></p>
                                    <p class="text-[11px] text-slate-400 mt-0.5"><?= htmlspecialchars($item['qualification']) ?> <?= $item['experience'] ? '• '.$item['experience'].' Exp' : '' ?></p>
                                </div>
                            </div>
                            <?php if (!empty($item['bio'])): ?>
                                <p class="text-xs text-slate-300 line-clamp-2 bg-slate-900/50 p-2.5 rounded-xl border border-slate-800/80 mb-3"><?= htmlspecialchars($item['bio']) ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-800/60">
                            <span class="text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                ● <?= ucfirst($item['status']) ?>
                            </span>
                            <div class="flex gap-3">
                                <a href="faculties.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit</a>
                                <a href="faculties.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Remove faculty member?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
