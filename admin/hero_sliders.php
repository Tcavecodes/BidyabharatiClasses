<?php
// admin/hero_sliders.php
include 'header.php';

// Auto-create table if not created via SQL import
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `hero_sliders` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `subtitle` VARCHAR(255) DEFAULT 'LEARN ANYTHING, ANYTIME, ANYWHERE',
      `title` VARCHAR(255) NOT NULL,
      `description` TEXT,
      `btn1_text` VARCHAR(50) DEFAULT 'View Course',
      `btn1_url` VARCHAR(255) DEFAULT 'course-1.php',
      `btn2_text` VARCHAR(50) DEFAULT 'Get Started',
      `btn2_url` VARCHAR(255) DEFAULT 'contact.php',
      `image_path` VARCHAR(255) NOT NULL,
      `status` ENUM('active', 'inactive') DEFAULT 'active',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Seed initial 3 sliders if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM hero_sliders")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `hero_sliders` (`id`, `subtitle`, `title`, `description`, `btn1_text`, `btn1_url`, `btn2_text`, `btn2_url`, `image_path`) VALUES
        (1, 'LEARN ANYTHING, ANYTIME, ANYWHERE', 'BEST ONLINE LEARNING FOR YOUR FUTURE', 'Empowering students from Class 3 to 12 with conceptual clarity, disciplined guidance, and excellence.', 'View Course', 'course-1.php', 'Get Started', 'contact.php', 'assets/images/banner/education-2021-04-04-14-25-07-utc.jpg'),
        (2, 'START YOUR FAVOURITE COURSE', 'START YOUR FAVOURITE COURSE BRIGHT FUTURE', 'Over three decades of dedicated teaching experience in Baripada, Odisha.', 'Explore Programs', 'course-1.php', 'Contact Us', 'contact.php', 'assets/images/banner/education-PHW33SU.jpg'),
        (3, 'EXCELLENCE IN EDUCATION', 'BUILD STRONG CONCEPTS FOR SUCCESS', 'Specialized academic coaching for CBSE and State Board students with individual attention.', 'Our Achievers', 'achievers.php', 'Enroll Now', 'contact.php', 'assets/images/banner/secondsection.jpg')");
    }
} catch (Exception $e) {}

$message = '';
$error = '';

// Delete Slider Item
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM hero_sliders WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && strpos($item['image_path'], 'uploads/') === 0 && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM hero_sliders WHERE id = ?")->execute([$id]);
        $message = "Slider slide removed!";
    }
}

// Add / Edit Slider Item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subtitle = trim($_POST['subtitle'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $btn1_text = trim($_POST['btn1_text'] ?? 'View Course');
    $btn1_url = trim($_POST['btn1_url'] ?? 'course-1.php');
    $btn2_text = trim($_POST['btn2_text'] ?? 'Get Started');
    $btn2_url = trim($_POST['btn2_url'] ?? 'contact.php');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/sliders/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM hero_sliders WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = 'slide_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = 'uploads/sliders/' . $fileName;
        }
    }

    if ($edit_id > 0) {
        $stmt = $pdo->prepare("UPDATE hero_sliders SET subtitle = ?, title = ?, description = ?, btn1_text = ?, btn1_url = ?, btn2_text = ?, btn2_url = ?, status = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$subtitle, $title, $description, $btn1_text, $btn1_url, $btn2_text, $btn2_url, $status, $image_path, $edit_id]);
        $message = "Slider updated successfully!";
    } else {
        if (empty($image_path)) {
            $error = "Please choose a banner image for the slider.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO hero_sliders (subtitle, title, description, btn1_text, btn1_url, btn2_text, btn2_url, status, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$subtitle, $title, $description, $btn1_text, $btn1_url, $btn2_text, $btn2_url, $status, $image_path]);
            $message = "New slider slide added!";
        }
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM hero_sliders WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM hero_sliders ORDER BY id ASC")->fetchAll();
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check"></i>
        <span><?= htmlspecialchars($message) ?></span>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation"></i>
        <span><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Card -->
    <div class="glass-panel p-6 rounded-2xl h-fit">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2 border-b border-slate-800 pb-3">
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-sliders' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Hero Slider Slide' : 'Add Hero Slider Slide' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Small Subtitle</label>
                <input type="text" name="subtitle" value="<?= htmlspecialchars($editItem['subtitle'] ?? 'LEARN ANYTHING, ANYTIME, ANYWHERE') ?>" placeholder="LEARN ANYTHING, ANYTIME, ANYWHERE"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Main Banner Heading Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" placeholder="BEST ONLINE LEARNING FOR YOUR FUTURE"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Description Paragraph</label>
                <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Brief description text..."><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Button 1 Label</label>
                    <input type="text" name="btn1_text" value="<?= htmlspecialchars($editItem['btn1_text'] ?? 'View Course') ?>"
                        class="w-full px-3.5 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Button 1 URL</label>
                    <input type="text" name="btn1_url" value="<?= htmlspecialchars($editItem['btn1_url'] ?? 'course-1.php') ?>"
                        class="w-full px-3.5 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Button 2 Label</label>
                    <input type="text" name="btn2_text" value="<?= htmlspecialchars($editItem['btn2_text'] ?? 'Get Started') ?>"
                        class="w-full px-3.5 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Button 2 URL</label>
                    <input type="text" name="btn2_url" value="<?= htmlspecialchars($editItem['btn2_url'] ?? 'contact.php') ?>"
                        class="w-full px-3.5 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
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
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Banner Background Image</label>
                <input type="file" name="image" accept="image/*" <?= $editItem ? '' : 'required' ?>
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <?php if ($editItem && !empty($editItem['image_path'])): ?>
                <div class="mt-2">
                    <p class="text-xs text-slate-400 mb-1">Current Preview:</p>
                    <img src="../<?= htmlspecialchars($editItem['image_path']) ?>" class="h-28 w-full object-cover rounded-xl border border-slate-700">
                </div>
            <?php endif; ?>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Slide' : 'Upload Slide' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="hero_sliders.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Active Hero Sliders (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No hero slider slides configured. Add slides using the form on the left.
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($items as $index => $item): ?>
                    <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex gap-4 items-center">
                        <img src="../<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-36 h-24 object-cover rounded-xl border border-slate-700 shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-500/20 text-indigo-300 uppercase tracking-wide">Slide #<?= $index + 1 ?></span>
                                <span class="text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                    ● <?= ucfirst($item['status']) ?>
                                </span>
                            </div>
                            <h4 class="text-sm font-bold text-white mt-1 truncate"><?= htmlspecialchars($item['title']) ?></h4>
                            <p class="text-xs text-slate-400 truncate"><?= htmlspecialchars($item['subtitle']) ?></p>
                            <div class="flex gap-3 mt-3">
                                <a href="hero_sliders.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit Slide</a>
                                <a href="hero_sliders.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Delete this hero slide?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
