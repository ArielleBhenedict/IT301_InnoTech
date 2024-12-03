<?php
// Database connection details
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "productsdb";

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$hostName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbName");
    $pdo->exec("USE $dbName");

    // Create tables if they don't exist
    $createCategoriesTable = "
        CREATE TABLE IF NOT EXISTS categories (
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(255) NOT NULL UNIQUE
        );
    ";

    $createProductTable = "
        CREATE TABLE IF NOT EXISTS product (
            productid INT AUTO_INCREMENT PRIMARY KEY,
            category_id INT NOT NULL,
            productname VARCHAR(255) NOT NULL,
            productdescription TEXT,
            quantity INT NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            image VARCHAR(255) NULL,
            FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
        );
    ";

    $pdo->exec($createCategoriesTable);
    $pdo->exec($createProductTable);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
