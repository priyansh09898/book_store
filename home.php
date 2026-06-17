<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>BookStore - Discover Your Next Great Read</title>
  <link rel="stylesheet" href="fonts.css">
  <link rel="stylesheet" href="style.css">
  <style>
    /* Reset some defaults for full-width layout */
    body, html {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    /* FULL WIDTH HERO */
    .hero {
      background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
      color: #F0EDE5;
      padding: 80px 0; /* Padding top/bottom */
      width: 100%;    /* Force full width */
      display: flex;
      justify-content: center;
    }

    /* Inner wrapper to keep text aligned with the rest of your site */
    .hero-inner {
      max-width: 1200px; /* Match your standard container width */
      width: 100%;
      margin: 0 auto;
      padding: 0 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
    }

    .hero-text h1 {
      font-family: 'Dancing Script', cursive;
      font-size: 3.5rem;
      color: #D4AF37;
      margin-bottom: 15px;
      line-height: 1.2;
    }

    .hero-text p {
      font-size: 1.2rem;
      color: #F0EDE5;
      margin-bottom: 25px;
      font-family: 'Lora', serif;
      line-height: 1.7;
    }

    .hero-books {
      display: flex;
      justify-content: center;
    }

    .hero-books img {
      width: 100%;
      max-width: 450px;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    /* PROMO SECTIONS */
    .promo-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      align-items: center;
      padding: 50px 30px;
      margin: 40px auto;
      max-width: 1200px; /* Keeps promos centered */
      border-radius: 15px;
      background: white;
      box-shadow: 0 5px 20px rgba(30, 58, 95, 0.15);
      border-left: 6px solid #D4AF37;
      transition: transform 0.3s ease;
    }

    /* Your existing Promo Styles... */
    .promo-section:nth-child(4) { border-left-color: #8B3A3A; background: linear-gradient(135deg, #F9F7F5 0%, #F0EEEB 100%); }
    .promo-section:nth-child(5) { border-left-color: #1E3A5F; background: linear-gradient(135deg, #FDFBF8 0%, #F8F6F2 100%); }

    .promo-text h1 { font-family: 'Dancing Script', cursive; font-size: 2.8rem; color: #1E3A5F; }
    .promo-text p { font-family: 'Lora', serif; border-left: 4px solid #D4AF37; padding-left: 15px; }
    .promo-image img { width: 100%; max-width: 280px; border-radius: 12px; border: 3px solid #D4AF37; }

    @media (max-width: 768px) {
      .hero-inner {
        grid-template-columns: 1fr;
        text-align: center;
      }
      .hero-text h1 { font-size: 2.5rem; }
      .promo-section { grid-template-columns: 1fr; margin: 20px; }
    }
  </style>
</head>

<body>

  <header>
    <nav class="navbar" role="navigation">
      <div class="container nav-inner">
        <div class="logo"> BookStore</div>
        <ul class="nav-links">
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
          <li><a href="books.php">Books</a></li>
          <li><a href="contect.php">Contact Us</a></li>
          <li><a href="newbook.php">🛒 Cart</a></li>
          <li><a href="profile.php">👤 Profile</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-inner">
      <div class="hero-text">
        <h1>Your Literary Paradise Awaits</h1>
        <p>Step into a world of endless imagination. From engineering to management, from timeless classics to modern bestsellers, BookStore brings you curated collections that inspire, educate, and transform.</p>
        <a href="books.php" class="btn">Browse Our Library</a>
      </div>
      <div class="hero-books">
        <img src="img/image.png" alt="Featured Books">
      </div>
    </div>
  </section>

  <section class="promo-section">
    <div class="promo-text">
      <h2>Legendary Adventure</h2>
      <h1>BROTHERS</h1>
      <p>A war born from pride and destiny. Bound by blood. Broken by power.</p>
      <a href="books.php" class="btn">Discover Now</a>
    </div>
    <div class="promo-image">
      <img src="img/111.jpg" alt="Brothers">
    </div>
  </section>

  <section class="promo-section">
    <div class="promo-image">
      <img src="img/222.jpg" alt="Faith">
    </div>
    <div class="promo-text">
      <h2>Spiritual Awakening</h2>
      <h1>FAITH</h1>
      <p>A message revealed in the darkest of times. Truth cannot be silenced.</p>
      <a href="books.php" class="btn">Read More</a>
    </div>
  </section>

  <footer class="footer">
    <div class="container footer-container">
      <div class="footer-column">
        <h3>BookStore</h3>
        <p>Your trusted source for timeless stories and endless knowledge.</p>
      </div>
      <div class="footer-column">
        <h3>Quick Links</h3>
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="about.php">About Us</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      © 2025 BookStore. All Rights Reserved.
    </div>
  </footer>

</body>
</html>