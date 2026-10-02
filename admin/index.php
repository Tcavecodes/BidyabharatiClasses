<?php
// admin/index.php
include 'header.php';

// Fetch quick stats
$countGallery = $pdo->query("SELECT COUNT(*) FROM gallery")->fetchColumn();
$countTestimonials = $pdo->query("SELECT COUNT(*) FROM testimonials")->fetchColumn();
$countFaculties = $pdo->query("SELECT COUNT(*) FROM faculties")->fetchColumn();
$countAchievers = $pdo->query("SELECT COUNT(*) FROM achievers")->fetchColumn();
$countDocuments = $pdo->query("SELECT COUNT(*) FROM documents")->fetchColumn();
try {
    $countFaqs = $pdo->query("SELECT COUNT(*) FROM faqs")->fetchColumn();
} catch (Exception $e) {
    $countFaqs = 0;
}
?>

<!-- Welcome Banner -->
<div class="p-6 rounded-2xl bg-gradient-to-r from-indigo-900/60 via-purple-900/40 to-slate-900 border border-indigo-500/20 mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-white font-heading">Welcome back, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?>!</h2>
        <p class="text-slate-300 text-sm mt-1">Manage all your institute details, media gallery, faculty directory, achievers, and downloadable files from here.</p>
    </div>
    <a href="contact_details.php" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-lg shadow-indigo-600/30 transition-all">
        <i class="fa-solid fa-gear mr-1.5"></i> Update Site Info
    </a>
</div>

<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 mb-8">
    <!-- Gallery -->
    <a href="gallery.php" class="p-5 rounded-2xl glass-panel hover:border-indigo-500/40 transition-all group">
        <div class="flex items-center justify-between mb-3">
            <span class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-images"></i>
            </span>
            <span class="text-xs font-medium text-slate-400">Total Items</span>
        </div>
        <div class="text-2xl font-bold text-white font-heading"><?= $countGallery ?></div>
        <div class="text-xs text-slate-400 mt-1">Gallery Images</div>
    </a>

    <!-- Testimonials -->
    <a href="testimonials.php" class="p-5 rounded-2xl glass-panel hover:border-indigo-500/40 transition-all group">
        <div class="flex items-center justify-between mb-3">
            <span class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-quote-right"></i>
            </span>
            <span class="text-xs font-medium text-slate-400">Reviews</span>
        </div>
        <div class="text-2xl font-bold text-white font-heading"><?= $countTestimonials ?></div>
        <div class="text-xs text-slate-400 mt-1">Student Reviews</div>
    </a>

    <!-- Faculty -->
    <a href="faculties.php" class="p-5 rounded-2xl glass-panel hover:border-indigo-500/40 transition-all group">
        <div class="flex items-center justify-between mb-3">
            <span class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-chalkboard-teacher"></i>
            </span>
            <span class="text-xs font-medium text-slate-400">Teachers</span>
        </div>
        <div class="text-2xl font-bold text-white font-heading"><?= $countFaculties ?></div>
        <div class="text-xs text-slate-400 mt-1">Faculty Members</div>
    </a>

    <!-- Achievers -->
    <a href="achievers.php" class="p-5 rounded-2xl glass-panel hover:border-indigo-500/40 transition-all group">
        <div class="flex items-center justify-between mb-3">
            <span class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-400 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-trophy"></i>
            </span>
            <span class="text-xs font-medium text-slate-400">Toppers</span>
        </div>
        <div class="text-2xl font-bold text-white font-heading"><?= $countAchievers ?></div>
        <div class="text-xs text-slate-400 mt-1">Star Achievers</div>
    </a>

    <!-- Documents -->
    <a href="documents.php" class="p-5 rounded-2xl glass-panel hover:border-indigo-500/40 transition-all group">
        <div class="flex items-center justify-between mb-3">
            <span class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-400 flex items-center justify-center text-lg group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-file-pdf"></i>
            </span>
            <span class="text-xs font-medium text-slate-400">PDFs/Notes</span>
        </div>
        <div class="text-2xl font-bold text-white font-heading"><?= $countDocuments ?></div>
        <div class="text-xs text-slate-400 mt-1">Downloads</div>
    </a>
</div>

<!-- Quick Action Shortcuts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="glass-panel p-6 rounded-2xl">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2">
            <i class="fa-solid fa-bolt text-amber-400"></i> Quick Management Shortcuts
        </h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="hero_sliders.php" class="p-4 rounded-xl bg-slate-800/60 hover:bg-slate-800 border border-slate-700/50 flex items-center gap-3 transition-colors">
                <i class="fa-solid fa-sliders text-indigo-400"></i>
                <span class="text-sm text-slate-200 font-medium">Manage Hero Sliders</span>
            </a>
            <a href="gallery.php" class="p-4 rounded-xl bg-slate-800/60 hover:bg-slate-800 border border-slate-700/50 flex items-center gap-3 transition-colors">
                <i class="fa-solid fa-cloud-arrow-up text-blue-400"></i>
                <span class="text-sm text-slate-200 font-medium">Upload Photos</span>
            </a>
            <a href="faculties.php" class="p-4 rounded-xl bg-slate-800/60 hover:bg-slate-800 border border-slate-700/50 flex items-center gap-3 transition-colors">
                <i class="fa-solid fa-user-plus text-emerald-400"></i>
                <span class="text-sm text-slate-200 font-medium">Add New Faculty</span>
            </a>
            <a href="documents.php" class="p-4 rounded-xl bg-slate-800/60 hover:bg-slate-800 border border-slate-700/50 flex items-center gap-3 transition-colors">
                <i class="fa-solid fa-file-circle-plus text-rose-400"></i>
                <span class="text-sm text-slate-200 font-medium">Upload Document</span>
            </a>
            <a href="faqs.php" class="p-4 rounded-xl bg-slate-800/60 hover:bg-slate-800 border border-slate-700/50 flex items-center gap-3 transition-colors">
                <i class="fa-solid fa-circle-question text-purple-400"></i>
                <span class="text-sm text-slate-200 font-medium">Manage FAQs (<?= $countFaqs ?>)</span>
            </a>
        </div>
    </div>

    <!-- Contact Info Summary -->
    <div class="glass-panel p-6 rounded-2xl">
        <h3 class="text-base font-bold text-white font-heading mb-4 flex items-center gap-2">
            <i class="fa-solid fa-circle-info text-indigo-400"></i> Active Contact Details
        </h3>
        <div class="space-y-3 text-sm">
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <span class="text-slate-400"><i class="fa-solid fa-phone text-indigo-400 mr-2"></i> Phone:</span>
                <span class="text-slate-200 font-medium"><?= htmlspecialchars($siteSettings['phone'] ?? 'N/A') ?></span>
            </div>
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <span class="text-slate-400"><i class="fa-solid fa-envelope text-indigo-400 mr-2"></i> Email:</span>
                <span class="text-slate-200 font-medium"><?= htmlspecialchars($siteSettings['email'] ?? 'N/A') ?></span>
            </div>
            <div class="flex items-center justify-between pb-2 border-b border-slate-800">
                <span class="text-slate-400"><i class="fa-solid fa-clock text-indigo-400 mr-2"></i> Hours:</span>
                <span class="text-slate-200 font-medium"><?= htmlspecialchars($siteSettings['working_hours'] ?? 'N/A') ?></span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-slate-400"><i class="fa-solid fa-map-marker-alt text-indigo-400 mr-2"></i> Address:</span>
                <span class="text-slate-200 font-medium truncate max-w-[200px]"><?= htmlspecialchars($siteSettings['address'] ?? 'N/A') ?></span>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
