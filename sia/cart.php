<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php
session_start();

// Include the database connection
require 'productdb.php';

// Handle removing items from the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    $removeProductId = filter_input(INPUT_POST, 'remove_product_id', FILTER_VALIDATE_INT);

    if ($removeProductId) {
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] == $removeProductId) {
                unset($_SESSION['cart'][$key]); // Remove the item
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
                break;
            }
        }
    }
}

// Fetch product details from the database and validate the cart
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $item) {
        $stmt = $pdo->prepare("SELECT productname, price FROM product WHERE productid = :id");
        $stmt->execute(['id' => $item['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Update session cart with database values
            $_SESSION['cart'][$key]['name'] = $product['productname'];
            $_SESSION['cart'][$key]['price'] = $product['price'];
        } else {
            // Remove items no longer in the database
            unset($_SESSION['cart'][$key]);
        }
    }

    // Re-index the cart array
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}
?>
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
    <div class="cart-profile">
        <button>
            <i class="fas fa-shopping-cart"></i> Cart
        </button>
        <a href="profile.php">
            <button>
                <i class="fas fa-user"></i> Profile
            </button>
        </a>
    </div>
</header>

<main class="cart_dashboard">
    <section class="product-section">
        <div class="product-list">
            <?php
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<p>Your cart is empty.</p>";
            } else {
                echo "<h2>Your Cart</h2>";
                $totalQuantity = 0;
                $totalAmount = 0;
                echo "<div class='product-list'>";
                foreach ($_SESSION['cart'] as $item) {
                    $totalQuantity += $item['quantity'];
                    $totalAmount += $item['price'] * $item['quantity'];

                    echo "<div class='product-card' data-price='{$item['price']}'>";
                    echo "<p>Product: " . htmlspecialchars($item['name']) . "</p>";
                    echo "<p>Price: $" . number_format($item['price'], 2) . "</p>";
                    echo "<p>Quantity: <input type='number' class='quantity-input' value='{$item['quantity']}' min='1'></p>";
                    echo "<p>Total: $" . number_format($item['price'] * $item['quantity'], 2) . "</p>";
                    echo "<form method='POST' action='cart.php'>";
                    echo "<input type='hidden' name='remove_product_id' value='" . $item['id'] . "'>";
                    echo "<button type='submit' name='remove_from_cart'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </section>
    <aside class="order-summary">
        <h3>Customer Details</h3>
        <p><strong>Name:</strong> <span id="customer-name-display">Lebron James</span></p>
        <p><strong>Contact No.:</strong> <span id="customer-contact-display">123-456-789</span></p>
        <p><strong>Email Address:</strong> <span id="customer-email-display">lebron@example.com</span></p>
        <button id="editCustomerBtn">Edit</button>
        <button id="saveCustomerBtn" style="display:none;">Save</button>
        <hr>
        <h3>Receipt</h3>
        <div class="receipt">
            <div id="receipt-items"></div>
            <p id="receipt-total-price"></p>
        </div>
        <hr>
        <div class="pickup">
            <h3>Pick-up Date & Time</h3>
            <input type="date" id="pickup-date">
            <input type="time" id="pickup-time">
        </div>
        <div class="total-summary">
            <p id="total-quantity">Total Quantity: 0</p>
            <p id="total-amount">Total Amount: $0.00</p>
        </div>
        <button class="preorder-button" id="openModalBtn">Pre-Order</button>
    </aside>
</main>


<script>

document.getElementById('editCustomerBtn').addEventListener('click', () => {
    document.getElementById('customer-name-display').innerHTML = `<input type="text" id="customer-name-input" value="${document.getElementById('customer-name-display').innerText}">`;
    document.getElementById('customer-contact-display').innerHTML = `<input type="text" id="customer-contact-input" value="${document.getElementById('customer-contact-display').innerText}">`;
    document.getElementById('customer-email-display').innerHTML = `<input type="email" id="customer-email-input" value="${document.getElementById('customer-email-display').innerText}">`;
    
    document.getElementById('editCustomerBtn').style.display = 'none';
    document.getElementById('saveCustomerBtn').style.display = 'inline-block';
});

// Save the edited customer details
document.getElementById('saveCustomerBtn').addEventListener('click', () => {
    const updatedName = document.getElementById('customer-name-input').value;
    const updatedContact = document.getElementById('customer-contact-input').value;
    const updatedEmail = document.getElementById('customer-email-input').value;

    // Update the displayed customer details
    document.getElementById('customer-name-display').innerText = updatedName;
    document.getElementById('customer-contact-display').innerText = updatedContact;
    document.getElementById('customer-email-display').innerText = updatedEmail;

    // Hide the save button and show the edit button again
    document.getElementById('saveCustomerBtn').style.display = 'none';
    document.getElementById('editCustomerBtn').style.display = 'inline-block'; // Ensure this line is present
});

// Function to update cart totals and receipt
function updateCart() {
    let totalQuantity = 0;
    let totalAmount = 0;
    const receiptItems = document.getElementById('receipt-items');
    const receiptTotalPrice = document.getElementById('receipt-total-price');

    receiptItems.innerHTML = ''; // Clear previous receipt items

    document.querySelectorAll('.product-card').forEach(card => {
        const productName = card.querySelector('p').innerText.split(': ')[1];
        const productPrice = parseFloat(card.getAttribute('data-price'));
        const quantity = parseInt(card.querySelector('.quantity-input').value);
        const itemTotal = productPrice * quantity;

        if (quantity > 0) {
            totalQuantity += quantity;
            totalAmount += itemTotal;

            // Add item details to the receipt
            const item = document.createElement('p');
            item.innerText = `${productName} - Quantity: ${quantity} - $${itemTotal.toFixed(2)}`;
            receiptItems.appendChild(item);
        }
    });

    // Update total price in receipt and summary
    receiptTotalPrice.innerText = `Total: $${totalAmount.toFixed(2)}`;
    document.getElementById('total-quantity').innerText = `Total Quantity: ${totalQuantity}`;
    document.getElementById('total-amount').innerText = `Total Amount: $${totalAmount.toFixed(2)}`;
}

// Initialize cart totals on load
document.addEventListener('DOMContentLoaded', () => {
    updateCart();
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', updateCart);
    });
});
</script>
</body>
</html>
