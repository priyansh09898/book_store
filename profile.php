<?php
session_start();
include "db.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details from database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id=$user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $error = "User not found";
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - BookStore</title>
    <link rel="stylesheet" href="fonts.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #ecf0f1 100%);
            padding: 40px 20px;
        }

        .profile-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-header {
            background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
            color: #D4AF37;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .profile-header h1 {
            margin: 0 0 10px 0;
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            color: #D4AF37;
        }

        .profile-header p {
            margin: 0;
            color: #F0EDE5;
            font-size: 1.1rem;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .profile-card h2 {
            color: #1E3A5F;
            font-family: 'Dancing Script', cursive;
            font-size: 1.8rem;
            margin-top: 0;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ecf0f1;
        }

        .profile-field {
            margin-bottom: 25px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #D4AF37;
        }

        .profile-field label {
            display: block;
            color: #1E3A5F;
            font-weight: 600;
            margin-bottom: 8px;
            font-family: 'Dancing Script', cursive;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .profile-field value {
            display: block;
            color: #555;
            font-size: 1.1rem;
            word-break: break-all;
            margin-top: 5px;
            font-family: 'Lora', serif;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #D4AF37, #B8860B);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 3rem;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary {
            flex: 1;
            min-width: 150px;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
            display: inline-block;
            font-family: 'Lora', serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
            color: #1E3A5F;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.3);
        }

        .btn-secondary {
            background: #1E3A5F;
            color: #D4AF37;
            border: 2px solid #D4AF37;
        }

        .btn-secondary:hover {
            background: #D4AF37;
            color: #1E3A5F;
        }

        .btn-danger {
            background: #8B3A3A;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Lora', serif;
        }

        .btn-danger:hover {
            background: #6B2A2A;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(139, 58, 58, 0.3);
        }

        .info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            text-align: center;
        }

        .info-box h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 25px;
            }

            .profile-header {
                padding: 30px 20px;
            }

            .profile-header h1 {
                font-size: 2rem;
            }

            .profile-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <header class="navbar" role="navigation" aria-label="Main navigation">
        <div class="container nav-inner">
            <div class="logo"> BookStore</div>
            <ul id="primary-navigation" class="nav-links" role="menubar" aria-label="Primary">
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="books.php">Books</a></li>
                <li><a href="contect.php">Contact Us</a></li>
                <li><a href="newbook.php">🛒 Cart</a></li>
                <li><a href="profile.php">👤 Profile</a></li>
                <!-- <li><a href="profile.php?logout=true">Logout</a></li> -->
            </ul>
        </div>
    </header>

    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-wrapper">
            <!-- Header -->
            <div class="profile-header">
                <div class="profile-avatar">👤</div>
                <h1>User Profile</h1>
                <p>Manage your account information</p>
            </div>

            <!-- Profile Card -->
            <div class="profile-card">
                <h2>👤 Personal Information</h2>

                <?php if (isset($error)): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                        ❌ <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($user)): ?>
                    <div class="profile-field">
                        <label>📝 Full Name</label>
                        <value><?= htmlspecialchars($user['fullname'] ?: 'Not set') ?></value>
                    </div>

                    <div class="profile-field">
                        <label>📧 Email Address</label>
                        <value><?= htmlspecialchars($user['email']) ?></value>
                    </div>

                    <div class="profile-field">
                        <label>🆔 User ID</label>
                        <value><?= htmlspecialchars($user['id']) ?></value>
                    </div>

                    <div class="profile-field">
                        <label>🔐 Account Status</label>
                        <value style="color: #27ae60;">✓ Active</value>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box">
                        <h3>💰 Ready to Shop?</h3>
                        <p>Browse our collection of books and start shopping now!</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="profile-actions">
                        <a href="books.php" class="btn-primary">🛍️ Browse Books</a>
                        <a href="newbook.php" class="btn-secondary">🛒 View Cart</a>
                    </div>

                    <!-- Logout Button -->
                    <div style="text-align: center; margin-top: 30px;">
                        <a href="?logout=true" class="btn-danger">🚪 Logout</a>
                    </div>

                <?php endif; ?>
            </div>

            <!-- Additional Info -->
            <div class="profile-card">
                <h2>ℹ️ Account Details</h2>
                <div class="profile-field">
                    <label>📍 Account Type</label>
                    <value>Regular Customer</value>
                </div>
                <div class="profile-field">
                    <label>✅ Email Verified</label>
                    <value style="color: #27ae60;">Yes</value>
                </div>
                <div class="profile-field">
                    <label>🛒 Shopping Status</label>
                    <value style="color: #667eea;">Active Shopper</value>
                </div>
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