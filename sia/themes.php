<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Theme</title>
  <style>
/* General Reset */
{
margin: 0;
padding: 0;
box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #e8f6fa;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #d9edf5;
}

.logo {
  font-size: 24px;
  font-weight: bold;
}

.search-bar {
  display: flex;
  gap: 5px;
}

.search-bar input {
  padding: 10px;
  border: 1px solid #d9edf5;
  border-radius: 5px;
}

.search-bar button {
  padding: 5px 10px;
  border: none;
  background-color: #0099cc;
  color: white;
  border-radius: 5px;
}

.location-cart {
  display: flex;
  align-items: center;
  gap: 10px;
}

aside {
  width: 20%;
  padding: 10px;
  background-color: #cfeefc;
}

.category {
  display: block;
  width: 100%;
  padding: 10px;
  margin: 5px 0;
  background-color: #66c5e8;
  border: none;
  color: white;
  border-radius: 5px;
  cursor: pointer;
}


  /* Main Form */
  .form-container {
    background:  #e8f6fa;
    border-radius: 10px;
    padding: 30px;
    width: 400px;
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }

  h3 {
    margin-top: 30px;
    margin-bottom: 10px;
    font-size: 18px;
    color: #555;
  }

  .form-group {
    margin-bottom: 15px;
  }

  label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
    color: #555;
  }

  input[type="text"],
  input[type="file"],
  input[type="color"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
  }

  button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }

  button:hover {
    background-color: #0056b3;
  }

</style>
</head>
<body>
  <header>
    <div class="logo">LOGO</div>
    <nav>
      <a href="#">Products</a>
      <a href="#">Inventory</a>
      <a href="#">Themes</a>
    </nav>
    <div class="location">
      <select>
        <option value="location">Location</option>
      </select>
      <div class="profile">⚫</div>
    </div>
  </header>
  <main>
    <div class="form-container">
      <h2>Edit Theme</h2>
      <form id="theme-form">
        <div class="form-group">
          <label for="theme-name">Theme Name</label>
          <input type="text" id="theme-name">
        </div>
        <div class="form-group">
          <label for="system-name">System Name</label>
          <input type="text" id="system-name">
        </div>
        <div class="form-group">
          <label for="logo">Logo</label>
          <input type="file" id="logo" accept="image/*">
        </div>
        <div class="form-group">
          <label for="background-image">Background Image</label>
          <input type="file" id="background-image" accept="image/*">
        </div>
        <h3>Color Palette</h3>
        <div class="form-group">
          <label for="header-footer-color">Header & Footer</label>
          <input type="color" id="header-footer-color">
        </div>
        <div class="form-group">
          <label for="background-color">Background Color</label>
          <input type="color" id="background-color">
        </div>
        <div class="form-group">
          <label for="main-text-color">Main Text Color</label>
          <input type="color" id="main-text-color">
        </div>
        <div class="form-group">
          <label for="description-text-color">Description Text Color</label>
          <input type="color" id="description-text-color">
        </div>
        <div class="form-group">
          <label for="button-color">Button Color</label>
          <input type="color" id="button-color">
        </div>
        <div class="form-group">
          <label for="card-color">Card Color</label>
          <input type="color" id="card-color">
        </div>
        <div class="form-group">
          <label for="category-card-color">Category Card Color</label>
          <input type="color" id="category-card-color">
        </div>
        <div class="form-group">
          <label for="product-color">Product</label>
          <input type="color" id="product-color">
        </div>
        <div class="form-group">
          <label for="location">Location</label>
          <input type="text" id="location">
        </div>
        <button type="button" id="apply-theme">Apply Theme</button>
      </form>
    </div>
  </main>
 <script>
document.getElementById('apply-theme').addEventListener('click', () => {
    const themeName = document.getElementById('theme-name').value;
    const systemName = document.getElementById('system-name').value;
    const headerFooterColor = document.getElementById('header-footer-color').value;
    const backgroundColor = document.getElementById('background-color').value;
    const mainTextColor = document.getElementById('main-text-color').value;

    // Apply colors to the page
    document.body.style.backgroundColor = backgroundColor;
    document.querySelector('header').style.backgroundColor = headerFooterColor;
    document.body.style.color = mainTextColor;

    // Display applied theme name
    alert(Theme "${themeName}" applied successfully!);
  });
</script>
</body>
</html>
