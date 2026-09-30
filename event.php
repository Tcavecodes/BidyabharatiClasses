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

    <!--  Call to action start -->
    <section class="call-action p-0 wow fadeInUp">
      <div class="container">
        <div class="call-wrap">
          <div class="call-main">
            <h3 class="mb-4">JOIN THE COMMUNITY COURSE AND <span class="cl-blue"> UPGRADE YOUR SKILL</span></h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
          </div>
          <div class="call-btn">
            <a href="contact.php" class="btn">Join Now</a>
          </div>
        </div>
      </div>
    </section>
    <!--  Call to action end -->



    <?php include 'includes/footer.php'; ?>
