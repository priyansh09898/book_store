<?php
include "db.php";

// Get all books from database
$books_result = $conn->query("SELECT * FROM books");

// Get all images from img folder
$img_files = array_diff(scandir('img'), array('..', '.'));

echo "<h1>📚 BookStore - Image & Database Verification</h1>";

echo "<h2>Database Books:</h2>";
if ($books_result && $books_result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Title</th><th>Image Path</th><th>File Exists?</th><th>Preview</th></tr>";

    while ($book = $books_result->fetch_assoc()) {
        $image_path = $book['image'];
        $file_exists = file_exists($image_path) ? "✅ YES" : "❌ NO";
        $status_color = file_exists($image_path) ? "green" : "red";

        echo "<tr style='border-bottom: 1px solid #ddd;'>";
        echo "<td>" . $book['id'] . "</td>";
        echo "<td>" . $book['title'] . "</td>";
        echo "<td>" . $image_path . "</td>";
        echo "<td style='color: $status_color; font-weight: bold;'>" . $file_exists . "</td>";

        if (file_exists($image_path)) {
            echo "<td><img src='$image_path' style='height: 50px; object-fit: cover;' alt='" . $book['title'] . "'></td>";
        } else {
            echo "<td>N/A</td>";
        }

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No books in database. <a href='setup.php'>Run Setup</a></p>";
}

echo "<h2>Available Image Files in img/ folder:</h2>";
if (!empty($img_files)) {
    echo "<ul style='columns: 3;'>";
    foreach ($img_files as $file) {
        if (is_file('img/' . $file)) {
            echo "<li>✅ " . $file . "</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>No images found in img/ folder</p>";
}

echo "<h2>Quick Links:</h2>";
echo "<ul>";
echo "<li><a href='books.php'>View Books Page</a></li>";
echo "<li><a href='admin.php'>Go to Admin Panel</a></li>";
echo "<li><a href='setup.php'>Run Database Setup</a></li>";
echo "</ul>";

echo "<style>";
echo "body { font-family: Arial; margin: 20px; }";
echo "table { margin: 20px 0; }";
echo "h2 { color: #1E3A5F; border-bottom: 2px solid #D4AF37; padding-bottom: 10px; }";
echo "a { color: #D4AF37; text-decoration: none; font-weight: bold; }";
echo "a:hover { text-decoration: underline; }";
echo "</style>";
