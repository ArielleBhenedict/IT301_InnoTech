<?php
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    $sql = "SELECT * FROM products WHERE name LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    // Display results (you can style this further)
    while ($product = mysqli_fetch_assoc($result)) {
        echo "<div class='product'>";
        echo "<h3>" . htmlspecialchars($product['name']) . "</h3>";
        echo "<p>Price: $" . number_format($product['price'], 2) . "</p>";
        echo "</div>";
    }
}
?>
