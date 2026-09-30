<?php
// admin/video_gallery.php
include 'header.php';

// Create videos table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `video_gallery` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(255) NOT NULL,
        `youtube_url` VARCHAR(255) NOT NULL,
        `category` VARCHAR(100) DEFAULT 'General',
        `duration` VARCHAR(50) DEFAULT '',
        `description` TEXT,
        `status` ENUM('active', 'inactive') DEFAULT 'active',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (Exception $e) {}

$message = '';
$error = '';

// Helper to convert YouTube URL to embed URL or ID
function getYoutubeEmbedUrl($url) {
    if (empty($url)) return '';
    $videoId = '';
    // Extract video ID using regex for all YouTube link formats
    if (preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match)) {
        $videoId = $match[1];
    }
    if (!empty($videoId)) {
        return 'https://www.youtube.com/embed/' . $videoId;
    }
    return $url;
}

// Auto-fix existing non-embed URLs in database
try {
    $rawVids = $pdo->query("SELECT id, youtube_url FROM video_gallery")->fetchAll() ?: [];
    foreach ($rawVids as $rv) {
        $fixedUrl = getYoutubeEmbedUrl($rv['youtube_url']);
        if ($fixedUrl !== $rv['youtube_url']) {
            $pdo->prepare("UPDATE video_gallery SET youtube_url = ? WHERE id = ?")->execute([$fixedUrl, $rv['id']]);
        }
    }
} catch (Exception $e) {}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM video_gallery WHERE id = ?")->execute([$id]);
    $message = "Video deleted successfully!";
}

// Handle Add / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $youtube_url = trim($_POST['youtube_url'] ?? '');
    $category = trim($_POST['category'] ?? 'General');
    $duration = trim($_POST['duration'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $embedUrl = getYoutubeEmbedUrl($youtube_url);

    if (empty($title) || empty($embedUrl)) {
        $error = "Please provide a valid Video Title and YouTube URL.";
    } else {
        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE video_gallery SET title = ?, youtube_url = ?, duration = ?, description = ?, status = ? WHERE id = ?");
            $stmt->execute([$title, $embedUrl, $duration, $description, $status, $edit_id]);
            $message = "Video updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO video_gallery (title, youtube_url, duration, description, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $embedUrl, $duration, $description, $status]);
            $message = "New YouTube video added to gallery!";
        }
    }
}

// Fetch item for editing
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM video_gallery WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

// Fetch all videos
$videos = $pdo->query("SELECT * FROM video_gallery ORDER BY id DESC")->fetchAll() ?: [];
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
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-video' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit YouTube Video' : 'Add YouTube Video' ?>
        </h3>

        <form method="POST" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Video Title <span class="text-rose-400">*</span></label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>"
                    placeholder="e.g. Class 10 Board Physics Masterclass"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">YouTube Video URL / Link <span class="text-rose-400">*</span></label>
                <input type="url" name="youtube_url" required value="<?= htmlspecialchars($editItem['youtube_url'] ?? '') ?>"
                    placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <p class="text-[11px] text-slate-400 mt-1">Paste any standard YouTube video URL or Share link.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Duration / Label (Optional)</label>
                <input type="text" name="duration" placeholder="e.g. 15:30 mins" value="<?= htmlspecialchars($editItem['duration'] ?? '') ?>"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Description (Optional)</label>
                <textarea name="description" rows="2" placeholder="Brief summary of the video content..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Video' : 'Add Video' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="video_gallery.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Existing YouTube Videos (<?= count($videos) ?>)</h3>
        
        <?php if (empty($videos)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No videos added yet. Add a YouTube video URL using the form on the left.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($videos as $vid): ?>
                    <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex flex-col gap-3">
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-slate-900 border border-slate-700">
                            <iframe src="<?= htmlspecialchars($vid['youtube_url']) ?>" class="w-full h-full border-0" allowfullscreen></iframe>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[11px] font-medium <?= $vid['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?>">
                                    ● <?= ucfirst($vid['status']) ?>
                                </span>
                            </div>
                            <h4 class="text-sm font-semibold text-white line-clamp-1"><?= htmlspecialchars($vid['title']) ?></h4>
                            <?php if (!empty($vid['duration'])): ?>
                                <p class="text-xs text-slate-400 mt-0.5"><i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars($vid['duration']) ?></p>
                            <?php endif; ?>
                            <div class="flex gap-3 mt-3 pt-2 border-t border-slate-800">
                                <a href="video_gallery.php?action=edit&id=<?= $vid['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium"><i class="fa-solid fa-pen mr-1"></i>Edit</a>
                                <a href="video_gallery.php?action=delete&id=<?= $vid['id'] ?>" onclick="return confirm('Delete this video?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium"><i class="fa-solid fa-trash mr-1"></i>Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
