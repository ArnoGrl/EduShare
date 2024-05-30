<?php
// Démarrage de la session pour pouvoir utiliser les variables de session
session_start();

// Inclusion du fichier de configuration pour accéder à des constantes, ici le chemin vers le fichier CSV des utilisateurs
include 'php/config.php';

// Affectation du chemin du fichier CSV à une variable
$csvFilePath = CSV_REGISTER;

// Vérification si la méthode de la requête HTTP est POST, ce qui indique que le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données envoyées par le formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ouverture du fichier CSV en lecture
    $fileHandle = fopen($csvFilePath, 'r');
    $isLoginSuccess = false; // Variable pour suivre si la connexion est réussie

    // Lecture ligne par ligne du fichier CSV
    while (($data = fgetcsv($fileHandle)) !== FALSE) {
        // Vérification si les données du fichier correspondent aux données saisies par l'utilisateur
        if ($data[0] == $username && password_verify($password, $data[1])) {
            $isLoginSuccess = true;
            // Si authentification réussie, stockage du nom d'utilisateur et de l'image de profil dans la session
            $_SESSION['username'] = $username;
            $_SESSION['profile_image'] = $data[2];
            break; // Sortie de la boucle après succès
        }
    }
    // Fermeture du fichier CSV après lecture
    fclose($fileHandle);

    // Redirection vers la page d'accueil si la connexion est réussie
    if ($isLoginSuccess) {
        header('Location: index.php');
        exit;
    } else {
        // Stockage d'un message d'erreur si les identifiants sont incorrects
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="/CSS/register.css">
    <title>Connexion</title>
</head>

<body>
    <!-- Formulaire de connexion -->
    <form method="post" action="login.php">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <!-- Affichage du message d'erreur si les identifiants sont incorrects -->
        <?php if (isset($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <button type="submit">Se connecter</button>
    </form>
    <!-- Lien vers la page d'inscription pour les nouveaux utilisateurs -->
    Pas encore inscrit ? <a href="register.php">Créez un compte ici</a>
</body>

</html>