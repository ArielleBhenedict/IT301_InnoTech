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
    <div class="logo">LOGO</div>
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
            for ($i = 0; $i < 8; $i++) {
                echo '
                    <div class="product-card">
                        <div class="product-image"></div>
                        <p>Product Name</p>
                        <p>No. of Stocks</p>
                        <p>Price</p>
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
            <p>Items</p>
            <p>Price</p>
        </div>
        <hr>
        <div class="pickup">
            <h3>Pick-up Date & Time</h3>
            <input type="date">
            <input type="time">
        </div>
        <div class="total-summary">
            <p>Total Quantity</p>
            <p>Total Amount</p>
        </div>
        <!-- Button to open the modal -->
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
                <div class="product-image"></div>
                <div class="product-info">
                    <p><strong>Product Name:</strong> Example Product</p>
                    <p><strong>No. of Stocks:</strong> 15</p>
                    <p><strong>Quantity:</strong> <input type="number" min="1" value="1" class="quantity-input"></p>
                    <p><strong>Price:</strong> $20</p>  
                </div>
            </div>
            <div class="modal-body-right">
                <p><strong>Customer Name:</strong> Lebron James</p>
                <p><strong>Contact Number:</strong> 123-456-789</p>
                <p><strong>Location:</strong> General Trias</p>
                <p><strong>Pick-up Date & Time:</strong> <input type="date"> <input type="time"></p>
                <p><strong>Total Quantity:</strong> 1</p>
                <p><strong>Total Amount:</strong> $20</p>
            </div>
        </div>
        <div class="modal-footer">
            <!-- Confirm order button, triggers redirect -->
            <button class="confirm-order-btn" id="confirmOrderBtn">Confirm Order</button>
        </div>
    </div>
</div>



<script>
// Get the modal element
var modal = document.getElementById("orderModal");

// Get the button that opens the modal
var openModalBtn = document.getElementById("openModalBtn");

// Get the <span> element that closes the modal
var closeBtn = document.getElementsByClassName("close-btn")[0];

// Get the confirm order button
var confirmOrderBtn = document.getElementById("confirmOrderBtn");

// When the user clicks the button, open the modal
openModalBtn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeBtn.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}   

// When the user clicks the confirm order button, redirect to order_details.php
confirmOrderBtn.onclick = function() { 

    modal.style.display = "none";
    window.location.href = "cart.php"; // Replace with your actual order details page
}
</script>
