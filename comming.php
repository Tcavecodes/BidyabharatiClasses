<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zxx">
  
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>ePathsala - Online Education Template</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/cropped-epathsala_favicon-192x192.png" />
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!--Custom CSS-->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <!--Plugin CSS-->
    <link href="assets/css/plugin.css" rel="stylesheet" type="text/css" />
    <!--Font Awesome-->
    <link rel="stylesheet" href="assets/vendor/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendor/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div id="status"></div>
    </div>
    <!-- Preloader Ends -->

    <!-- Faq start -->
    <section class="comming-soon">
      <div class="container">
        <div class="comming__soon_text">
          <i class="fas fa-archway"></i>
          <h1 class="cl-white">Under Construction</h1>
          <p class="cl-orange">Our website is under construction. We will be here soon with our awesome new site, subscribe to be notified.</p>
          <div id="countdown"></div>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!--  Faq end -->

    <!-- *Scripts* -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugin.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/custom-swiper.js"></script>
    <script src="assets/js/custom-nav.js"></script>
    <script>
      //Countdown
      // Set the date we're counting down to
      var countDownDate = new Date("Jan 5, 2022 15:37:25").getTime();

      // Update the count down every 1 second
      var x = setInterval(function () {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="countdown"
        document.getElementById("countdown").innerHTML =
          days + "<span>Days </span>" + hours + "<span>Hours </span>" + minutes + "<span>Minutes </span>" + seconds + "<span>Seconds </span>";

        // If the count down is over, write some text
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("countdown").innerHTML = "EXPIRED";
        }
      }, 1000);
    </script>
  <script type="module" src="https://static.cloudflareinsights.com/beacon.min.js/v31edd6df95cf4e85bb4c19e7a9bdbcba1788362987495" integrity="sha512-iIg7k2xntmwu6/uSb5tpc/hySgZc4eoL31yB29W6tJFo2akwjPWcEqnCEdJvGexCL0KEQwVYv5BlowfhVz26hg==" data-cf-beacon='{"version":"2024.11.0","token":"e2e296138d64407b8469055f5cbf0b42","r":1,"spa":2}' crossorigin="anonymous"></script>
<script>(function(){function c(){var b=a.contentDocument||(a.contentWindow&&a.contentWindow.document);if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'a39d235f4e3d0884',t:'MTc4OTE5NzUwNg=='};var a=document.createElement('script');a.src='../../cdn-cgi/challenge-platform/h/g/scripts/jsd/330e41bb475c/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>

</html>
