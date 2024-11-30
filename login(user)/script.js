document.addEventListener("DOMContentLoaded", () => {
    // Login form validation or other client-side logic can go here (optional)
    const loginForm = document.getElementById('login-form');
    
    loginForm.addEventListener('submit', (event) => {
        const username = loginForm.querySelector('input[name="username"]').value;
        const password = loginForm.querySelector('input[name="password"]').value;

        // Basic validation before submitting form
        if (!username || !password) {
            alert("Please fill in all fields!");
            event.preventDefault();
        }
    });
});
