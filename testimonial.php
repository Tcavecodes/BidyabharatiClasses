<?php 
include 'includes/header.php'; 

// Fetch active testimonials from DB
try {
    $stmtTestimonials = $pdo->query("SELECT * FROM testimonials WHERE LOWER(status) = 'active' ORDER BY id DESC");
    $testimonials = $stmtTestimonials->fetchAll() ?: [];
} catch (Exception $e) {
    $testimonials = [];
}

// Fallback to default testimonials if DB has no entries
if (empty($testimonials)) {
    $testimonials = [
        [
            'name' => 'Adam Cheis',
            'designation' => 'Graphic Designer',
            'rating' => 5,
            'message' => 'Bidyabharati Classes provides exceptional academic guidance with personal attention and clear concepts.',
            'image_path' => 'assets/images/team/user-1.jpg'
        ],
        [
            'name' => 'Amanda Lee',
            'designation' => 'Student',
            'rating' => 5,
            'message' => 'The teachers here are very experienced and supportive. My marks improved significantly after joining.',
            'image_path' => 'assets/images/team/user-2.jpg'
        ]
    ];
}

// If only 1 testimonial exists, duplicate it so Slick Slider (slidesToShow: 2) displays properly without breaking
if (count($testimonials) === 1) {
    $testimonials[] = $testimonials[0];
}
?>


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>testimonials</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Testimonial feedback -->
    <section class="home-2 testimonial">
      <div class="container">
        <div class="row review-slider feedback-main wow fadeInUp">
          <?php foreach ($testimonials as $t): ?>
            <div class="col-md-6">
              <div class="feedback-inner">
                <div class="consult-content">
                  <ul class="mb-2">
                    <?php 
                      $r = intval($t['rating'] ?? 5);
                      for ($s = 1; $s <= 5; $s++): 
                    ?>
                      <li><i class="<?= $s <= $r ? 'fas fa-star' : 'far fa-star' ?>"></i></li>
                    <?php endfor; ?>
                  </ul>
                  <p class="mb-0"><?= nl2br(htmlspecialchars($t['message'])) ?></p>
                </div>
                <div class="consult-title d-flex justify-content-start align-items-center">
                  <?php 
                    $userImg = (!empty($t['image_path']) && file_exists(__DIR__ . '/' . $t['image_path'])) ? $t['image_path'] : 'assets/images/team/user-1.jpg';
                  ?>
                  <img src="<?= htmlspecialchars($userImg) ?>" onerror="this.onerror=null;this.src='assets/images/team/user-1.jpg';" alt="<?= htmlspecialchars($t['name']) ?>" />
                  <div class="ps-name">
                    <h5 class="mb-0"><?= htmlspecialchars($t['name']) ?></h5>
                    <span class="cl-orange"><?= htmlspecialchars($t['designation'] ?: 'Student') ?></span>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <!-- Testimonial ends -->

    <!--  Call to action start -->
    <section class="home-2 call-action pb-0 wow fadeInUp">
      <div class="container">
        <div class="call-wrap">
          <div class="call-main">
            <h2 class="mb-4">JOIN THE COMMUNITY COURSE AND <span class="cl-blue"> UPGRADE YOUR SKILL</span></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            <div class="mt-3">
              <a href="contact.php" class="btn">Join Now</a>
            </div>
          </div>
          <div class="call-image">
            <img src="assets/images/shape/Education-13-Converted-01-1024x667.png" alt="" />
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
            Subscribe to our newsletter and get many <br />
            interesting things every week
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
