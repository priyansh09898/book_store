<?php
session_start();
include "db.php";

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) || isset($_SESSION['username']);

// Add to cart - redirect to login if not logged in
if (isset($_GET['add'])) {
    if (!$isLoggedIn) {
        header("Location: login.php");
        exit();
    }

    $id = (int)$_GET['add'];
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
}

// Update quantity
if (isset($_POST['change']) && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $change = (int)$_POST['change'];

    if (isset($_SESSION['cart'][$id])) {
        $new_qty = $_SESSION['cart'][$id] + $change;

        // Don't allow quantity less than 1
        if ($new_qty >= 1) {
            $_SESSION['cart'][$id] = $new_qty;
        }
    }

    // Refresh page to show updated cart
    header("Location: newbook.php");
    exit();
}

// Remove item
if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$id]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - BookStore</title>
    <link rel="stylesheet" href="fonts.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .cart-table thead {
            background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
            color: #F0EDE5;
        }

        .cart-table th {
            padding: 20px;
            text-align: left;
            font-weight: 600;
        }

        .cart-table td {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .cart-table tbody tr:hover {
            background: #f8f9fa;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-control button {
            background: #1E3A5F;
            color: #D4AF37;
            border: 2px solid #D4AF37;
            width: 35px;
            height: 35px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            font-weight: bold;
        }

        .quantity-control button:hover {
            background: #D4AF37;
            color: #1E3A5F;
            transform: scale(1.1);
        }

        .remove-btn {
            background: #8B3A3A !important;
            color: white !important;
            padding: 8px 12px !important;
            border: none !important;
            border-radius: 5px !important;
            cursor: pointer !important;
            text-decoration: none !important;
            font-size: 0.9rem !important;
            transition: all 0.3s ease !important;
            display: inline-block !important;
        }

        .remove-btn:hover {
            background: #6B2A2A !important;
            transform: scale(1.05) !important;
        }

        .cart-summary {
            background: linear-gradient(135deg, #f5f7fa 0%, #ecf0f1 100%);
            padding: 30px;
            border-radius: 15px;
            margin: 40px 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .summary-item {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .summary-item h3 {
            color: #1E3A5F;
            margin-top: 0;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Dancing Script', cursive;
        }

        .summary-item .amount {
            color: #D4AF37;
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0 0 0;
            font-family: 'Dancing Script', cursive;
        }

        .checkout-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .checkout-form h2 {
            color: #1E3A5F;
            text-align: center;
            margin-top: 0;
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #ecf0f1 100%);
            border-radius: 15px;
        }

        .empty-cart h2 {
            color: #1E3A5F;
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-family: 'Dancing Script', cursive;
        }

        .empty-cart p {
            color: #7f8c8d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .empty-cart a {
            display: inline-block;
            background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
            color: #D4AF37;
            padding: 12px 35px;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .empty-cart a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        @media (max-width: 768px) {
            .cart-summary {
                grid-template-columns: 1fr;
            }

            .checkout-form {
                max-width: 100%;
            }

            .cart-table {
                font-size: 0.9rem;
            }

            .cart-table th,
            .cart-table td {
                padding: 12px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
  <header>
    <nav class="navbar" role="navigation" aria-label="Main navigation">
      <div class="container nav-inner">
        <div class="logo"> BookStore</div>

        <!-- checkbox toggle -->
        <!-- <input type="checkbox" id="nav-toggle" /> -->
        <!-- <label for="nav-toggle" class="nav-toggle-label" aria-hidden="true">Menu</label> -->

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
    </nav>
  </header>

    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 20px; text-align: center;">
        <div class="container">
            <h1 style="font-size: 2.5rem; margin: 0 0 10px 0;">🛒 Shopping Cart</h1>
            <p style="font-size: 1.1rem; margin: 0; opacity: 0.9;">Review your items and proceed to checkout</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container" style="margin-top: 60px; margin-bottom: 60px;">
        <?php if (!empty($_SESSION['cart'])): ?>
            <!-- Cart Table -->
            <div style="overflow-x: auto; margin-bottom: 60px;">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subtotal = 0;
                        $taxRate = 0.18; // 18% GST

                        foreach ($_SESSION['cart'] as $id => $qty) {
                            $id = (int)$id;
                            $result = $conn->query("SELECT * FROM books WHERE id=$id");
                            $product = $result->fetch_assoc();

                            if ($product) {
                                $total = $product['price'] * $qty;
                                $subtotal += $total;
                        ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($product['title']) ?></strong></td>
                                    <td>₹<?= number_format($product['price'], 2) ?></td>
                                    <td>
                                        <div class="quantity-control">
                                            <form method="post" style="display: flex; gap: 5px;">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <button type="submit" name="change" value="-1" title="Decrease quantity">−</button>
                                                <span style="width: 40px; text-align: center; line-height: 35px;"><?= $qty ?></span>
                                                <button type="submit" name="change" value="1" title="Increase quantity">+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td><strong style="color: #667eea;">₹<?= number_format($total, 2) ?></strong></td>
                                    <td><a href="?remove=<?= $id ?>" class="remove-btn">Remove</a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Order Summary -->
            <div class="cart-summary">
                <div class="summary-item">
                    <h3>Order Summary</h3>
                    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                        <tr style="border-bottom: 1px solid #ecf0f1;">
                            <td style="padding: 8px 0;">Subtotal</td>
                            <td style="text-align: right; padding: 8px 0;">₹<?= number_format($subtotal, 2) ?></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ecf0f1;">
                            <td style="padding: 8px 0;">Tax (GST 18%)</td>
                            <td style="text-align: right; padding: 8px 0;">₹<?= number_format($subtotal * $taxRate, 2) ?></td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; font-size: 1.1rem;"><strong>Total Amount</strong></td>
                            <td style="text-align: right; padding: 12px 0; font-size: 1.3rem; color: #667eea;"><strong>₹<?= number_format($subtotal + ($subtotal * $taxRate), 2) ?></strong></td>
                        </tr>
                    </table>
                </div>

                <div class="summary-item">
                    <h3>📦 Delivery Info</h3>
                    <p style="margin: 15px 0; color: #555; line-height: 1.6;">
                        <strong>✓ Free Shipping</strong> for orders above ₹500<br>
                        <strong>✓ Delivery</strong> within 3-5 business days<br>
                        <strong>✓ Easy Returns</strong> within 14 days<br>
                        <strong>✓ Secure Payment</strong> guarantee
                    </p>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="checkout-form">
                <h2>Checkout</h2>
                <form method="post" action="login.php">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="John Doe" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="john@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Delivery Address</label>
                        <textarea id="address" name="address" placeholder="Enter your full address..." rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="+91 98765 43210" required>
                    </div>
                    <button type="submit" class="btn" style="width: 100%; padding: 15px; font-size: 1.1rem;">Proceed to Payment</button>
                </form>
                <p style="text-align: center; color: #7f8c8d; margin-top: 15px; font-size: 0.9rem;">
                    * Payment processing will be implemented in production
                </p>
            </div>

        <?php else: ?>
            <!-- Empty Cart -->
            <div class="empty-cart">
                <h2>🛒 Your Cart is Empty</h2>
                <p>You haven't added any books to your cart yet.</p>
                <a href="books.php">Continue Shopping</a>
            </div>
        <?php endif; ?>
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