<?php
// admin/documents.php
include 'header.php';

$message = '';
$error = '';

// Delete Document
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT file_path FROM documents WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['file_path']) && file_exists(__DIR__ . '/../' . $item['file_path'])) {
            @unlink(__DIR__ . '/../' . $item['file_path']);
        }
        $pdo->prepare("DELETE FROM documents WHERE id = ?")->execute([$id]);
        $message = "Document deleted!";
    }
}

// Upload / Edit Document
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $class_name = trim($_POST['class_name'] ?? 'General');
    $medium = trim($_POST['medium'] ?? 'English');
    $category = 'General';
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/documents/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $file_path = '';
    $file_size = '';
    $file_type = 'pdf';

    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT file_path, file_size, file_type FROM documents WHERE id = ?");
        $stmt->execute([$edit_id]);
        $oldDoc = $stmt->fetch();
        if ($oldDoc) {
            $file_path = $oldDoc['file_path'];
            $file_size = $oldDoc['file_size'];
            $file_type = $oldDoc['file_type'];
        }
    }

    if (isset($_FILES['doc_file']) && $_FILES['doc_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        $allowedDocExts = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'jpg', 'jpeg', 'png'];
        $docCheck = validate_uploaded_file($_FILES['doc_file'], '5 MB', 5 * 1024 * 1024, $allowedDocExts);
        if (!$docCheck['valid']) {
            $error = $docCheck['error'];
        } else {
            $ext = $docCheck['ext'];
            $fileName = 'doc_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $targetFile = $uploadDir . $fileName;

            $bytes = $_FILES['doc_file']['size'];
            if ($bytes >= 1048576) {
                $formattedSize = number_format($bytes / 1048576, 2) . ' MB';
            } else {
                $formattedSize = number_format($bytes / 1024, 2) . ' KB';
            }

            if (move_uploaded_file($_FILES['doc_file']['tmp_name'], $targetFile)) {
                $file_path = 'uploads/documents/' . $fileName;
                $file_size = $formattedSize;
                $file_type = $ext;
            }
        }
    }

    if (empty($error)) {
        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE documents SET title = ?, class_name = ?, medium = ?, category = ?, status = ?, file_path = ?, file_size = ?, file_type = ? WHERE id = ?");
            $stmt->execute([$title, $class_name, $medium, $category, $status, $file_path, $file_size, $file_type, $edit_id]);
            $message = "Document updated!";
        } else {
            if (empty($file_path)) {
                $error = "Please choose a PDF or document file to upload.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO documents (title, class_name, medium, category, status, file_path, file_size, file_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$title, $class_name, $medium, $category, $status, $file_path, $file_size, $file_type]);
                $message = "New document uploaded!";
            }
        }
    }
}

$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM documents WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

$items = $pdo->query("SELECT * FROM documents ORDER BY id DESC")->fetchAll();
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

<div class="space-y-8">
    <!-- Form Card -->
    <div class="glass-panel p-6 rounded-2xl">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2 border-b border-slate-800 pb-3">
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-file-circle-plus' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Document' : 'Upload New Document' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Document Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>" placeholder="Class 12 Physics Syllabus 2025"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Class</label>
                <input type="text" name="class_name" value="<?= htmlspecialchars($editItem['class_name'] ?? 'Class 10') ?>" placeholder="e.g. Class 10, Class 12, All"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Medium</label>
                <select name="medium" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="English" <?= ($editItem['medium'] ?? '') === 'English' ? 'selected' : '' ?>>English</option>
                    <option value="Odia" <?= ($editItem['medium'] ?? '') === 'Odia' ? 'selected' : '' ?>>Odia</option>
                    <option value="Both" <?= ($editItem['medium'] ?? '') === 'Both' ? 'selected' : '' ?>>Both (Eng & Odia)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">File Upload (PDF, DOC, ZIP)</label>
                <input type="file" name="doc_file" accept=".pdf,.doc,.docx,.zip,.rar,.txt" <?= $editItem ? '' : 'required' ?>
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <div class="md:col-span-4 pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Document' : 'Upload File' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="documents.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="glass-panel p-6 rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-800">
            <h3 class="text-base font-bold text-white font-heading">Uploaded Documents (<?= count($items) ?>)</h3>
        </div>
        
        <?php if (empty($items)): ?>
            <div class="p-8 text-center text-slate-400 text-sm">
                No documents uploaded yet. Add PDFs or study materials using the form above.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-950/40 text-blue-400 text-xs font-bold uppercase tracking-wider border-b border-slate-800">
                            <th class="py-3.5 px-4">DOCUMENT NAME & SIZE</th>
                            <th class="py-3.5 px-4">CLASS</th>
                            <th class="py-3.5 px-4">MEDIUM</th>
                            <th class="py-3.5 px-4">DATE</th>
                            <th class="py-3.5 px-4">TYPE</th>
                            <th class="py-3.5 px-4 text-right">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        <?php foreach ($items as $item): 
                            $uploadDate = !empty($item['created_at']) ? date('d M Y', strtotime($item['created_at'])) : date('d M Y');
                            $fileType = !empty($item['file_type']) ? strtoupper($item['file_type']) : 'PDF';
                            $fileSize = !empty($item['file_size']) ? $item['file_size'] : '—';
                            $className = !empty($item['class_name']) ? $item['class_name'] : 'General';
                            $mediumName = !empty($item['medium']) ? $item['medium'] : 'English';
                        ?>
                            <tr class="hover:bg-slate-800/40 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-base shrink-0 border border-rose-500/20">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-sm font-medium text-white truncate max-w-md"><?= htmlspecialchars($item['title']) ?></h4>
                                            <span class="text-xs text-slate-400"><?= htmlspecialchars($fileSize) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-slate-300 font-medium text-xs">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-800 border border-slate-700/80 text-slate-200"><?= htmlspecialchars($className) ?></span>
                                </td>
                                <td class="py-4 px-4 text-slate-300 text-xs">
                                    <?= htmlspecialchars($mediumName) ?>
                                </td>
                                <td class="py-4 px-4 text-slate-400 text-xs whitespace-nowrap">
                                    <?= $uploadDate ?>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold tracking-wider bg-rose-500/20 text-rose-300 uppercase border border-rose-500/30"><?= htmlspecialchars($fileType) ?></span>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="../<?= htmlspecialchars($item['file_path']) ?>" target="_blank" title="View / Download" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-indigo-400 text-xs font-semibold">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <a href="documents.php?action=edit&id=<?= $item['id'] ?>" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-indigo-400 text-xs font-medium">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="documents.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Delete this document?')" class="p-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-rose-400 text-xs font-medium">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
