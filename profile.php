<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
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
    <a href="cart.php">
        <button>
            <i class="fas fa-shopping-cart"></i> Cart
        </button>
    </a>
    <button>
        <i class="fas fa-user"></i> Profile
    </button>
</div>
    </header>

    <main class="dashboard">
    <div class="profile-section">
    <img src="lebron.jpg" 
         alt="LeBron James" class="profile-pic">
    <h1>Lebron James Protacio Rizal Mercado y Alonzo Realonda</h1>
</div>

        <section class="recent-orders">
            <h2>Recent Orders</h2>
            <div class="order-list">
                <?php
                for ($i = 0; $i < 5; $i++) {
                    echo '
                        <div class="order-card">
                            <div class="product-image"></div>
                            <p>Product Name</p>
                            <p>No. of Stocks</p>
                            <p>Price</p>
                            <button>Buy Again</button>
                        </div>
                    ';
                }
                ?>
            </div>
        </section>

        <section class="recently-visited">
            <h2>Recently Visited</h2>
            <div class="visited-list">
                <?php
                for ($i = 0; $i < 5; $i++) {
                    echo '
                        <div class="visited-card">
                            <div class="product-image"></div>
                            <p>Product Name</p>
                            <p>No. of Stocks</p>
                            <p>Price</p>
                            <button>Add to Cart</button>
                        </div>
                    ';
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>
