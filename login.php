<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
session_start();
$errorMessage = "";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Include the database connection (PDO)
    require_once "connection.php";

    try {
        // Prepare and execute query with PDO
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = "yes";
                $_SESSION["username"] = $user["username"];
                $_SESSION["display_name"] = $user["fullname"]; // Assuming 'fullname' is the correct column
                header("Location: home.php");
                die();
            } else {
                $errorMessage = "Password does not match";
            }
        } else {
            $errorMessage = "Username does not match";
        }
    } catch (PDOException $e) {
        // Handle connection or query errors
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

       </div>
       <form action="login.php" method="post">
    <div class="login-container">
        <div class="login-logo">
            <img src="assets/images/ilogo.png" alt="loginlogo">
        </div>
        <div class="login-form-container">
            <h1 class="intellisearchsign" style="text-align:center;">Log in to IntelliSearch</h1>
            <div class="login-form">
                <input type="text" placeholder="Enter username:" name="username" class="login-form-control" required>
            </div>
            <div class="login-form">
                <input type="password" placeholder="Enter Password:" name="password" class="login-form-control" required>
            </div>
            
                <input type="submit" value="Login" name="login" class="login-btn">
           
            <div class = "link"><p>Not registered yet <a href="signup.php">Register Here</a></p>
        <?php if (!empty($errorMessage)): ?>
            <div class='alert'><?php echo $errorMessage; ?></div>
        <?php endif; ?>
    </div>
    </div>
        </div>
    </div>
</form>
</body>
</html>
 