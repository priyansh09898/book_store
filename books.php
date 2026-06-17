<?php
session_start();
include "db.php";

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['username']);

$result = $conn->query("SELECT * FROM books");
if (!$result) {
  die("Database query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Books - BookStore</title>
  <link rel="stylesheet" href="fonts.css">
  <link rel="stylesheet" href="style.css">
  <style>
    .books-header {
      background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
      color: var(--light-bg);
      padding: 60px 20px;
      text-align: center;
      border-bottom: 4px solid #D4AF37;
    }

    .books-header h1 {
      font-size: 2.8rem;
      margin-bottom: 10px;
      font-family: 'Dancing Script', cursive;
      color: #D4AF37;
    }

    .books-header p {
      font-size: 1.2rem;
      opacity: 0.95;
      font-family: 'Lora', serif;
    }

    /* Single Book Card Styling */
    .book-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .book-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
      border-top: 4px solid #D4AF37;
    }

    .book-card img {
      width: 100%;
      height: 280px;
      object-fit: cover;
      display: block;
    }

    .book-card-content {
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .book-card-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: #1E3A5F;
      margin: 0 0 10px 0;
      font-family: 'Dancing Script', cursive;
      line-height: 1.3;
    }

    .book-card-description {
      font-size: 0.95rem;
      color: #666;
      margin: 0 0 15px 0;
      line-height: 1.5;
      flex-grow: 1;
      font-family: 'Lora', serif;
      max-height: 60px;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .book-card-price {
      font-size: 1.6rem;
      font-weight: bold;
      color: #D4AF37;
      margin: 10px 0;
      font-family: 'Dancing Script', cursive;
    }

    .book-card .btn {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
      color: #D4AF37;
      border: 2px solid #D4AF37;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      font-family: 'Lora', serif;
    }

    .book-card .btn:hover {
      background: #D4AF37;
      color: #1E3A5F;
      transform: scale(1.02);
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 30px;
      margin: 40px 0;
    }

    @media (max-width: 768px) {
      .card-container {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
      }

      .book-card-title {
        font-size: 1.1rem;
      }

      .book-card-price {
        font-size: 1.4rem;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <header>
    <nav class="navbar">
      <div class="container nav-inner">
        <div class="logo"> BookStore</div>
        <ul class="nav-links">
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
    </nav>
  </header>

  <!-- Books Header -->
  <div class="books-header">
    <h1>Discover Our Collection</h1>
    <p>Explore a world of stories, knowledge, and inspiration</p>
  </div>

  <!-- Books Grid -->
  <div class="container">
    <div class="card-container">
      <?php
      if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()):
          // Generate image path - handle both with and without 'img/' prefix
          $imagePath = $row['image'] ?? 'img/default.jpeg';
          if (!empty($imagePath) && !str_starts_with($imagePath, 'img/')) {
            $imagePath = 'img/' . $imagePath;
          }
      ?>
          <div class="book-card">
            <img src="<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($row['title']) ?>" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22240%22 height=%22280%22><rect fill=%22%23f0f0f0%22 width=%22240%22 height=%22280%22/><text x=%2250%25%22 y=%2245%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2218%22 fill=%22%23999%22 font-weight=%22bold%22><?= htmlspecialchars(substr($row['title'], 0, 20)) ?></text><text x=%2250%25%22 y=%2255%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2212%22 fill=%22%23ccc%22>Book Cover</text></svg>'">
            <div class="book-card-content">
              <h3 class="book-card-title"><?= htmlspecialchars($row['title']) ?></h3>
              <p class="book-card-description"><?= htmlspecialchars($row['description'] ?? 'Explore this amazing book.') ?></p>
              <div class="book-card-price">₹<?= htmlspecialchars($row['price']) ?></div>
              <a href="<?php echo $isLoggedIn ? 'newbook.php?add=' . $row['id'] : 'login.php'; ?>" class="btn">Buy Now</a>
            </div>
          </div>
      <?php
        endwhile;
      } else {
        echo "<p style='text-align: center; padding: 30px; grid-column: 1/-1;'>No books available. Please visit again soon!</p>";
      }
      ?>
    </div>
  </div>

  <br><br><br>
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