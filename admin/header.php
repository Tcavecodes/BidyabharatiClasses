<?php
// admin/header.php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/auth.php';
check_admin_auth();

// Fetch site details for logo & name
$stmtSettings = $pdo->query("SELECT * FROM site_settings WHERE id = 1");
$siteSettings = $stmtSettings->fetch() ?: [];

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - <?= htmlspecialchars($siteSettings['site_name'] ?? 'Bidyabharati Classes') ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
    <!-- Google Fonts Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, .font-heading { font-family: 'Outfit', sans-serif; }
        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="h-full flex flex-col bg-slate-950 text-slate-100">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside id="adminSidebar" class="w-64 bg-slate-900/90 border-r border-slate-800 flex flex-col shrink-0 transition-all duration-300">
        <!-- Logo Header -->
        <div class="p-5 border-b border-slate-800 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-xl bg-white/10 p-1 flex items-center justify-center shrink-0 border border-slate-700/60 shadow-lg">
                    <img src="../assets/images/bclogo.png" alt="Bidyabharati Classes Logo" class="w-full h-full object-contain">
                </div>
                <div class="sidebar-text">
                    <h2 class="font-bold text-base text-white tracking-wide leading-tight">Admin Portal</h2>
                    <p class="text-xs text-slate-400 font-medium truncate max-w-[140px]"><?= htmlspecialchars($siteSettings['site_name'] ?? 'Bidyabharati') ?></p>
                </div>
            </div>
            <button onclick="toggleAdminSidebar()" title="Close Sidebar" class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto custom-scrollbar">
            <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 py-2">Core Controls</div>

            <a href="index.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'index.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <a href="contact_details.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'contact_details.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-address-card w-5 text-center"></i>
                <span class="sidebar-text">Contact Details & Logo</span>
            </a>

            <a href="hero_sliders.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'hero_sliders.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-sliders w-5 text-center"></i>
                <span class="sidebar-text">Hero Banner Sliders</span>
            </a>

            <a href="gallery.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'gallery.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-images w-5 text-center"></i>
                <span class="sidebar-text">Photo Gallery</span>
            </a>

            <a href="video_gallery.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'video_gallery.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-video w-5 text-center"></i>
                <span class="sidebar-text">Video Gallery</span>
            </a>

            <a href="testimonials.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'testimonials.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-quote-right w-5 text-center"></i>
                <span class="sidebar-text">Testimonials</span>
            </a>

            <a href="faculties.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'faculties.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-chalkboard-teacher w-5 text-center"></i>
                <span class="sidebar-text">Faculties / Instructors</span>
            </a>

            <a href="achievers.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'achievers.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-trophy w-5 text-center"></i>
                <span class="sidebar-text">Achievers & Toppers</span>
            </a>

            <a href="documents.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'documents.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-file-pdf w-5 text-center"></i>
                <span class="sidebar-text">Download Documents</span>
            </a>

            <a href="events.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'events.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                <span class="sidebar-text">Campus Events</span>
            </a>

            <a href="notices.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'notices.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-bullhorn w-5 text-center"></i>
                <span class="sidebar-text">Notice Board</span>
            </a>

            <a href="enrollments.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg font-medium text-sm transition-all <?= $current_page == 'enrollments.php' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/60' ?>">
                <i class="fa-solid fa-user-graduate w-5 text-center"></i>
                <span class="sidebar-text">Enrollments & Inquiries</span>
            </a>
        </nav>

        <!-- User Profile footer -->
        <div class="p-4 border-t border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-slate-300 text-xs shrink-0">
                    <?= strtoupper(substr($_SESSION['admin_name'] ?? 'Admin', 0, 2)) ?>
                </div>
                <div class="sidebar-text">
                    <p class="text-xs font-semibold text-slate-200 leading-none"><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Administrator') ?></p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Online</p>
                </div>
            </div>
            <a href="logout.php" title="Logout" class="text-slate-400 hover:text-rose-400 transition-colors p-1.5 rounded-lg hover:bg-slate-800">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 overflow-y-auto bg-slate-950 flex flex-col">
        <!-- Top Navigation / Header -->
        <header class="h-16 border-b border-slate-800/80 bg-slate-900/50 backdrop-blur-md px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <button onclick="toggleAdminSidebar()" title="Toggle Sidebar" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700/80 transition-colors">
                    <i class="fa-solid fa-bars text-base"></i>
                </button>
                <h1 class="text-xl font-bold text-white tracking-tight">
                    <?php
                    switch($current_page) {
                        case 'index.php': echo 'Dashboard Overview'; break;
                        case 'contact_details.php': echo 'Contact & Branding Settings'; break;
                        case 'hero_sliders.php': echo 'Hero Banner Sliders'; break;
                        case 'gallery.php': echo 'Gallery Management'; break;
                        case 'testimonials.php': echo 'Testimonials Management'; break;
                        case 'faculties.php': echo 'Faculty & Instructors'; break;
                        case 'achievers.php': echo 'Achievers & Rankers'; break;
                        case 'documents.php': echo 'Download Documents'; break;
                        case 'events.php': echo 'Campus Events Management'; break;
                        case 'notices.php': echo 'Notice Board & Announcements'; break;
                        case 'enrollments.php': echo 'Student Enrollment Applications'; break;
                        case 'contact_messages.php': echo 'Contact Form Messages'; break;
                        default: echo 'Admin Panel';
                    }
                    ?>
                </h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="../index.php" target="_blank" class="flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 transition-colors border border-slate-700">
                    <i class="fa-solid fa-globe text-indigo-400"></i> View Live Site
                </a>
            </div>
        </header>

        <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            if (!sidebar) return;
            const isClosed = sidebar.classList.contains('-ml-64');
            if (isClosed) {
                sidebar.classList.remove('-ml-64');
                localStorage.setItem('admin_sidebar_closed', 'false');
            } else {
                sidebar.classList.add('-ml-64');
                localStorage.setItem('admin_sidebar_closed', 'true');
            }
        }

        // Restore sidebar state on page load
        if (localStorage.getItem('admin_sidebar_closed') === 'true') {
            const sidebar = document.getElementById('adminSidebar');
            if (sidebar) sidebar.classList.add('-ml-64');
        }
        </script>

        <!-- Body Content -->
        <div class="p-8 flex-1">
