# BookStore - Database Setup Guide

## Step-by-Step Setup Instructions

### Step 1: Run the Database Setup Script

1. Open your browser and navigate to: `http://localhost/bookstore/setup.php`
2. This will automatically create:
   - **bookstore** database
   - **users** table (stores registered user data from login page)
   - **books** table (stores books added in admin panel)
   - **contact_messages** table (stores contact form messages)
   - **team** table (for team members)
   - **orders** table (for future orders)

### Step 2: Register a New User

1. Go to `http://localhost/bookstore/login.php`
2. Click "Create one" to switch to registration form
3. Enter:
   - Full Name
   - Email
   - Password
4. Click "Sign Up"
5. The data will be stored in the **users** table

### Step 3: View Registered Users in Admin Panel

1. Go to `http://localhost/bookstore/admin.php`
2. Scroll down to see the "Registered Users" section
3. All users registered through the login page will appear here with:
   - User ID
   - Full Name
   - Email
   - Registration Date

### Step 4: View Contact Messages

1. In the Admin Panel, scroll to "Contact Messages" section
2. All messages submitted through `contect.php` will appear here

### Step 5: Add Books

1. In the Admin Panel, use the "Add New Book" form
2. Enter:
   - Book Title
   - Description
   - Price (₹)
   - Book Image
3. Click "Add Book"
4. The book will appear in both:
   - Admin panel inventory
   - Books page (books.php)

## Database Tables Structure

### users table

- id (Auto-increment Primary Key)
- fullname (VARCHAR 100)
- email (VARCHAR 100) - UNIQUE
- password (VARCHAR 100)
- created_at (TIMESTAMP - Auto-set)

### books table

- id (Auto-increment Primary Key)
- title (VARCHAR 100)
- description (TEXT)
- price (DECIMAL 10,2)
- image (VARCHAR 255)

### contact_messages table

- id (Auto-increment Primary Key)
- name (VARCHAR 100)
- email (VARCHAR 150)
- message (TEXT)
- created_at (TIMESTAMP - Auto-set)

### team table

- id (Auto-increment Primary Key)
- name (VARCHAR 100)
- role (VARCHAR 100)
- image (VARCHAR 255)

### orders table

- id (Auto-increment Primary Key)
- user_id (INT - Foreign Key)
- book_id (INT - Foreign Key)
- quantity (INT)
- total_price (DECIMAL 10,2)
- created_at (TIMESTAMP - Auto-set)

## Troubleshooting

### If setup.php shows database connection error:

- Make sure XAMPP MySQL is running
- Check that db.php has correct connection details
- Verify MySQL port is 3306

### If tables already exist:

- The setup script will skip creating existing tables
- Data won't be duplicated

### To reset everything:

- Delete the bookstore database in phpMyAdmin
- Run setup.php again
