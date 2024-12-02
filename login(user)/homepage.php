<?php
require_once 'database.php'; // Include the database connection

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signup_submit'])) {
        // Handle Sign Up form
        $lastName = htmlspecialchars($_POST['last_name']);
        $firstName = htmlspecialchars($_POST['first_name']);
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['signup_email']);
        $password = htmlspecialchars($_POST['signup_password']);
        $confirmPassword = htmlspecialchars($_POST['confirm_password']);

        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match.');</script>";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            try {
                // Insert the new user into the `users` table
                $sql = "INSERT INTO users (userfullname, useremail, username, userpassword) 
                        VALUES (:fullname, :email, :username, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':fullname' => $firstName . ' ' . $lastName,
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => $hashedPassword,
                ]);
                echo "<script>alert('Sign-up successful!');</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
            }
        }
    }

    if (isset($_POST['login_submit'])) {
        // Handle Login form
        $email = htmlspecialchars($_POST['login_email']);
        $password = htmlspecialchars($_POST['login_password']);

        try {
            // Fetch the user from the `users` table
            $sql = "SELECT * FROM users WHERE useremail = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['userpassword'])) {
                echo "<script>alert('Login successful! Welcome " . $user['username'] . ".');</script>";
            } else {
                echo "<script>alert('Invalid email or password.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page with Popups</title>
    <style>
                /* General Styles */
                body {
            font-family: Arial, sans-serif;
            background-color: #b3d8e6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logo {
            position: absolute;
            top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .icon {
            font-size: 100px;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #5a5a8f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .button:hover {
            background-color: #7a7aad;
        }

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup {
            width: 450px;
            max-width: 90%;
            padding: 20px;
            background-color: #e3f3f9;
            border-radius: 10px;
            box-shadow: 0px 0px 10px #5a5a8f;
            position: relative;
        }

        .popup h2 {
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
            color: #333;
        }

        .popup input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #5a5a8f;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        .popup label {
            font-size: 14px;
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .popup label input {
            margin-right: 10px;
        }

        .popup button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: white;
            background-color: #5a5a8f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #7a7aad;
        }

        .popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .popup .close:hover {
            color: red;
        }

        /* Two-Column Layout for Sign Up Form */
        .signup-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .signup-form input {
            width: 100%;
        }

        .signup-form .full-width {
            grid-column: 1 / -1;
        }

        .signup-form .half-width {
            grid-column: span 1;
        }
    </style>
</head>
<body>
    <div class="logo">LOGO</div>
    <div class="icon">👤</div>
    <h1>Hi!</h1>
    <div class="buttons">
        <button class="button" onclick="showPopup('loginPopup')">Login</button>
        <button class="button" onclick="showPopup('signupPopup')">Sign Up</button>
    </div>

    <!-- Login Popup -->
    <div class="popup-overlay" id="loginPopup" onclick="hidePopupOnClickOutside(event, 'loginPopup')">
        <div class="popup">
            <button class="close" onclick="hidePopup('loginPopup')">&times;</button>
            <h2>Login</h2>
            <form action="homepage.php" method="POST">
                <input type="email" name="login_email" placeholder="Email Address" required>
                <input type="password" name="login_password" placeholder="Password" required>
                <label><input type="checkbox" name="remember_me"> Remember Me</label>
                <button type="submit" name="login_submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Sign Up Popup -->
    <div class="popup-overlay" id="signupPopup" onclick="hidePopupOnClickOutside(event, 'signupPopup')">
        <div class="popup">
            <button class="close" onclick="hidePopup('signupPopup')">&times;</button>
            <h2>Sign Up</h2>
            <form class="signup-form" action="homepage.php" method="POST">
                <input type="text" name="last_name" placeholder="Last Name" required class="half-width">
                <input type="text" name="first_name" placeholder="First Name" required class="half-width">
                <input type="text" name="username" placeholder="Username" required class="half-width">
                <input type="email" name="signup_email" placeholder="Email Address" required class="half-width">
                <input type="password" name="signup_password" placeholder="Password" required class="half-width">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required class="half-width">
                <label><input type="checkbox" name="terms_conditions"> Agree to Terms and Conditions</label>
                <button type="submit" name="signup_submit">Sign Up</button>
            </form>
        </div>
    </div>

    <script>
        // Your original JavaScript here
    </script>
</body>
</html>
