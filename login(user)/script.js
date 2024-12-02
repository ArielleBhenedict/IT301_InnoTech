document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("login-btn");
    const loginPopup = document.getElementById("login-popup");

    loginBtn.addEventListener("click", () => {
        loginPopup.style.display = "block";
    });

    // Close popup when clicking outside of it
    loginPopup.addEventListener("click", (event) => {
        if (event.target === loginPopup) {
            loginPopup.style.display = "none";
        }
    });
});
