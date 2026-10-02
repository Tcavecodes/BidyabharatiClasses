<?php 
include 'includes/header.php'; 

$blogId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$blog = null;

if ($blogId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ? AND LOWER(status) = 'active'");
        $stmt->execute([$blogId]);
        $blog = $stmt->fetch();
    } catch (Exception $e) {
        $blog = null;
    }
}

// Fallback if blog ID not provided or not found
if (!$blog) {
    try {
        $stmt = $pdo->query("SELECT * FROM blogs WHERE LOWER(status) = 'active' ORDER BY id DESC LIMIT 1");
        $blog = $stmt->fetch();
    } catch (Exception $e) {
        $blog = null;
    }
}

if (!$blog) {
    $blog = [
        'id' => 1,
        'title' => 'Effective Preparation Strategies for Board & Entrance Examinations',
        'category' => 'Exam Guidance',
        'author_name' => 'TIKAM BEHERA',
        'author_role' => 'Director & Physics Faculty',
        'image_path' => 'assets/images/blog/blog-1.jpg',
        'summary' => 'Discover key study habits, time management tips, and problem-solving techniques to excel in Board and Competitive Exams.',
        'content' => "Success in Board and entrance examinations like NEET and JEE requires a balanced mix of conceptual clarity, regular practice, and smart test strategies.\n\nKey Focus Areas:\n1. Master the Fundamentals: Thoroughly understand core concepts in Physics, Chemistry, and Mathematics/Biology.\n2. Time Management: Follow a disciplined daily schedule allocated across subject topics and doubt sessions.\n3. Regular Mock Tests: Simulate actual examination conditions to boost speed and accuracy.\n\nAt Bidyabharati Classes, our personalized attention and structured test series ensure students stay ahead with confidence.",
        'created_at' => date('Y-m-d H:i:s')
    ];
}

// Fetch recent active blogs for sidebar
try {
    $stmtRecent = $pdo->prepare("SELECT * FROM blogs WHERE LOWER(status) = 'active' AND id != ? ORDER BY id DESC LIMIT 4");
    $stmtRecent->execute([$blog['id']]);
    $recentBlogs = $stmtRecent->fetchAll() ?: [];
} catch (Exception $e) {
    $recentBlogs = [];
}
?>

    <!-- Blog title starts -->
    <section class="blog-top-title" style="position:relative; background:#111827; padding: 60px 0;">
      <div class="container text-center">
        <span class="badge badge-primary px-3 py-2 mb-3" style="font-size:14px; text-transform:uppercase; border-radius:20px; background-color:#4f46e5; color:#fff;">
          <?= htmlspecialchars($blog['category'] ?? 'Education') ?>
        </span>
        <h1 class="cl-white" style="color:#ffffff; font-size:2.2rem; font-weight:700; max-width:900px; margin:0 auto 15px auto;">
          <?= htmlspecialchars($blog['title']) ?>
        </h1>
        <p class="cl-white" style="color:#cbd5e1; font-size:0.95rem;">
          <i class="far fa-calendar-alt mr-1"></i> Published on <?= date('F d, Y', strtotime($blog['created_at'])) ?>
        </p>
      </div>
    </section>
    <!-- Blog title end -->

    <!--  Blog details start -->
    <section class="blog__details py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <!-- Featured Image -->
            <div class="mb-4" style="border-radius:12px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
              <img src="<?= htmlspecialchars(!empty($blog['image_path']) ? $blog['image_path'] : 'assets/images/blog/blog-1.jpg') ?>" 
                   alt="<?= htmlspecialchars($blog['title']) ?>" 
                   style="width:100%; max-height:450px; object-fit:cover;" />
            </div>

            <!-- Author Card -->
            <div class="bg__author d-flex align-items-center p-3 mb-4" style="background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0;">
              <img src="assets/images/team/director.jpeg" alt="Author" style="width:60px; height:60px; border-radius:50%; object-fit:cover; margin-right:15px;" />
              <div class="bg__author_name">
                <h5 class="mb-0" style="font-weight:700; color:#1e293b;"><?= htmlspecialchars($blog['author_name'] ?? 'TIKAM BEHERA') ?></h5>
                <span style="font-size:13px; color:#64748b;"><?= htmlspecialchars($blog['author_role'] ?? 'Director & Physics Faculty') ?></span>
              </div>
            </div>

            <!-- Article Body -->
            <div class="bg__contents" style="font-size:1.05rem; line-height:1.8; color:#334155;">
              <div class="bg__only_detail">
                <?php if (!empty($blog['summary'])): ?>
                  <p class="lead font-weight-bold" style="font-size:1.15rem; color:#1e293b; border-left:4px solid #4f46e5; padding-left:15px; margin-bottom:25px;">
                    <?= htmlspecialchars($blog['summary']) ?>
                  </p>
                <?php endif; ?>

                <div class="blog-main-content">
                  <?= nl2br(htmlspecialchars($blog['content'])) ?>
                </div>
              </div>

              <!-- Share / Back Link -->
              <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">
                <a href="blog-list.php" class="btn btn-outline-primary rounded-pill px-4">
                  <i class="fas fa-arrow-left mr-2"></i> Back to All Blogs
                </a>
                <div class="social-share">
                  <span class="mr-2 font-weight-bold text-muted">Share:</span>
                  <a href="#" class="mr-2 text-primary"><i class="fab fa-facebook-f"></i></a>
                  <a href="#" class="mr-2 text-info"><i class="fab fa-twitter"></i></a>
                  <a href="#" class="text-danger"><i class="fab fa-linkedin-in"></i></a>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="col-lg-4 col-md-12 aside-sidebar customize-wrap wow fadeInUp mt-4 mt-lg-0">
            <div class="sidebar-profile mb-4 text-center">
              <div class="sidebar-title">
                <h4>OUR DIRECTOR</h4>
              </div>
              <div class="ss__myprofile p-3" style="background:#f8fafc; border-radius:12px; border:1px solid #e2e8f0;">
                <img src="assets/images/team/director.jpeg" alt="Director" style="width:80px; height:80px; border-radius:50%; object-fit:cover;" class="mb-2" />
                <h5 class="mb-1" style="font-weight:700;">TIKAM BEHERA</h5>
                <p class="text-muted small mb-0">M. SC. PHYSICS — Director & Founder</p>
              </div>
            </div>

            <div class="sidebar-course mb-4">
              <div class="sidebar-title">
                <h4>MORE ARTICLES</h4>
              </div>
              <?php if (empty($recentBlogs)): ?>
                <p class="text-muted small">No other recent articles.</p>
              <?php else: ?>
                <?php foreach ($recentBlogs as $rb): ?>
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
              <?php endif; ?>
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
    <!-- Blog details end -->

    <?php include 'includes/footer.php'; ?>
