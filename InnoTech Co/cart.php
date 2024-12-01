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
            // Example dynamic product data with prices
            $products = [
                ["name" => "Product A", "price" => 20],
                ["name" => "Product B", "price" => 30],
                ["name" => "Product C", "price" => 25],
                ["name" => "Product D", "price" => 15],
                // Add more products here as needed
            ];

            foreach ($products as $product) {
                echo '
                    <div class="product-card" data-price="' . $product['price'] . '">
                        <div class="product-image"></div>
                        <p>' . $product['name'] . '</p>
                        <p>No. of Stocks: 15</p>
                        <p>Price: $' . $product['price'] . '</p>
                        <button class="delete-button">Delete</button>
                        <input type="number" min="0" value="0" class="quantity-input">
                    </div>
                ';
            }
            ?>
        </div>
    </section>

    <aside class="order-summary">
        <h3>Customer Details</h3>
        <p>Name</p>
        <p>Contact No.</p>
        <p>Email Address</p>
        <hr>
        <h3>Receipt</h3>
        <div class="receipt">
            <p id="items">Items</p>
            <p id="price">Price</p>
        </div>
        <hr>
        <div class="pickup">
            <h3>Pick-up Date & Time</h3>
            <input type="date" id="pickup-date">
            <input type="time" id="pickup-time">
        </div>
        <div class="total-summary">
            <p id="total-quantity">Total Quantity</p>
            <p id="total-amount">Total Amount</p>
        </div>
        <button class="preorder-button" id="openModalBtn">Pre-Order</button>
    </aside>
</main>

<!-- Order Details Modal -->
<div id="orderModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Order Details</h2>
            <span class="close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <div class="modal-body-left">
                <!-- Dynamic product details will be inserted here -->
                <div id="modal-product-list"></div>
            </div>
            <div class="modal-body-right">
                <div class="customer-details">
                    <p><strong>Customer Name:</strong> Lebron James</p>
                    <p><strong>Contact Number:</strong> 123-456-789</p>
                    <p><strong>Location:</strong> General Trias</p>
                    <p><strong>Pick-up Date & Time:</strong> <span id="modal-pickup-date"></span> <span id="modal-pickup-time"></span></p>
                    <p><strong>Total Quantity:</strong> <span id="modal-total-quantity"></span></p>
                    <p><strong>Total Amount:</strong> $<span id="modal-total-amount"></span></p>
                </div>
                <!-- Scrollable customer details area -->
                
            </div>
        </div>
        <div class="modal-footer">
            <button class="confirm-order-btn" id="confirmOrderBtn">Confirm Order</button>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const preorderButton = document.getElementById("openModalBtn");
    const modal = document.getElementById("orderModal");
    const modalProductList = document.getElementById("modal-product-list");
    const totalQuantityElem = document.getElementById("total-quantity");
    const totalAmountElem = document.getElementById("total-amount");
    const itemsElem = document.getElementById("items");
    const priceElem = document.getElementById("price");

    // Function to update total price and quantity
    function updateCart() {
        let totalQuantity = 0;
        let totalPrice = 0;
        let cartItems = '';
        let productsInCart = [];

        document.querySelectorAll('.product-card').forEach(function(card) {
            const quantityInput = card.querySelector(".quantity-input");
            const productPrice = parseFloat(card.getAttribute('data-price'));
            const productName = card.querySelector("p").innerText;
            const productImage = card.querySelector(".product-image").style.backgroundImage;
            const quantity = parseInt(quantityInput.value);

            if (quantity > 0) {
                totalQuantity += quantity;
                totalPrice += productPrice * quantity;
                cartItems += `<p>${productName} - Quantity: ${quantity} - $${productPrice}</p>`;
                productsInCart.push({
                    name: productName,
                    price: productPrice,
                    quantity: quantity,
                    image: productImage,
                    total: productPrice * quantity
                });
            }
        });

        totalQuantityElem.innerText = `Total Quantity: ${totalQuantity}`;
        totalAmountElem.innerText = `Total Amount: $${totalPrice.toFixed(2)}`;
        itemsElem.innerHTML = cartItems;
        priceElem.innerText = `$${totalPrice.toFixed(2)}`;
        
        return productsInCart;
    }

    // Update cart on quantity change
    document.querySelectorAll(".quantity-input").forEach(input => {
        input.addEventListener('input', updateCart);
    });

    // Add event listener for delete buttons
    document.querySelectorAll(".delete-button").forEach(button => {
        button.addEventListener("click", function(event) {
            const productCard = event.target.closest(".product-card"); // Get the parent card element
            if (productCard) {
                productCard.remove(); // Remove the card from the DOM
                updateCart(); // Update the cart totals after deletion
            }
        });
    });

    // When the Pre-Order button is clicked, show the modal with updated values
    preorderButton.addEventListener('click', function() {
        const productsInCart = updateCart(); // Get updated product info from cart
        const modalProductList = document.getElementById("modal-product-list");

        // Clear previous products in modal
        modalProductList.innerHTML = '';

        // Populate modal with specific product details
        productsInCart.forEach(function(product) {
            const productElement = document.createElement("div");
            productElement.classList.add("modal-product");

            productElement.innerHTML = `
                <div class="product-image" style="background-image: ${product.image};"></div>
                <div class="product-info">
                    <p><strong>Product Name:</strong> ${product.name}</p>
                    <p><strong>No. of Stocks:</strong> 15</p>
                    <p><strong>Quantity:</strong> ${product.quantity}</p>
                    <p><strong>Price:</strong> $${product.price}</p>
                    <p><strong>Total:</strong> $${product.total}</p>
                </div>
            `;

            modalProductList.appendChild(productElement);
        });

        // Set pickup date and time
        let modalPickupDate = document.getElementById('pickup-date').value;
        let modalPickupTime = document.getElementById('pickup-time').value;
        document.getElementById('modal-pickup-date').innerText = modalPickupDate;
        document.getElementById('modal-pickup-time').innerText = modalPickupTime;

        // Update total quantity and amount
        document.getElementById('modal-total-quantity').innerText = totalQuantityElem.innerText;
        document.getElementById('modal-total-amount').innerText = totalAmountElem.innerText;

        // Show the modal
        modal.style.display = "block";
    });

    // Modal close functionality
    document.querySelector(".close-btn").addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Close modal when clicking outside the modal
    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    // Confirm order action
    document.getElementById('confirmOrderBtn').addEventListener('click', function() {
        alert("Order Confirmed!");  // Redirect to order confirmation page or perform other actions.
        modal.style.display = "none";
    });

    // Initialize cart
    updateCart();
});

</script>