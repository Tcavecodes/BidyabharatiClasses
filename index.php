<?php
include 'includes/header.php';

// Fetch active hero sliders from DB
try {
    $stmtSliders = $pdo->query("SELECT * FROM hero_sliders WHERE status = 'active' ORDER BY id ASC");
    $heroSliders = $stmtSliders->fetchAll() ?: [];
} catch (Exception $e) {
    $heroSliders = [];
}

// Fallback to 3 default slides if DB is empty
if (empty($heroSliders)) {
    $heroSliders = [
        [
            'subtitle' => 'LEARN ANYTHING, ANYTIME, ANYWHERE',
            'title' => 'BEST ONLINE LEARNING FOR YOUR FUTURE',
            'description' => 'Empowering students from Class 3 to 12 with conceptual clarity, disciplined guidance, and excellence.',
            'btn1_text' => 'View Course',
            'btn1_url' => 'course-1.php',
            'btn2_text' => 'Get Started',
            'btn2_url' => 'contact.php',
            'image_path' => 'assets/images/banner/education-2021-04-04-14-25-07-utc.jpg'
        ],
        [
            'subtitle' => 'START YOUR FAVOURITE COURSE',
            'title' => 'START YOUR FAVOURITE COURSE BRIGHT FUTURE',
            'description' => 'Over three decades of dedicated teaching experience in Baripada, Odisha.',
            'btn1_text' => 'Explore Programs',
            'btn1_url' => 'course-1.php',
            'btn2_text' => 'Contact Us',
            'btn2_url' => 'contact.php',
            'image_path' => 'assets/images/banner/education-PHW33SU.jpg'
        ],
        [
            'subtitle' => 'EXCELLENCE IN EDUCATION',
            'title' => 'BUILD STRONG CONCEPTS FOR SUCCESS',
            'description' => 'Specialized academic coaching for CBSE and State Board students with individual attention.',
            'btn1_text' => 'Our Achievers',
            'btn1_url' => 'achievers.php',
            'btn2_text' => 'Enroll Now',
            'btn2_url' => 'contact.php',
            'image_path' => 'assets/images/banner/secondsection.jpg'
        ]
    ];
}

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

// Fetch active FAQs from DB
try {
    $stmtFaqs = $pdo->query("SELECT * FROM faqs WHERE LOWER(status) = 'active' ORDER BY sort_order ASC, id ASC");
    $faqs = $stmtFaqs->fetchAll() ?: [];
} catch (Exception $e) {
    $faqs = [];
}

if (empty($faqs)) {
    $faqs = [
        [
            'question' => 'What courses are offered?',
            'answer' => 'We offer a comprehensive range of coaching programs including Foundation batches for Classes 8 to 10, Medical Entrance (NEET-UG), Engineering Entrance (JEE Main & Advanced), Board Exam preparations (CBSE/ICSE/State Board), and specialized Crash Courses with extensive problem-solving drills.'
        ],
        [
            'question' => 'How to enroll?',
            'answer' => 'Enrolling is straightforward! You can apply directly through our online enrollment form, visit our admissions desk at the campus, or contact our academic counselors. Our team will guide you through batch timings, documentation, and the enrollment process.'
        ],
        [
            'question' => 'Fee structure?',
            'answer' => 'Our fee structure is transparent, affordable, and tailored to the program duration and grade level. We also offer merit-based scholarship fee waivers up to 100% based on our admission & scholarship test, along with flexible installment payment plans.'
        ],
        [
            'question' => 'What is online coaching course?',
            'answer' => 'Our online coaching course combines live interactive virtual lectures with top faculties, recorded class archives for round-the-clock revision, digital study modules, live doubt-clearing sessions, and national-level online mock tests with real-time performance analytics.'
        ]
    ];
}

// Fetch active Blogs for home page
try {
    $stmtHomeBlogs = $pdo->query("SELECT * FROM blogs WHERE LOWER(status) = 'active' ORDER BY id DESC LIMIT 3");
    $homeBlogs = $stmtHomeBlogs->fetchAll() ?: [];
} catch (Exception $e) {
    $homeBlogs = [];
}

if (empty($homeBlogs)) {
    $homeBlogs = [
        [
            'id' => 1,
            'title' => 'Effective Preparation Strategies for Board & Entrance Examinations',
            'category' => 'Exam Guidance',
            'author_name' => 'TIKAM BEHERA',
            'author_role' => 'Director & Physics Faculty',
            'image_path' => 'assets/images/blog/blog-1.jpg',
            'summary' => 'Discover key study habits, time management tips, and problem-solving techniques to excel in Board and Competitive Exams.',
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'title' => 'The Role of Physics and Problem Solving in Future Careers',
            'category' => 'Science & Innovation',
            'author_name' => 'TIKAM BEHERA',
            'author_role' => 'M. Sc. Physics',
            'image_path' => 'assets/images/blog/blog-2.jpg',
            'summary' => 'Why analytical thinking and strong fundamentals in Physics open doors to modern engineering, technology, and research careers.',
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 3,
            'title' => 'Building Academic Excellence: Guidance for Class 8 to 10 Foundation Batches',
            'category' => 'Academic Insights',
            'author_name' => 'Academic Team',
            'author_role' => 'Senior Faculty',
            'image_path' => 'assets/images/blog/blog-3.jpg',
            'summary' => 'Starting early with foundation courses builds competitive confidence and conceptual strength for senior secondary challenges.',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
}
?>
    <!-- banner starts -->
    <section class="banner-main pb-0">
      <div class="banner-content">
        <div class="slider banner-slider">
          <?php foreach ($heroSliders as $slide): ?>
            <div class="h2-slider-list sl-overlay" style="background-image: url(<?= htmlspecialchars($slide['image_path']) ?>)">
              <div class="container">
                <div class="slide-contain">
                  <?php if (!empty($slide['subtitle'])): ?>
                    <h4><?= htmlspecialchars($slide['subtitle']) ?></h4>
                  <?php endif; ?>
                  <h1 class="cl-white mt-4 wow fadeInDown"><?= htmlspecialchars($slide['title']) ?></h1>
                  <?php if (!empty($slide['description'])): ?>
                    <p class="wow fadeInLeft"><?= htmlspecialchars($slide['description']) ?></p>
                  <?php endif; ?>
                  <div class="slide-btn mt-4 wow fadeInLeft">
                    <?php if (!empty($slide['btn1_text'])): ?>
                      <a href="<?= htmlspecialchars($slide['btn1_url'] ?? '#') ?>" class="btn btn-curve mr-2"><?= htmlspecialchars($slide['btn1_text']) ?></a>
                    <?php endif; ?>
                    <?php if (!empty($slide['btn2_text'])): ?>
                      <a href="<?= htmlspecialchars($slide['btn2_url'] ?? '#') ?>" class="btn btn-curve btn-white"><?= htmlspecialchars($slide['btn2_text']) ?></a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <!-- banner ends -->

    <!-- content main start -->
    <section class="services-main">
      <div class="container">
        <div class="service-full wow fadeInRight">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="row service-list-wrap">
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-scblue mb-4">
                    <i class="far fa-user"></i>
                    <h4 class="cl-white">EXPERIENCED FACULTY</h4>
                    <p class="m-0">Dedicated teachers focused on clear concepts and student progress.</p>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-scgreen mb-4">
                    <i class="fas fa-graduation-cap"></i>
                    <h4 class="cl-white">CBSE & STATE BOARD</h4>
                    <p class="m-0">Coaching designed for both CBSE and State Board students.</p>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-sc-lblue mb-4">
                    <i class="fas fa-clipboard-check"></i>
                    <h4 class="cl-white">REGULAR ASSESSMENTS</h4>
                    <p class="m-0">Tests and practice sessions to track progress and strengthen preparation.</p>
                  </div>
                </div>
                <div class="col-lg-3 col-md-6 p-0">
                  <div class="service-ct-list bg-sc-dblue mb-4">
                    <i class="fas fa-user-check"></i>
                    <h4 class="cl-white">PERSONALIZED ATTENTION</h4>
                    <p class="m-0">Individual guidance to help every student learn with confidence.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End content main -->

    <!-- About start -->
    <section class="about-company p-0">
      <div class="container">
        <div class="row flex-row-reverse">
          <div class="col-lg-5 wow fadeInLeftBig">
            <div class="about-wrap-img">
              <img src="assets/images/inner/education-students-people-knowledge-concept-2021-04-02-19-49-59-utc.jpg" alt="" />
            </div>
          </div>
          <div class="col-lg-7 wow fadeInRightBig">
            <div class="about-us-wrap">
              <div class="about-title mb-4">
                <span class="text-xs font-poppins font-bold uppercase tracking-widest text-[#ee8c1c] block mb-1">About Bidyabharati Classes</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#00254e] tracking-tight uppercase font-['Outfit'] leading-tight mb-2">
                  Learn Something New, And Grow Your <span class="text-[#06bbcc]">Skill</span>
                </h2>
                <div class="w-16 h-1 bg-[#ee8c1c] rounded-full mt-2"></div>
              </div>
              <div class="about-content">
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dignissimos, deleniti adipisci ut inventore commodi iure explicabo excepturi
                  cumque laudantium quis praesentium id nesciunt! Soluta sunt obcaecati aspernatur nostrum ab.
                </p>
                <p class="mb-4">
                  Using our single innovative platform you can remove all your communication dependencies and the messy ratâ€™s nest of email, calls, texts,
                  wikis, and apps you currently have.
                </p>
                <a href="#" class="btn">View Course</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="main-shape01"></div>
    </section>
    <!-- About end -->

    <!-- Director Message start -->
    <section class="director-message">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-5 col-md-12 text-center wow fadeInLeft">
            <div class="director-img-container">
              <img src="assets/images/team/director.png" alt="Director" class="img-fluid director-photo" />
            </div>
          </div>
          <div class="col-lg-7 col-md-12 wow fadeInRight">
            <div class="director-msg-wrap pl-lg-4 mt-4 mt-lg-0">
              <div class="director-header">
                <span class="director-subtitle">DIRECTOR'S MESSAGE</span>
                <h2 class="director-title">DIRECTOR'S MESSAGE</h2>
                <div class="director-divider"></div>
              </div>
              <div class="director-content">
                <p>
                  Welcome to Bidyabharati Classes, where academic excellence meets innovation. We are dedicated to providing students with high-quality education, modern learning resources, and the guidance required to achieve their career goals and excel in a rapidly evolving world.
                </p>
                <p>
                  We believe in fostering holistic development through practical learning, dedicated mentorship, and comprehensive academic experiences. Our mission is to empower every learner with knowledge, confidence, and real-world skills.
                </p>
                <p>
                  Our experienced faculty and student-centric approach ensure that every learner receives the personal attention and professional support necessary to build a rewarding future and contribute meaningfully to society.
                </p>
                <div class="director-signature mt-4">
                  <p class="sign-greeting mb-1">Sincerely,</p>
                  <h4 class="director-name mb-0">TIKAM BEHERA</h4>
                  <span class="director-designation">M. SC. PHYSICS</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Director Message end -->

    <!-- Campus Updates & Why Choose Us start -->
    <section class="campus-updates-section">
      <div class="container">
        <!-- Section Header -->
        <div class="section-title sc-center justify-content-center text-center borderline mb-5 wow fadeInDown">
          <div class="title-top">
            <span class="campus-update-tag">Campus Update</span>
            <h2 class="campus-update-heading">CAMPUS UPDATES & <span class="cl-blue">HAPPENINGS</span></h2>
          </div>
        </div>

        <div class="row align-items-center">
          <!-- Left Column: Photo Collage -->
          <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 text-center wow fadeInLeft">
            <div class="campus-collage-wrap">
              <img src="assets/images/inner/campus-animated-learning.svg" alt="Campus Updates & Learning" class="campus-collage-img campus-animated-img" />
            </div>
          </div>

          <!-- Right Column: Why Choose Us Content -->
          <div class="col-lg-6 col-md-12 wow fadeInRight">
            <div class="campus-content-wrap">
              <span class="campus-why-tag">// WHY CHOOSE BIDYABHARATI CLASSES?</span>
              <h2 class="campus-why-title">WHY CHOOSE BIDYABHARATI CLASSES?</h2>
              <p class="campus-why-desc">
                We provide a wide range of academic programs and specialized guidance that empowers students to excel, build deep conceptual clarity, and achieve their career goals with expert faculty mentorship.
              </p>
              <h4 class="campus-why-highlight">5000+ Trained Students</h4>
              <ul class="campus-features-list">
                <li><i class="fas fa-check"></i> <span>STRUCTURED STUDY PLANS & ASSESSMENTS</span></li>
                <li><i class="fas fa-check"></i> <span>EXPERT MENTORSHIP & COUNSELING</span></li>
                <li><i class="fas fa-check"></i> <span>FOCUS ON EXAM TEMPERAMENT</span></li>
                <li><i class="fas fa-check"></i> <span>PROVEN TOP RESULTS</span></li>
                <li><i class="fas fa-check"></i> <span>VIBRANT CAMPUS COMMUNITY</span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Campus Updates & Why Choose Us end -->

    <!-- Events & Notice Board start -->
    <?php
    try {
        $activeEvents = $pdo->query("SELECT * FROM events WHERE status = 'active' ORDER BY event_date DESC LIMIT 6")->fetchAll() ?: [];
        $activeNotices = $pdo->query("SELECT * FROM notices WHERE status = 'active' ORDER BY notice_date DESC LIMIT 7")->fetchAll() ?: [];
    } catch (Exception $e) {
        $activeEvents = [];
        $activeNotices = [];
    }
    ?>
    <section class="events-notice-section">
      <div class="container">
        <div class="row">
          <!-- Latest Events Column -->
          <div class="col-lg-6 col-md-12 mb-4 mb-lg-0 en-col-wrap">
            <h3 class="en-col-title">LATEST EVENTS</h3>
            <div class="en-events-list">
              <?php if (empty($activeEvents)): ?>
                <p class="text-muted small">No upcoming events posted.</p>
              <?php else: ?>
                <?php foreach ($activeEvents as $evt): ?>
                  <div class="en-event-card">
                    <div class="en-date-badge">
                      <div class="en-date-month"><?= strtoupper(date('M', strtotime($evt['event_date']))) ?></div>
                      <div class="en-date-day"><?= date('d', strtotime($evt['event_date'])) ?></div>
                    </div>
                    <div class="en-event-content">
                      <div class="en-event-rating">
                        <?= str_repeat('<i class="fas fa-star"></i>', $evt['rating'] ?? 5) ?>
                      </div>
                      <h4 class="en-event-title"><a href="event.php"><?= htmlspecialchars($evt['title']) ?></a></h4>
                      <p class="en-event-desc">
                        <?= htmlspecialchars($evt['description'] ?? '') ?>
                      </p>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>

          <!-- Notice Board Column -->
          <div class="col-lg-6 col-md-12 en-col-wrap">
            <h3 class="en-col-title">NOTICE BOARD</h3>
            <div class="en-notice-board-wrap">
              <div class="en-notice-list">
                <?php if (empty($activeNotices)): ?>
                  <p class="text-muted small">No active notices.</p>
                <?php else: ?>
                  <?php foreach ($activeNotices as $not): ?>
                    <div class="en-notice-item">
                      <h4 class="en-notice-title"><a href="#"><?= htmlspecialchars($not['title']) ?></a></h4>
                      <span class="en-notice-category"><?= htmlspecialchars($not['category']) ?></span>
                      <span class="en-notice-date"><?= date('M d, Y', strtotime($not['notice_date'])) ?></span>
                    </div>
                  <?php endforeach; ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Events & Notice Board end -->

    <!-- Enrollment CTA Section start -->
    <section class="enrollment-cta-section wow fadeInUp">
      <div class="container">
        <div class="enrollment-banner">
          <div class="row align-items-center">
            <!-- Left Hero Content -->
            <div class="col-lg-6 col-md-12 mb-4 mb-lg-0">
              <div class="enroll-hero-content">
                <h2 class="enroll-hero-title">READY TO START YOUR SUCCESS JOURNEY? ENROL NOW!</h2>
                <p class="enroll-hero-desc">Fill out our fast and simple enrolment form to begin your path to academic excellence.</p>
                <a href="#enroll-form" class="btn enroll-hero-btn">ENROLL NOW</a>
              </div>
            </div>

            <!-- Right Enrollment Form Card -->
            <div class="col-lg-6 col-md-12">
              <div class="enroll-form-card" id="enroll-form">
                <div class="enroll-form-header">
                  <h3 class="enroll-header-title">Start Your Enrollment</h3>
                  <p class="enroll-header-subtitle">Fill out your information to reserve your seat for the next batch</p>
                </div>
                <div class="enroll-form-body">
                  <?php
                  $enrollMsg = '';
                  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_enrollment'])) {
                    $sName = trim($_POST['student_name'] ?? '');
                    $sEmail = trim($_POST['email'] ?? '');
                    $sPhone = trim($_POST['phone'] ?? '');
                    $sCourse = trim($_POST['course'] ?? '');
                    $sMessage = trim($_POST['message'] ?? '');

                    if (!empty($sName) && !empty($sEmail) && !empty($sCourse)) {
                      try {
                        $stmtEnroll = $pdo->prepare("INSERT INTO enrollments (student_name, email, phone, course, message, status) VALUES (?, ?, ?, ?, ?, 'pending')");
                        $stmtEnroll->execute([$sName, $sEmail, $sPhone, $sCourse, $sMessage]);
                        $enrollMsg = '<div class="alert alert-success p-2 mb-3 text-center" style="font-size: 13px; border-radius: 8px; background-color: #d1e7dd; color: #0f5132;">Thank you for enrolling! Our team will contact you shortly.</div>';
                      } catch (Exception $e) {
                        $enrollMsg = '<div class="alert alert-danger p-2 mb-3 text-center" style="font-size: 13px; border-radius: 8px;">An error occurred while submitting. Please try again.</div>';
                      }
                    }
                  }
                  ?>
                  <?= $enrollMsg ?>
                  <form action="index.php#enroll-form" method="POST">
                    <input type="hidden" name="submit_enrollment" value="1">
                    <div class="form-group mb-3">
                      <input type="text" name="student_name" class="form-control enroll-field" placeholder="Your Full Name" required />
                    </div>
                    <div class="form-group mb-3">
                      <input type="email" name="email" class="form-control enroll-field" placeholder="Email Address" required />
                    </div>
                    <div class="form-group mb-3">
                      <input type="text" name="phone" class="form-control enroll-field" placeholder="Phone Number" required />
                    </div>
                    <div class="form-group mb-3">
                      <select name="course" class="form-control enroll-field enroll-select" required style="color: #495057;">
                        <option value="" disabled selected>Choose Course / Class</option>
                        <option value="CBSE Class III - VIII">CBSE Class III - VIII (All Subjects)</option>
                        <option value="CBSE Class IX - X">CBSE Class IX - X (All Subjects)</option>
                        <option value="State Board Class III - X">State Board Class III - X (All Subjects)</option>
                        <option value="Class XI Mathematics">Class XI Mathematics Special Coaching</option>
                        <option value="Class XII Mathematics">Class XII Mathematics Special Coaching</option>
                      </select>
                    </div>
                    <div class="form-group mb-4">
                      <input type="text" name="message" class="form-control enroll-field" placeholder="Type Additional Note / Query" />
                    </div>
                    <div class="d-flex align-items-center justify-content-between position-relative">
                      <button type="submit" class="btn enroll-submit-btn">
                        ENROLL NOW <i class="fas fa-arrow-right ml-2"></i>
                      </button>
                      <div class="enroll-card-deco">
                        <svg width="56" height="56" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <rect x="8" y="6" width="38" height="48" rx="4" fill="#F8FAFC" stroke="#CBD5E1" stroke-width="2"/>
                          <line x1="14" y1="16" x2="38" y2="16" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                          <line x1="14" y1="24" x2="38" y2="24" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                          <line x1="14" y1="32" x2="34" y2="34" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                          <line x1="14" y1="40" x2="28" y2="40" stroke="#94A3B8" stroke-width="2" stroke-linecap="round"/>
                          <g transform="rotate(-35 44 40)">
                            <rect x="38" y="10" width="8" height="30" rx="2" fill="#1D4ED8"/>
                            <rect x="38" y="16" width="8" height="3" fill="#F59E0B"/>
                            <path d="M38 40L42 49L46 40H38Z" fill="#F59E0B"/>
                            <path d="M40.5 45L42 49L43.5 45H40.5Z" fill="#0F172A"/>
                          </g>
                        </svg>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Enrollment CTA Section end -->

    <!-- Image Gallery Section start -->
    <?php
    // Fetch Active Gallery Items for Homepage
    $home_gallery_items = [];
    try {
        $stmtHomeGal = $pdo->query("SELECT * FROM gallery WHERE status = 'active' ORDER BY id DESC LIMIT 12");
        $home_gallery_items = $stmtHomeGal->fetchAll() ?: [];
    } catch (Exception $e) {
        $home_gallery_items = [];
    }

    if (!function_exists('getCategorySlug')) {
        function getCategorySlug($catName) {
            return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $catName), '-'));
        }
    }

    // Dynamic Categories for homepage
    $home_categories = [];
    foreach ($home_gallery_items as $hgItem) {
        $cRaw = trim($hgItem['category'] ?? '');
        if (!empty($cRaw)) {
            $cSlug = getCategorySlug($cRaw);
            if (!isset($home_categories[$cSlug])) {
                $home_categories[$cSlug] = $cRaw;
            }
        }
    }

    if (empty($home_categories)) {
        $home_categories = [
            'classroom' => 'Classroom',
            'events' => 'Events & Celebrations',
            'student-activities' => 'Student Activities',
            'achievements' => 'Achievements',
            'campus' => 'Campus & Infrastructure',
            'workshops' => 'Workshops & Seminars',
        ];
    }
    ?>
    <section class="w-full bg-surface-container-lowest py-space-xl" id="image-gallery">
      <div class="max-w-[1240px] mx-auto px-margin-mobile lg:px-margin flex flex-col gap-space-lg">
        <!-- Section Header -->
        <div class="section-title sc-center justify-content-center text-center borderline mb-4">
          <div class="title-top">
            <span class="campus-update-tag" style="color: #ee8c1c; font-weight: 700; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">OUR GALLERY</span>
            <h2 class="campus-update-heading" style="font-size: 32px; font-weight: 700; color: #181d38; text-transform: uppercase; margin-top: 5px;">
              MOMENTS THAT TELL <span style="color: #06bbcc;">OUR STORY</span>
            </h2>
          </div>
        </div>

        <!-- Category Filter Pills Bar -->
        <div class="w-full overflow-x-auto pb-2 scrollbar-none">
          <div class="inline-flex items-center gap-2" id="image-filter-container">
            <button class="gallery-filter-btn btn btn-curve transition-all shadow-sm !px-5 !py-2.5 text-sm uppercase font-semibold !bg-[#06bbcc] !text-white" data-cat="all">
              All
            </button>
            <?php foreach ($home_categories as $hSlug => $hLabel): ?>
              <button class="gallery-filter-btn btn btn-curve btn-white transition-all border border-gray-200 !px-5 !py-2.5 text-sm uppercase font-semibold text-gray-700 hover:!bg-[#06bbcc] hover:!text-white" data-cat="<?= htmlspecialchars($hSlug) ?>">
                <?= htmlspecialchars($hLabel) ?>
              </button>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Responsive 4-Column Image Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md" id="image-grid">
          <?php if (!empty($home_gallery_items)): ?>
            <?php foreach ($home_gallery_items as $hPhoto): 
              $hCatSlug = getCategorySlug($hPhoto['category'] ?? 'general');
            ?>
            <div class="gallery-card group relative h-72 rounded-2xl overflow-hidden bg-surface-container cursor-pointer shadow-sm hover:shadow-xl transition-all duration-300" data-category="<?= htmlspecialchars($hCatSlug) ?>" data-gallery-item="">
              <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" data-alt="<?= htmlspecialchars($hPhoto['title']) ?>" src="<?= htmlspecialchars($hPhoto['image_path']) ?>" alt="<?= htmlspecialchars($hPhoto['title']) ?>">
              <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-on-primary">
                <div class="w-12 h-12 rounded-full bg-surface-container-lowest/30 backdrop-blur-md flex items-center justify-center">
                  <span class="material-symbols-outlined text-[24px]">zoom_in</span>
                </div>
              </div>
              <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/80 via-black/40 to-transparent text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span class="text-[10px] font-bold uppercase tracking-wider bg-[#ee8c1c] px-2 py-0.5 rounded text-white inline-block mb-1"><?= htmlspecialchars($hPhoto['category']) ?></span>
                <h4 class="text-xs font-semibold truncate"><?= htmlspecialchars($hPhoto['title']) ?></h4>
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

        <!-- View Full Gallery Action Button -->
        <div class="flex justify-center pt-space-md">
          <a href="gallery.php" class="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-primary text-on-primary font-label-lg text-label-lg hover:bg-secondary transition-all shadow-md">
            <span class="material-symbols-outlined text-[18px]">collections</span>
            <span>View Full Gallery Page</span>
          </a>
        </div>
      </div>
    </section>
    <!-- Image Gallery Section end -->

    <!-- Interactive Lightbox Modal -->
    <div aria-modal="true" class="fixed inset-0 z-50 bg-primary/95 backdrop-blur-md hidden flex-col justify-between p-4 sm:p-8" id="gallery-lightbox" role="dialog">
      <!-- Lightbox Top Controls -->
      <div class="w-full max-w-6xl mx-auto flex items-center justify-between text-on-primary py-2">
        <div class="flex items-center gap-3">
          <span class="font-label-lg text-label-lg px-3 py-1 rounded-full bg-surface-container-lowest/15 backdrop-blur-sm" id="lightbox-counter">1 / 6</span>
          <span class="font-label-md text-label-md text-tertiary-fixed-dim uppercase tracking-wider font-semibold" id="lightbox-badge">Classroom</span>
        </div>
        <button class="w-10 h-10 rounded-full bg-surface-container-lowest/20 hover:bg-surface-container-lowest/30 flex items-center justify-center transition-all" id="lightbox-close">
          <span class="material-symbols-outlined text-[24px]">close</span>
        </button>
      </div>
      <!-- Lightbox Center Content with Prev / Next -->
      <div class="w-full max-w-6xl mx-auto flex-1 flex items-center justify-between gap-4 py-4 relative">
        <button class="w-12 h-12 rounded-full bg-surface-container-lowest/20 hover:bg-surface-container-lowest/40 text-on-primary flex items-center justify-center transition-all shrink-0" id="lightbox-prev">
          <span class="material-symbols-outlined text-[28px]">chevron_left</span>
        </button>
        <div class="flex-1 flex flex-col items-center justify-center max-h-[70vh] overflow-hidden">
          <img alt="Expanded View" class="max-h-[62vh] w-auto max-w-full object-contain rounded-xl shadow-2xl transition-all duration-300" id="lightbox-img" src="">
        </div>
        <button class="w-12 h-12 rounded-full bg-surface-container-lowest/20 hover:bg-surface-container-lowest/40 text-on-primary flex items-center justify-center transition-all shrink-0" id="lightbox-next">
          <span class="material-symbols-outlined text-[28px]">chevron_right</span>
        </button>
      </div>
      <!-- Lightbox Bottom Caption -->
      <div class="w-full max-w-3xl mx-auto text-center text-on-primary pb-2">
        <h3 class="font-headline-md text-headline-sm sm:text-headline-md text-surface-container-lowest mb-1" id="lightbox-title"></h3>
        <p class="font-body-sm text-body-sm text-primary-fixed-dim max-w-xl mx-auto" id="lightbox-desc"></p>
      </div>
    </div>

    <!-- Gallery Script -->
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.gallery-filter-btn');
        const galleryItems = document.querySelectorAll('[data-gallery-item]');
        const countPill = document.getElementById('gallery-count-pill');
        const emptyState = document.getElementById('gallery-empty-state');

        filterBtns.forEach(btn => {
          btn.addEventListener('click', () => {
            const selected = btn.getAttribute('data-cat');
            filterBtns.forEach(b => {
              b.classList.remove('!bg-[#06bbcc]', '!text-white');
              b.classList.add('btn-white', 'text-gray-700');
            });
            btn.classList.add('!bg-[#06bbcc]', '!text-white');
            btn.classList.remove('btn-white', 'text-gray-700');

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

            if (countPill) countPill.textContent = `Showing ${visibleCount} Photos`;

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
          const titleEl = currentItem.querySelector('h3');
          const descEl = currentItem.querySelector('p');
          const cat = currentItem.getAttribute('data-category');

          lightboxImg.src = imgEl ? imgEl.src : '';
          lightboxTitle.textContent = titleEl ? titleEl.textContent : 'Bidyabharati Moment';
          lightboxDesc.textContent = descEl ? descEl.textContent : '';
          lightboxCounter.textContent = `${activeIndex + 1} / ${activeList.length}`;
          lightboxBadge.textContent = cat ? cat.replace('-', ' ') : 'Gallery';

          lightbox.classList.remove('hidden');
          lightbox.classList.add('flex');
          document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
          lightbox.classList.add('hidden');
          lightbox.classList.remove('flex');
          document.body.style.overflow = '';
        }

        galleryItems.forEach(item => {
          item.addEventListener('click', () => {
            const activeList = getActiveItems();
            const itemIndex = activeList.indexOf(item);
            if (itemIndex !== -1) openLightbox(itemIndex);
          });
        });

        if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
        if (lightboxPrev) lightboxPrev.addEventListener('click', () => openLightbox(activeIndex - 1));
        if (lightboxNext) lightboxNext.addEventListener('click', () => openLightbox(activeIndex + 1));

        window.addEventListener('keydown', (e) => {
          if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') openLightbox(activeIndex - 1);
            if (e.key === 'ArrowRight') openLightbox(activeIndex + 1);
          }
        });

        window.resetGalleryFilter = function() {
          const allBtn = document.querySelector('.gallery-filter-btn[data-cat="all"]');
          if (allBtn) allBtn.click();
        };
      });
    </script>




    <!-- Testimonial feedback -->
    <section class="home-2 testimonial p-0">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline mb-5 wow fadeInDown">
          <div class="title-top">
            <span class="campus-update-tag">Customer Reviews</span>
            <h2 class="campus-update-heading">WHAT PEOPLE <span class="cl-blue">SAY</span></h2>
          </div>
        </div>
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
                <div class="consult-title d-flex justify-content-start">
                  <img src="<?= htmlspecialchars(!empty($t['image_path']) ? $t['image_path'] : 'assets/images/team/user-1.jpg') ?>" alt="<?= htmlspecialchars($t['name']) ?>" />
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

    <!-- FAQ Section start -->
    <section class="faq-section">
      <div class="container">
        <!-- Section Header -->
        <div class="section-title sc-center justify-content-center text-center mb-5 wow fadeInDown">
          <div class="title-top">
            <span class="faq-tag">FAQ QUESTIONS</span>
            <h2 class="faq-heading">FREQUENTLY ASKED QUESTIONS</h2>
          </div>
        </div>

        <!-- FAQ Accordion -->
        <div class="faq-accordion-wrap wow fadeInUp">
          <div class="accordion" id="homeFaqAccordion">
            <?php foreach ($faqs as $index => $faq): ?>
              <?php 
                $faqId = 'faqCollapse' . ($index + 1);
                $isFirst = ($index === 0);
              ?>
              <div class="faq-item-card">
                <button
                  class="faq-btn <?= $isFirst ? '' : 'collapsed' ?>"
                  type="button"
                  data-toggle="collapse"
                  data-target="#<?= $faqId ?>"
                  aria-expanded="<?= $isFirst ? 'true' : 'false' ?>"
                  aria-controls="<?= $faqId ?>"
                >
                  <h4 class="faq-question"><?= htmlspecialchars($faq['question']) ?></h4>
                </button>
                <div id="<?= $faqId ?>" class="collapse <?= $isFirst ? 'show' : '' ?>" data-parent="#homeFaqAccordion">
                  <div class="faq-body">
                    <?= nl2br(htmlspecialchars($faq['answer'])) ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>
    <!-- FAQ Section end -->

    <!-- Blog Section start -->
    <section class="home-2 blog-article py-5" style="background:#f8fafc;">
      <div class="container">
        <div class="section-title sc-center justify-content-center text-center borderline mb-5 wow fadeInDown">
          <div class="title-top">
            <span class="campus-update-tag">LATEST NEWS & ARTICLES</span>
            <h2 class="campus-update-heading">OUR RECENT <span class="cl-blue">BLOG POSTS</span></h2>
          </div>
        </div>
        <div class="row">
          <?php foreach ($homeBlogs as $b): ?>
            <div class="col-lg-4 col-md-6 mb-4 wow fadeInUp">
              <div class="article-list h-100 d-flex flex-column" style="background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.05);">
                <div class="at-thumbnail">
                  <a href="blog-detail.php?id=<?= $b['id'] ?>">
                    <img src="<?= htmlspecialchars(!empty($b['image_path']) ? $b['image_path'] : 'assets/images/blog/blog-1.jpg') ?>" alt="<?= htmlspecialchars($b['title']) ?>" />
                  </a>
                  <span class="blog-tag"> <?= htmlspecialchars($b['category'] ?? 'Education') ?> </span>
                </div>
                <div class="article-content flex-grow-1 d-flex flex-column">
                  <?php 
                    $authorImg = (!empty($b['author_image']) && file_exists(__DIR__ . '/' . $b['author_image'])) ? $b['author_image'] : 'assets/images/team/director.jpeg';
                  ?>
                  <img src="<?= htmlspecialchars($authorImg) ?>" onerror="this.onerror=null;this.src='assets/images/team/director.jpeg';" alt="Author" class="article-avatar" />
                  <div class="artl-detail flex-grow-1">
                    <a href="blog-detail.php?id=<?= $b['id'] ?>">
                      <h4><?= htmlspecialchars($b['title']) ?></h4>
                    </a>
                    <p><?= htmlspecialchars($b['summary'] ?: substr(strip_tags($b['content'] ?? ''), 0, 90) . '...') ?></p>
                    <a href="blog-detail.php?id=<?= $b['id'] ?>" class="bl-link">Read More <i class="fas fa-angle-double-right"></i></a>
                  </div>
                  <div class="artl-bottom mt-auto">
                    <ul class="d-flex justify-content-between align-items-center">
                      <li><i class="far fa-calendar-alt mr-1"></i> <?= date('M d, Y', strtotime($b['created_at'])) ?></li>
                      <li><span class="text-primary font-weight-bold" style="font-size:12px;"><?= htmlspecialchars($b['author_name'] ?? 'Admin') ?></span></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
          <a href="blog-list.php" class="btn text-white px-4 py-2 font-weight-bold" style="background:#4f46e5; border-radius:30px; font-size:14px;">
            View All Blogs <i class="fas fa-arrow-right ml-2"></i>
          </a>
        </div>
      </div>
    </section>
    <!-- Blog Section end -->

<?php
include 'includes/footer.php';
?>
