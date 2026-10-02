<?php 
include 'includes/header.php'; 

try {
    $stmtFaqs = $pdo->query("SELECT * FROM faqs WHERE LOWER(status) = 'active' ORDER BY sort_order ASC, id ASC");
    $allFaqs = $stmtFaqs->fetchAll() ?: [];
} catch (Exception $e) {
    $allFaqs = [];
}

if (empty($allFaqs)) {
    $allFaqs = [
        [
            'question' => 'What courses are offered at Bidyabharati Classes?',
            'answer' => 'We offer a comprehensive range of coaching programs including Foundation batches for Classes 8 to 10, Medical Entrance (NEET-UG), Engineering Entrance (JEE Main & Advanced), Board Exam preparations (CBSE/ICSE/State Board), and specialized Crash Courses with extensive problem-solving drills.'
        ],
        [
            'question' => 'How to enroll in Bidyabharati Classes?',
            'answer' => 'Enrolling is straightforward! You can apply directly through our online enrollment form, visit our admissions desk at the campus, or contact our academic counselors. Our team will guide you through batch timings, documentation, and the enrollment process.'
        ],
        [
            'question' => 'What is the fee structure and scholarship options?',
            'answer' => 'Our fee structure is transparent, affordable, and tailored to the program duration and grade level. We also offer merit-based scholarship fee waivers up to 100% based on our admission & scholarship test, along with flexible installment payment plans.'
        ],
        [
            'question' => 'What is the online coaching course format?',
            'answer' => 'Our online coaching course combines live interactive virtual lectures with top faculties, recorded class archives for round-the-clock revision, digital study modules, live doubt-clearing sessions, and national-level online mock tests with real-time performance analytics.'
        ]
    ];
}

$half = ceil(count($allFaqs) / 2);
$col1Faqs = array_slice($allFaqs, 0, $half);
$col2Faqs = array_slice($allFaqs, $half);
?>

    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>FREQUENTLY ASKED QUESTION</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Faq start -->
    <section>
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12">
            <!--Accordion wrapper 1-->
            <div class="accordion md-accordion mb-3" id="accordionEx1" role="tablist" aria-multiselectable="true">
              <?php foreach ($col1Faqs as $idx => $f): ?>
                <?php 
                  $cId = "collapseCol1_" . ($idx + 1);
                  $hId = "headingCol1_" . ($idx + 1);
                  $isFirst = ($idx === 0);
                ?>
                <div class="card">
                  <div class="card-header" role="tab" id="<?= $hId ?>">
                    <a
                      class="<?= $isFirst ? '' : 'collapsed' ?>"
                      data-toggle="collapse"
                      data-parent="#accordionEx1"
                      href="#<?= $cId ?>"
                      aria-expanded="<?= $isFirst ? 'true' : 'false' ?>"
                      aria-controls="<?= $cId ?>"
                    >
                      <h5 class="mb-0"><?= htmlspecialchars($f['question']) ?> <i class="fas fa-plus"></i></h5>
                    </a>
                  </div>
                  <div id="<?= $cId ?>" class="collapse <?= $isFirst ? 'show' : '' ?>" role="tabpanel" aria-labelledby="<?= $hId ?>" data-parent="#accordionEx1">
                    <div class="card-body">
                      <p><?= nl2br(htmlspecialchars($f['answer'])) ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12">
            <!--Accordion wrapper 2-->
            <div class="accordion acc-dark md-accordion mb-3" id="accordionEx2" role="tablist" aria-multiselectable="true">
              <?php foreach ($col2Faqs as $idx => $f): ?>
                <?php 
                  $cId = "collapseCol2_" . ($idx + 1);
                  $hId = "headingCol2_" . ($idx + 1);
                  $isFirst = ($idx === 0);
                ?>
                <div class="card">
                  <div class="card-header" role="tab" id="<?= $hId ?>">
                    <a
                      class="<?= $isFirst ? '' : 'collapsed' ?>"
                      data-toggle="collapse"
                      data-parent="#accordionEx2"
                      href="#<?= $cId ?>"
                      aria-expanded="<?= $isFirst ? 'true' : 'false' ?>"
                      aria-controls="<?= $cId ?>"
                    >
                      <h5 class="mb-0"><?= htmlspecialchars($f['question']) ?> <i class="fas fa-plus"></i></h5>
                    </a>
                  </div>
                  <div id="<?= $cId ?>" class="collapse <?= $isFirst ? 'show' : '' ?>" role="tabpanel" aria-labelledby="<?= $hId ?>" data-parent="#accordionEx2">
                    <div class="card-body">
                      <p><?= nl2br(htmlspecialchars($f['answer'])) ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  Faq end -->

    <!--  Call to action start -->
    <section class="call-action p-0 wow fadeInUp">
      <div class="container">
        <div class="call-wrap">
          <div class="call-main">
            <h3 class="mb-4">JOIN THE COMMUNITY COURSE AND <span class="cl-blue"> UPGRADE YOUR SKILL</span></h3>
            <p>Empowering students with conceptual clarity, interactive sessions, and competitive exam preparation.</p>
          </div>
          <div class="call-btn">
            <a href="contact.php" class="btn">Join Now</a>
          </div>
        </div>
      </div>
    </section>
    <!--  Call to action end -->

    <!--  Newsletter start -->
    <section class="newsletter">
      <div class="container">
        <div class="news-headding text-center">
          <h2>SIGN UP TO OUR NEWSLETTER</h2>
          <p>
            Subscribe to our newsletter and get updates <br />
            about new batches and announcements.
          </p>
          <form>
            <div class="form-group">
              <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Your Email" />
              <button class="btn"><i class="fas fa-envelope-open-text"></i> Subscribe</button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!--  Newsletter end -->

    <?php include 'includes/footer.php'; ?>
