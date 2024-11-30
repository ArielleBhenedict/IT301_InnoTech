document.getElementById('login-btn').addEventListener('click', function() {
    document.getElementById('login-popup').style.display = 'block';
});

// Close popup when clicking outside of it
window.onclick = function(event) {
    if (event.target === document.getElementById('login-popup')) {
        document.getElementById('login-popup').style.display = 'none';
    }
};
