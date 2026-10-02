<?php 
include 'includes/header.php'; 

try {
    $stmtBlogs = $pdo->query("SELECT * FROM blogs WHERE LOWER(status) = 'active' ORDER BY id DESC");
    $blogs = $stmtBlogs->fetchAll() ?: [];
} catch (Exception $e) {
    $blogs = [];
}

if (empty($blogs)) {
    $blogs = [
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

    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>BLOG & ARTICLES</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Blog list section start -->
    <section class="home-2 blog-article blog-singlelist">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="blog-wrap">
              <div class="row">
                <?php foreach ($blogs as $b): ?>
                  <div class="col-lg-6 col-md-6 mb-4 wow fadeInRight">
                    <div class="article-list">
                      <div class="at-thumbnail">
                        <a href="blog-detail.php?id=<?= $b['id'] ?>">
                          <img src="<?= htmlspecialchars(!empty($b['image_path']) ? $b['image_path'] : 'assets/images/blog/blog-1.jpg') ?>" alt="<?= htmlspecialchars($b['title']) ?>" />
                        </a>
                        <span class="blog-tag"> <?= htmlspecialchars($b['category'] ?? 'Education') ?> </span>
                      </div>
                      <div class="article-content">
                        <?php 
                          $authorImg = (!empty($b['author_image']) && file_exists(__DIR__ . '/' . $b['author_image'])) ? $b['author_image'] : 'assets/images/team/director.jpeg';
                        ?>
                        <img src="<?= htmlspecialchars($authorImg) ?>" onerror="this.onerror=null;this.src='assets/images/team/director.jpeg';" alt="Author" class="article-avatar" />
                        <div class="artl-detail">
                          <a href="blog-detail.php?id=<?= $b['id'] ?>">
                            <h4><?= htmlspecialchars($b['title']) ?></h4>
                          </a>
                          <p><?= htmlspecialchars($b['summary'] ?: substr(strip_tags($b['content'] ?? ''), 0, 100) . '...') ?></p>
                          <a href="blog-detail.php?id=<?= $b['id'] ?>" class="bl-link">Read More <i class="fas fa-angle-double-right"></i></a>
                        </div>
                        <div class="artl-bottom">
                          <ul class="d-flex justify-content-between align-items-center">
                            <li><i class="far fa-calendar-alt mr-1"></i> <?= date('F d, Y', strtotime($b['created_at'])) ?></li>
                            <li><span class="badge badge-light text-primary"><?= htmlspecialchars($b['author_name'] ?? 'Admin') ?></span></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="col-lg-4 col-md-12 aside-sidebar customize-wrap wow fadeInUp">
            <div class="sidebar-profile mb-4 text-center">
              <div class="sidebar-title">
                <h4>OUR DIRECTOR</h4>
              </div>
              <div class="ss__myprofile p-3">
                <img src="assets/images/team/director.jpeg" alt="Director" style="width:90px; height:90px; border-radius:50%; object-fit:cover;" class="mb-2" />
                <h4 class="mb-1">TIKAM BEHERA</h4>
                <p class="text-muted small mb-0">M. SC. PHYSICS — Director & Founder</p>
              </div>
            </div>

            <div class="sidebar-course mb-4">
              <div class="sidebar-title">
                <h4>RECENT POSTS</h4>
              </div>
              <?php 
                $recentBlogs = array_slice($blogs, 0, 4);
                foreach ($recentBlogs as $rb): 
              ?>
                <div class="customize-item d-flex mb-3 align-items-center">
                  <div class="sv-image pr-3" style="width:70px; shrink:0;">
                    <a href="blog-detail.php?id=<?= $rb['id'] ?>">
                      <img src="<?= htmlspecialchars(!empty($rb['image_path']) ? $rb['image_path'] : 'assets/images/blog/blog-1.jpg') ?>" alt="" style="width:60px; height:60px; object-fit:cover; border-radius:8px;" />
                    </a>
                  </div>
                  <div class="customize-ct m-0">
                    <h6 class="mb-1" style="font-size:13px; line-height:1.4;">
                      <a href="blog-detail.php?id=<?= $rb['id'] ?>"><?= htmlspecialchars($rb['title']) ?></a>
                    </h6>
                    <span class="cust-meta text-muted small"><i class="far fa-calendar-alt"></i> <?= date('M d, Y', strtotime($rb['created_at'])) ?></span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="sidebar-links">
              <div class="sidebar-title">
                <h4>FOLLOW US</h4>
              </div>
              <div class="side-contact-wp text-center mb-4">
                <ul class="sidebar-social mb-3">
                  <?php if (!empty($site_info['facebook_url'])): ?>
                    <li><a href="<?= htmlspecialchars($site_info['facebook_url']) ?>" target="_blank" class="bg-fb"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                  <?php endif; ?>
                  <?php if (!empty($site_info['twitter_url'])): ?>
                    <li><a href="<?= htmlspecialchars($site_info['twitter_url']) ?>" target="_blank" class="bg-twitter"><i class="fab fa-twitter"></i> Twitter</a></li>
                  <?php endif; ?>
                  <?php if (!empty($site_info['instagram_url'])): ?>
                    <li><a href="<?= htmlspecialchars($site_info['instagram_url']) ?>" target="_blank" style="background:#e1306c; color:#fff;"><i class="fab fa-instagram"></i> Instagram</a></li>
                  <?php endif; ?>
                  <?php if (!empty($site_info['linkedin_url'])): ?>
                    <li><a href="<?= htmlspecialchars($site_info['linkedin_url']) ?>" target="_blank" class="bg-linkedin"><i class="fab fa-linkedin-in"></i> LinkedIn</a></li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog list section end -->

    <?php include 'includes/footer.php'; ?>
