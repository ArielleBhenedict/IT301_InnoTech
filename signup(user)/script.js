document.addEventListener("DOMContentLoaded", () => {
    // Sign up form validation or other client-side logic can go here (optional)
    const signupForm = document.getElementById('signup-form');
    
    signupForm.addEventListener('submit', (event) => {
        const username = signupForm.querySelector('input[name="username"]').value;
        const email = signupForm.querySelector('input[name="email"]').value;
        const password = signupForm.querySelector('input[name="password"]').value;

        // Basic validation before submitting form
        if (!username || !email || !password) {
            alert("Please fill in all fields!");
            event.preventDefault();
        }
    });
});
