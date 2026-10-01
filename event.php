<?php include 'includes/header.php'; ?>


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Event List</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->



    <!-- News/Events news start -->
    <section class="courses news-events pt-5 pb-5">
      <div class="container">
        <!-- Section Header -->
        <div class="section-title sc-center justify-content-center text-center borderline mb-5">
          <div class="title-top">
            <div class="title-quote">
              <span>Pride of Our Institute</span>
            </div>
            <h3>UPCOMING <span class="cl-blue">EVENTS</span></h3>
            <p class="mt-2 text-muted">Join our workshops, seminars, and events designed to guide and inspire academic success.</p>
          </div>
        </div>

        <div class="wrap-customize">
          <div class="row">
            <?php
            try {
              $eventsStmt = $pdo->query("SELECT * FROM events WHERE status = 'active' ORDER BY event_date DESC");
              $eventsList = $eventsStmt->fetchAll();
            } catch (Exception $e) {
              $eventsList = [];
            }

            if (empty($eventsList)) {
              $eventsList = [
                ['title' => 'Student Leadership & Career Workshop', 'event_date' => '2026-12-26', 'event_time' => '10:00 AM', 'location' => 'Main Auditorium', 'image_path' => 'assets/images/courses/event-1.jpg'],
                ['title' => 'The Best Coaching & Annual Conference', 'event_date' => '2026-12-28', 'event_time' => '11:00 AM', 'location' => 'Conference Hall', 'image_path' => 'assets/images/courses/event-2.jpg'],
                ['title' => 'The Ultimate Future Skills Program', 'event_date' => '2026-12-21', 'event_time' => '09:30 AM', 'location' => 'Lab Hall', 'image_path' => 'assets/images/courses/event-3.jpg'],
                ['title' => 'National Science & Technology Innovation Expo', 'event_date' => '2026-12-15', 'event_time' => '10:00 AM', 'location' => 'Exhibition Ground', 'image_path' => 'assets/images/courses/event-1.jpg'],
              ];
            }

            foreach ($eventsList as $evt):
              $evtImg = !empty($evt['image_path']) ? htmlspecialchars($evt['image_path']) : 'assets/images/courses/event-1.jpg';
              $evtDate = date('d M', strtotime($evt['event_date']));
            ?>
            <div class="col-lg-4 col-md-6 mb-4 customize-wrap wow fadeInUp">
              <div class="customize-item">
                <div class="sv-image">
                  <img src="<?= $evtImg ?>" alt="<?= htmlspecialchars($evt['title']) ?>" />
                </div>
                <div class="customize-ct">
                  <h4>
                    <a href="javascript:void(0)"><?= htmlspecialchars($evt['title']) ?></a>
                  </h4>
                  <?php if (!empty($evt['description'])): ?>
                    <p class="text-muted text-sm mt-2 mb-0" style="font-size: 13px; text-transform: none; font-weight: normal; font-family: inherit;"><?= htmlspecialchars($evt['description']) ?></p>
                  <?php endif; ?>
                </div>
                <div class="customize-bottom">
                  <ul class="d-flex justify-content-start">
                    <li class="mr-3"><i class="far fa-calendar-alt"></i> <?= $evtDate ?></li>
                    <li class="mr-3"><i class="far fa-clock"></i> <?= htmlspecialchars($evt['event_time'] ?? '10AM') ?></li>
                    <li><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($evt['location'] ?? 'Baripada') ?></li>
                  </ul>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- News/Events news start -->


    <!-- Conversion CTA Section -->
    <section class="py-16 lg:py-20 bg-gradient-to-r from-[#0c2340] via-[#123B6D] to-[#0c2340] relative overflow-hidden" data-purpose="conversion-cta" id="contact">
      <!-- Ambient glow backgrounds -->
      <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-[#06bbcc]/20 blur-3xl pointer-events-none"></div>
      <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-[#ee8c1c]/15 blur-3xl pointer-events-none"></div>

      <div class="container mx-auto px-4 text-center relative z-10 space-y-6">
        <span class="campus-update-tag !text-[#ee8c1c] block text-center">Admissions Open 2025–26</span>

        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight font-['Poppins']">
          Find the Right Program for <span class="text-[#ee8c1c]">Your Child</span>
        </h2>

        <p class="text-slate-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed font-['Inter']">
          Have questions about classes, subjects, curriculum, or the right program for your child? Get in touch with Bidyabharati Classes and let us help you choose the appropriate academic support.
        </p>

        <!-- Location Badge -->
        <div class="inline-flex items-center gap-2 text-white/90 bg-white/10 border border-white/15 px-4 py-2 rounded-xl text-sm font-medium backdrop-blur-sm">
          <i class="fa-solid fa-location-dot text-[#ee8c1c]"></i>
          <span>Baripada, Mayurbhanj, Odisha</span>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex flex-wrap justify-center gap-4">
          <a class="btn btn-curve !px-8 !py-3.5 !bg-[#ee8c1c] !text-white hover:!bg-[#e5893e] shadow-lg flex items-center gap-2 font-bold" href="contact.php">
            <i class="fa-solid fa-paper-plane"></i>
            <span>Enquire Now</span>
          </a>
          <a class="btn btn-curve btn-white border border-white/20 !px-8 !py-3.5 !bg-emerald-600 !text-white hover:!bg-emerald-700 shadow-lg flex items-center gap-2 font-bold" href="tel:+919437380042">
            <i class="fa-solid fa-phone"></i>
            <span>Call Admissions Office</span>
          </a>
        </div>

        <!-- Bottom Trust Checklist -->
        <div class="flex flex-wrap items-center justify-center gap-6 text-slate-300 text-xs sm:text-sm font-medium pt-2">
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-[#ee8c1c]"></i>
            <span>Class 3 to 12</span>
          </div>
          <span class="text-slate-500">•</span>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-[#ee8c1c]"></i>
            <span>CBSE &amp; Odia Medium</span>
          </div>
          <span class="text-slate-500">•</span>
          <div class="flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-[#ee8c1c]"></i>
            <span>Dedicated Mentors in Baripada</span>
          </div>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>
