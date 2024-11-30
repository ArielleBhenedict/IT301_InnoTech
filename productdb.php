<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "innotech";

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$hostName;dbname=$dbName", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all products
    $query = "SELECT * FROM `product`";
    $stmt = $pdo->query($query);

    // Fetch results as an associative array
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display products
    foreach ($products as $product) {
        echo "Product ID: " . $product['productid'] . "<br>";
        echo "Name: " . $product['productname'] . "<br>";
        echo "Description: " . $product['productdescription'] . "<br>";
        echo "Quantity: " . $product['quantity'] . "<br>";
        echo "Price: " . $product['price'] . "<br><br>";
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
