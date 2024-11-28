// Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // Get all buttons with the class "edit-btn"
    const editButtons = document.querySelectorAll(".edit-btn");
  
    // Add a click event listener to each button
    editButtons.forEach((button) => {
      button.addEventListener("click", () => {
        // Example: Display an alert or log a message
        alert(`You clicked ${button.textContent.trim()} for editing.`);
        
      });
    });
  });
  