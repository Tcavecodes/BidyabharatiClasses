<?php
$page_title = "Gallery | Bidyabharati Classes - Baripada, Odisha";
include 'includes/header.php';

// Fetch Active Gallery Items from DB
$db_gallery_items = [];
try {
    $stmtGal = $pdo->query("SELECT * FROM gallery WHERE status = 'active' ORDER BY id DESC");
    $db_gallery_items = $stmtGal->fetchAll() ?: [];
} catch (Exception $e) {
    $db_gallery_items = [];
}

// Helper to convert Category Name to slug
function getCategorySlug($catName) {
    return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $catName), '-'));
}

// Extract unique categories from DB items
$dynamic_categories = [];
foreach ($db_gallery_items as $gItem) {
    $catRaw = trim($gItem['category'] ?? '');
    if (!empty($catRaw)) {
        $slug = getCategorySlug($catRaw);
        if (!isset($dynamic_categories[$slug])) {
            $dynamic_categories[$slug] = $catRaw;
        }
    }
}

// Default fallback categories if no DB items yet
if (empty($dynamic_categories)) {
    $dynamic_categories = [
        'classroom' => 'Classroom',
        'events' => 'Events & Celebrations',
        'student-activities' => 'Student Activities',
        'achievements' => 'Achievements',
        'campus' => 'Campus & Infrastructure',
        'workshops' => 'Workshops & Seminars',
    ];
}
?>
<main>
<!-- Top Notification Ribbon -->
<div class="w-full bg-sky-50 border-b border-sky-100 text-brand-navy py-2.5 px-4">
<div class="container mx-auto flex flex-wrap items-center justify-between gap-2 text-xs font-semibold">
<div class="flex items-center gap-2">
<span class="px-2 py-0.5 rounded-full bg-[#ee8c1c] text-white font-bold text-[10px] uppercase tracking-wider">New</span>
<span class="text-slate-700">State Board &amp; CBSE 2025 Felicitation Ceremony photos now live in the gallery!</span>
</div>
<a class="text-[#06bbcc] hover:underline font-bold inline-flex items-center gap-1" href="#image-gallery">
<span>Browse Album</span>
<i class="fa-solid fa-arrow-right text-[10px]"></i>
</a>
</div>
</div>
<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-brand-lightBlue/50 via-white to-brand-bgLight pt-36 md:pt-40 lg:pt-44 pb-16 lg:pb-20 overflow-hidden" data-purpose="hero-section">
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
<!-- Left Hero Content Column -->
<div class="lg:col-span-7 space-y-6">
<span class="campus-update-tag">Our Gallery</span>
<h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-navy leading-tight tracking-tight font-['Poppins']">
              Moments of Learning, <br class="hidden sm:inline"/>
<span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-blue to-brand-navy">Growth &amp; Achievement</span>
</h1>
<p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl font-['Inter']">
              Explore memorable moments from Bidyabharati Classes — from concept-led classroom sessions and academic laboratories to celebrations, milestone achievements, and holistic student life in Baripada, Mayurbhanj, Odisha.
            </p>
<!-- CTAs -->
<div class="pt-4 flex flex-wrap gap-4 items-center font-['Poppins']">
<a class="btn btn-curve mr-2" href="#image-gallery">
   Explore Gallery <i class="fa-solid fa-images ml-2"></i>
</a>
<a class="btn btn-curve btn-white border border-gray-200" href="#video-gallery">
  Watch Videos <i class="fa-solid fa-circle-play ml-2 text-[#06bbcc]"></i>
</a>
</div>
<!-- Quick Metrics Bar -->
<div class="counter pt-4">
  <div class="counter-wrap !p-4 !bg-transparent !shadow-none !border-0">
    <div class="content flex justify-between gap-6">
      <div class="value-pin !p-2">
        <span class="value !text-3xl !mb-1 text-[#06bbcc] font-extrabold"><?= count($db_gallery_items) > 0 ? (count($db_gallery_items) . '+') : '450+' ?></span>
        <h5 class="!text-xs text-gray-700 font-bold uppercase">Memories Captured</h5>
      </div>
      <div class="value-pin !p-2">
        <span class="value !text-3xl !mb-1 text-[#ee8c1c] font-extrabold">12+</span>
        <h5 class="!text-xs text-gray-700 font-bold uppercase">Annual Batches</h5>
      </div>
      <div class="value-pin !p-2">
        <span class="value !text-3xl !mb-1 text-[#06bbcc] font-extrabold">98.6%</span>
        <h5 class="!text-xs text-gray-700 font-bold uppercase">Board Success</h5>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Right Hero Composition -->
<div class="lg:col-span-5 relative">
<div class="relative mx-auto max-w-md lg:max-w-none">
<!-- Decorative background glow -->
<div class="absolute -inset-4 bg-gradient-to-tr from-brand-blue/20 to-brand-gold/20 rounded-3xl filter blur-xl opacity-70"></div>
<!-- Primary Image Container -->
<div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
<img alt="Capturing moments at Bidyabharati Classes Baripada" class="w-full h-[440px] object-cover object-center transform hover:scale-105 transition-transform duration-700" src="assets/images/banner/abouthero.jpg"/>
<div class="absolute inset-0 bg-gradient-to-t from-brand-navy/70 via-transparent to-transparent"></div>
<div class="absolute bottom-4 left-4 right-4 text-white">
<span class="bg-[#ee8c1c] text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 inline-block">Campus Life</span>
<p class="text-sm font-semibold drop-shadow">Capturing dedication, learning, and academic excellence in Baripada</p>
</div>
</div>
<!-- Floating Glassmorphism Badge 1 - Top Right -->
<div class="absolute -top-4 -right-4 sm:-right-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-[#ee8c1c]">
<i class="fa-solid fa-award text-lg text-[#ee8c1c]"></i>
</div>
<div>
<span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Achievements</span>
<span class="text-sm font-bold text-brand-navy">State Rank Holders 2025</span>
</div>
</div>
<!-- Floating Glassmorphism Badge 2 - Bottom Left -->
<div class="absolute -bottom-4 -left-4 sm:-left-6 bg-white/95 backdrop-blur-md p-3.5 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3">
<div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center text-[#06bbcc]">
<i class="fa-solid fa-camera text-lg text-[#06bbcc]"></i>
</div>
<div>
<span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block">Photo Collection</span>
<span class="text-sm font-bold text-brand-navy">Baripada Campus Gallery</span>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Image Gallery Section -->
<section class="w-full bg-surface-container-lowest py-space-xl" id="image-gallery">
<div class="max-w-[1240px] mx-auto px-margin-mobile lg:px-margin flex flex-col gap-space-lg">
<!-- Section Header -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
<div class="flex flex-col items-start gap-2 max-w-2xl">
<span class="campus-update-tag">Image Gallery</span>
<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#123B6D] tracking-tight font-['Poppins']">
            Moments That <span class="text-[#ee8c1c]">Tell Our Story</span>
          </h2>
<p class="text-slate-600 text-base sm:text-lg leading-relaxed font-['Inter']">
            Take a glimpse into the vibrant learning atmosphere, practical sessions, celebrations, academic accolades, and everyday student experiences at Bidyabharati Classes.
          </p>
</div>
<!-- Counter Indicator -->
<div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-lg bg-surface-container-low text-primary font-label-md text-label-md">
<span class="material-symbols-outlined text-[18px] text-secondary">image</span>
<span class="font-semibold" id="gallery-count-pill">Showing <?= count($db_gallery_items) > 0 ? count($db_gallery_items) : '12' ?> Photos</span>
</div>
</div>
<!-- Category Filter Pills Bar -->
<div class="w-full overflow-x-auto pb-2 scrollbar-none">
<div class="inline-flex items-center gap-2" id="image-filter-container">
<button class="gallery-filter-btn btn btn-curve transition-all shadow-sm !px-4 !py-2 text-xs uppercase font-semibold !bg-[#06bbcc] !text-white" data-cat="all">
            All
          </button>
<?php foreach ($dynamic_categories as $catSlug => $catLabel): ?>
<button class="gallery-filter-btn btn btn-curve btn-white transition-all border border-gray-200 !px-4 !py-2 text-xs uppercase font-semibold text-gray-700 hover:!bg-[#06bbcc] hover:!text-white" data-cat="<?= htmlspecialchars($catSlug) ?>">
            <?= htmlspecialchars($catLabel) ?>
          </button>
<?php endforeach; ?>
</div>
</div>
<!-- Responsive 4-Column Image Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md" id="image-grid">
<?php if (!empty($db_gallery_items)): ?>
  <?php foreach ($db_gallery_items as $gPhoto): 
    $cSlug = getCategorySlug($gPhoto['category'] ?? 'general');
  ?>
  <div class="gallery-card group relative h-72 rounded-2xl overflow-hidden bg-surface-container cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300" data-category="<?= htmlspecialchars($cSlug) ?>" data-category-label="<?= htmlspecialchars($gPhoto['category'] ?? 'General') ?>" data-gallery-item="">
    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="<?= htmlspecialchars($gPhoto['title']) ?>" src="<?= htmlspecialchars($gPhoto['image_path']) ?>" alt="<?= htmlspecialchars($gPhoto['title']) ?>">
    <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-on-primary">
      <div class="w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center">
        <span class="material-symbols-outlined text-[24px]">zoom_in</span>
      </div>
    </div>
    <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
      <span class="text-[10px] font-bold uppercase tracking-wider bg-[#ee8c1c] px-2 py-0.5 rounded text-white inline-block mb-1"><?= htmlspecialchars($gPhoto['category']) ?></span>
      <h4 class="text-xs font-semibold truncate"><?= htmlspecialchars($gPhoto['title']) ?></h4>
    </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
<!-- Fallback Demo Items if DB is empty -->
<div class="gallery-card group relative h-72 rounded-2xl overflow-hidden bg-surface-container cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300" data-category="classroom" data-gallery-item="">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="High school science coaching classroom in Odisha with an instructor explaining physics wave mechanics diagrams on a board to curious young students." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOG8vxBId6x4T57Qld-iHVEQKtyl0E9cDpIO9GdYPpP2c5_sjEUs1MC5F_fIdFoabNrXhfDlfQDDU3KmNKsiXBcH82bieTcsS1nUKh0iXGBR1agpMqZXZu_8TYvxwZlCOlBBdzmQhET3lK49WyPOUj_wqhoYergYA0GUYuBvj1RmCNq49TmZwNJt7dljLO03lUU68NZlHNUGmp1HJ1nkx4BzVnyAshqYNf0F9frLifoaWY2ZbRSCui7w">
<div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-on-primary">
<div class="w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center">
<span class="material-symbols-outlined text-[24px]">zoom_in</span>
</div>
</div>
</div>
<!-- Item 2: Events & Celebrations -->
<div class="gallery-card group relative h-72 rounded-2xl overflow-hidden bg-surface-container cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300" data-category="events" data-gallery-item="">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="Vibrant annual academic celebration stage in Odisha with students performing cultural dance and receiving awards under warm auditorium spotlights." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCeDBnfqOcN2Nik24tB7M5XwGYCGVBg_QmCkE35FUccwNEinBTqzr7sP8XBi9N9zuKFQf6rfGCELcQVNtsxLgXTEAmKcg8rKgzkhOh22DfbLq7SnyT1lfcGighcJi4k2pEizcOmE-X00nu4z2ytRK-Av0WFv-135eMzRwMq0JtkX_5eeNEHcKSRjETacH3n3XtezuHzf7A-FICWzC3KO44liiHrHeJqMVD6BkgY6I_PijAuQ8wb80vdSQ">
<div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-on-primary">
<div class="w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center">
<span class="material-symbols-outlined text-[24px]">zoom_in</span>
</div>
</div>
</div>
<!-- Item 3: Student Activities -->
<div class="gallery-card group relative h-72 rounded-2xl overflow-hidden bg-surface-container cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300" data-category="student-activities" data-gallery-item="">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="Indian school students collaborating on a hands-on optics science demonstration with prisms, test tubes, and laser light in a brightly lit learning laboratory." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDEa0du5XKMUo4PRB7DWvgHbC_TKmQ_54C3vvi5Arf4X8o5jNPfoIfH34MldJCZKPU349MpAwiHGU83M4T4MBimXjNAbt8n1n-xRuDWupHSxvt7rEGqkTdYP3iyIEXwdbAZcslG_bul9qoXVyM_drNasJj_HGno259LpD04_uC-phZceP1TDqj1GCDG61fFkp9Ce0scR526JVb1toQ6V6nuipyjtGOSmocytWI8R-HfN4KlWsyvuKteKg">
<div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-on-primary">
<div class="w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center">
<span class="material-symbols-outlined text-[24px]">zoom_in</span>
</div>
</div>
</div>
<!-- Item 4: Achievements -->
<div class="gallery-card group relative h-72 rounded-2xl overflow-hidden bg-surface-container cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300" data-category="achievements" data-gallery-item="">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="Proud young Indian students wearing medals and holding academic merit trophies surrounded by smiling faculty members and proud parents." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDco8sWgWn9JLiyxpDCn-HogOuoPobIGblx7Kbc9BQJE_NM36UZnC9tbni4eslDchu3va2cHqtgyqUa0D-piaoY3GE8BcipG00Cd8fBjFNrYwQPDX3hPzbzGBZYmuI3Qw69tUPai53ZvBFJS-dQfWiQdNGO50U8JWnUCZRLLO_gxQonKZHLYYxWIoNcwgJJR737_QsAmlbdFZxeYR2Qn4qMdT0SbZEbM8E2MFxSPnP_dKh3FNKwcnvxew">
<div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-on-primary">
<div class="w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center">
<span class="material-symbols-outlined text-[24px]">zoom_in</span>
</div>
</div>
</div>
<?php endif; ?>
</div>
<!-- Empty State Container (Hidden by default) -->
<div class="hidden flex-col items-center justify-center text-center py-16 px-4 bg-surface-container-low rounded-2xl" id="gallery-empty-state">
<div class="w-16 h-16 rounded-full bg-surface-container flex items-center justify-center text-outline mb-3">
<span class="material-symbols-outlined text-[32px]">photo_library</span>
</div>
<h4 class="font-headline-sm text-headline-sm text-primary">No Moments in This Category</h4>
<p class="font-body-md text-body-md text-on-surface-variant max-w-md mt-1">We are actively compiling fresh media memories for this specific collection. Please select another category.</p>
<button class="mt-4 px-4 py-2 rounded-lg bg-primary text-on-primary font-label-md text-label-md" onclick="resetGalleryFilter()">View All Photos</button>
</div>
<!-- Load More Action -->
<div class="flex justify-center pt-space-md">
<button class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-surface-container-low text-primary font-label-lg text-label-lg hover:bg-surface-container transition-all" id="load-more-photos">
<span class="material-symbols-outlined text-[18px]">add_photo_alternate</span>
<span class="">Load More Photos</span>
</button>
</div>
</div>
</section>
<!-- Video Gallery Section -->
<?php
// Fetch Active YouTube Videos from DB
$db_videos = [];
try {
    $stmtVids = $pdo->query("SELECT * FROM video_gallery WHERE status = 'active' ORDER BY id DESC");
    $db_videos = $stmtVids->fetchAll() ?: [];
} catch (Exception $e) {
    $db_videos = [];
}
?>
<section class="w-full bg-surface-container-low py-space-xl" id="video-gallery">
<div class="max-w-[1240px] mx-auto px-margin-mobile lg:px-margin flex flex-col gap-space-lg">
<!-- Section Header -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
<div class="flex flex-col items-start gap-2 max-w-2xl">
<span class="campus-update-tag">Video Gallery</span>
<h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#123B6D] tracking-tight font-['Poppins']">
            Watch, Learn &amp; <span class="text-[#ee8c1c]">Experience</span>
          </h2>
<p class="text-slate-600 text-base sm:text-lg leading-relaxed font-['Inter']">
            Watch real classroom highlights, annual event celebrations, inspiring student success stories, and specialized faculty masterclasses from Baripada campus.
          </p>
</div>
<!-- Video badge counter -->
<div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-lg bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm">
<span class="material-symbols-outlined text-[18px] text-error">play_circle</span>
<span class="font-semibold" id="video-count-pill"><?= count($db_videos) > 0 ? (count($db_videos) . ' YouTube Videos') : 'Featured Class Footage' ?></span>
</div>
</div>

<!-- Responsive YouTube Video Grid (4 columns) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-md" id="video-grid">
<?php if (!empty($db_videos)): ?>
  <?php foreach ($db_videos as $vid): ?>
  <div class="flex flex-col rounded-2xl bg-surface-container-lowest shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden" data-video-item="">
    <div class="relative w-full aspect-video bg-primary-container">
      <iframe allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" class="w-full h-full object-cover border-0" src="<?= htmlspecialchars($vid['youtube_url']) ?>" title="<?= htmlspecialchars($vid['title']) ?>"></iframe>
    </div>
    <div class="flex flex-col p-4 flex-grow justify-between gap-3">
      <div>
        <div class="flex items-center justify-between text-xs mb-1">
          <?php if (!empty($vid['duration'])): ?>
            <span class="text-slate-500 font-medium"><i class="fa-regular fa-clock mr-1"></i><?= htmlspecialchars($vid['duration']) ?></span>
          <?php endif; ?>
        </div>
        <h3 class="font-headline-sm text-headline-sm text-primary leading-snug line-clamp-2 font-bold font-['Poppins']">
          <?= htmlspecialchars($vid['title']) ?>
        </h3>
        <?php if (!empty($vid['description'])): ?>
          <p class="font-body-sm text-body-sm text-slate-600 mt-1 line-clamp-2 font-['Inter']">
            <?= htmlspecialchars($vid['description']) ?>
          </p>
        <?php endif; ?>
      </div>
      <div class="flex items-center justify-between pt-2 border-t border-slate-100">
        <span class="text-xs text-[#06bbcc] font-semibold">Bidyabharati Channel</span>
        <i class="fa-brands fa-youtube text-red-600 text-lg"></i>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
<?php else: ?>
<!-- Empty State Container when no videos added by admin -->
<div class="col-span-full flex flex-col items-center justify-center text-center py-12 px-4 bg-white rounded-2xl border border-slate-100 shadow-sm w-full">
  <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center text-red-500 mb-3">
    <i class="fa-brands fa-youtube text-2xl"></i>
  </div>
  <h4 class="font-bold text-lg text-slate-800 font-['Poppins']">No Videos Added Yet</h4>
  <p class="text-xs text-slate-500 max-w-md mt-1 font-['Inter']">We are currently curating new classroom highlights and video lectures. Please check back soon or visit our admin panel to add YouTube video links!</p>
</div>
<?php endif; ?>
</div>
</div>
</section>
<!-- Interactive Lightbox Modal -->
<div aria-modal="true" class="fixed inset-0 z-[99999] bg-slate-950/95 text-white backdrop-blur-md hidden flex-col justify-between p-4 sm:p-8 font-['Poppins']" id="gallery-lightbox" role="dialog">
<!-- Lightbox Top Controls -->
<div class="w-full max-w-6xl mx-auto flex items-center justify-between text-white py-2">
<div class="flex items-center gap-3">
<span class="text-xs px-3 py-1 rounded-full bg-white/15 backdrop-blur-sm font-semibold" id="lightbox-counter">1 / 12</span>
<span class="text-xs text-[#ee8c1c] uppercase tracking-wider font-bold" id="lightbox-badge">Classroom</span>
</div>
<button class="w-10 h-10 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-all cursor-pointer" id="lightbox-close">
<i class="fa-solid fa-xmark text-lg"></i>
</button>
</div>
<!-- Lightbox Center Content with Prev / Next -->
<div class="w-full max-w-6xl mx-auto flex-1 flex items-center justify-between gap-4 py-4 relative">
<button class="w-12 h-12 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-all shrink-0 cursor-pointer" id="lightbox-prev">
<i class="fa-solid fa-chevron-left text-lg"></i>
</button>
<div class="flex-1 flex flex-col items-center justify-center max-h-[70vh] overflow-hidden">
<img alt="Expanded View" class="max-h-[62vh] w-auto max-w-full object-contain rounded-xl shadow-2xl transition-all duration-300 border-2 border-white/20" id="lightbox-img" src=""/>
</div>
<button class="w-12 h-12 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-all shrink-0 cursor-pointer" id="lightbox-next">
<i class="fa-solid fa-chevron-right text-lg"></i>
</button>
</div>
<!-- Lightbox Bottom Caption -->
<div class="w-full max-w-3xl mx-auto text-center text-white pb-2">
<h3 class="text-base sm:text-lg font-bold text-white mb-1 drop-shadow" id="lightbox-title"></h3>
<p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto font-['Inter']" id="lightbox-desc"></p>
</div>
</div>
<!-- Final Call-To-Action Container -->
<section class="py-16 lg:py-20 bg-gradient-to-r from-[#0c2340] via-[#123B6D] to-[#0c2340] relative overflow-hidden" data-purpose="conversion-cta">
<!-- Ambient glow backgrounds -->
<div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-[#06bbcc]/20 blur-3xl pointer-events-none"></div>
<div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-[#ee8c1c]/15 blur-3xl pointer-events-none"></div>

<div class="container mx-auto px-4 text-center relative z-10 space-y-6">
  <span class="campus-update-tag !text-[#ee8c1c] block text-center">Baripada Community</span>

  <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-['Poppins']">
    Stay Connected With <span class="text-[#ee8c1c]">Bidyabharati Classes</span>
  </h2>

  <p class="text-slate-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed font-['Inter']">
    Follow our daily journey and stay updated with new batch dates, scholarship tests, award ceremonies, and admissions notifications across Mayurbhanj.
  </p>

  <!-- Social Channel Badges -->
  <div class="flex flex-wrap items-center justify-center gap-3 pt-2 text-xs sm:text-sm font-medium">
    <a class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white border border-white/15 px-4 py-2 rounded-full transition-all" href="#">
      <i class="fa-brands fa-facebook-f text-[#06bbcc]"></i>
      <span>Facebook @bidyabharatibaripada</span>
    </a>
    <a class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white border border-white/15 px-4 py-2 rounded-full transition-all" href="#">
      <i class="fa-brands fa-youtube text-red-500"></i>
      <span>YouTube Channel</span>
    </a>
    <a class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white border border-white/15 px-4 py-2 rounded-full transition-all" href="#">
      <i class="fa-brands fa-instagram text-pink-500"></i>
      <span>Instagram</span>
    </a>
  </div>

  <!-- Action Buttons -->
  <div class="pt-4 flex flex-wrap justify-center gap-4 font-['Poppins']">
    <a class="btn btn-curve !px-8 !py-3.5 !bg-[#ee8c1c] !text-white hover:!bg-[#e5893e] shadow-lg flex items-center gap-2 font-bold" href="https://wa.me/919437380042" target="_blank">
      <i class="fa-brands fa-whatsapp text-lg"></i>
      <span>Join WhatsApp Notice Group</span>
    </a>
    <a class="btn btn-curve btn-white border border-white/20 !px-8 !py-3.5 !bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-lg flex items-center gap-2 font-bold" href="contact.php">
      <i class="fa-solid fa-paper-plane"></i>
      <span>Contact Desk</span>
    </a>
  </div>
</div>
</section>
<!-- Inline Micro-interactions Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
      // 1. Image Filter Logic
      const filterBtns = document.querySelectorAll('.gallery-filter-btn');
      const galleryItems = document.querySelectorAll('[data-gallery-item]');
      const countPill = document.getElementById('gallery-count-pill');
      const emptyState = document.getElementById('gallery-empty-state');

      filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          const selected = btn.getAttribute('data-cat');
          
          // Update button styles
          filterBtns.forEach(b => {
            b.className = 'gallery-filter-btn btn btn-curve btn-white transition-all border border-gray-200 !px-4 !py-2 text-xs uppercase font-semibold text-gray-700 hover:!bg-[#06bbcc] hover:!text-white';
          });
          btn.className = 'gallery-filter-btn btn btn-curve transition-all shadow-sm !px-4 !py-2 text-xs uppercase font-semibold !bg-[#06bbcc] !text-white';

          // Filter cards
          let visibleCount = 0;
          galleryItems.forEach(item => {
            const cat = item.getAttribute('data-category');
            if (selected === 'all' || cat === selected) {
              item.classList.remove('hidden');
              visibleCount++;
            } else {
              item.classList.add('hidden');
            }
          });

          if (countPill) {
            countPill.textContent = `Showing ${visibleCount} Photos`;
          }

          if (emptyState) {
            if (visibleCount === 0) {
              emptyState.classList.remove('hidden');
              emptyState.classList.add('flex');
            } else {
              emptyState.classList.add('hidden');
              emptyState.classList.remove('flex');
            }
          }
        });
      });

      // 2. Video Filter Logic
      const vfilterBtns = document.querySelectorAll('.video-filter-btn');
      const videoItems = document.querySelectorAll('[data-video-item]');

      vfilterBtns.forEach(vbtn => {
        vbtn.addEventListener('click', () => {
          const vselected = vbtn.getAttribute('data-vcat');

          vfilterBtns.forEach(b => {
            b.classList.remove('bg-primary', 'text-on-primary', 'shadow-sm');
            b.classList.add('bg-surface-container-lowest', 'text-on-surface-variant');
          });
          vbtn.classList.add('bg-primary', 'text-on-primary', 'shadow-sm');
          vbtn.classList.remove('bg-surface-container-lowest', 'text-on-surface-variant');

          videoItems.forEach(vitem => {
            const vcat = vitem.getAttribute('data-vcat');
            if (vselected === 'all' || vcat === vselected) {
              vitem.classList.remove('hidden');
            } else {
              vitem.classList.add('hidden');
            }
          });
        });
      });

      // 3. Lightbox Logic
      const lightbox = document.getElementById('gallery-lightbox');
      const lightboxImg = document.getElementById('lightbox-img');
      const lightboxTitle = document.getElementById('lightbox-title');
      const lightboxDesc = document.getElementById('lightbox-desc');
      const lightboxCounter = document.getElementById('lightbox-counter');
      const lightboxBadge = document.getElementById('lightbox-badge');
      const lightboxClose = document.getElementById('lightbox-close');
      const lightboxPrev = document.getElementById('lightbox-prev');
      const lightboxNext = document.getElementById('lightbox-next');

      let activeIndex = 0;
      const getActiveItems = () => Array.from(document.querySelectorAll('[data-gallery-item]:not(.hidden)'));

      function openLightbox(index) {
        const activeList = getActiveItems();
        if (!activeList.length) return;

        activeIndex = (index + activeList.length) % activeList.length;
        const currentItem = activeList[activeIndex];
        const imgEl = currentItem.querySelector('img');
        const altText = imgEl ? (imgEl.getAttribute('data-alt') || imgEl.alt || 'Bidyabharati Moment') : 'Bidyabharati Moment';
        const cat = currentItem.getAttribute('data-category');

        if (lightboxImg) lightboxImg.src = imgEl ? imgEl.src : '';
        if (lightboxTitle) lightboxTitle.textContent = altText;
        if (lightboxDesc) lightboxDesc.textContent = `Baripada Campus Academic Gallery (${cat ? cat.replace('-', ' ') : 'General'})`;
        if (lightboxCounter) lightboxCounter.textContent = `${activeIndex + 1} / ${activeList.length}`;
        if (lightboxBadge) lightboxBadge.textContent = cat ? cat.replace('-', ' ') : 'Gallery';

        if (lightbox) {
          lightbox.classList.remove('hidden');
          lightbox.classList.add('flex');
        }
        document.body.style.overflow = 'hidden';
      }

      function closeLightbox() {
        if (lightbox) {
          lightbox.classList.add('hidden');
          lightbox.classList.remove('flex');
        }
        document.body.style.overflow = '';
      }

      // Event Delegation: Click on any gallery card or nested element opens Lightbox
      document.addEventListener('click', (e) => {
        const card = e.target.closest('[data-gallery-item]');
        if (card && !card.classList.contains('hidden')) {
          const activeList = getActiveItems();
          const itemIndex = activeList.indexOf(card);
          if (itemIndex !== -1) {
            openLightbox(itemIndex);
          }
        }
      });

      if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
      if (lightboxPrev) lightboxPrev.addEventListener('click', (e) => { e.stopPropagation(); openLightbox(activeIndex - 1); });
      if (lightboxNext) lightboxNext.addEventListener('click', (e) => { e.stopPropagation(); openLightbox(activeIndex + 1); });

      window.addEventListener('keydown', (e) => {
        if (lightbox && !lightbox.classList.contains('hidden')) {
          if (e.key === 'Escape') closeLightbox();
          if (e.key === 'ArrowLeft') openLightbox(activeIndex - 1);
          if (e.key === 'ArrowRight') openLightbox(activeIndex + 1);
        }
      });

      // Quick helper to reset category filter from empty state
      window.resetGalleryFilter = function() {
        const allBtn = document.querySelector('.gallery-filter-btn[data-cat="all"]');
        if (allBtn) allBtn.click();
      };
    });
  </script>
</main>
<?php include 'includes/footer.php'; ?>
