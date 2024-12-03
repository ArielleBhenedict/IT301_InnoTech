<?php
require 'productdb.php';
session_start();

// Fetch categories and products
function fetchCategoriesAndProducts($pdo) {
    $stmt = $pdo->query("
        SELECT categories.category_id, categories.category_name, 
               product.productid, product.productname, product.price, product.quantity 
        FROM categories
        LEFT JOIN product ON categories.category_id = product.category_id
        ORDER BY categories.category_id, product.productname
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$data = fetchCategoriesAndProducts($pdo);

// Group products by category
$categories = [];
$products = [];
foreach ($data as $row) {
    $categories[$row['category_id']] = $row['category_name'];
    if (!empty($row['productid'])) {
        $products[$row['category_id']][] = $row;
    }
}

// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $productName = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
    $productPrice = filter_input(INPUT_POST, 'product_price', FILTER_VALIDATE_FLOAT);

    if ($productId && $productName && $productPrice) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product exists in the cart
        $productExists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                $item['quantity']++;
                $productExists = true;
                break;
            }
        }

        // Add new product
        if (!$productExists) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => htmlspecialchars($productName),
                'price' => $productPrice,
                'quantity' => 1,
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #d7eef3;
}

/* Header ng lahat*/
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f2f8fa;
    padding: 15px 30px;
    border-bottom: 1px solid #b3d6e0;
}

.logo {
    font-size: 30px;
    font-weight: bold;
    color: #3b4c5a;
}


.logo img {
    height: 35px;
}

.search-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
    margin: 0 20px;
}

.search-bar input {
    padding: 10px;
    border: 1px solid #b3d6e0;
    border-radius: 15px;
    width: 30%;
    margin-right: 13px;
}

.search-bar button {
    background-color: #3b4c5a;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 10px 20px;
    cursor: pointer;
}

.location select {
    padding: 10px;
    border: 1px solid #b3d6e0;
    border-radius: 10px;
    background-color: #ffffff;
}

.cart-profile button {
    background-color: #3b4c5a;
    color: white;
    border: none;
    border-radius: 50%;
    padding: 12px;
    cursor: pointer;
    font-size: 14px;
    margin-left: 10px;
}
/*Homepage-------------------------------------*/
  aside {
    width: 20%;
    padding: 10px;
    background-color: #cfeefc;
  }
  
  .category {
    display: block;
    width: 100%;
    padding: 10px;
    margin: 15px 0;
    background-color: #60b2c3;
    border: none;
    color: white;
    border-radius: 15px;
    cursor: pointer;
  }
  
  main {
    display: flex;
  }
  
  .product-card {
    background-color: #abdce6;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    height: 280px; 
    transition: transform 0.3s, box-shadow 0.3s; 
    margin-top: 25px;
  }
  
  .product-card:hover,.category:hover,.preorder-button:hover, .cart-profile button:hover {
    transform: scale(1.05); /* Slightly enlarge the card */
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2); /* Enhance the shadow */
    background-color: #9ccde7; /* Optional: change background color on hover */
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease; /* Smooth transition */ 
  }
  
  .image-placeholder {
    width: 100%;
    height: 150px; 
    background-color: #e0f0f5;
    border-radius: 10px;
    margin-bottom: 10px;
  }
  
  .product-card h3 {
    font-size: 18px;
    margin-bottom: 5px;
  }
  
  .product-card p {
    margin: 5px 0;
  }
    </style>
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
                (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)
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
        <?php foreach ($categories as $categoryId => $categoryName): ?>
            <button class="category" data-category="<?= $categoryId; ?>">
                <?= htmlspecialchars($categoryName); ?>
            </button>
        <?php endforeach; ?>
    </aside>
    <?php foreach ($categories as $categoryId => $categoryName): ?>
        <?php if (isset($products[$categoryId])): ?>
            <div class="category-section" id="category-<?= $categoryId; ?>">
                <div class="products">
                    <?php foreach ($products[$categoryId] as $product): ?>
                        <div class="product-card">
                            <div class="image-placeholder"></div>
                            <h3><?= htmlspecialchars($product['productname']); ?></h3>
                            <p>Stock: <?= $product['quantity']; ?></p>
                            <p>Price: $<?= number_format($product['price'], 2); ?></p>
                            <form method="POST" action="home.php">
                                <input type="hidden" name="product_id" value="<?= $product['productid']; ?>">
                                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['productname']); ?>">
                                <input type="hidden" name="product_price" value="<?= $product['price']; ?>">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</main>
<script>
 document.addEventListener("DOMContentLoaded", () => {
        // Get all category buttons and sections
        const categoryButtons = document.querySelectorAll(".category");
        const categorySections = document.querySelectorAll(".category-section");

        // Function to display the selected category
        function showCategory(categoryId) {
            categorySections.forEach(section => {
                if (categoryId === "all" || section.id === `category-${categoryId}`) {
                    section.style.display = "block"; // Show matching category
                } else {
                    section.style.display = "none"; // Hide non-matching categories
                }
            });
        }

        // Add event listeners to category buttons
        categoryButtons.forEach(button => {
            button.addEventListener("click", () => {
                const categoryId = button.dataset.category;
                showCategory(categoryId);
            });
        });

        // Show all products by default
        showCategory("all");
    });

    
     </script>
</body>
</html>
