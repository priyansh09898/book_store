<?php
session_start();
include "db.php";

$result = $conn->query("SELECT * FROM team");
if (!$result) {
  die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - BookStore</title>
  <link rel="stylesheet" href="fonts.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .team-member {
      background: white;
      padding: 20px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-member:hover {
      transform: translateY(-10px);
      box-shadow: 0 8px 25px rgba(212, 175, 55, 0.2);
    }

    .team-member img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .team-member h3 {
      color: #1E3A5F;
      margin: 15px 0 5px 0;
      font-size: 1.3rem;
      font-family: 'Dancing Script', cursive;
    }

    .team-member p {
      color: #D4AF37;
      font-weight: 500;
      margin: 0;
      font-family: 'Lora', serif;
    }

    .about-text {
      background: white;
      padding: 40px;
      border-radius: 15px;
      margin-bottom: 40px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .about-text h2 {
      color: #1E3A5F;
      font-size: 2rem;
      margin-top: 0;
      position: relative;
      padding-bottom: 15px;
      font-family: 'Dancing Script', cursive;
    }

    .about-text h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #D4AF37 0%, #B8860B 100%);
      border-radius: 2px;
    }

    .about-text p {
      color: #555;
      line-height: 1.8;
      font-size: 1.1rem;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      margin-bottom: 40px;
    }

    @media (max-width: 768px) {
      .about-text {
        padding: 20px;
      }

      .about-text h2 {
        font-size: 1.5rem;
      }

      .team-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <header class="navbar" role="navigation" aria-label="Main navigation">
    <div class="container nav-inner">
      <div class="logo"> BookStore</div>
      <!-- <input type="checkbox" id="nav-toggle" />
      <label for="nav-toggle" class="nav-toggle-label" aria-hidden="true">Menu</label> -->
      <ul id="primary-navigation" class="nav-links" role="menubar" aria-label="Primary">
        <li><a href="home.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="books.php">Books</a></li>
        <li><a href="contect.php">Contact Us</a></li>
        <li><a href="newbook.php">🛒 Cart</a></li>
        <li><a href="profile.php">👤 Profile</a></li>
        <!-- <li><a href="profile.php?logout=true">Logout</a></li>
        <li><a href="login.php">Login</a></li> -->
      </ul>
    </div>
  </header>

  <!-- Hero Section -->
  <section style="background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%); color: #F0EDE5; padding: 80px 20px; text-align: center; border-bottom: 4px solid #D4AF37;">
    <div class="container">
      <h1 style="font-size: 3rem; margin: 0 0 15px 0; font-family: 'Dancing Script', cursive; color: #D4AF37;">About BookStore</h1>
      <p style="font-size: 1.2rem; margin: 0; opacity: 0.9; font-family: 'Lora', serif;">Discover the story behind your favorite bookstore</p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container" style="margin-top: 60px; margin-bottom: 60px;">
    <!-- Mission Section -->
    <div class="about-text">
      <h2>Our Mission</h2>
      <p>
        At BookStore, we believe in the power of knowledge and imagination. Our mission is to provide
        readers with access to a wide variety of books across genres — from higher education to management
        and engineering, as well as fiction and non-fiction titles that inspire and entertain. We aim to make
        reading accessible, engaging, and enjoyable for everyone.
      </p>
    </div>

    <!-- Who We Are Section -->
    <div class="about-text">
      <h2>Who We Are</h2>
      <p>
        Founded in 2025, BookStore has quickly grown into a trusted platform for book lovers. We aim to make
        reading accessible, engaging, and enjoyable for everyone. Whether you're a student, a professional,
        or simply a curious mind, we have something for you. Our platform bridges the gap between readers and
        amazing books, making knowledge and stories just a click away.
      </p>
    </div>

    <!-- Our Values Section -->
    <div class="about-text">
      <h2>Our Core Values</h2>
      <p>
        <strong style="color: #1E3A5F;">📚 Knowledge:</strong> We believe that books are the foundation of knowledge and growth.
        We curate our collection to ensure quality and diversity.<br><br>
        <strong style="color: #1E3A5F;">💡 Innovation:</strong> We continuously improve our platform to provide the best
        reading experience for our customers.<br><br>
        <strong style="color: #1E3A5F;">🤝 Community:</strong> We foster a community of readers who share their passion
        for books and support each other's learning journey.<br><br>
        <strong style="color: #1E3A5F;">✨ Excellence:</strong> We are committed to delivering excellence in every
        aspect of our service, from customer support to book selection.
      </p>
    </div>

    <!-- Meet Our Team Section -->
    <div>
      <h2 style="color: #1E3A5F; font-size: 2.5rem; text-align: center; margin-bottom: 50px; font-family: 'Dancing Script', cursive;">
        ✨ Meet Our Team
        <div style="width: 100px; height: 4px; background: linear-gradient(90deg, #D4AF37 0%, #B8860B 100%); border-radius: 2px; margin: 15px auto 0;"></div>
      </h2>

      <div class="team-grid">
        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <div class="team-member">
              <img src="<?php echo !empty($row['image']) ? $row['image'] : 'img/default-user.png'; ?>"
                alt="<?php echo $row['name']; ?>"
                onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22280%22 height=%22250%22><rect fill=%22%231E3A5F%22 width=%22280%22 height=%22250%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2220%22 fill=%22%23D4AF37%22><?php echo substr($row['name'], 0, 1); ?></text></svg>'">
              <h3><?php echo $row['name']; ?></h3>
              <p><?php echo $row['role']; ?></p>
            </div>
        <?php
          }
        } else {
          echo "<p style='grid-column: 1/-1; text-align: center; color: #999; font-size: 1.1rem;'>Team members coming soon...</p>";
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer" role="contentinfo">
    <div class="container footer-container">
      <div class="footer-column">
        <h3>BookStore</h3>
        <p style="font-family: 'Lora', serif;">Your trusted source for timeless stories and endless knowledge.</p>
      </div>

      <div class="footer-column">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="books.php">Books</a></li>
          <li><a href="contect.php">Contact Us</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h3>Support</h3>
        <ul>
          <li><a href="contect.php">Contact Us</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      ©️ 2025 BookStore. All Rights Reserved. | Privacy | Terms of Service
    </div>
  </footer>
</body>

</html>