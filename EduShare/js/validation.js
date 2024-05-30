// Ajoute un écouteur d'événement pour le formulaire avec l'ID 'registerForm'
// Cet écouteur va écouter l'événement 'submit' du formulaire
document.getElementById('registerForm').addEventListener('submit', function(event) {
    // Récupère la valeur du champ de mot de passe avec l'ID 'password'
    const password = document.getElementById('password').value;
    // Récupère la valeur du champ de confirmation du mot de passe avec l'ID 'confirm_password'
    const confirmPassword = document.getElementById('confirm_password').value;

    // Vérifie si la longueur du mot de passe est inférieure à 8 caractères
    if (password.length < 8) {
        // Affiche une alerte si le mot de passe est trop court
        alert('Le mot de passe doit contenir au moins 8 caractères.');
        // Empêche l'envoi du formulaire
        event.preventDefault();
    // Vérifie si le mot de passe et la confirmation du mot de passe ne correspondent pas
    } else if (password !== confirmPassword) {
        // Affiche une alerte si les mots de passe ne correspondent pas
        alert('Les mots de passe ne correspondent pas.');
        // Empêche l'envoi du formulaire
        event.preventDefault();
    }
});
