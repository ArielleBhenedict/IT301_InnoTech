let categories = [];
let products = [];

// Load saved data (from localStorage or session)
function loadData() {
    const savedCategories = JSON.parse(localStorage.getItem('categories'));
    const savedProducts = JSON.parse(localStorage.getItem('products'));

    if (savedCategories) categories = savedCategories;
    if (savedProducts) products = savedProducts;

    updateCategoryList();
    updateProductList();
}

// Function to add a new category
function addCategory() {
    const categoryName = document.getElementById('category-name').value;
    if (categoryName && !categories.includes(categoryName)) {
        categories.push(categoryName);
        document.getElementById('category-name').value = ''; // Clear the input field
        updateCategoryList();
        updateProductCategoryOptions();
    } else {
        alert('Please enter a valid category name.');
    }
}

// Function to add a new product
function addProduct() {
    const productName = document.getElementById('product-name').value;
    const productDescription = document.getElementById('product-description').value;
    const productStocks = document.getElementById('product-stocks').value;
    const productPrice = document.getElementById('product-price').value;
    const productCategory = document.getElementById('product-category').value;

    if (productName && productDescription && productStocks && productPrice && productCategory) {
        const product = {
            name: productName,
            description: productDescription,
            stocks: productStocks,
            price: productPrice,
            category: productCategory
        };
        products.push(product);
        clearProductForm();
        updateProductList();
    } else {
        alert('Please fill out all product fields.');
    }
}

// Function to update the category list on the page
function updateCategoryList() {
    const categoryList = document.getElementById('category-list');
    categoryList.innerHTML = ''; // Clear the list before updating

    categories.forEach(category => {
        const categoryDiv = document.createElement('div');
        categoryDiv.className = 'category-item';
        categoryDiv.innerHTML = `
            <h4>${category}</h4>
            <div class="product-cards" id="product-cards-${category}"></div>
        `;
        categoryList.appendChild(categoryDiv);
    });
}

// Function to update the product list grouped by category
function updateProductList() {
    categories.forEach(category => {
        const categoryProducts = products.filter(product => product.category === category);
        const productCardsContainer = document.getElementById(`product-cards-${category}`);
        productCardsContainer.innerHTML = ''; // Clear current products

        categoryProducts.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.innerHTML = `
                <p><strong>${product.name}</strong></p>
                <p>${product.description}</p>
                <p>Stocks: ${product.stocks}</p>
                <p>Price: $${product.price}</p>
            `;
            productCardsContainer.appendChild(productCard);
        });
    });
}

// Function to update the category options in the product form
function updateProductCategoryOptions() {
    const productCategorySelect = document.getElementById('product-category');
    productCategorySelect.innerHTML = '<option value="">Select Category</option>'; // Clear existing options

    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        productCategorySelect.appendChild(option);
    });
}

// Function to clear the product form fields
function clearProductForm() {
    document.getElementById('product-name').value = '';
    document.getElementById('product-description').value = '';
    document.getElementById('product-stocks').value = '';
    document.getElementById('product-price').value = '';
    document.getElementById('product-category').value = '';
}

// Function to save the data (to localStorage)
function saveData() {
    localStorage.setItem('categories', JSON.stringify(categories));
    localStorage.setItem('products', JSON.stringify(products));
    alert('Data saved successfully!');
}

loadData(); // Initial load

// Function to load products from the server (via PHP)
function loadProducts() {
    fetch('productsdb.php')
        .then(response => response.json())
        .then(data => {
            displayProducts(data);
        })
        .catch(error => {
            console.error("Error loading products:", error);
        });
}

// Function to display products grouped by category
function displayProducts(productsGroupedByCategory) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = ''; // Clear current products

    for (const category in productsGroupedByCategory) {
        const categoryDiv = document.createElement('div');
        categoryDiv.className = 'category-item';

        const categoryHeader = document.createElement('h4');
        categoryHeader.textContent = category;
        categoryDiv.appendChild(categoryHeader);

        const productCardsContainer = document.createElement('div');
        productCardsContainer.className = 'product-cards';

        productsGroupedByCategory[category].forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.innerHTML = `
                <p><strong>${product.productname}</strong></p>
                <p>${product.productdescription}</p>
                <p>Stocks: ${product.quantity}</p>
                <p>Price: $${product.price}</p>
            `;
            productCardsContainer.appendChild(productCard);
        });

        categoryDiv.appendChild(productCardsContainer);
        productList.appendChild(categoryDiv);
    }
}

// Call the loadProducts function when the page loads
window.onload = loadProducts;
