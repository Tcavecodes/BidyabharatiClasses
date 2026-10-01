    <!-- Footer starts -->
    <footer class="bg-[#0b1829] text-white pt-16 pb-8 border-t border-[#1e293b]" id="footer">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-[#1e293b]">
          <!-- Brand Description (Col 1) -->
          <div class="lg:col-span-4 space-y-4">
            <div class="flex items-center gap-3">
              <img alt="<?= htmlspecialchars($site_info['site_name'] ?? 'Bidyabharati Classes Logo') ?>" class="h-10 w-auto object-contain" src="<?= !empty($site_info['logo_path']) ? htmlspecialchars($site_info['logo_path']) : 'assets/images/logo.png' ?>"/>
              <div>
                <p class="font-poppins font-extrabold text-lg leading-none tracking-tight text-white uppercase"><?= htmlspecialchars($site_info['site_name'] ?? 'BIDYABHARATI') ?></p>
                <p class="font-poppins font-bold text-[10px] tracking-widest text-[#ee8c1c] uppercase mt-0.5">CLASSES • BARIPADA</p>
              </div>
            </div>
            <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
              A trusted academic coaching institute located in Baripada, Odisha. Providing student-centric coaching for Class 3 to 12 across CBSE and Odia Medium curriculums.
            </p>
            <div class="flex items-center gap-2.5 pt-2">
              <?php if (!empty($site_info['facebook_url'])): ?>
                <a aria-label="Facebook" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-[#06bbcc] text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-sm" href="<?= htmlspecialchars($site_info['facebook_url']) ?>" target="_blank"><i class="fa-brands fa-facebook-f text-xs"></i></a>
              <?php endif; ?>
              <?php if (!empty($site_info['instagram_url'])): ?>
                <a aria-label="Instagram" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-[#06bbcc] text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-sm" href="<?= htmlspecialchars($site_info['instagram_url']) ?>" target="_blank"><i class="fa-brands fa-instagram text-xs"></i></a>
              <?php endif; ?>
              <?php if (!empty($site_info['twitter_url'])): ?>
                <a aria-label="Twitter" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-[#06bbcc] text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-sm" href="<?= htmlspecialchars($site_info['twitter_url']) ?>" target="_blank"><i class="fa-brands fa-x-twitter text-xs"></i></a>
              <?php endif; ?>
              <?php if (!empty($site_info['linkedin_url'])): ?>
                <a aria-label="LinkedIn" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-[#06bbcc] text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-sm" href="<?= htmlspecialchars($site_info['linkedin_url']) ?>" target="_blank"><i class="fa-brands fa-linkedin-in text-xs"></i></a>
              <?php endif; ?>
            </div>
          </div>
          <!-- Quick Links (Col 2) -->
          <div class="lg:col-span-2 space-y-3">
            <h4 class="font-poppins font-bold text-xs text-[#ee8c1c] uppercase tracking-wider">QUICK LINKS</h4>
            <ul class="space-y-2.5 text-xs text-[#94a3b8]">
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="index.php">Home</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="about.php">About</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="course-1.php">Programs</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="gallery.php">Gallery</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="event.php">Events</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="instructors.php">Faculties</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="achievers.php">Achievers</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="download.php">Downloads</a></li>
              <li><a class="text-[#94a3b8] hover:text-white transition-colors" href="contact.php">Contact Us</a></li>
            </ul>
          </div>
          <!-- Academic Classes (Col 3) -->
          <div class="lg:col-span-3 space-y-3">
            <h4 class="font-poppins font-bold text-xs text-[#ee8c1c] uppercase tracking-wider">CLASSES &amp; BOARDS</h4>
            <ul class="space-y-2.5 text-xs">
              <li><span class="text-white font-bold">Class 3 to 5:</span> <span class="text-[#94a3b8]">Primary Foundation</span></li>
              <li><span class="text-white font-bold">Class 6 to 8:</span> <span class="text-[#94a3b8]">Middle School Concepts</span></li>
              <li><span class="text-white font-bold">Class 9 &amp; 10:</span> <span class="text-[#94a3b8]">Board Preparation</span></li>
              <li><span class="text-white font-bold">Class 11 &amp; 12:</span> <span class="text-[#94a3b8]">Senior Secondary Science</span></li>
              <li class="pt-2 text-[#ee8c1c] font-bold">CBSE &amp; Odia Medium Batches</li>
            </ul>
          </div>
          <!-- Contact Information (Col 4) -->
          <div class="lg:col-span-3 space-y-3">
            <h4 class="font-poppins font-bold text-xs text-[#ee8c1c] uppercase tracking-wider">CONTACT INFO</h4>
            <div class="space-y-2.5 text-xs text-[#94a3b8]">
              <p class="flex items-start gap-2.5">
                <i class="fa-solid fa-location-dot text-[#ee8c1c] mt-0.5 text-xs"></i>
                <span class="text-[#94a3b8]"><?= !empty($site_info['address']) ? htmlspecialchars($site_info['address']) : 'Baripada, Mayurbhanj, Odisha - 757001' ?></span>
              </p>
              <p class="flex items-center gap-2.5">
                <i class="fa-solid fa-phone text-[#ee8c1c] text-xs"></i>
                <a class="text-[#94a3b8] hover:text-white transition-colors" href="tel:<?= htmlspecialchars($site_info['phone'] ?? '+919437380042') ?>"><?= htmlspecialchars($site_info['phone'] ?? '+91 94373 80042') ?></a>
              </p>
              <p class="flex items-center gap-2.5">
                <i class="fa-solid fa-envelope text-[#ee8c1c] text-xs"></i>
                <a class="text-[#94a3b8] hover:text-white transition-colors" href="mailto:<?= htmlspecialchars($site_info['email'] ?? 'info@bidyabharaticlasses.com') ?>"><?= htmlspecialchars($site_info['email'] ?? 'info@bidyabharaticlasses.com') ?></a>
              </p>
              <p class="flex items-center gap-2.5">
                <i class="fa-solid fa-clock text-[#ee8c1c] text-xs"></i>
                <span class="text-[#94a3b8]"><?= !empty($site_info['working_hours']) ? htmlspecialchars($site_info['working_hours']) : 'Mon - Sat: 7:00 AM - 8:00 PM' ?></span>
              </p>
            </div>
          </div>
        </div>
        <!-- Copyright strip -->
        <div class="pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-[#94a3b8] gap-4">
          <p class="text-[#94a3b8]">© 2026 Bidyabharati Classes. All Rights Reserved.</p>
          <p class="text-[#94a3b8]">Designed &amp; Developed by <span class="text-[#94a3b8] font-bold">ThinkersCave Technologies</span></p>
        </div>
      </div>
    </footer>
    <!-- Footer ends -->

    <!-- Search form popup -->
    <form action="#" class="ct-searchForm">
      <div class="inner">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-sm-8">
              <div class="form-group">
                <input id="cf-search-form" type="text" placeholder="Search ..." required class="form-control" />
                <button type="submit" class="ct-search-btn"><i class="fa fa-search"></i></button>
              </div>
              <div class="form-group">
                <a href="#" class="ct-searchForm-close">
                  <i class="fas fa-times"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <!-- Search form popup end -->

    <!-- Floating WhatsApp Chat Button -->
    <a href="https://wa.me/919437380042?text=Hello%21%20I%20would%20like%20to%20know%20more%20about%20Bidyabharati%20Classes." 
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat on WhatsApp"
       class="fixed bottom-6 left-6 z-50 flex items-center justify-center w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-2xl hover:scale-110 transition-all duration-300 group">
      <i class="fa-brands fa-whatsapp text-3xl"></i>
      <span class="absolute left-16 bg-slate-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
        Chat with Us
      </span>
    </a>

    <!-- Back to top start -->
    <div id="back-to-top">
      <a href="#" aria-label="Back to top"><i class="fa-solid fa-arrow-up"></i></a>
    </div>
    <!-- Back to top ends -->

    <!-- *Scripts* -->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugin.js"></script>
    <script src="assets/js/main.js?v=<?= time() ?>"></script>
    <script src="assets/js/custom-swiper.js"></script>
    <script src="assets/js/custom-nav.js"></script>
  </body>
</html>
