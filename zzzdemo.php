<?php
session_start();

// DB CONNECTION
$conn = new mysqli("localhost", "root", "", "bookstore");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// LOGIN
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, set session
        $_SESSION['user'] = $email;
        header("Location: home.php"); // Replace with your dashboard/home page
        exit();
    } else {
        $message = "Invalid Email or Password!";
    }
}

// CHECK IF ALREADY LOGGED IN
if (isset($_SESSION['user'])) {
    // Redirect to home or dashboard if already logged in
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amazon Login Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            width: 100px;
            margin: 20px 0;
        }

        .container {
            width: 350px;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 4px;
        }

        h1 {
            font-size: 28px;
            font-weight: 400;
            margin-bottom: 20px;
        }

        label {
            font-size: 13px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #a6a6a6;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #e77600;
            box-shadow: 0 0 3px 2px rgba(228, 121, 17, .5);
            outline: none;
        }

        .btn-amazon {
            width: 100%;
            background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
            border: 1px solid #a88734;
            padding: 8px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 13px;
        }

        .btn-amazon:hover {
            background: #f0c14b;
        }

        .footer-text {
            font-size: 12px;
            margin-top: 20px;
            color: #555;
        }

        .toggle-link {
            color: #0066c0;
            cursor: pointer;
            text-decoration: none;
        }

        .toggle-link:hover {
            text-decoration: underline;
            color: #c45500;
        }

        .hidden { display: none; }
    </style>
</head>

<body>

<div class="container" id="loginBox">
    <h1>Sign-In</h1>
    <form method="post">
        <label>Email or mobile phone number</label>
        <input type="email" name="email" required>
        
        <label>Password</label>
        <input type="password" name="password" required>
        
        <button type="submit" name="login" class="btn-amazon">Continue</button>
    </form>
    <p class="footer-text"><?= $message ?></p>
    <p><a href="#" onclick="showRegister()">Create your account</a></p>
</div>

<div class="container hidden" id="registerBox">
    <h1>Create Account</h1>
    <form method="post">
        <label>Your name</label>
        <input type="text" name="name" placeholder="First and last name" required>
        
        <label>Mobile number or email</label>
        <input type="email" name="email" required>
        
        <label>Password</label>
        <input type="password" name="password" placeholder="At least 6 characters" required>
        
        <button type="submit" name="register" class="btn-amazon">Verify mobile number</button>
    </form>
    <p class="footer-text"><?= $message ?></p>
    <p><a href="#" onclick="showLogin()">Already have an account? Sign-In</a></p>
</div>

<script>
function showRegister(){
    document.getElementById("loginBox").classList.add("hidden");
    document.getElementById("registerBox").classList.remove("hidden");
}

function showLogin(){
    document.getElementById("loginBox").classList.remove("hidden");
    document.getElementById("registerBox").classList.add("hidden");
}
</script>

</body>
</html>