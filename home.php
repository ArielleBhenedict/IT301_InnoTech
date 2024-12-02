<?php
// Include the database connection file
require 'productdb.php';

// Fetch categories and products from the database
function fetchCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function fetchProducts($pdo) {
    $stmt = $pdo->query("SELECT p.productid, p.productname, p.productdescription, p.quantity, p.price, c.category_name 
                         FROM product p
                         JOIN categories c ON p.category_id = c.category_id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$categories = fetchCategories($pdo);
$products = fetchProducts($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="homepage.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<header class="header">
    <a href="home.php" class="logo">
        <img src="pansamantala.png" alt="Logo" class="logo-image">
    </a>
    <div class="search-bar">
        <input type="text" placeholder="Search">
        <button>Search</button>
    </div>
    <div class="location">
        <i class="fas fa-map-marker-alt"></i>
        <select>
            <option value="Location">Location</option>
            <option value="General Trias">General Trias</option>
            <option value="Dasmarinas">Dasmarinas</option>
            <option value="Trece Martires">Trece Martires</option>
            <option value="Silang">Silang</option>
            <option value="New York Cubao">New York Cubao</option>
        </select>
    </div>
    <a href="cart.php">
        <div class="cart-profile">
            <button>
                <i class="fas fa-shopping-cart"></i> Cart
            </button>
        </div>
    </a>
    <a href="profile.php">
        <button>
            <i class="fas fa-user"></i> Profile
        </button>
    </a>
</header>
<main>
    <aside>
        <button class="category" data-category="all">All</button>
        <?php foreach ($categories as $category): ?>
            <button class="category" data-category="<?= $category['category_id']; ?>">
                <?= htmlspecialchars($category['category_name']); ?>
            </button>
        <?php endforeach; ?>
    </aside>
    <section class="product-grid" id="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-card" data-category="<?= $product['category_id']; ?>">
                <div class="image-placeholder"></div>
                <h3><?= htmlspecialchars($product['productname']); ?></h3>
                <p>No. of Stocks: <?= $product['quantity']; ?></p>
                <p>Price: <?= number_format($product['price'], 2); ?></p>
                <p>Category: <?= htmlspecialchars($product['category_name']); ?></p>
            </div>
        <?php endforeach; ?>
    </section>
</main>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const productGrid = document.getElementById("product-grid");
        const categoryButtons = document.querySelectorAll(".category");

        // Function to filter products by category
        function filterProducts(categoryId) {
            const productCards = document.querySelectorAll(".product-card");
            productCards.forEach(card => {
                if (categoryId === "all" || card.dataset.category === categoryId) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        // Add click event listeners to category buttons
        categoryButtons.forEach(button => {
            button.addEventListener("click", () => {
                const categoryId = button.getAttribute("data-category");
                filterProducts(categoryId);
            });
        });
    });
</script>
</body>
</html>
