document.addEventListener("DOMContentLoaded", () => {
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
  