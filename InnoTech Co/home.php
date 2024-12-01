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
</a>

    <a href="profile.php">
        <button>
            <i class="fas fa-user"></i> Profile
        </button>
    </a>
</div>
</header>


  <main>
    <aside>
      <button class="category" data-category="all">All</button>
      <button class="category" data-category="electronics">Electronics</button>
      <button class="category" data-category="fashion">Fashion</button>
      <button class="category" data-category="home">Home</button>
    </aside>
    <section class="product-grid">
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
      <div class="product-card">
        <div class="image-placeholder"></div>
        <h3>Product Name</h3>
        <p>No. of Stocks</p>
        <p>Price</p>
      </div>
    </section>
  </main>
  <script> document.addEventListener("DOMContentLoaded", () => {
    const productGrid = document.getElementById("product-grid");
    const categoryButtons = document.querySelectorAll(".category");
    let products = []; // Global variable to store fetched products
  
    // Fetch products from the API
    fetch("https://api.example.com/products")
      .then(response => response.json())
      .then(data => {
        products = data; // Store the fetched products
        displayProducts(); // Display all products initially
      })
      .catch(error => console.error("Error fetching products:", error));
  
    // Function to display products
    function displayProducts(filterCategory = "all") {
      productGrid.innerHTML = ""; // Clear existing products
  
      // Filter products based on the selected category
      const filteredProducts =
        filterCategory === "all"
          ? products
          : products.filter(product => product.category === filterCategory);
  
      // Generate product cards dynamically
      filteredProducts.forEach(product => {
        const productCard = document.createElement("div");
        productCard.classList.add("product-card");
        productCard.innerHTML = `
          <div class="image-placeholder"></div>
          <h3>${product.name}</h3>
          <p>No. of Stocks: ${product.stocks}</p>
          <p>Price: ${product.price}</p>
        `;
        productGrid.appendChild(productCard);
      });
    }
  
    // Add click event listeners to category buttons
    categoryButtons.forEach(button => {
      button.addEventListener("click", () => {
        const category = button.getAttribute("data-category");
        displayProducts(category); // Filter and display products
      });
    });
  });
  </script>
</body>
</html>