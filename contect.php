<?php
session_start();
include "db.php";

$message_sent = false;
$error_msg = "";

if (isset($_POST['send_message'])) {
  // SECURITY: Use real_escape_string to prevent SQL Injection
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $message = $conn->real_escape_string($_POST['message']);

  $sql = "INSERT INTO contact_messages (name, email, message) 
            VALUES ('$name', '$email', '$message')";

  if ($conn->query($sql)) {
    $message_sent = true;
  } else {
    $error_msg = "Error: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - BookStore</title>
  <link rel="stylesheet" href="fonts.css">
  <link rel="stylesheet" href="style.css">
  <style>
    /* STICKY FOOTER CORE LOGIC */
    html,
    body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .main-wrapper {
      flex: 1 0 auto;
      /* This pushes the footer to the bottom */
    }

    .footer {
      flex-shrink: 0;
      /* Prevents footer from squashing */
      width: 100%;
      background: #1E3A5F;
      /* Match your theme */
      color: white;
      padding: 40px 0 20px 0;
    }

    /* FORM STYLING */
    .contact-form-box {
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .contact-form-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .contact-form-box textarea {
      resize: vertical;
      font-family: inherit;
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-top: 5px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      margin-top: 5px;
    }

    .btn {
      background: #D4AF37;
      color: white;
      padding: 12px 25px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      width: 100%;
    }

    @media (max-width: 768px) {
      .container {
        margin-top: 40px !important;
      }

      .grid-container {
        grid-template-columns: 1fr !important;
        gap: 20px !important;
      }
    }
  </style>
</head>

<body>
  <div class="main-wrapper">
    <header class="navbar" role="navigation" aria-label="Main navigation">
      <div class="container nav-inner">
        <div class="logo">📚 BookStore</div>
        <!-- <input type="checkbox" id="nav-toggle" /> -->
        <label for="nav-toggle" class="nav-toggle-label" aria-hidden="true">Menu</label>
        <ul id="primary-navigation" class="nav-links" role="menubar" aria-label="Primary">
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="books.php">Books</a></li>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="newbook.php">🛒 Cart</a></li>
          <li><a href="profile.php">👤 Profile</a></li>
          <!-- <li><a href="profile.php?logout=true">Logout</a></li>
          <li><a href="login.php">Login</a></li> -->
        </ul>
      </div>
    </header>

    <section class="contact-header" style="background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%); color: #F0EDE5; padding: 60px 20px; text-align: center; border-bottom: 4px solid #D4AF37;">
      <div class="container">
        <h1 style="font-size: 2.5rem; margin: 0 0 10px 0; font-family: 'Dancing Script', cursive; color: #D4AF37;">Get In Touch</h1>
        <p style="font-size: 1.1rem; margin: 0; opacity: 0.9; font-family: 'Lora', serif;">We'd love to hear from you. Send us a message!</p>
      </div>
    </section>

    <div class="container" style="margin-top: 60px; margin-bottom: 60px;">
      <?php if ($message_sent): ?>
        <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
          ✓ Message sent successfully! We'll get back to you shortly.
        </div>
      <?php endif; ?>

      <?php if ($error_msg): ?>
        <div class="alert alert-danger" style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 20px;">
          ✕ <?php echo $error_msg; ?>
        </div>
      <?php endif; ?>

      <div class="grid-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 40px;">
        <div class="contact-form-box">
          <h2 style="color: #1E3A5F; margin-top: 0; font-family: 'Dancing Script', cursive; font-size: 1.8rem;">Send Us a Message</h2>
          <form method="POST" action="">
            <div class="form-group">
              <label for="name">Your Name</label>
              <input type="text" id="name" name="name" placeholder="John Doe" required>
            </div>
            <div class="form-group">
              <label for="email">Your Email</label>
              <input type="email" id="email" name="email" placeholder="john@example.com" required>
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" placeholder="Your message here..." rows="5" required></textarea>
            </div>
            <button type="submit" name="send_message" class="btn">Send Message</button>
          </form>
        </div>

        <div class="contact-info-box" style="background: linear-gradient(135deg, #f5f7fa 0%, #ecf0f1 100%); padding: 30px; border-radius: 15px;">
          <h2 style="color: #1E3A5F; margin-top: 0; font-family: 'Dancing Script', cursive; font-size: 2rem;">Contact Information</h2>
          <div style="margin-bottom: 25px;">
            <h4 style="color: #D4AF37; margin-bottom: 5px; font-family: 'Dancing Script', cursive;">📧 Email</h4>
            <p style="color: #555; margin: 0; font-family: 'Lora', serif;">support@bookstore.com</p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="color: #D4AF37; margin-bottom: 5px; font-family: 'Dancing Script', cursive;">📱 Phone</h4>
            <p style="color: #555; margin: 0; font-family: 'Lora', serif;">+91 98765 43210</p>
          </div>

          <div style="margin-bottom: 25px;">
            <h4 style="color: #D4AF37; margin-bottom: 5px; font-family: 'Dancing Script', cursive;">📍 Address</h4>
            <p style="color: #555; margin: 0; font-family: 'Lora', serif;">Rajkot, Gujarat, India</p>

            <div style="border-top: 2px solid rgba(212, 175, 55, 0.2); padding-top: 20px; margin-top: 20px;">
              <h4 style="color: #D4AF37; margin-bottom: 10px; font-family: 'Dancing Script', cursive;">Follow Us</h4>
              <div style="display: flex; gap: 10px;">
                <a href="#" style="display: inline-block; width: 40px; height: 40px; background: #1E3A5F; color: #D4AF37; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none; font-weight: bold;">f</a>
                <a href="#" style="display: inline-block; width: 40px; height: 40px; background: #1E3A5F; color: #D4AF37; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none; font-weight: bold;">in</a>
                <a href="#" style="display: inline-block; width: 40px; height: 40px; background: #1E3A5F; color: #D4AF37; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none; font-weight: bold;">tw</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer" role="contentinfo">
    <div class="container" style="display: flex; justify-content: space-between; flex-wrap: wrap; gap: 20px; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
      <div class="footer-column" style="flex: 1; min-width: 200px;">
        <h3>BookStore</h3>
        <p style="font-family: 'Lora', serif; opacity: 0.8;">Your trusted source for timeless stories and endless knowledge.</p>
      </div>

      <div class="footer-column" style="flex: 1; min-width: 200px;">
        <h3>Quick Links</h3>
        <ul style="list-style: none; padding: 0;">
          <li><a href="home.php" style="color: white; text-decoration: none;">Home</a></li>
          <li><a href="about.php" style="color: white; text-decoration: none;">About Us</a></li>
          <li><a href="books.php" style="color: white; text-decoration: none;">Books</a></li>
          <li><a href="contact.php" style="color: white; text-decoration: none;">Contact Us</a></li>
        </ul>
      </div>

      <div class="footer-column" style="flex: 1; min-width: 200px;">
        <h3>Support</h3>
        <ul style="list-style: none; padding: 0;">
          <li><a href="contact.php" style="color: white; text-decoration: none;">Contact Us</a></li>
          <li><a href="#" style="color: white; text-decoration: none;">Privacy Policy</a></li>
          <li><a href="#" style="color: white; text-decoration: none;">Terms of Service</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom" style="text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 30px; font-size: 0.9rem; opacity: 0.7;">
      © 2026 BookStore. All Rights Reserved. | Privacy | Terms of Service
    </div>
  </footer>
</body>

</html>