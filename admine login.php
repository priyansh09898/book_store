<?php
session_start();
include "db.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['fullname'];
        header("Location: profile.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql)) {
        $success = "Registration successful! Please login.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BookStore</title>
    <link rel="stylesheet" href="fonts.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1E3A5F 0%, #0F2536 100%);
            padding: 20px;
            font-family: 'Lora', serif;
        }

        .login-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(30, 58, 95, 0.3);
            width: 100%;
            max-width: 450px;
            padding: 50px;
            border-top: 4px solid #D4AF37;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 2.5rem;
            color: #1E3A5F;
            margin: 0;
            font-family: 'Dancing Script', cursive;
        }

        .login-header p {
            color: #6B5344;
            margin-top: 5px;
            font-family: 'Lora', serif;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1E3A5F;
            font-family: 'Dancing Script', cursive;
            font-size: 1.1rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #E8DFD5;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Lora', serif;
            background-color: #FFFEF0;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #D4AF37 0%, #B8860B 100%);
            color: #1E3A5F;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Lora', serif;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
        }

        .toggle-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #E8DFD5;
        }

        .toggle-link {
            color: #D4AF37;
            cursor: pointer;
            font-weight: 600;
            font-family: 'Lora', serif;
            text-decoration: none;
        }

        .toggle-link:hover {
            text-decoration: underline;
        }

        .home-button {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background: #ecf0f1;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .home-button:hover {
            background: #bdc3c7;
        }

        .hidden {
            display: none !important;
        }

        .admin-link {
            text-align: center;
            font-size: 0.9rem;
            margin-top: 15px;
        }

        .admin-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Login Form -->
        <div class="login-box" id="loginSection">
            <div class="login-header">
                <h1>BookStore</h1>
                <p>Sign in to your account</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    ⚠️ <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" name="login" class="submit-btn">Sign In</button>
            </form>

            <div class="toggle-section">
                Don't have an account? <span class="toggle-link" onclick="toggleForms()">Create one</span>
            </div>

            <!-- <div class="admin-link">
                <a href="admin.php">Admin Panel →</a>
            </div> -->

            <a href="home.php" class="home-button">← Back to Home</a>
        </div>

        <!-- Registration Form -->
        <div class="login-box hidden" id="registerSection">
            <div class="login-header">
                <h1>BookStore</h1>
                <p>Create a new account</p>
            </div>

            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    ✓ <?= $success ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password (min 6 chars)" required>
                </div>

                <button type="submit" name="register" class="submit-btn">Create Account</button>
            </form>

            <div class="toggle-section">
                Already have an account? <span class="toggle-link" onclick="toggleForms()">Sign in</span>
            </div>

            <a href="home.php" class="home-button">← Back to Home</a>
        </div>
    </div>

    <script>
        function toggleForms() {
            const loginSection = document.getElementById('loginSection');
            const registerSection = document.getElementById('registerSection');
            loginSection.classList.toggle('hidden');
            registerSection.classList.toggle('hidden');
        }
    </script>
</body>

</html>