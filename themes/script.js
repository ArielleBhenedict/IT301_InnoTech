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
    alert(`Theme "${themeName}" applied successfully!`);
  });
  