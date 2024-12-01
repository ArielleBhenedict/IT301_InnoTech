<?php
require_once 'db.php';

if (isset($_POST['signup_submit'])) {
    // Get form data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        // Clear passwords while retaining other details
        $password = '';
        $confirmPassword = '';
    } else {
        // Hash the password if they match
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Prepare SQL statement to insert admin data
            $stmt = $pdo->prepare("INSERT INTO admins (adminusername, adminemail, adminpassword, adminfullname) 
                                   VALUES (:username, :email, :password, :fullname)");
            
            // Bind actual variables to parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':fullname', $fullName); // bind to a new variable

            // Combine first and last name into one variable
            $fullName = $firstName . ' ' . $lastName;

            // Execute the insert query
            if ($stmt->execute()) {
                echo "<script>
                        alert('Registration successful! Please log in.');
                        showLoginPopup();
                      </script>";
            } else {
                echo "<script>alert('Error: Registration failed.');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
if (isset($_POST['login_submit'])) {
    // Get form data
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    try {
        // Prepare SQL statement to fetch user data based on email
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE adminemail = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Fetch the user data
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password is correct
        if ($admin && password_verify($password, $admin['adminpassword'])) {
            // Start session to store user information
            session_start();
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_username'] = $admin['adminusername'];
            $_SESSION['admin_email'] = $admin['adminemail'];

            // Redirect to products page
            header("Location: product.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please try again.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
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
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #5a5a8f;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #7a7aad;
        }

        /* Popups */
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
            background-color: #e3f3f9;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        .popup input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #5a5a8f;
            border-radius: 5px;
        }

        .popup button {
            width: 100%;
            padding: 10px;
            color: white;
            background-color: #5a5a8f;
            border: none;
            border-radius: 5px;
        }

        .popup button:hover {
            background-color: #7a7aad;
        }

        .popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
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
    <div class="popup-overlay" id="loginPopup">
        <div class="popup">
            <button class="close" onclick="hidePopup('loginPopup')">&times;</button>
            <h2>Login</h2>
            <form action="adminhomepage.php" method="POST">
                <input type="email" name="login_email" placeholder="Email Address" required>
                <input type="password" name="login_password" placeholder="Password" required>
                <button type="submit" name="login_submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Sign Up Popup -->
    <div class="popup-overlay" id="signupPopup" onclick="hidePopupOnClickOutside(event, 'signupPopup')">
        <div class="popup">
            <button class="close" onclick="hidePopup('signupPopup')">&times;</button>
            <h2>Sign Up</h2>
            <form class="signup-form" action="adminhomepage.php" method="POST">
                <input type="text" name="last_name" placeholder="Last Name" value="<?php echo isset($lastName) ? htmlspecialchars($lastName) : ''; ?>" required class="half-width">
                <input type="text" name="first_name" placeholder="First Name" value="<?php echo isset($firstName) ? htmlspecialchars($firstName) : ''; ?>" required class="half-width">
                <input type="text" name="username" placeholder="Username" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required class="half-width">
                <input type="email" name="signup_email" placeholder="Email Address" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required class="half-width">
                <input type="password" name="signup_password" placeholder="Password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required class="half-width">
                <input type="password" name="confirm_password" placeholder="Confirm Password" value="<?php echo isset($confirmPassword) ? htmlspecialchars($confirmPassword) : ''; ?>" required class="half-width">
                <label><input type="checkbox" name="terms_conditions"> Agree to Terms and Conditions</label>
                <button type="submit" name="signup_submit">Sign Up</button>
            </form>
        </div>
    </div>

    <script>
        function showPopup(popupId) {
            document.getElementById(popupId).style.display = 'flex';
        }

        // Function to hide a popup
        function hidePopup(popupId) {
            document.getElementById(popupId).style.display = 'none';
        }

        // Hide popup when clicking outside of the popup
        function hidePopupOnClickOutside(event, popupId) {
            if (event.target === document.getElementById(popupId)) {
                hidePopup(popupId);
            }
        }

        // Show login popup after successful signup
        function showLoginPopup() {
            hidePopup('signupPopup');  // Hide the sign-up popup
            showPopup('loginPopup');   // Show the login popup
        }
    </script>
</body>
</html>
