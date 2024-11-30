document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("login-btn");
    const loginPopup = document.getElementById("login-popup");
    const closePopup = document.getElementById("close-popup");

    // Show the login popup when clicking the login button
    loginBtn.addEventListener("click", () => {
        loginPopup.style.display = "block";
    });

    // Close the popup when clicking the close button
    closePopup.addEventListener("click", () => {
        loginPopup.style.display = "none";
    });

    // Close the popup if the user clicks outside the popup
    window.addEventListener("click", (event) => {
        if (event.target === loginPopup) {
            loginPopup.style.display = "none";
        }
    });
});
