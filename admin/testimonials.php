<?php
// admin/testimonials.php
include 'header.php';

$message = '';
$error = '';

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM testimonials WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM testimonials WHERE id = ?")->execute([$id]);
        $message = "Testimonial deleted successfully!";
    }
}

// Handle Add / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $designation = trim($_POST['designation'] ?? 'Student');
    $rating = (int)($_POST['rating'] ?? 5);
    $messageText = trim($_POST['message'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/testimonials/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM testimonials WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = 'testi_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = 'uploads/testimonials/' . $fileName;
        }
    }

    if ($edit_id > 0) {
        $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, designation = ?, rating = ?, message = ?, status = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$name, $designation, $rating, $messageText, $status, $image_path, $edit_id]);
        $message = "Testimonial updated!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO testimonials (name, designation, rating, message, status, image_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $designation, $rating, $messageText, $status, $image_path]);
        $message = "New testimonial added!";
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM testimonials ORDER BY id DESC")->fetchAll();
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
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-plus-circle' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Testimonial' : 'Add Testimonial' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Student / Parent Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($editItem['name'] ?? '') ?>"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Designation / Course</label>
                <input type="text" name="designation" placeholder="e.g. NEET 2024 Ranker, Class 12 Student" value="<?= htmlspecialchars($editItem['designation'] ?? 'Student') ?>"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Rating (1-5)</label>
                    <select name="rating" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <?php for($r=5; $r>=1; $r--): ?>
                            <option value="<?= $r ?>" <?= ($editItem['rating'] ?? 5) == $r ? 'selected' : '' ?>><?= $r ?> Stars</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Review Message</label>
                <textarea name="message" rows="4" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['message'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Student Photo (Optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Testimonial' : 'Save Testimonial' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="testimonials.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Testimonials List (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No testimonials added yet. Use the form to submit student reviews.
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($items as $item): ?>
                    <div class="glass-panel p-5 rounded-2xl border border-slate-800 flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold shrink-0 overflow-hidden">
                            <?php if (!empty($item['image_path'])): ?>
                                <img src="../<?= htmlspecialchars($item['image_path']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <?= strtoupper(substr($item['name'], 0, 2)) ?>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="text-sm font-semibold text-white"><?= htmlspecialchars($item['name']) ?> <span class="text-xs text-slate-400 font-normal"> - <?= htmlspecialchars($item['designation']) ?></span></h4>
                                <div class="text-amber-400 text-xs">
                                    <?= str_repeat('<i class="fa-solid fa-star"></i>', $item['rating']) ?>
                                </div>
                            </div>
                            <p class="text-xs text-slate-300 mt-2 bg-slate-900/60 p-3 rounded-xl border border-slate-800/80 italic">"<?= htmlspecialchars($item['message']) ?>"</p>
                            
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                    ● <?= ucfirst($item['status']) ?>
                                </span>
                                <div class="flex gap-3">
                                    <a href="testimonials.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit</a>
                                    <a href="testimonials.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Delete this testimonial?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
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
