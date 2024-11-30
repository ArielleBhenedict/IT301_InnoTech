<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="signup-container">
        <form action="signup.php" method="POST">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" name="confirm-password" id="confirm-password" required>
            <input type="submit" value="Signup" name="signup">
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>
