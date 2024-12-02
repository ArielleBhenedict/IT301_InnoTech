<?php
require_once 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    try {
        // Query the database for the user
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['userpassword'])) {
            // Start a session and store user details (optional)
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to a dashboard or another page
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="first-page">
        <button id="login-btn">Login</button>
    </div>

    <!-- Login Popup -->
    <div id="login-popup" class="popup">
        <div class="popup-content">
            <form action="login.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" value="Login" name="login">
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
