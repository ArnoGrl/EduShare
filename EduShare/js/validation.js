
document.getElementById('registerForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password.length < 8) {
        alert('Le mot de passe doit contenir au moins 8 caractères.');
        event.preventDefault();
    } else if (password !== confirmPassword) {
        alert('Les mots de passe ne correspondent pas.');
        event.preventDefault();
    }
});