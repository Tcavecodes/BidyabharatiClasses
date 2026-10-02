<?php
// admin/blogs.php
include 'header.php';

// Auto-create table if not created
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `blogs` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) NOT NULL,
      `slug` VARCHAR(255) DEFAULT '',
      `category` VARCHAR(100) DEFAULT 'Education',
      `author_name` VARCHAR(150) DEFAULT 'TIKAM BEHERA',
      `author_role` VARCHAR(150) DEFAULT 'Director & Physics Faculty',
      `author_image` VARCHAR(255) DEFAULT 'assets/images/team/director.jpeg',
      `image_path` VARCHAR(255) DEFAULT 'assets/images/blog/blog-1.jpg',
      `summary` TEXT,
      `content` LONGTEXT NOT NULL,
      `status` ENUM('active', 'inactive') DEFAULT 'active',
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $count = $pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO `blogs` (`id`, `title`, `category`, `author_name`, `author_role`, `image_path`, `summary`, `content`) VALUES
        (1, 'Effective Preparation Strategies for Board & Entrance Examinations', 'Exam Guidance', 'TIKAM BEHERA', 'Director & Physics Faculty', 'assets/images/blog/blog-1.jpg', 'Discover key study habits, time management tips, and problem-solving techniques to excel in Board and Competitive Exams.', 'Success in Board and entrance examinations like NEET and JEE requires a balanced mix of conceptual clarity, regular practice, and smart test strategies.\n\nKey Focus Areas:\n1. Master the Fundamentals: Thoroughly understand core concepts in Physics, Chemistry, and Mathematics/Biology.\n2. Time Management: Follow a disciplined daily schedule allocated across subject topics and doubt sessions.\n3. Regular Mock Tests: Simulate actual examination conditions to boost speed and accuracy.\n\nAt Bidyabharati Classes, our personalized attention and structured test series ensure students stay ahead with confidence.'),
        (2, 'The Role of Physics and Problem Solving in Future Careers', 'Science & Innovation', 'TIKAM BEHERA', 'M. Sc. Physics', 'assets/images/blog/blog-2.jpg', 'Why analytical thinking and strong fundamentals in Physics open doors to modern engineering, technology, and research careers.', 'Physics is not merely a subject; it is the study of how the universe behaves. Developing analytical problem-solving skills through Physics empowers students to tackle complex challenges across engineering, data science, and technology.\n\nBuilding strong analytical skills from early school years forms a foundation that benefits students throughout higher education and professional endeavors.'),
        (3, 'Building Academic Excellence: Guidance for Class 8 to 10 Foundation Batches', 'Academic Insights', 'Academic Team', 'Senior Faculty', 'assets/images/blog/blog-3.jpg', 'Starting early with foundation courses builds competitive confidence and conceptual strength for senior secondary challenges.', 'Early foundation batches bridge the gap between basic school curriculum and advanced competitive standards. By mastering concepts early, students develop problem-solving speed and critical thinking before entering Class 11 and 12.')");
    }
} catch (Exception $e) {}

$message = '';
$error = '';

// Delete Blog
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && strpos($item['image_path'], 'uploads/blogs/') === 0 && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
        $message = "Blog post deleted successfully!";
    }
}

// Add / Edit Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'Education');
    $author_name = trim($_POST['author_name'] ?? 'TIKAM BEHERA');
    $author_role = trim($_POST['author_role'] ?? 'Director & Physics Faculty');
    $summary = trim($_POST['summary'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/blogs/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = 'assets/images/blog/blog-1.jpg';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM blogs WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: 'assets/images/blog/blog-1.jpg';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = 'blog_' . time() . '_' . rand(100, 999) . '.' . $ext;
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image_path = 'uploads/blogs/' . $fileName;
        }
    }

    if (!empty($title) && !empty($content)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE blogs SET title = ?, slug = ?, category = ?, author_name = ?, author_role = ?, summary = ?, content = ?, status = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $category, $author_name, $author_role, $summary, $content, $status, $image_path, $edit_id]);
            $message = "Blog post updated successfully!";
        } else {
            $stmt = $pdo->prepare("INSERT INTO blogs (title, slug, category, author_name, author_role, summary, content, status, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $category, $author_name, $author_role, $summary, $content, $status, $image_path]);
            $message = "New blog post published successfully!";
        }
    } else {
        $error = "Title and Content fields are required.";
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM blogs ORDER BY id DESC")->fetchAll();
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
            <?= $editItem ? 'Edit Blog Post' : 'Add New Blog Post' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Article Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>"
                    placeholder="e.g. Effective Preparation Strategies for Board Exams"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Category</label>
                <input type="text" name="category" value="<?= htmlspecialchars($editItem['category'] ?? 'Education') ?>"
                    placeholder="e.g. Exam Guidance, Academic Insights, Science"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Author Name</label>
                    <input type="text" name="author_name" value="<?= htmlspecialchars($editItem['author_name'] ?? 'TIKAM BEHERA') ?>"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Author Role</label>
                    <input type="text" name="author_role" value="<?= htmlspecialchars($editItem['author_role'] ?? 'Director & Physics Faculty') ?>"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Featured Image</label>
                <?php if (!empty($editItem['image_path'])): ?>
                    <div class="mb-2 flex items-center gap-3">
                        <img src="../<?= htmlspecialchars($editItem['image_path']) ?>" class="w-16 h-12 object-cover rounded-lg border border-slate-700" alt="Current Image">
                        <span class="text-xs text-slate-400">Current Cover Image</span>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*"
                    class="w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-600/20 file:text-indigo-400 hover:file:bg-indigo-600 hover:file:text-white cursor-pointer">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Short Summary / Teaser</label>
                <textarea name="summary" rows="2" placeholder="Brief 1-2 sentence overview for blog list cards..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['summary'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Full Article Content</label>
                <textarea name="content" rows="8" required placeholder="Type full blog post body here..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none"><?= htmlspecialchars($editItem['content'] ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Published / Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Draft / Inactive</option>
                </select>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <?= $editItem ? 'Update Blog Post' : 'Publish Blog Post' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="blogs.php" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table List Card -->
    <div class="lg:col-span-2 glass-panel p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
            <h3 class="text-base font-bold text-white font-heading flex items-center gap-2">
                <i class="fa-solid fa-newspaper text-indigo-400"></i>
                All Blog Posts (<?= count($items) ?>)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-xs uppercase tracking-wider text-slate-400 bg-slate-800/50 rounded-xl">
                    <tr>
                        <th class="px-4 py-3">Cover</th>
                        <th class="px-4 py-3">Title & Summary</th>
                        <th class="px-4 py-3">Category / Author</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-500">No blog posts found. Publish one using the form on the left.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-4 py-3.5">
                                    <img src="../<?= htmlspecialchars(!empty($item['image_path']) ? $item['image_path'] : 'assets/images/blog/blog-1.jpg') ?>"
                                         class="w-16 h-12 object-cover rounded-lg border border-slate-700/80" alt="Cover">
                                </td>
                                <td class="px-4 py-3.5 max-w-xs">
                                    <div class="font-semibold text-white mb-1 line-clamp-1"><?= htmlspecialchars($item['title']) ?></div>
                                    <div class="text-xs text-slate-400 line-clamp-2"><?= htmlspecialchars($item['summary'] ?: substr($item['content'], 0, 100)) ?></div>
                                    <div class="text-[10px] text-slate-500 mt-1"><i class="fa-regular fa-clock mr-1"></i><?= date('M d, Y', strtotime($item['created_at'])) ?></div>
                                </td>
                                <td class="px-4 py-3.5 text-xs">
                                    <span class="px-2.5 py-1 rounded-md bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 block w-fit mb-1 font-medium">
                                        <?= htmlspecialchars($item['category']) ?>
                                    </span>
                                    <span class="text-slate-400 text-[11px]"><i class="fa-solid fa-user text-slate-500 mr-1"></i><?= htmlspecialchars($item['author_name']) ?></span>
                                </td>
                                <td class="px-4 py-3.5">
                                    <?php if ($item['status'] === 'active'): ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Published</span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-500/10 text-rose-400 border border-rose-500/20">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3.5 text-right space-x-2">
                                    <a href="../blog-detail.php?id=<?= $item['id'] ?>" target="_blank" class="p-1.5 rounded-lg bg-emerald-600/20 text-emerald-400 hover:bg-emerald-600 hover:text-white transition-all inline-block" title="Preview on Website">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="blogs.php?action=edit&id=<?= $item['id'] ?>" class="p-1.5 rounded-lg bg-indigo-600/20 text-indigo-400 hover:bg-indigo-600 hover:text-white transition-all inline-block" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <a href="blogs.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this blog post?')" class="p-1.5 rounded-lg bg-rose-600/20 text-rose-400 hover:bg-rose-600 hover:text-white transition-all inline-block" title="Delete">
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
