<?php
// Include the database connection
include('productdb.php');

// Fetch all categories for the product category dropdown
$categories = [];
try {
    $stmt = $pdo->query("SELECT category_id, category_name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Fetch all products for display and editing
$products = [];
try {
    $stmt = $pdo->query("SELECT productid, productname, productdescription, quantity, price, category_id FROM product");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Handling form submission for adding a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addProduct'])) {
        // Insert new product into the database
        $stmt = $pdo->prepare("INSERT INTO product (productname, productdescription, quantity, price, category_id)
                               VALUES (:productName, :productDescription, :productStocks, :productPrice, :categoryId)");
        $stmt->execute([
            'productName' => $_POST['productName'],
            'productDescription' => $_POST['productDescription'],
            'productStocks' => $_POST['productStocks'],
            'productPrice' => $_POST['productPrice'],
            'categoryId' => $_POST['categoryName']
        ]);
        
    }

    // Handling adding a new category
    if (isset($_POST['addCategory'])) {
        // Insert new category into the categories table
        $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (:categoryName)");
        $stmt->execute(['categoryName' => $_POST['newCategoryName']]);
        
    }

    // Handling product updates
    if (isset($_POST['updateProduct'])) {
        // Update the product details in the database
        foreach ($_POST['productid'] as $index => $productId) {
            $stmt = $pdo->prepare("UPDATE product SET productname = ?, productdescription = ?, quantity = ?, price = ?, category_id = ? WHERE productid = ?");
            $stmt->execute([
                $_POST['productname'][$index],
                $_POST['productdescription'][$index],
                $_POST['quantity'][$index],
                $_POST['price'][$index],
                $_POST['category_id'][$index],
                $productId
            ]);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Products & Categories</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="header">
        <div class="logo">LOGO</div>
        <nav class="menu">
            <a href="index.html" class="active">Products</a>
            <a href="#">Inventory</a>
            <a href="#">Themes</a>
        </nav>
        <div class="location">
            <select>
                <option value="default">Location</option>
                <option value="store1">Store 1</option>
                <option value="store2">Store 2</option>
            </select>
        </div>

        <div class="profile">
            <a href ="">
            <button>
            <i class="fas fa-user"></i> Profile
              </button>
        </a>
</div>
    </div>

    <div class="content">
        <h2>Manage Products & Categories</h2>

        <h3>Add New Category</h3>
                <form action="edit-products.php" method="post">
                    <input type="text" name="newCategoryName" placeholder="Enter New Category" required>
                    <button type="submit" name="addCategory">Add Category</button>
                </form>
        
                <h3>Edit Products</h3>
                <form action="edit-products.php" method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <input type="hidden" name="productid[]" value="<?php echo $product['productid']; ?>">
                                    <td><input type="text" name="productname[]" value="<?php echo htmlspecialchars($product['productname']); ?>" required></td>
                                    <td><input type="text" name="productdescription[]" value="<?php echo htmlspecialchars($product['productdescription']); ?>" required></td>
                                    <td><input type="number" name="quantity[]" value="<?php echo htmlspecialchars($product['quantity']); ?>" required></td>
                                    <td><input type="number" name="price[]" value="<?php echo htmlspecialchars($product['price']); ?>" required></td>
                                    <td>
                                        <select name="category_id[]" required>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['category_id']; ?>" <?php echo $category['category_id'] == $product['category_id'] ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="updateProduct">Save Changes</button>
                </form>
           

            <!-- Add New Product Card -->
            <div class="product-card">
                <h3>Add New Product</h3>
                <form action="edit-products.php" method="post">
                <input type="file" id="product-image" accept="image/*" required>
                    <input type="text" name="productName" placeholder="Product Name" required>
                    <input type="text" name="productDescription" placeholder="Product Description" required>
                    <input type="number" name="productStocks" placeholder="Quantity" required>
                    <input type="number" name="productPrice" placeholder="Price" required>
                    <select name="categoryName" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['category_id']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <button type="submit" name="addProduct">Add Product</button>
                </form>
            </div>

           
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
