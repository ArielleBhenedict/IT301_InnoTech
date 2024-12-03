<?php
// Include the database connection
include('productdb.php');

// Fetch all products from the database
function fetchProducts($pdo) {
    // Adjusted query to correctly fetch product data
    $stmt = $pdo->query("SELECT p.productid, p.productname, p.productdescription, p.quantity, p.price, c.category_name 
                         FROM product p
                         JOIN categories c ON p.category_id = c.category_id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Fetch all products from the database
try {
    $products = fetchProducts($pdo);  // Assuming fetchProducts is defined to get all products
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Check if a delete request was made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare delete query
    $stmt = $pdo->prepare("DELETE FROM product WHERE productid = :productid");
    $stmt->execute(['productid' => $delete_id]);

    // Redirect back to the products page after deletion
    header("Location: product.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="header">
        <div class="logo">LOGO</div>
        <nav class="menu">
            <a href="index.html" class="active">Products</a>
            <a href="edit-products.php">Manage Products</a>
            <a href="#">Inventory</a>
            <a href="#">Themes</a>
        </nav>

        <div class="location">
        <i class="fas fa-map-marker-alt"></i>
        <select>
            <option value="Location">Location</option>
            <option value="General Trias">General Trias</option>
        </select>
    </div>
        <div class="profile">
            <img src="profile-icon.png" alt="Profile" style="width: 30px; height: 30px;">
        </div>
    </div>

    <div class="content">
        <h2>Products</h2>
        <div class="product-container">
            <div class="product-list">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <h4><?php echo htmlspecialchars($product['productname']); ?></h4>
                        <p><?php echo htmlspecialchars($product['productdescription']); ?></p>
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($product['quantity']); ?></p>
                        <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>

                        <!-- Delete Button -->
                        <form action="product.php" method="get" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <input type="hidden" name="delete_id" value="<?php echo $product['productid']; ?>">  <!-- Ensure correct field name -->
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Edit Button -->
        <div class="edit-section">
            <a href="edit-products.php" class="edit-btn">Manage Products & Categories</a>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>