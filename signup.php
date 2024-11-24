<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
        <?php
        require_once "connection.php"; // Ensure the connection file is included

        $errors = []; // Array to hold error messages

        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Validate inputs
            if (empty($fullName) || empty($email) || empty($username) || empty($password) || empty($passwordRepeat)) {
                $errors[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is not valid.";
            }
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }
            if ($password !== $passwordRepeat) {
                $errors[] = "Passwords do not match.";
            }

            // Check for existing email or username
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $errors[] = "Email or Username already exists!";
            }else {
                // Insert new user into the database
                $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password) VALUES (?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ssss", $fullName, $email, $username, $passwordHash);
                    $stmt->execute();
                    header("Location: login.php");
                    exit();
                } else {
                    echo "<div class='alert'>Something went wrong. Please try again.</div>";
                }
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
        <?php
        require_once "connection.php"; // Ensure the connection file is included

        $errors = []; // Array to hold error messages

        if (isset($_POST["submit"])) {
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Validate inputs
            if (empty($fullName) || empty($email) || empty($username) || empty($password) || empty($passwordRepeat)) {
                $errors[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email is not valid.";
            }
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }
            if ($password !== $passwordRepeat) {
                $errors[] = "Passwords do not match.";
            }

            // Check for existing email or username
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $errors[] = "Email or Username already exists!";
            }else {
                // Insert new user into the database
                $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password) VALUES (?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ssss", $fullName, $email, $username, $passwordHash);
                    $stmt->execute();
                    header("Location: login.php");
                    exit();
                } else {
                    echo "<div class='alert'>Something went wrong. Please try again.</div>";
                }
            }
        }
        ?>
<div class="top">

<form action="signup.php" method="post">
<div class="login-container">
<div class="login-logo">
    <img src="assets/images/ilogo.png" alt="loginlogo">
</div>
<div class="login-form-container">
<h1 class="intellisearchsign" style="text-align:center;">Sign in to IntelliSearch</h1>
    <div class="login-form">
        <input type="text" class="login-form-control" name="fullname" placeholder="Full Name:" required>
    </div>
    <div class="login-form">
        <input type="email" class="login-form-control" name="email" placeholder="Email:" required>
    </div>
    <div class="login-form">
        <input type="text" class="login-form-control" name="username" placeholder="Username:" required>
    </div>
    <div class="login-form">
        <input type="password" class="login-form-control" name="password" placeholder="Password:" required>
    </div>
    <div class="login-form">
        <input type="password" class="login-form-control" name="repeat_password" placeholder="Repeat Password:" required>
    </div>

        <input type="submit" class="login-btn" value="Register" name="submit">
    
    <div class = "link">
    <p>Already Registered? <a href="login.php">Login Here</a></p> 
    <?php
        if (!empty($errors)) {
            echo "<div class='alert'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        ?>
</div>
</div>
</div>

</form>
</div>
</body>
</html>
