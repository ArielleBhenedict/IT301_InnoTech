<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="first-page">
        <h1>Welcome to Our System</h1>
        <button id="login-btn">Login</button> <!-- Trigger Login Popup -->

        <!-- Popup Window for Login -->
        <div id="login-popup" class="popup">
            <div class="popup-content">
                <span id="close-popup">&times;</span>
                <h2>Login to Your Account</h2>
                <form id="login-form" action="login.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Login</button>
                    <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
