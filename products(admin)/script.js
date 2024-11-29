document.addEventListener("DOMContentLoaded", () => {
  const productGrid = document.getElementById("product-grid");
  const categoryButtons = document.querySelectorAll(".category");
  const addProductButton = document.getElementById("add-product-btn");
  const deleteProductButtons = document.querySelectorAll(".delete-btn");
  const editProductButtons = document.querySelectorAll(".edit-btn");

  let products = []; // Array to store fetched products

  // Fetch the products data (from a server or static JSON file)
  fetch("https://api.example.com/products")
    .then(response => response.json())
    .then(data => {
      products = data; // Store the products in the global array
      displayProducts(); // Display all products initially
    })
    .catch(error => console.error("Error fetching products:", error));

  // Function to display the products
  function displayProducts(filterCategory = "all") {
    productGrid.innerHTML = ""; // Clear current product grid

    // Filter the products based on the selected category
    const filteredProducts = filterCategory === "all"
      ? products
      : products.filter(product => product.category === filterCategory);

    // Loop through the filtered products and display them in the grid
    filteredProducts.forEach(product => {
      const productCard = document.createElement("div");
      productCard.classList.add("product-card");
      productCard.innerHTML = `
        <div class="image-placeholder">
          <img src="${product.image_url}" alt="${product.name}" />
        </div>
        <h3>${product.name}</h3>
        <p>Category: ${product.category}</p>
        <p>Price: $${product.price}</p>
        <p>No. of Stocks: ${product.stocks}</p>
        <button class="edit-btn" data-id="${product.id}">Edit</button>
        <button class="delete-btn" data-id="${product.id}">Delete</button>
      `;
      productGrid.appendChild(productCard);
    });

    // Re-attach event listeners for the new dynamically added buttons
    attachEventListeners();
  }

  // Function to attach event listeners for edit and delete buttons
  function attachEventListeners() {
    // Edit product buttons
    editProductButtons.forEach(button => {
      button.addEventListener("click", (e) => {
        const productId = e.target.getAttribute("data-id");
        alert(`You clicked edit for product ID: ${productId}`);
        // You can redirect to an edit page or open a modal to edit the product
      });
    });

    // Delete product buttons
    deleteProductButtons.forEach(button => {
      button.addEventListener("click", (e) => {
        const productId = e.target.getAttribute("data-id");
        const productIndex = products.findIndex(product => product.id == productId);
        if (productIndex !== -1) {
          products.splice(productIndex, 1); // Remove the product from the array
          displayProducts(); // Re-render the product list
        }
      });
    });
  }

  // Add product button (example)
  addProductButton.addEventListener("click", () => {
    alert("Redirecting to Add Product page");
    // Here you could open a modal or redirect to another page to add a new product
  });

  // Add category filtering
  categoryButtons.forEach(button => {
    button.addEventListener("click", () => {
      const category = button.getAttribute("data-category");
      displayProducts(category); // Filter and display products based on category
    });
  });
});
