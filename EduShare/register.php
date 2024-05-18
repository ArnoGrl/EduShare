<?php
session_start();
include 'php/config.php';
// Chemin vers le fichier CSV
$csvFilePath = CSV_REGISTER;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $imagePath = '';

        // Gestion du téléchargement de l'image
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = $_FILES['profile_image']['name'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $uploadFileDir = 'images/user_picture/';
                $dest_path = $uploadFileDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $imagePath = $dest_path;
                }
            }
        }

        if ($imagePath === '') {
            $imagePath = 'images/user_picture/default.png'; // Image par défaut si aucune n'est téléchargée
        }

        // Ouverture du fichier CSV en mode écriture
        $fileHandle = fopen($csvFilePath, 'a'); // 'a' pour append
        if ($fileHandle !== false) {
            // Écriture des données dans le fichier CSV
            fputcsv($fileHandle, [$username, $hashedPassword, $imagePath]);
            fclose($fileHandle);
        }

        header('Location: login.php'); // Redirection vers la page de connexion
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
    <p>Avez-vous déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    <script src="js/validation.js"></script>

    <?php
    if (isset($error)) {
        echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
    }
    ?>
</body>

</html>