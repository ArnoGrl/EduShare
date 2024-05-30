<?php
// Démarrage de la session pour gérer les données de session.
session_start();
// Inclusion du fichier de configuration où sont stockées certaines constantes.
include 'php/config.php';

// Chemin d'accès au fichier CSV où les données utilisateur seront stockées.
$csvFilePath = CSV_REGISTER;

// Vérification si la méthode utilisée pour la requête est POST (envoi du formulaire).
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire.
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérification de la validité du mot de passe.
    if (strlen($password) < 8) {
        // Erreur si le mot de passe est inférieur à 8 caractères.
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirmPassword) {
        // Erreur si les mots de passe ne correspondent pas.
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Hachage du mot de passe pour le stockage sécurisé.
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $imagePath = '';

        // Gestion de l'upload d'image de profil.
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = $_FILES['profile_image']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

            // Vérification si l'extension est permise.
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $uploadFileDir = 'images/user_picture/';
                $dest_path = $uploadFileDir . $newFileName;

                // Déplacement du fichier dans le dossier de destination.
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagePath = $dest_path;
                }
            }
        }

        // Attribution d'une image par défaut si aucune image n'a été téléchargée.
        if ($imagePath === '') {
            $imagePath = 'images/user_picture/default.png';
        }

        // Ouverture du fichier CSV en mode ajout ('a' pour append).
        $fileHandle = fopen($csvFilePath, 'a');
        if ($fileHandle !== false) {
            // Écriture des données utilisateur dans le fichier CSV.
            fputcsv($fileHandle, [$username, $hashedPassword, $imagePath]);
            fclose($fileHandle); // Fermeture du fichier.
        }

        // Redirection vers la page de connexion après l'inscription.
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" type="text/css" href="/CSS/register.css">
    <title>Inscription</title>
</head>

<body>
    <!-- Formulaire d'inscription avec enctype spécifié pour l'upload de fichier. -->
    <form id="registerForm" method="post" action="register.php" enctype="multipart/form-data">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <label for="confirm_password">Confirmez le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
        <label for="profile_image">Image de profil:</label>
        <input type="file" id="profile_image" name="profile_image">
        <button type="submit" id="submitBtn">S'inscrire</button>
    </form>
    <!-- Lien vers la page de connexion pour les utilisateurs déjà inscrits. -->
    <p>Avez-vous déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    <script src="js/validation.js"></script>

    <!-- Affichage d'un message d'erreur si applicable. -->
    <?php
    if (isset($error)) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    ?>
</body>

</html>