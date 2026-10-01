<?php include 'includes/header.php'; ?>


    <!-- Breadcrumb starts -->
    <section class="breadcrumb-main">
      <div class="container">
        <div class="breadcrumb-inner">
          <h2>Contact Us</h2>
        </div>
      </div>
      <div class="sl-overlay"></div>
    </section>
    <!-- Breadcrumb end -->

    <!-- Contact start -->
    <section class="contact-main pt-12 pb-16 lg:pb-24">
      <div class="container">
        <div class="row mb-12">
          <div class="col-lg-4 col-md-4 col-sm-12 mb-4 mb-md-0">
            <div class="contact-info text-center h-full p-6 bg-slate-50 rounded-2xl border border-slate-100 shadow-sm">
              <i class="far fa-clock text-3xl text-[#ee8c1c] mb-3 block"></i>
              <h3 class="text-lg font-bold text-[#00254e] mb-2 uppercase font-['Outfit']">Our Hours</h3>
              <div class="ct__atdetail text-sm text-slate-600">
                <p class="m-0"><?= htmlspecialchars($site_info['working_hours'] ?? '10:00 AM – 10:00 PM (Monday - Sunday)') ?></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 mb-4 mb-md-0">
            <div class="contact-info text-center h-full p-6 bg-slate-50 rounded-2xl border border-slate-100 shadow-sm">
              <i class="far fa-map text-3xl text-[#ee8c1c] mb-3 block"></i>
              <h3 class="text-lg font-bold text-[#00254e] mb-2 uppercase font-['Outfit']">LOCATION</h3>
              <div class="ct__atdetail text-sm text-slate-600">
                <p class="m-0"><?= htmlspecialchars($site_info['address'] ?? 'Baripada, Mayurbhanj, Odisha - 757001') ?></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
            <div class="contact-info text-center h-full p-6 bg-slate-50 rounded-2xl border border-slate-100 shadow-sm">
              <i class="fas fa-phone-alt text-3xl text-[#ee8c1c] mb-3 block"></i>
              <h3 class="text-lg font-bold text-[#00254e] mb-2 uppercase font-['Outfit']">CONTACT US</h3>
              <div class="ct__atdetail text-sm text-slate-600 space-y-1">
                <p class="m-0">Phone: <a href="tel:<?= htmlspecialchars($site_info['phone'] ?? '+919437380042') ?>" class="hover:text-[#06bbcc] font-medium"><?= htmlspecialchars($site_info['phone'] ?? '+91 94373 80042') ?></a></p>
                <p class="m-0">Email: <a href="mailto:<?= htmlspecialchars($site_info['email'] ?? 'info@bidyabharaticlasses.com') ?>" class="hover:text-[#06bbcc] font-medium"><?= htmlspecialchars($site_info['email'] ?? 'info@bidyabharaticlasses.com') ?></a></p>
              </div>
            </div>
          </div>
        </div>

        <div class="contact-map my-12 rounded-3xl overflow-hidden shadow-lg border border-slate-200">
          <?php if (!empty($site_info['map_iframe'])): ?>
            <?php 
              $mapSrc = $site_info['map_iframe'];
              if (preg_match('/src="([^"]+)"/', $mapSrc, $matches)) {
                  $mapSrc = $matches[1];
              }
            ?>
            <iframe
              src="<?= htmlspecialchars($mapSrc) ?>"
              width="100%"
              height="420"
              style="border: 0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
          <?php else: ?>
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3701.1969548805046!2d86.72061507501103!3d21.926978556323917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a1db10060c040c5%3A0x29d37d3190f744d7!2sBidya%20Bharati%20Coaching!5e0!3m2!1sen!2sin!4v1790449664204!5m2!1sen!2sin"
              width="100%"
              height="420"
              style="border: 0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
          <?php endif; ?>
        </div>

        <div class="contact-form max-w-3xl mx-auto mt-14 p-8 sm:p-12 bg-white rounded-3xl shadow-2xl border border-slate-100 relative overflow-hidden">
          <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-[#00254e] via-[#06bbcc] to-[#ee8c1c]"></div>
          
          <div class="text-center mb-10 space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-[#ee8c1c] block">Get In Touch</span>
            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#00254e] font-['Outfit']">Send Us A Message</h3>
            <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto leading-relaxed">Have a question or want to know more about our courses? Fill out the form below.</p>
          </div>

          <?php
          $contactMsgAlert = '';
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_contact_form'])) {
            $cName = trim($_POST['name'] ?? '');
            $cEmail = trim($_POST['email'] ?? '');
            $cPhone = trim($_POST['phone'] ?? '');
            $cMessage = trim($_POST['message'] ?? '');

            if (!empty($cName) && !empty($cEmail) && !empty($cMessage)) {
              try {
                $stmtMsg = $pdo->prepare("INSERT INTO enrollments (student_name, email, phone, course, message, status) VALUES (?, ?, ?, 'General Contact Inquiry', ?, 'pending')");
                $stmtMsg->execute([$cName, $cEmail, $cPhone, $cMessage]);
                $contactMsgAlert = '<div class="alert alert-success p-4 mb-8 text-center text-sm font-medium rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 shadow-sm flex items-center justify-center gap-2.5"><i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i> Thank you for contacting us! Your inquiry has been submitted successfully to our team.</div>';
              } catch (Exception $e) {
                $contactMsgAlert = '<div class="alert alert-danger p-4 mb-8 text-center text-sm font-medium rounded-2xl bg-rose-50 text-rose-800 border border-rose-200 shadow-sm flex items-center justify-center gap-2.5"><i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i> An error occurred while sending your message. Please try again.</div>';
              }
            } else {
              $contactMsgAlert = '<div class="alert alert-warning p-4 mb-8 text-center text-sm font-medium rounded-2xl bg-amber-50 text-amber-800 border border-amber-200 shadow-sm flex items-center justify-center gap-2.5"><i class="fa-solid fa-circle-exclamation text-amber-600 text-lg"></i> Please fill out all required fields (Name, Email, and Message).</div>';
            }
          }
          ?>
          <?= $contactMsgAlert ?>

          <form action="contact.php" method="POST" class="!w-full space-y-6 text-left m-0">
            <input type="hidden" name="submit_contact_form" value="1">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <!-- Name Input -->
              <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Your Name <span class="text-rose-500">*</span></label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400"><i class="fa-solid fa-user text-sm"></i></span>
                  <input type="text" name="name" id="form6Example1" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-[#06bbcc] focus:ring-2 focus:ring-[#06bbcc]/20 focus:outline-none transition-all" placeholder="Enter your full name" required />
                </div>
              </div>

              <!-- Email Input -->
              <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Email Address <span class="text-rose-500">*</span></label>
                <div class="relative">
                  <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400"><i class="fa-solid fa-envelope text-sm"></i></span>
                  <input type="email" name="email" id="form6Example5" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-[#06bbcc] focus:ring-2 focus:ring-[#06bbcc]/20 focus:outline-none transition-all" placeholder="name@example.com" required />
                </div>
              </div>
            </div>

            <!-- Phone Number Input -->
            <div class="space-y-2">
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Phone Number</label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400"><i class="fa-solid fa-phone text-sm"></i></span>
                <input type="text" name="phone" id="form6Example6" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-[#06bbcc] focus:ring-2 focus:ring-[#06bbcc]/20 focus:outline-none transition-all" placeholder="+91 98765 43210" />
              </div>
            </div>

            <!-- Message Input -->
            <div class="space-y-2">
              <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Your Message <span class="text-rose-500">*</span></label>
              <div class="relative">
                <span class="absolute top-4 left-0 flex items-center pl-4 pointer-events-none text-slate-400"><i class="fa-solid fa-comment-dots text-sm"></i></span>
                <textarea name="message" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-[#06bbcc] focus:ring-2 focus:ring-[#06bbcc]/20 focus:outline-none transition-all" id="form6Example7" placeholder="Write your message or inquiry here..." rows="4" required></textarea>
              </div>
            </div>

            <!-- Submit button -->
            <div class="pt-4 text-center">
              <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-[#ee8c1c] hover:bg-[#e07d10] text-white font-bold text-sm rounded-xl shadow-lg shadow-[#ee8c1c]/25 hover:shadow-xl hover:shadow-[#ee8c1c]/35 transition-all inline-flex items-center justify-center gap-2.5 cursor-pointer border-0">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Send Message</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- Contact end -->



    <?php include 'includes/footer.php'; ?>
