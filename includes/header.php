<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?= isset($page_title) ? htmlspecialchars($page_title) : (defined('SITE_NAME') ? SITE_NAME : 'ePathsala') ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/cropped-epathsala_favicon-192x192.png" />
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!--Custom CSS-->
    <link href="assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>" rel="stylesheet" type="text/css" />
    <!--Plugin CSS-->
    <link href="assets/css/plugin.css" rel="stylesheet" type="text/css" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
  </head>
  <body class="home-2">
    <!-- Preloader -->
    <div id="preloader">
      <div id="status"></div>
    </div>
    <!-- Preloader Ends -->

    <!-- header starts -->
    <header class="main_header_area">
      <div class="topbar-wrap">
        <div class="container">
          <div class="top-info d-flex justify-content-between align-items-center">
            <ul class="t-address">
              <li><i class="fas fa-phone-alt"></i> <?= defined('SITE_PHONE') ? SITE_PHONE : '+974 8845246937' ?></li>
              <li><i class="far fa-envelope"></i> <a href="mailto:<?= defined('SITE_EMAIL') ? SITE_EMAIL : 'info@epathsala.com' ?>"><?= defined('SITE_EMAIL') ? SITE_EMAIL : 'info@epathsala.com' ?></a></li>
              <li><i class="fas fa-map-marker-alt"></i> <?= defined('SITE_ADDRESS') ? SITE_ADDRESS : '24th street, California' ?></li>
            </ul>
            <ul class="t-social">
              <li>
                <a href="#"><i class="fab fa-facebook-f"></i></a>
              </li>
              <li>
                <a href="#"><i class="fab fa-instagram"></i></a>
              </li>
              <li>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </li>
              <li>
                <span class="ct-search-link"
                  ><a href="#"><i class="fa fa-search"></i></a
                ></span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Navigation Bar -->
      <div class="header_menu">
        <nav class="navbar navbar-default">
          <div class="container">
            <div class="navbar-flex d-flex align-items-center justify-content-between w-100">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <a class="navbar-brand text-center" href="index.php">
                  <img src="assets/images/logo.png" alt="image" />
                </a>
              </div>
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="navbar-collapse1 w-100" id="bs-example-navbar-collapse-1">
                <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                <ul class="nav navbar-nav" id="responsive-menu">
                  <li class="<?= ($currentPage == 'index.php' || $currentPage == '') ? 'active' : '' ?>">
                    <a href="index.php">Home</a>
                  </li>
                  <li class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">
                    <a href="about.php">About</a>
                  </li>
                  <li class="<?= (in_array($currentPage, ['course-1.php', 'course-2.php', 'course-detail.php'])) ? 'active' : '' ?>">
                    <a href="course-1.php">Programs</a>
                  </li>
                  <li class="<?= ($currentPage == 'gallery.php') ? 'active' : '' ?>">
                    <a href="gallery.php">Gallery</a>
                  </li>
                  <li class="<?= (in_array($currentPage, ['event.php', 'event-detail.php'])) ? 'active' : '' ?>">
                    <a href="event.php">Events</a>
                  </li>
                  <li class="dropdown submenu <?= (in_array($currentPage, ['instructors.php', 'achievers.php', 'download.php'])) ? 'active' : '' ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      Academics <i class="fas fa-chevron-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="instructors.php">Faculties</a></li>
                      <li><a href="achievers.php">Achievers</a></li>
                      <li><a href="download.php">Downloads</a></li>
                    </ul>
                  </li>
                  <li class="<?= ($currentPage == 'contact.php') ? 'active' : '' ?>">
                    <a href="contact.php">Contact Us</a>
                  </li>
                </ul>
              </div>
              <!-- /.navbar-collapse -->
              <div id="slicknav-mobile"></div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </nav>
      </div>
      <!-- Navigation Bar Ends -->
    </header>
    <!-- header ends -->
