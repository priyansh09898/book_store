<?php
// Database setup script
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql_db = "CREATE DATABASE IF NOT EXISTS bookstore";
if ($conn->query($sql_db) === TRUE) {
    echo "✓ Database created successfully.<br>";
} else {
    echo "✗ Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db("bookstore");

// Create users table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_users) === TRUE) {
    echo "✓ Users table created successfully.<br>";
} else {
    echo "✗ Error creating users table: " . $conn->error . "<br>";
}

// Create books table
$sql_books = "CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    image VARCHAR(255)
)";

if ($conn->query($sql_books) === TRUE) {
    echo "✓ Books table created successfully.<br>";
} else {
    echo "✗ Error creating books table: " . $conn->error . "<br>";
}

// Create contact_messages table
$sql_contact = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(150),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_contact) === TRUE) {
    echo "✓ Contact messages table created successfully.<br>";
} else {
    echo "✗ Error creating contact_messages table: " . $conn->error . "<br>";
}

// Create team table
$sql_team = "CREATE TABLE IF NOT EXISTS team (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    role VARCHAR(100),
    image VARCHAR(255)
)";

if ($conn->query($sql_team) === TRUE) {
    echo "✓ Team table created successfully.<br>";
} else {
    echo "✗ Error creating team table: " . $conn->error . "<br>";
}

// Create orders table
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    quantity INT,
    total_price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(book_id) REFERENCES books(id)
)";

if ($conn->query($sql_orders) === TRUE) {
    echo "✓ Orders table created successfully.<br>";
} else {
    echo "✗ Error creating orders table: " . $conn->error . "<br>";
}

// Insert sample books if not exist
$check_books = $conn->query("SELECT COUNT(*) as count FROM books");
$row = $check_books->fetch_assoc();

if ($row['count'] == 0) {
    $sql_insert_books = "INSERT INTO books (title, description, price, image) VALUES
        ('The Alchemist', 'A philosophical novel by Paulo Coelho about dreams and destiny.', 350.00, 'img/111.jpg'),
        ('Rich Dad Poor Dad', 'A book about financial education and wealth building.', 450.00, 'img/222.jpg'),
        ('Atomic Habits', 'A guide to building good habits and breaking bad ones.', 400.00, 'img/333.png'),
        ('Think and Grow Rich', 'Classic book on success and personal development.', 500.00, 'img/1b.jpeg'),
        ('Wings of Fire', 'Autobiography of Dr. A.P.J. Abdul Kalam.', 380.00, 'img/2b.jpeg')";

    if ($conn->query($sql_insert_books) === TRUE) {
        echo "✓ Sample books inserted successfully.<br>";
    } else {
        echo "✗ Error inserting books: " . $conn->error . "<br>";
    }
}

$conn->close();
echo "<br><strong>✓ Database setup complete!</strong>";
echo "<br><a href='home.php'>← Return to Home</a>";
