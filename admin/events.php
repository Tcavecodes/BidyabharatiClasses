<?php
// admin/events.php
include 'header.php';

// Auto-create table if not created
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `events` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) NOT NULL,
      `event_date` DATE NOT NULL,
      `event_time` VARCHAR(100) DEFAULT '10:00 AM',
      `location` VARCHAR(255) DEFAULT 'Baripada Campus',
      `description` TEXT,
      `rating` INT DEFAULT 5,
      `image_path` VARCHAR(255) DEFAULT '',
      `status` ENUM('active', 'inactive') DEFAULT 'active',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $count = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `events` (`id`, `title`, `event_date`, `event_time`, `location`, `description`, `rating`, `image_path`) VALUES
        (1, 'Student Leadership & Career Workshop', '2026-12-26', '10:00 AM', 'Main Auditorium', 'Interactive workshop on career pathways, leadership skills, and exam preparation.', 5, 'assets/images/courses/event-1.jpg'),
        (2, 'The Best Coaching & Annual Conference', '2026-12-28', '11:00 AM', 'Conference Hall', 'Annual academic conference celebrating student milestones and honors.', 5, 'assets/images/courses/event-2.jpg'),
        (3, 'The Ultimate Future Skills Program', '2026-12-21', '09:30 AM', 'Lab Hall', 'Specialized session on logical reasoning, science experiments, and problem solving.', 5, 'assets/images/courses/event-3.jpg'),
        (4, 'National Science & Technology Innovation Expo', '2026-12-15', '10:00 AM', 'Exhibition Ground', 'Student project exhibition highlighting science models and creative innovations.', 5, 'assets/images/courses/event-1.jpg')");
    }
} catch (Exception $e) {}

$message = '';
$error = '';

// Delete Event
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && strpos($item['image_path'], 'uploads/') === 0 && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$id]);
        $message = "Event deleted successfully!";
    }
}

// Add / Edit Event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $event_date = trim($_POST['event_date'] ?? date('Y-m-d'));
    $event_time = trim($_POST['event_time'] ?? '10:00 AM');
    $location = trim($_POST['location'] ?? 'Baripada Campus');
    $description = trim($_POST['description'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/events/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM events WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = 'evt_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = 'uploads/events/' . $fileName;
        }
    }

    if ($edit_id > 0) {
        $stmt = $pdo->prepare("UPDATE events SET title = ?, event_date = ?, event_time = ?, location = ?, description = ?, rating = ?, status = ?, image_path = ? WHERE id = ?");
        $stmt->execute([$title, $event_date, $event_time, $location, $description, $rating, $status, $image_path, $edit_id]);
        $message = "Event updated successfully!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date, event_time, location, description, rating, status, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $event_date, $event_time, $location, $description, $rating, $status, $image_path]);
        $message = "New event created!";
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM events ORDER BY event_date DESC")->fetchAll();
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
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-calendar-plus' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Event' : 'Add New Event' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Event Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" placeholder="Annual Science Exhibition 2026"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Event Date</label>
                    <input type="date" name="event_date" required value="<?= htmlspecialchars($editItem['event_date'] ?? date('Y-m-d')) ?>"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Time</label>
                    <input type="text" name="event_time" value="<?= htmlspecialchars($editItem['event_time'] ?? '10:00 AM') ?>" placeholder="10:00 AM - 1:00 PM"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Location / Venue</label>
                <input type="text" name="location" value="<?= htmlspecialchars($editItem['location'] ?? 'Baripada Campus') ?>" placeholder="Main Auditorium"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Description</label>
                <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Event Image / Banner</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Event' : 'Save Event' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="events.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Events List (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No events posted yet. Use the form to publish events.
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($items as $item): ?>
                    <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-400 flex flex-col items-center justify-center font-bold text-xs shrink-0 border border-indigo-500/20">
                                <span class="text-amber-400 text-sm uppercase"><?= date('M', strtotime($item['event_date'])) ?></span>
                                <span class="text-white text-base leading-none"><?= date('d', strtotime($item['event_date'])) ?></span>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-white truncate"><?= htmlspecialchars($item['title']) ?></h4>
                                <p class="text-xs text-slate-400 mt-0.5"><i class="fa-regular fa-clock mr-1 text-indigo-400"></i><?= htmlspecialchars($item['event_time']) ?> • <i class="fa-solid fa-location-dot mr-1 text-rose-400"></i><?= htmlspecialchars($item['location']) ?></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 shrink-0">
                            <span class="text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                ● <?= ucfirst($item['status']) ?>
                            </span>
                            <a href="events.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit</a>
                            <a href="events.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Delete this event?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
