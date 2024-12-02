<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "users"; // Change to the new database name

// Try to connect using PDO
try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$hostName", $dbUser, $dbPassword);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
    $pdo->exec($sql);
    
    // Select the new database
    $pdo->exec("USE `$dbName`");

    // SQL queries to create tables
    $tableSql = "
    CREATE TABLE IF NOT EXISTS `users` (
      `user_id` INT(11) NOT NULL AUTO_INCREMENT,
      `userfullname` VARCHAR(128) NOT NULL,
      `useremail` VARCHAR(255) NOT NULL UNIQUE,
      `username` VARCHAR(255) NOT NULL UNIQUE DEFAULT 'Guest',
      `userpassword` VARCHAR(255) NOT NULL,
      `userprofilepic` VARCHAR(255) NOT NULL DEFAULT 'default-avatar.png',
      PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

     CREATE TABLE IF NOT EXISTS `admins` (
      `admin_id` INT(11) NOT NULL AUTO_INCREMENT,
      `adminfullname` VARCHAR(128) NOT NULL,
      `adminemail` VARCHAR(255) NOT NULL UNIQUE,
      `adminusername` VARCHAR(255) NOT NULL UNIQUE DEFAULT 'Guest',
      `adminpassword` VARCHAR(255) NOT NULL,
      `adminprofilepic` VARCHAR(255) NOT NULL DEFAULT 'default-avatar.png',
      PRIMARY KEY (`admin_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    ";

    // Execute table creation SQL
    $pdo->exec($tableSql);

} catch (PDOException $e) {
    // Catch any errors and display a message
    echo "Connection failed: " . $e->getMessage();
}
?>