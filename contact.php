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
    <section class="contact-main pb-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="contact-info text-center">
              <i class="far fa-clock"></i>
              <h3>Our Hours</h3>
              <div class="ct__atdetail">
                <p><?= htmlspecialchars($site_info['working_hours'] ?? '10:00 AM – 10:00 PM (Monday - Sunday)') ?></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="contact-info text-center">
              <i class="far fa-map"></i>
              <h3>LOCATION</h3>
              <div class="ct__atdetail">
                <p><?= htmlspecialchars($site_info['address'] ?? 'Baripada, Mayurbhanj, Odisha - 757001') ?></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-12 text-center">
            <div class="contact-info">
              <i class="fas fa-phone-alt"></i>
              <h3>CONTACT US</h3>
              <div class="ct__atdetail">
                <p>Phone: <?= htmlspecialchars($site_info['phone'] ?? '+91 94373 80042') ?></p>
                <p>Email: <a href="mailto:<?= htmlspecialchars($site_info['email'] ?? 'info@bidyabharaticlasses.com') ?>"><?= htmlspecialchars($site_info['email'] ?? 'info@bidyabharaticlasses.com') ?></a></p>
              </div>
            </div>
          </div>
        </div>
        <div class="contact-map">
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
              height="450"
              style="border: 0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
          <?php else: ?>
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3701.1969548805046!2d86.72061507501103!3d21.926978556323917!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a1db10060c040c5%3A0x29d37d3190f744d7!2sBidya%20Bharati%20Coaching!5e0!3m2!1sen!2sin!4v1790449664204!5m2!1sen!2sin"
              width="100%"
              height="450"
              style="border: 0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
          <?php endif; ?>
        </div>
        <div class="contact-form">
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
                $contactMsgAlert = '<div class="alert alert-success p-3 mb-4 text-center" style="font-size: 14px; border-radius: 8px; background-color: #d1e7dd; color: #0f5132;">Thank you for contacting us! Your inquiry has been submitted successfully to our team.</div>';
              } catch (Exception $e) {
                $contactMsgAlert = '<div class="alert alert-danger p-3 mb-4 text-center" style="font-size: 14px; border-radius: 8px;">An error occurred while sending your message. Please try again.</div>';
              }
            } else {
              $contactMsgAlert = '<div class="alert alert-warning p-3 mb-4 text-center" style="font-size: 14px; border-radius: 8px;">Please fill out all required fields (Name, Email, and Message).</div>';
            }
          }
          ?>
          <?= $contactMsgAlert ?>
          <form action="contact.php" method="POST" class="m-auto text-center">
            <input type="hidden" name="submit_contact_form" value="1">
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row mb-4">
              <div class="col">
                <div class="form-outline">
                  <input type="text" name="name" id="form6Example1" class="form-control" placeholder="Your Name *" required />
                </div>
              </div>
            </div>
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" name="email" id="form6Example5" class="form-control" placeholder="Email Address *" required />
            </div>

            <!-- Number input -->
            <div class="form-outline mb-4">
              <input type="text" name="phone" id="form6Example6" class="form-control" placeholder="Phone No." />
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
              <textarea name="message" class="form-control" id="form6Example7" placeholder="Message *" rows="4" required></textarea>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn">Send Message</button>
          </form>
        </div>
      </div>
    </section>
    <!-- Contact end -->



    <?php include 'includes/footer.php'; ?>
