<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
            <img src="lebron.jpg" alt="LeBron James" class="profile-pic">
            <h1>Lebron James Protacio Rizal Mercado y Alonzo Realonda</h1>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <button class="tab-btn active" onclick="showTab('history')">History</button>
            <button class="tab-btn" onclick="showTab('orders')">Orders</button>
        </div>

        <!-- History Tab Content -->
        <section id="history" class="tab-content active">
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

        <!-- Orders Tab Content -->
        <section id="orders" class="tab-content">
            <h2>Order Status</h2>
            <div class="order-list">
                <?php
                for ($i = 0; $i < 5; $i++) {
                    echo '
                        <div class="order-card">
                            <div class="product-image"></div>
                            <p>Product Name</p>
                            <p>Status: <span class="status preparing">Preparing</span></p>
                            <p>Quantity: <span class="quantity">2</span></p>
                            <p>Total Amount: <span class="total-amount">$40.00</span></p>
                        </div>
                    ';
                }
                ?>
            </div>
        </section>
    </main>

    <script>
        function showTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            const tabBtns = document.querySelectorAll('.tab-btn');
            tabBtns.forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(tabName).classList.add('active');
            const activeTabBtn = document.querySelector(`.tab-btn[onclick="showTab('${tabName}')"]`);
            activeTabBtn.classList.add('active');
        }
    </script>
</body>
</html>
