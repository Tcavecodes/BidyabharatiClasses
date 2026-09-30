<?php 
$page_title = "Downloads | Bidyabharati Classes";
include 'includes/header.php'; 
?>
<main>
<!-- Toast Notification Container -->
<div class="fixed top-24 right-6 z-50 transform translate-y-[-100%] opacity-0 transition-all duration-300 pointer-events-none" id="download-toast">
<div class="flex items-center gap-3 bg-brand-navy text-white px-5 py-3 rounded-xl shadow-2xl border border-slate-700 font-['Poppins']">
<i class="fa-solid fa-[#06bbcc] fa-circle-check text-lg text-[#06bbcc]"></i>
<span class="text-xs sm:text-sm font-semibold" id="toast-message">Starting download...</span>
</div>
</div>
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-brand-lightBlue/50 via-white to-brand-bgLight pt-36 md:pt-40 lg:pt-44 pb-16 lg:pb-20 overflow-hidden" data-purpose="hero-section">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<!-- Text Column -->
<div class="lg:col-span-7 space-y-6">
<span class="campus-update-tag">Resource Center</span>
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-navy leading-tight tracking-tight font-['Poppins']">
              Academic Resources &amp; <br class="hidden sm:inline"/>
<span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-blue to-brand-navy">Downloads</span>
</h1>
<p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl font-['Inter']">
              Access important notices, academic resources, forms, study materials, schedules, and other useful documents from Bidyabharati Classes in Baripada, Mayurbhanj, Odisha.
            </p>
<div class="pt-4 flex flex-wrap items-center gap-4 font-['Poppins']">
<button class="btn btn-curve mr-2" onclick="document.getElementById('document-repository').scrollIntoView({ behavior: 'smooth' })">
  Browse Documents <i class="fa-solid fa-arrow-down ml-2"></i>
</button>
<div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-200 shadow-sm text-xs font-semibold">
<span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
<span class="text-brand-navy font-bold">48+ Documents Available</span>
<span class="text-slate-500">• Verified 2025–26</span>
</div>
</div>
</div>
<!-- Right Column - Visual Composition -->
<div class="lg:col-span-5 relative">
<div class="relative mx-auto max-w-md lg:max-w-none">
<!-- Decorative background glow -->
<div class="absolute -inset-4 bg-gradient-to-tr from-brand-blue/20 to-brand-gold/20 rounded-3xl filter blur-xl opacity-70"></div>
<!-- Main Image Container -->
<div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
<img alt="Bidyabharati Classes Academic Resources" class="w-full h-[440px] object-cover object-center transform hover:scale-105 transition-transform duration-700" src="assets/images/banner/abouthero.jpg"/>
<div class="absolute inset-0 bg-gradient-to-t from-brand-navy/70 via-transparent to-transparent"></div>
<div class="absolute bottom-4 left-4 right-4 text-white">
<span class="bg-[#ee8c1c] text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 inline-block">Official Repository</span>
<p class="text-sm font-semibold drop-shadow">Verified academic materials, syllabus guides, and instant notice downloads</p>
</div>
</div>
<!-- Floating Glassmorphism Badge 1 - Top Right -->
<div class="absolute -top-4 -right-4 sm:-right-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center text-[#06bbcc]">
<i class="fa-solid fa-file-pdf text-lg text-[#06bbcc]"></i>
</div>
<div>
<span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Format</span>
<span class="text-sm font-bold text-brand-navy">High-Speed PDF &amp; Docs</span>
</div>
</div>
<!-- Floating Glassmorphism Badge 2 - Bottom Left -->
<div class="absolute -bottom-4 -left-4 sm:-left-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-[#ee8c1c]">
<i class="fa-solid fa-circle-check text-lg text-[#ee8c1c]"></i>
</div>
<div>
<span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Updated Daily</span>
<span class="text-sm font-bold text-brand-navy">Baripada Academic Cell</span>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Quick Information Strip -->
<section class="w-full bg-slate-50/70 py-10 border-y border-slate-100">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
<!-- Card 1 -->
<div class="flex items-start gap-4 p-5 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
<div class="w-11 h-11 rounded-xl bg-sky-50 text-[#06bbcc] flex items-center justify-center shrink-0">
<i class="fa-solid fa-book-open text-lg"></i>
</div>
<div class="flex flex-col">
<span class="font-bold text-brand-navy text-base leading-tight font-['Poppins']">Academic Resources</span>
<p class="text-xs text-slate-500 mt-1 leading-relaxed font-['Inter']">Study materials, syllabi, notes &amp; structured learning guides.</p>
</div>
</div>
<!-- Card 2 -->
<div class="flex items-start gap-4 p-5 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
<div class="w-11 h-11 rounded-xl bg-amber-50 text-[#ee8c1c] flex items-center justify-center shrink-0">
<i class="fa-solid fa-bullhorn text-lg"></i>
</div>
<div class="flex flex-col">
<span class="font-bold text-brand-navy text-base leading-tight font-['Poppins']">Important Notices</span>
<p class="text-xs text-slate-500 mt-1 leading-relaxed font-['Inter']">Latest institutional announcements, timetables &amp; circulars.</p>
</div>
</div>
<!-- Card 3 -->
<div class="flex items-start gap-4 p-5 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
<div class="w-11 h-11 rounded-xl bg-sky-50 text-[#06bbcc] flex items-center justify-center shrink-0">
<i class="fa-solid fa-file-signature text-lg"></i>
</div>
<div class="flex flex-col">
<span class="font-bold text-brand-navy text-base leading-tight font-['Poppins']">Forms &amp; Documents</span>
<p class="text-xs text-slate-500 mt-1 leading-relaxed font-['Inter']">Admission forms, scholarship tests &amp; student undertakings.</p>
</div>
</div>
<!-- Card 4 -->
<div class="flex items-start gap-4 p-5 rounded-2xl bg-white shadow-sm border border-slate-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
<div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
<i class="fa-solid fa-bolt text-lg"></i>
</div>
<div class="flex flex-col">
<span class="font-bold text-brand-navy text-base leading-tight font-['Poppins']">Instant Access</span>
<p class="text-xs text-slate-500 mt-1 leading-relaxed font-['Inter']">One-click verified high-speed downloads in PDF, DOCX, XLSX.</p>
</div>
</div>
</div>
</div>
</section>
<!-- Recently Added Section -->
<section class="w-full py-12 bg-white">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
<div class="flex items-center gap-3">
<h2 class="text-2xl sm:text-3xl font-extrabold text-[#123B6D] tracking-tight font-['Poppins']">Recently Added</h2>
<span class="px-3 py-1 rounded-full bg-amber-50 text-[#ee8c1c] border border-amber-200 text-xs font-bold uppercase tracking-wider">New Updates</span>
</div>
<span class="text-xs sm:text-sm text-slate-500 font-['Inter']">Synchronized daily from Baripada Academic Cell</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md">
<!-- Recent Card 1 -->
<div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
<div class="flex flex-col gap-space-xs">
<div class="flex items-center justify-between">
<span class="px-2 py-0.5 rounded text-[11px] font-bold tracking-wider bg-rose-100 text-rose-800">PDF</span>
<span class="font-label-md text-label-md text-on-surface-variant">20 Sep 2026</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-primary text-[16px] leading-snug pt-space-xs">
              Annual Board Examination Revision Schedule 2026
            </h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Exam • Class 10 &amp; 12 • 2.4 MB</p>
</div>
<div class="pt-space-md flex items-center justify-between">
<span class="font-label-md text-label-md text-secondary font-semibold">CBSE / Odisha Board</span>
<button class="inline-flex items-center gap-1 text-primary hover:text-secondary font-label-md text-label-md p-1.5 rounded hover:bg-surface-container transition-colors" onclick="triggerDownload('Annual Board Examination Revision Schedule 2026.pdf')">
<span class="material-symbols-outlined text-[18px]">download</span>
<span class="">Download</span>
</button>
</div>
</div>
<!-- Recent Card 2 -->
<div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
<div class="flex flex-col gap-space-xs">
<div class="flex items-center justify-between">
<span class="px-2 py-0.5 rounded text-[11px] font-bold tracking-wider bg-rose-100 text-rose-800">PDF</span>
<span class="font-label-md text-label-md text-on-surface-variant">18 Sep 2026</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-primary text-[16px] leading-snug pt-space-xs">
              CBSE Class 10 Mathematics Formula Handbook &amp; Practice Sets
            </h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Study Material • Class 10 (CBSE) • 4.1 MB</p>
</div>
<div class="pt-space-md flex items-center justify-between">
<span class="font-label-md text-label-md text-secondary font-semibold">CBSE Curriculum</span>
<button class="inline-flex items-center gap-1 text-primary hover:text-secondary font-label-md text-label-md p-1.5 rounded hover:bg-surface-container transition-colors" onclick="triggerDownload('CBSE Class 10 Mathematics Formula Handbook.pdf')">
<span class="material-symbols-outlined text-[18px]">download</span>
<span class="">Download</span>
</button>
</div>
</div>
<!-- Recent Card 3 -->
<div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
<div class="flex flex-col gap-space-xs">
<div class="flex items-center justify-between">
<span class="px-2 py-0.5 rounded text-[11px] font-bold tracking-wider bg-rose-100 text-rose-800">PDF</span>
<span class="font-label-md text-label-md text-on-surface-variant">15 Sep 2026</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-primary text-[16px] leading-snug pt-space-xs">
              Admission Application &amp; Scholarship Registration Form (2025-26)
            </h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Forms • General (Class 3-12) • 1.2 MB</p>
</div>
<div class="pt-space-md flex items-center justify-between">
<span class="font-label-md text-label-md text-secondary font-semibold">Institutional Forms</span>
<button class="inline-flex items-center gap-1 text-primary hover:text-secondary font-label-md text-label-md p-1.5 rounded hover:bg-surface-container transition-colors" onclick="triggerDownload('Admission Application Form 2025-26.pdf')">
<span class="material-symbols-outlined text-[18px]">download</span>
<span class="">Download</span>
</button>
</div>
</div>
<!-- Recent Card 4 -->
<div class="flex flex-col justify-between p-space-md rounded-xl bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow">
<div class="flex flex-col gap-space-xs">
<div class="flex items-center justify-between">
<span class="px-2 py-0.5 rounded text-[11px] font-bold tracking-wider bg-rose-100 text-rose-800">PDF</span>
<span class="font-label-md text-label-md text-on-surface-variant">14 Sep 2026</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-primary text-[16px] leading-snug pt-space-xs">
              CHSE Odisha (+2 Science) Physics Model Question Paper 2026
            </h3>
<p class="font-body-sm text-body-sm text-on-surface-variant">Question Papers • Class 12 (CHSE) • 5.8 MB</p>
</div>
<div class="pt-space-md flex items-center justify-between">
<span class="font-label-md text-label-md text-secondary font-semibold">CHSE Odisha</span>
<button class="inline-flex items-center gap-1 text-primary hover:text-secondary font-label-md text-label-md p-1.5 rounded hover:bg-surface-container transition-colors" onclick="triggerDownload('CHSE Class 12 Physics Model Paper 2026.pdf')">
<span class="material-symbols-outlined text-[18px]">download</span>
<span class="">Download</span>
</button>
</div>
</div>
</div>
</div>
</section>
<!-- Document Center & Interactive Repository -->
<section class="w-full py-16 lg:py-20 bg-slate-50/70" id="document-repository">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<!-- Section Header -->
<div class="flex flex-col items-center text-center max-w-3xl mx-auto mb-12">
<span class="campus-update-tag block text-center">Document Center</span>
<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#123B6D] tracking-tight mb-4 font-['Poppins']">
          Important Documents &amp; <span class="text-[#ee8c1c]">Resources</span>
        </h2>
<p class="text-slate-600 text-base sm:text-lg leading-relaxed font-['Inter']">
          Search, filter, preview, and download official documents published by Bidyabharati Classes.
        </p>
</div>

    <?php
    $db_docs = [];
    try {
        $stmtDocs = $pdo->query("SELECT * FROM documents WHERE status = 'active' ORDER BY id DESC");
        $db_docs = $stmtDocs->fetchAll() ?: [];
    } catch (Exception $e) {
        $db_docs = [];
    }
    ?>

    <!-- Tabular Document Repository (Desktop Table) -->
    <div class="hidden lg:block bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden border border-slate-200/60">
    <table class="w-full text-left" id="documents-table">
    <thead>
    <tr class="bg-surface-container text-primary font-label-md text-label-md uppercase tracking-wider">
    <th class="py-4 px-6" scope="col">Document Name &amp; Size</th>
    <th class="py-4 px-4" scope="col">Class</th>
    <th class="py-4 px-4" scope="col">Medium</th>
    <th class="py-4 px-4" scope="col">Date</th>
    <th class="py-4 px-4" scope="col">Type</th>
    <th class="py-4 px-6 text-right" scope="col">Action</th>
    </tr>
    </thead>
    <tbody class="font-body-sm text-body-sm" id="table-body">
    <?php if (!empty($db_docs)): ?>
      <?php foreach ($db_docs as $doc): 
          $uDate = !empty($doc['created_at']) ? date('d M Y', strtotime($doc['created_at'])) : date('d M Y');
          $fType = !empty($doc['file_type']) ? strtoupper($doc['file_type']) : 'PDF';
          $fSize = !empty($doc['file_size']) ? $doc['file_size'] : 'PDF Document';
          $cName = !empty($doc['class_name']) ? $doc['class_name'] : 'General';
          $mName = !empty($doc['medium']) ? $doc['medium'] : 'English';
          $fPath = !empty($doc['file_path']) ? htmlspecialchars($doc['file_path']) : '#';
      ?>
      <tr class="doc-row hover:bg-surface-container-low/70 transition-colors" data-class="<?= htmlspecialchars($cName) ?>" data-medium="<?= htmlspecialchars($mName) ?>" data-title="<?= htmlspecialchars($doc['title']) ?>">
        <td class="py-4 px-6">
          <div class="flex flex-col">
            <span class="font-headline-sm text-headline-sm text-[16px] text-primary font-semibold"><?= htmlspecialchars($doc['title']) ?></span>
            <span class="text-on-surface-variant font-body-sm text-body-sm mt-0.5">Uploaded <?= $uDate ?> • <?= htmlspecialchars($fSize) ?></span>
          </div>
        </td>
        <td class="py-4 px-4 text-on-surface font-medium"><?= htmlspecialchars($cName) ?></td>
        <td class="py-4 px-4 text-on-surface-variant"><?= htmlspecialchars($mName) ?></td>
        <td class="py-4 px-4 text-on-surface-variant whitespace-nowrap"><?= $uDate ?></td>
        <td class="py-4 px-4">
          <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-rose-100 text-rose-800"><?= htmlspecialchars($fType) ?></span>
        </td>
        <td class="py-4 px-6 text-right">
          <div class="flex items-center justify-end gap-2">
            <a href="<?= $fPath ?>" target="_blank" class="p-2 rounded-lg text-secondary hover:bg-surface-container transition-colors inline-flex items-center" title="View Document">
              <span class="material-symbols-outlined text-[20px]">visibility</span>
            </a>
            <a href="<?= $fPath ?>" download class="px-3 py-1.5 rounded-lg bg-primary-container text-on-primary hover:bg-secondary font-label-md text-label-md transition-colors flex items-center gap-1">
              <span class="material-symbols-outlined text-[16px]">download</span>
              <span>Download</span>
            </a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6" class="py-8 text-center text-slate-500">No documents found.</td>
      </tr>
    <?php endif; ?>
    </tbody>
    </table>
    </div>

    <!-- Mobile Document Cards (< lg viewport) -->
    <div class="lg:hidden flex flex-col gap-space-md" id="mobile-cards-container">
    <?php if (!empty($db_docs)): ?>
      <?php foreach ($db_docs as $doc): 
          $uDate = !empty($doc['created_at']) ? date('d M Y', strtotime($doc['created_at'])) : date('d M Y');
          $fType = !empty($doc['file_type']) ? strtoupper($doc['file_type']) : 'PDF';
          $fSize = !empty($doc['file_size']) ? $doc['file_size'] : 'PDF Document';
          $cName = !empty($doc['class_name']) ? $doc['class_name'] : 'General';
          $mName = !empty($doc['medium']) ? $doc['medium'] : 'English';
          $fPath = !empty($doc['file_path']) ? htmlspecialchars($doc['file_path']) : '#';
      ?>
      <div class="mobile-doc-card bg-surface-container-lowest p-space-md rounded-xl shadow-sm flex flex-col gap-space-sm border border-slate-200/60">
        <div class="flex items-start justify-between gap-space-xs">
          <span class="font-headline-sm text-headline-sm text-[16px] text-primary"><?= htmlspecialchars($doc['title']) ?></span>
          <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-rose-100 text-rose-800"><?= htmlspecialchars($fType) ?></span>
        </div>
        <div class="flex flex-wrap gap-1.5">
          <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-md text-label-md">Class: <?= htmlspecialchars($cName) ?></span>
          <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-md text-label-md">Medium: <?= htmlspecialchars($mName) ?></span>
        </div>
        <div class="flex items-center justify-between pt-2">
          <span class="font-body-sm text-body-sm text-on-surface-variant"><?= $uDate ?> • <?= htmlspecialchars($fSize) ?></span>
          <a href="<?= $fPath ?>" download class="px-3 py-1.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">download</span>
            <span>Download</span>
          </a>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
    </div>
<!-- Empty State Fallback -->
<div class="hidden bg-surface-container-lowest p-12 rounded-2xl shadow-sm text-center flex flex-col items-center justify-center" id="empty-state">
<div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant mb-4">
<span class="material-symbols-outlined text-[32px]">folder_off</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-primary">No Documents Found</h3>
<p class="font-body-md text-body-md text-on-surface-variant max-w-md mt-1 mb-6">
          Try adjusting your search query, or clear active category and class filters to browse all documents.
        </p>
<button class="px-space-lg py-space-sm rounded-lg bg-primary text-on-primary font-label-lg text-label-lg hover:bg-secondary transition-colors" onclick="resetFilters()">
          Clear All Filters
        </button>
</div>
<!-- Pagination & Metrics -->
<div class="mt-space-lg flex flex-col sm:flex-row items-center justify-between gap-space-md" id="pagination-strip">
<span class="font-body-sm text-body-sm text-on-surface-variant">
          Showing <span class="font-semibold text-primary">1–10</span> of <span class="font-semibold text-primary">48</span> documents
        </span>
<div class="flex items-center gap-1">
<button class="px-3 py-1.5 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-md text-label-md disabled:opacity-50" disabled="">
            Previous
          </button>
<button class="w-8 h-8 rounded-lg bg-primary text-on-primary font-label-md text-label-md font-bold">1</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container text-on-surface font-label-md text-label-md">2</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container text-on-surface font-label-md text-label-md">3</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container text-on-surface font-label-md text-label-md">4</button>
<button class="w-8 h-8 rounded-lg hover:bg-surface-container text-on-surface font-label-md text-label-md">5</button>
<button class="px-3 py-1.5 rounded-lg bg-surface-container text-primary hover:bg-surface-container-high transition-colors font-label-md text-label-md">
            Next
          </button>
</div>
</div>
</div>
</section>
<!-- CMS & Security Information Strip -->
<section class="w-full bg-surface-container-high py-4">
<div class="max-w-7xl mx-auto px-margin">
<div class="flex items-center gap-space-sm text-on-surface-variant font-body-sm text-body-sm">
<span class="material-symbols-outlined text-[18px] text-secondary">info</span>
<span class=""><strong class="text-primary font-semibold">Institutional Storage Notice:</strong> Published documents from the administrative portal automatically sync here. Files are served securely via verified institutional storage and scanned for security.</span>
</div>
</div>
</section>
<!-- Looking for Specific Document Support CTA Banner -->
<section class="w-full py-16 bg-surface">
<!-- Need Document Assistance CTA -->
<section class="w-full py-12 bg-white">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#0c2340] via-[#123B6D] to-[#0c2340] text-white p-8 md:p-12 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-8">
<!-- Decorative ambient glows -->
<div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-[#06bbcc]/20 blur-3xl pointer-events-none"></div>
<div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-[#ee8c1c]/15 blur-3xl pointer-events-none"></div>

<div class="flex flex-col gap-3 z-10 max-w-2xl text-left">
<span class="campus-update-tag !text-[#ee8c1c] block self-start">NEED DOCUMENT ASSISTANCE?</span>
<h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight font-['Poppins']">
            Looking for a Specific Document or <span class="text-[#ee8c1c]">Past Paper?</span>
          </h3>
<p class="text-slate-200 text-sm sm:text-base leading-relaxed font-['Inter']">
            If you cannot find the syllabus, test paper, or institutional notice you are looking for, contact our Baripada office directly. Our academic counselors are available to assist you.
          </p>
</div>

<div class="flex flex-col sm:flex-row lg:flex-col xl:flex-row items-stretch gap-4 z-10 w-full lg:w-auto shrink-0 font-['Poppins']">
<a class="btn btn-curve !px-6 !py-3.5 !bg-[#ee8c1c] !text-white hover:!bg-[#e5893e] shadow-lg flex items-center justify-center gap-2 font-bold text-xs sm:text-sm" href="tel:+919437380042">
  <i class="fa-solid fa-phone"></i>
  <span>Contact Office (+91 94373 80042)</span>
</a>
<a class="btn btn-curve btn-white border border-white/20 !px-6 !py-3.5 !bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-lg flex items-center justify-center gap-2 font-bold text-xs sm:text-sm" href="https://wa.me/919437380042" target="_blank">
  <i class="fa-brands fa-whatsapp text-lg"></i>
  <span>WhatsApp Academic Counselor</span>
</a>
</div>
</div>
</div>
</section>
</section>
<!-- Interactive Search / Filter / Toast Logic -->
<script>
    function triggerDownload(fileName) {
      const toast = document.getElementById('download-toast');
      const message = document.getElementById('toast-message');
      
      message.textContent = 'Starting download: ' + fileName + '...';
      toast.classList.remove('translate-y-[-100%]', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');

      setTimeout(function() {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-[-100%]', 'opacity-0');
      }, 3200);
    }

    function previewDoc(docTitle) {
      alert('Opening secure preview for: ' + docTitle + '\n(Bidyabharati Classes PDF Viewer)');
    }

    function filterDocuments() {
      const searchVal = document.getElementById('search-input')?.value.toLowerCase().trim() || '';
      const catVal = document.getElementById('category-filter')?.value || 'all';
      const classVal = document.getElementById('class-filter')?.value || 'all';
      const mediumVal = document.getElementById('medium-filter')?.value || 'all';

      const rows = document.querySelectorAll('.doc-row');
      const mobileCards = document.querySelectorAll('.mobile-doc-card');
      let visibleCount = 0;

      function matchElement(el) {
        const title = el.getAttribute('data-title').toLowerCase();
        const category = el.getAttribute('data-category');
        const classes = el.getAttribute('data-class');
        const medium = el.getAttribute('data-medium');

        const matchesSearch = !searchVal || title.includes(searchVal);
        const matchesCategory = (catVal === 'all') || (category === catVal);
        const matchesClass = (classVal === 'all') || (classes && classes.includes(classVal));
        const matchesMedium = (mediumVal === 'all') || (medium === 'General') || (medium && medium.includes(mediumVal));

        return matchesSearch && matchesCategory && matchesClass && matchesMedium;
      }

      rows.forEach(function(row) {
        if (matchElement(row)) {
          row.style.display = '';
          visibleCount++;
        } else {
          row.style.display = 'none';
        }
      });

      mobileCards.forEach(function(card) {
        if (matchElement(card)) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });

      // Update counters & fallback state
      const counter = document.getElementById('doc-counter');
      const emptyState = document.getElementById('empty-state');
      const paginationStrip = document.getElementById('pagination-strip');

      if (counter) counter.textContent = 'Showing ' + visibleCount + ' of 48 documents';

      if (visibleCount === 0) {
        if (emptyState) emptyState.classList.remove('hidden');
        if (paginationStrip) paginationStrip.classList.add('hidden');
      } else {
        if (emptyState) emptyState.classList.add('hidden');
        if (paginationStrip) paginationStrip.classList.remove('hidden');
      }
    }

    function sortDocuments() {
      const sortSelect = document.getElementById('sort-filter');
      if (!sortSelect) return;
      const sortType = sortSelect.value;
      const tbody = document.getElementById('table-body');
      const rows = Array.from(tbody.querySelectorAll('.doc-row'));
      const mobileContainer = document.getElementById('mobile-cards-container');
      const mobileCards = Array.from(mobileContainer.querySelectorAll('.mobile-doc-card'));

      function sortFn(a, b) {
        if (sortType === 'latest') {
          return b.getAttribute('data-timestamp').localeCompare(a.getAttribute('data-timestamp'));
        } else if (sortType === 'oldest') {
          return a.getAttribute('data-timestamp').localeCompare(b.getAttribute('data-timestamp'));
        } else if (sortType === 'az') {
          return a.getAttribute('data-title').localeCompare(b.getAttribute('data-title'));
        }
        return 0;
      }

      rows.sort(sortFn);
      rows.forEach(function(row) { tbody.appendChild(row); });

      mobileCards.sort(sortFn);
      mobileCards.forEach(function(card) { mobileContainer.appendChild(card); });
    }

    function resetFilters() {
      if (document.getElementById('search-input')) document.getElementById('search-input').value = '';
      if (document.getElementById('category-filter')) document.getElementById('category-filter').value = 'all';
      if (document.getElementById('class-filter')) document.getElementById('class-filter').value = 'all';
      if (document.getElementById('medium-filter')) document.getElementById('medium-filter').value = 'all';
      if (document.getElementById('sort-filter')) document.getElementById('sort-filter').value = 'latest';
      filterDocuments();
      sortDocuments();
    }
  </script>
</div></main>
<?php include 'includes/footer.php'; ?>

