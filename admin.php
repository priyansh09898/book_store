<?php
session_start();
include "db.php";

if (isset($_POST['add_book'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description'] ?? '');
    $price = $conn->real_escape_string($_POST['price']);

    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_name = basename($image);
    $target = "img/" . $image_name;

    // Validate file upload
    if (!empty($image_name) && move_uploaded_file($image_tmp, $target)) {
        // Store only filename, not full path
        $image_path = $conn->real_escape_string($image_name);
        $sql = "INSERT INTO books (title, description, price, image) 
                VALUES ('$title', '$description', '$price', '$image_path')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Book added successfully!');</script>";
        } else {
            echo "<script>alert('Error: ' . " . $conn->error . ");</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid image file.');</script>";
    }
}

// Delete book
if (isset($_GET['delete_book'])) {
    $book_id = (int)$_GET['delete_book'];
    $delete_sql = "DELETE FROM books WHERE id = $book_id";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Book deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting book: " . $conn->error . "');</script>";
    }
}

$result = $conn->query("SELECT * FROM books");
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Get users
$users_result = $conn->query("SELECT * FROM users");
$users = ($users_result && $users_result->num_rows > 0) ? $users_result : null;

// Get contact messages
$messages_result = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
$messages = ($messages_result && $messages_result->num_rows > 0) ? $messages_result : null;
?>


<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel - BookStore</title>
    <link rel="stylesheet" href="fonts.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
            color: #F0EDE5;
            padding: 40px 20px;
            text-align: center;
            border-bottom: 4px solid #D4AF37;
        }

        .admin-header h1 {
            font-size: 2.5rem;
            margin: 0;
            margin-bottom: 10px;
            font-family: 'Dancing Script', cursive;
            color: #D4AF37;
        }

        .admin-header p {
            font-family: 'Lora', serif;
            color: #F0EDE5;
        }

        .admin-content {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            padding: 40px 0;
        }

        .form-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-section h2 {
            color: #1E3A5F;
            margin-top: 0;
            border-bottom: 3px solid #D4AF37;
            padding-bottom: 15px;
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
        }

        .books-grid {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .books-grid h2 {
            color: #1E3A5F;
            margin-top: 0;
            border-bottom: 3px solid #D4AF37;
            padding-bottom: 15px;
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .book-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .book-item:hover {
            border-color: #D4AF37;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
        }

        .book-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .book-item h3 {
            color: #1E3A5F;
            font-size: 1rem;
            margin: 10px 0;
            font-family: 'Dancing Script', cursive;
        }

        .book-item p {
            color: #D4AF37;
            font-weight: bold;
            font-size: 1.2rem;
            font-family: 'Dancing Script', cursive;
            margin-bottom: 10px;
        }

        .book-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 10px;
        }

        .delete-btn {
            background: #8B3A3A;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .delete-btn:hover {
            background: #6B2A2A;
            transform: scale(1.05);
        }

        textarea {
            width: 100% !important;
            resize: vertical;
        }

        @media (max-width: 1024px) {
            .admin-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <header>
        <nav class="navbar">
            <div class="container nav-inner">
                <div class="logo">📚 BookStore Admin</div>
                <ul class="nav-links">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="books.php">All Books</a></li>
                    <li><a href="login.php">Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Admin Header -->
    <div class="admin-header">
        <h1>Admin Control Panel</h1>
        <p>Manage your bookstore inventory</p>
    </div>

    <!-- Admin Content -->
    <div class="container">
        <div class="admin-content">
            <!-- Add Book Form -->
            <div class="form-section">
                <h2>➕ Add New Book</h2>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Book Title</label>
                        <input type="text" name="title" placeholder="Enter book title" required>
                    </div>

                    <div class="form-group">
                        <label>Description (Optional)</label>
                        <textarea name="description" placeholder="Enter book description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Price (₹)</label>
                        <input type="number" name="price" placeholder="Enter price" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label>Book Image</label>
                        <input type="file" name="image" accept="image/*" required>
                    </div>

                    <button type="submit" name="add_book" class="btn">Add Book</button>
                </form>
            </div>

            <!-- Books Display -->
            <div class="books-grid">
                <h2>📚 All Books in Inventory</h2>
                <div class="book-grid">

                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Handle image path - add img/ prefix if not already there
                            $imagePath = $row['image'] ?? 'default.jpeg';
                            if (!str_starts_with($imagePath, 'img/')) {
                                $imagePath = 'img/' . $imagePath;
                            }
                    ?>
                            <div class="book-item">
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo $row['title']; ?>" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22150%22><rect fill=%22%23ddd%22 width=%22200%22 height=%22150%22/><text x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2214%22 fill=%22%23999%22>No Image</text></svg>'">
                                <h3><?php echo $row['title']; ?></h3>
                                <p>₹<?php echo $row['price']; ?></p>
                                <div class="book-actions">
                                    <a href="admin.php?delete_book=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p style='grid-column: 1/-1; text-align: center; color: #7f8c8d;'>No books in inventory yet. Add your first book!</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Registered Users Section -->
        <div style="margin-top: 40px;">
            <div class="books-grid">
                <h2>👥 Registered Users</h2>
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead style="background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%); color: #D4AF37;">
                        <tr>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">ID</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Full Name</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Email</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($users) {
                            while ($user = $users->fetch_assoc()) {
                                echo "<tr style='border-bottom: 1px solid #e0e0e0;'>";
                                echo "<td style='padding: 12px;'>" . htmlspecialchars($user['id']) . "</td>";
                                echo "<td style='padding: 12px;'>" . htmlspecialchars($user['fullname'] ?? 'N/A') . "</td>";
                                echo "<td style='padding: 12px;'>" . htmlspecialchars($user['email']) . "</td>";
                                echo "<td style='padding: 12px;'>" . (isset($user['created_at']) ? date('d-m-Y H:i', strtotime($user['created_at'])) : 'N/A') . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='padding: 20px; text-align: center; color: #999;'>No registered users yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Contact Messages Section -->
        <div style="margin-top: 40px; margin-bottom: 40px;">
            <div class="books-grid">
                <h2>💬 Contact Messages</h2>
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead style="background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%); color: #D4AF37;">
                        <tr>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">ID</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Name</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Email</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Message</th>
                            <th style="padding: 12px; text-align: left; border-bottom: 2px solid #D4AF37;">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($messages) {
                            while ($msg = $messages->fetch_assoc()) {
                                echo "<tr style='border-bottom: 1px solid #e0e0e0;'>";
                                echo "<td style='padding: 12px;'>" . htmlspecialchars($msg['id']) . "</td>";
                                echo "<td style='padding: 12px;'>" . htmlspecialchars($msg['name']) . "</td>";
                                echo "<td style='padding: 12px;'>" . htmlspecialchars($msg['email']) . "</td>";
                                $message_preview = strlen($msg['message']) > 40 ? substr($msg['message'], 0, 40) . '...' : $msg['message'];
                                echo "<td style='padding: 12px; max-width: 250px; word-wrap: break-word;'>" . htmlspecialchars($message_preview) . "</td>";
                                echo "<td style='padding: 12px;'>" . date('d-m-Y H:i', strtotime($msg['created_at'])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='padding: 20px; text-align: center; color: #999;'>No messages yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container footer-container">
            <div class="footer-column">
                <h3>BookStore Admin</h3>
                <p>Manage your bookstore inventory effectively</p>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="books.php">View Books</a></li>
                    <li><a href="admin.php">Admin Panel</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="contect.php">Contact Us</a></li>
                    <li><a href="#">Documentation</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            ©️ 2025 BookStore Admin. All Rights Reserved. | Privacy | Terms of Service
        </div>
    </footer>
</body>

</html>