<?php include 'includes/header.php'; ?>


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Our Instructors</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Instructors start -->
    <?php
    $faculties_list = [];
    try {
        $stmtFac = $pdo->query("SELECT * FROM faculties WHERE status = 'active' ORDER BY id DESC");
        $faculties_list = $stmtFac->fetchAll() ?: [];
    } catch (Exception $e) {
        $faculties_list = [];
    }
    ?>
    <section class="instructors pb-5 pt-5">
      <div class="container">
        <!-- Section Header -->
        <div class="section-title sc-center justify-content-center text-center borderline mb-5">
          <div class="title-top">
            <div class="title-quote">
              <span>Pride of Our Institute</span>
            </div>
            <h3>EXPERT <span class="cl-blue">INSTRUCTORS</span></h3>
            <p class="mt-2 text-muted">Dedicated educators and subject experts empowering students toward academic excellence.</p>
          </div>
        </div>

        <div class="row instruct-main wow fadeInLeft">
          <?php if (!empty($faculties_list)): ?>
            <?php foreach ($faculties_list as $index => $faculty): ?>
              <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="faculty-card-modern" style="background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #edf2f7; transition: all 0.3s ease; height: 100%; flex-direction: column; display: flex;">
                  <!-- Full Image Block -->
                  <div style="width: 100%; height: 320px; overflow: hidden; background: #f8fafc;">
                    <img src="<?= !empty($faculty['image_path']) ? htmlspecialchars($faculty['image_path']) : 'assets/images/team/team-1.jpg' ?>" 
                         alt="<?= htmlspecialchars($faculty['name']) ?>" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: transform 0.5s ease;" />
                  </div>
                  <!-- Content Block below image -->
                  <div style="padding: 20px 15px; text-align: center; display: flex; flex-direction: column; justify-content: center; flex-grow: 1;">
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 500; color: #1e293b; margin-bottom: 6px; line-height: 1.2;"><?= htmlspecialchars($faculty['name']) ?></h3>
                    <h4 style="font-family: 'Poppins', sans-serif; font-size: 17px; font-weight: 700; color: #f97316; margin-bottom: 6px; line-height: 1.3; text-transform: capitalize;"><?= htmlspecialchars($faculty['designation']) ?></h4>
                    <?php if (!empty($faculty['qualification']) || !empty($faculty['experience'])): ?>
                      <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #64748b; margin-bottom: 0; font-weight: 400; line-height: 1.4;">
                        <?= htmlspecialchars($faculty['qualification'] ?? '') ?><?= (!empty($faculty['qualification']) && !empty($faculty['experience'])) ? ' • ' : '' ?><?= htmlspecialchars($faculty['experience'] ?? '') ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <!-- Fallback Static Cards when DB is empty -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
              <div class="faculty-card-modern" style="background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #edf2f7; text-align: center;">
                <div style="width: 100%; height: 320px; overflow: hidden; background: #f8fafc;">
                  <img src="assets/images/team/team-1.jpg" alt="Faculty" style="width: 100%; height: 100%; object-fit: cover; object-position: top center;" />
                </div>
                <div style="padding: 20px 15px;">
                  <h3 style="font-size: 18px; font-weight: 500; color: #1e293b; margin-bottom: 6px;">Priya Patel</h3>
                  <h4 style="font-size: 17px; font-weight: 700; color: #f97316; margin-bottom: 6px;">99.6% – State Board Topper</h4>
                  <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">Science Stream Gold Medalist</p>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <!-- Instructors ends -->

    <?php include 'includes/footer.php'; ?>
