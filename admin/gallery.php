<?php
// admin/gallery.php
include 'header.php';

$message = '';
$error = '';

// Handle Delete Photo
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        if (!empty($item['image_path']) && file_exists(__DIR__ . '/../' . $item['image_path'])) {
            @unlink(__DIR__ . '/../' . $item['image_path']);
        }
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        $message = "Gallery image deleted successfully!";
    }
}

// Handle Rename Category Tab
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_type']) && $_POST['action_type'] === 'rename_category') {
    $oldCat = trim($_POST['old_category'] ?? '');
    $newCat = trim($_POST['new_category'] ?? '');
    if (!empty($oldCat) && !empty($newCat)) {
        $stmtRen = $pdo->prepare("UPDATE gallery SET category = ? WHERE category = ?");
        $stmtRen->execute([$newCat, $oldCat]);
        $message = "Category tab '" . htmlspecialchars($oldCat) . "' renamed to '" . htmlspecialchars($newCat) . "'!";
    }
}

// Handle Add / Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'General');
    $status = $_POST['status'] ?? 'active';
    $edit_id = isset($_POST['edit_id']) ? (int)$_POST['edit_id'] : 0;

    $uploadDir = __DIR__ . '/../uploads/gallery/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image_path = '';
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
        $stmt->execute([$edit_id]);
        $image_path = $stmt->fetchColumn() ?: '';
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $imgCheck = validate_uploaded_file($_FILES['image'], '2 MB', MAX_IMAGE_SIZE_BYTES, ALLOWED_IMAGE_EXTENSIONS);
        if (!$imgCheck['valid']) {
            $error = $imgCheck['error'];
        } else {
            $ext = $imgCheck['ext'];
            $fileName = 'gal_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $targetFile = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image_path = 'uploads/gallery/' . $fileName;
            }
        }
    }

    if (empty($error)) {
        if ($edit_id > 0) {
            $stmt = $pdo->prepare("UPDATE gallery SET title = ?, category = ?, status = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$title, $category, $status, $image_path, $edit_id]);
            $message = "Gallery item updated!";
        } else {
            if (empty($image_path)) {
                $error = "Please upload an image for the gallery item.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO gallery (title, category, status, image_path) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $category, $status, $image_path]);
                $message = "New gallery image added!";
            }
        }
    }
}

// Fetch item for editing if requested
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([(int)$_GET['id']]);
    $editItem = $stmt->fetch();
}

// Fetch all gallery items
$items = $pdo->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();
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

<?php
// Extract all unique existing categories
$existing_categories = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != '' ORDER BY category ASC")->fetchAll(PDO::FETCH_COLUMN) ?: [];
$default_preset_categories = ['Classroom', 'Events & Celebrations', 'Student Activities', 'Achievements', 'Campus & Infrastructure', 'Workshops & Seminars'];
$all_known_categories = array_unique(array_merge($default_preset_categories, $existing_categories));
?>

<!-- Category Tabs Summary Badge Banner -->
<div class="glass-panel p-5 rounded-2xl mb-8 border border-slate-800">
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
        <div class="flex-1">
            <h3 class="text-sm font-bold text-white flex items-center gap-2 font-heading">
                <i class="fa-solid fa-tags text-indigo-400"></i> Active Gallery Filter Tabs
            </h3>
            <p class="text-xs text-slate-400 mt-1">Click any category badge below to quickly set it for your new upload, or type a custom name in the form to create a new tab!</p>
            <div class="flex flex-wrap gap-2 mt-3">
                <?php foreach ($all_known_categories as $catBadge): 
                    $catPhotoCount = 0;
                    $stmtCount = $pdo->prepare("SELECT COUNT(*) FROM gallery WHERE category = ?");
                    $stmtCount->execute([$catBadge]);
                    $catPhotoCount = $stmtCount->fetchColumn();
                ?>
                    <div class="inline-flex items-center rounded-full bg-indigo-500/15 border border-indigo-500/30 text-indigo-300 text-xs font-semibold overflow-hidden">
                        <button type="button" onclick="setCategoryValue('<?= htmlspecialchars(addslashes($catBadge)) ?>')"
                            class="px-3 py-1 hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-folder text-[10px]"></i> <?= htmlspecialchars($catBadge) ?>
                            <span class="text-[10px] opacity-75">(<?= $catPhotoCount ?>)</span>
                        </button>
                        <button type="button" onclick="openRenameModal('<?= htmlspecialchars(addslashes($catBadge)) ?>')"
                            title="Rename Category Tab Name"
                            class="px-2 py-1 bg-indigo-500/20 hover:bg-indigo-600 text-indigo-300 hover:text-white transition-all border-l border-indigo-500/30">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                        </button>
                        <?php if ($catPhotoCount > 0): ?>
                            <a href="gallery.php?action=delete_category&cat_name=<?= urlencode($catBadge) ?>" 
                                onclick="return confirm('Deleting category <?= htmlspecialchars(addslashes($catBadge)) ?> will remove all <?= $catPhotoCount ?> photos in this category. Continue?')"
                                title="Delete category tab and its photos"
                                class="px-2 py-1 bg-rose-500/20 hover:bg-rose-600 text-rose-300 hover:text-white transition-all border-l border-indigo-500/30">
                                <i class="fa-solid fa-xmark text-[11px]"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Rename Category Modal -->
<div id="rename_cat_modal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-panel p-6 rounded-2xl max-w-md w-full border border-slate-700 shadow-2xl">
        <h4 class="text-base font-bold text-white mb-2 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-indigo-400"></i> Rename Category Tab
        </h4>
        <p class="text-xs text-slate-400 mb-4">Renaming this category will update the tab name across all assigned gallery photos.</p>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="action_type" value="rename_category">
            <input type="hidden" id="old_category_input" name="old_category">
            
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase mb-1">New Tab Name</label>
                <input type="text" id="new_category_input" name="new_category" required
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="flex gap-2 justify-end pt-2">
                <button type="button" onclick="closeRenameModal()" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs transition-all shadow-md">Save New Name</button>
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Card -->
    <div class="glass-panel p-6 rounded-2xl h-fit">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2 border-b border-slate-800 pb-3">
            <i class="fa-solid <?= $editItem ? 'fa-pen-to-square' : 'fa-plus-circle' ?> text-indigo-400"></i>
            <?= $editItem ? 'Edit Gallery Photo' : 'Upload Photo & Assign Category Tab' ?>
        </h3>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php if ($editItem): ?>
                <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Photo Title</label>
                <input type="text" name="title" required value="<?= htmlspecialchars($editItem['title'] ?? '') ?>"
                    placeholder="e.g. Science Lab Demonstration"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">
                    Category Tab <span class="text-indigo-400">*</span>
                </label>
                
                <!-- Category Select Dropdown -->
                <select id="category_select" onchange="toggleCustomCategoryInput(this.value)"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none mb-2">
                    <?php 
                    $currentCat = $editItem['category'] ?? 'Classroom';
                    $isCustom = !in_array($currentCat, $all_known_categories) && !empty($currentCat);
                    ?>
                    <?php foreach ($all_known_categories as $catOpt): ?>
                        <option value="<?= htmlspecialchars($catOpt) ?>" <?= ($currentCat === $catOpt) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($catOpt) ?>
                        </option>
                    <?php endforeach; ?>
                    <option value="--NEW--" <?= $isCustom ? 'selected' : '' ?>>➕ + Create New Category Tab...</option>
                </select>

                <!-- Actual submitted Category input (Hidden or Custom) -->
                <div id="custom_cat_wrapper" class="<?= $isCustom ? '' : 'hidden' ?> mt-2">
                    <label class="block text-[11px] font-semibold text-indigo-300 mb-1">Enter New Category Name:</label>
                    <input type="text" id="category_custom_input" placeholder="e.g. Sports Day, Excursion, Science Expo" value="<?= $isCustom ? htmlspecialchars($currentCat) : '' ?>"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-indigo-500/50 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <!-- Hidden form submit value -->
                <input type="hidden" id="category_input" name="category" value="<?= htmlspecialchars($currentCat) ?>">

                <p class="text-[11px] text-slate-400 mt-2 leading-relaxed">
                    Choose an existing category from the dropdown above, or select <strong>"+ Create New Category Tab"</strong> to add a brand new tab to the website!
                </p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="active" <?= ($editItem['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($editItem['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Image Upload</label>
                <input type="file" name="image" accept="image/*" <?= $editItem ? '' : 'required' ?>
                    class="w-full px-3 py-2 rounded-xl bg-slate-800/80 border border-slate-700 text-slate-300 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
            </div>

            <?php if ($editItem && !empty($editItem['image_path'])): ?>
                <div class="mt-2">
                    <p class="text-xs text-slate-400 mb-1">Current Preview:</p>
                    <img src="../<?= htmlspecialchars($editItem['image_path']) ?>" class="h-24 w-full object-cover rounded-xl border border-slate-700">
                </div>
            <?php endif; ?>

            <div class="pt-2 flex gap-2">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-all shadow-lg shadow-indigo-600/30">
                    <?= $editItem ? 'Update Photo' : 'Upload Photo' ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="gallery.php" class="py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Data List Grid -->
    <div class="lg:col-span-2 space-y-4">
        <h3 class="text-base font-bold text-white font-heading mb-2">Existing Gallery Photos (<?= count($items) ?>)</h3>
        
        <?php if (empty($items)): ?>
            <div class="glass-panel p-8 text-center rounded-2xl text-slate-400 text-sm">
                No gallery items uploaded yet. Use the form to add photos.
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($items as $item): ?>
                    <div class="glass-panel p-4 rounded-2xl border border-slate-800 flex gap-4 items-center">
                        <img src="../<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-20 h-20 object-cover rounded-xl border border-slate-700 shrink-0">
                        <div class="flex-1 min-w-0">
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-500/20 text-indigo-300 uppercase tracking-wide mb-1"><?= htmlspecialchars($item['category']) ?></span>
                            <h4 class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($item['title']) ?></h4>
                            <span class="inline-block text-[11px] font-medium <?= $item['status'] === 'active' ? 'text-emerald-400' : 'text-slate-500' ?> mt-1">
                                ● <?= ucfirst($item['status']) ?>
                            </span>
                            <div class="flex gap-3 mt-2">
                                <a href="gallery.php?action=edit&id=<?= $item['id'] ?>" class="text-xs text-indigo-400 hover:text-indigo-300 font-medium">Edit</a>
                                <a href="gallery.php?action=delete&id=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this image?')" class="text-xs text-rose-400 hover:text-rose-300 font-medium">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleCustomCategoryInput(val) {
    const wrapper = document.getElementById('custom_cat_wrapper');
    const hiddenInput = document.getElementById('category_input');
    const customInput = document.getElementById('category_custom_input');

    if (val === '--NEW--') {
        wrapper.classList.remove('hidden');
        customInput.focus();
        hiddenInput.value = customInput.value.trim();
    } else {
        wrapper.classList.add('hidden');
        hiddenInput.value = val;
    }
}

function setCategoryValue(val) {
    const select = document.getElementById('category_select');
    const hiddenInput = document.getElementById('category_input');
    const wrapper = document.getElementById('custom_cat_wrapper');
    
    if (select) {
        let found = false;
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].value === val) {
                select.selectedIndex = i;
                found = true;
                break;
            }
        }
        if (!found) {
            select.value = '--NEW--';
            wrapper.classList.remove('hidden');
            document.getElementById('category_custom_input').value = val;
        } else {
            wrapper.classList.add('hidden');
        }
    }
    if (hiddenInput) {
        hiddenInput.value = val;
    }
}

// Keep hidden input updated when typing in custom input
document.addEventListener('DOMContentLoaded', function() {
    const customInput = document.getElementById('category_custom_input');
    const hiddenInput = document.getElementById('category_input');
    const select = document.getElementById('category_select');

    if (customInput) {
        customInput.addEventListener('input', function() {
            if (select.value === '--NEW--') {
                hiddenInput.value = this.value.trim();
            }
        });
    }
});

function openRenameModal(catName) {
    document.getElementById('old_category_input').value = catName;
    document.getElementById('new_category_input').value = catName;
    document.getElementById('rename_cat_modal').classList.remove('hidden');
    document.getElementById('new_category_input').focus();
}

function closeRenameModal() {
    document.getElementById('rename_cat_modal').classList.add('hidden');
}
</script>

<?php include 'footer.php'; ?>
