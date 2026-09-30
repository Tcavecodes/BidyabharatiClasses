<?php include 'includes/header.php'; ?>

    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Our Achievers</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Achievers start -->
    <section class="instructors pb-5">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline mb-5">
          <div class="title-top">
            <div class="title-quote">
              <span>Pride of Our Institute</span>
            </div>
            <h3>STUDENT <span class="cl-blue">ACHIEVERS</span></h3>
            <p class="mt-2 text-muted">Celebrating our outstanding students who achieved academic excellence and national honors.</p>
          </div>
        </div>

        <div class="row instruct-main wow fadeInLeft">
          <?php
          $achievers_list = [];
          try {
              $stmtAch = $pdo->query("SELECT * FROM achievers WHERE status = 'active' ORDER BY id DESC");
              $achievers_list = $stmtAch->fetchAll() ?: [];
          } catch (Exception $e) {
              $achievers_list = [];
          }
          ?>
          <?php if (!empty($achievers_list)): ?>
            <?php foreach ($achievers_list as $achiever): ?>
              <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="faculty-card-modern" style="background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #edf2f7; transition: all 0.3s ease; height: 100%; flex-direction: column; display: flex;">
                  <!-- Full Image Block -->
                  <div style="width: 100%; height: 320px; overflow: hidden; background: #f8fafc;">
                    <img src="<?= !empty($achiever['image_path']) ? htmlspecialchars($achiever['image_path']) : 'assets/images/team/team-1.jpg' ?>" 
                         alt="<?= htmlspecialchars($achiever['student_name']) ?>" 
                         style="width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: transform 0.5s ease;" />
                  </div>
                  <!-- Content Block below image -->
                  <div style="padding: 20px 15px; text-align: center; display: flex; flex-direction: column; justify-content: center; flex-grow: 1;">
                    <h3 style="font-family: 'Poppins', sans-serif; font-size: 18px; font-weight: 600; color: #1e293b; margin-bottom: 6px; line-height: 1.2;"><?= htmlspecialchars($achiever['student_name']) ?></h3>
                    <h4 style="font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 700; color: #ee8c1c; margin-bottom: 6px; line-height: 1.3;"><?= htmlspecialchars($achiever['rank_score']) ?></h4>
                    <?php if (!empty($achiever['exam_name']) || !empty($achiever['year'])): ?>
                      <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #64748b; margin-bottom: 0; font-weight: 500; line-height: 1.4;">
                        <?= htmlspecialchars($achiever['exam_name'] ?? '') ?><?= (!empty($achiever['exam_name']) && !empty($achiever['year'])) ? ' (' . htmlspecialchars($achiever['year']) . ')' : '' ?>
                      </p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12 text-center py-5">
              <p class="text-muted fs-5">No achievers found at the moment.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <!-- Achievers ends -->



<?php include 'includes/footer.php'; ?>
