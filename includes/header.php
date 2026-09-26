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
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts & Icons for Tailwind Theme -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Outfit:wght@500;600;700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN & Design System Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "tertiary": "#342300",
            "secondary-fixed-dim": "#a4c9ff",
            "tertiary-container": "#4f3700",
            "on-secondary-fixed-variant": "#004884",
            "on-surface-variant": "#43474f",
            "background": "#f8f9ff",
            "secondary-fixed": "#d4e3ff",
            "error-container": "#ffdad6",
            "surface-container-low": "#eff4ff",
            "outline": "#737780",
            "surface-dim": "#cbdbf5",
            "on-tertiary-fixed-variant": "#5e4200",
            "on-secondary-container": "#003c70",
            "surface-bright": "#f8f9ff",
            "primary-fixed": "#d5e3ff",
            "on-tertiary": "#ffffff",
            "on-tertiary-fixed": "#271900",
            "on-primary-container": "#84a6df",
            "surface-container-high": "#dce9ff",
            "on-surface": "#0b1c30",
            "secondary-container": "#64a8fe",
            "on-tertiary-container": "#d39c25",
            "secondary": "#005fac",
            "inverse-primary": "#a8c8ff",
            "surface-tint": "#3c5f93",
            "surface-container-highest": "#d3e4fe",
            "surface-variant": "#d3e4fe",
            "on-error-container": "#93000a",
            "on-error": "#ffffff",
            "surface-container-lowest": "#ffffff",
            "tertiary-fixed": "#ffdea7",
            "outline-variant": "#c3c6d0",
            "on-primary-fixed": "#001b3c",
            "inverse-on-surface": "#eaf1ff",
            "on-secondary-fixed": "#001c39",
            "primary-fixed-dim": "#a8c8ff",
            "surface-container": "#e5eeff",
            "error": "#ba1a1a",
            "on-background": "#0b1c30",
            "surface": "#f8f9ff",
            "on-secondary": "#ffffff",
            "tertiary-fixed-dim": "#f8bd45",
            "inverse-surface": "#213145",
            "on-primary-fixed-variant": "#22477a",
            "primary": "#00254e",
            "on-primary": "#ffffff",
            "primary-container": "#123b6d"
          },
          borderRadius: {
            "DEFAULT": "0.25rem",
            "lg": "0.5rem",
            "xl": "0.75rem",
            "full": "9999px"
          },
          spacing: {
            "space-xs": "0.25rem",
            "space-xl": "2.5rem",
            "margin": "2rem",
            "margin-mobile": "1rem",
            "space-sm": "0.5rem",
            "gutter-mobile": "1rem",
            "space-lg": "1.5rem",
            "space-md": "1rem",
            "gutter": "1.5rem"
          },
          fontFamily: {
            "display-hero-mobile": [ "Outfit", "sans-serif" ],
            "body-lg": [ "Inter", "sans-serif" ],
            "display-hero": [ "Outfit", "sans-serif" ],
            "headline-md": [ "Outfit", "sans-serif" ],
            "headline-lg-mobile": [ "Outfit", "sans-serif" ],
            "label-lg": [ "Outfit", "sans-serif" ],
            "headline-lg": [ "Outfit", "sans-serif" ],
            "headline-sm": [ "Outfit", "sans-serif" ],
            "stat-counter": [ "Outfit", "sans-serif" ],
            "label-md": [ "Outfit", "sans-serif" ],
            "body-sm": [ "Inter", "sans-serif" ],
            "body-md": [ "Inter", "sans-serif" ]
          },
          fontSize: {
            "display-hero-mobile": [ "36px", { "lineHeight": "44px", "letterSpacing": "-0.015em", "fontWeight": "700" } ],
            "body-lg": [ "18px", { "lineHeight": "28px", "fontWeight": "400" } ],
            "display-hero": [ "56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" } ],
            "headline-md": [ "28px", { "lineHeight": "36px", "fontWeight": "600" } ],
            "headline-lg-mobile": [ "28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "700" } ],
            "label-lg": [ "14px", { "lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "600" } ],
            "headline-lg": [ "40px", { "lineHeight": "48px", "letterSpacing": "-0.01em", "fontWeight": "700" } ],
            "headline-sm": [ "20px", { "lineHeight": "28px", "fontWeight": "600" } ],
            "stat-counter": [ "48px", { "lineHeight": "52px", "fontWeight": "700" } ],
            "label-md": [ "12px", { "lineHeight": "16px", "letterSpacing": "0.04em", "fontWeight": "600" } ],
            "body-sm": [ "14px", { "lineHeight": "20px", "fontWeight": "400" } ],
            "body-md": [ "16px", { "lineHeight": "24px", "fontWeight": "400" } ]
          }
        }
      }
    };
    </script>
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
