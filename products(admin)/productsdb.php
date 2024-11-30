<?php
// Database connection details
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "productsdb"; // Database name

try {
    // Connect to MySQL server (no specific database selected yet)
    $pdo = new PDO("mysql:host=$hostName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbName");

    // Now, connect to the newly created database
    $pdo->exec("USE $dbName");

    // SQL queries to create tables if they don't exist
    $createCategoriesTable = "
        CREATE TABLE IF NOT EXISTS categories (
            category_id INT AUTO_INCREMENT PRIMARY KEY,
            category_name VARCHAR(255) NOT NULL UNIQUE
        );
    ";

    $createProductTable = "
        CREATE TABLE IF NOT EXISTS product (
            productid INT AUTO_INCREMENT PRIMARY KEY,  -- Ensure correct column name 'productid'
            category_id INT NOT NULL,
            productname VARCHAR(255) NOT NULL,
            productdescription TEXT,
            quantity INT NOT NULL,
            price DECIMAL(10, 2) NOT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE  -- Added CASCADE to ensure referential integrity
        );
    ";

    // Execute the queries to create tables if they don't exist
    $pdo->exec($createCategoriesTable);
    $pdo->exec($createProductTable);

    echo "Database and tables are ready to use.";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch all products from the database
function fetchProducts($pdo) {
    // Adjusted query to correctly fetch product data
    $stmt = $pdo->query("SELECT p.productid, p.productname, p.productdescription, p.quantity, p.price, c.category_name 
                         FROM product p
                         JOIN categories c ON p.category_id = c.category_id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>