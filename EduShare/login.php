<?php
session_start();
include 'php/config.php';
// Chemin vers le fichier CSV
$csvFilePath = CSV_REGISTER;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $fileHandle = fopen($csvFilePath, 'r');
    $isLoginSuccess = false;

    while (($data = fgetcsv($fileHandle)) !== FALSE) {
        if ($data[0] == $username && password_verify($password, $data[1])) {
            $isLoginSuccess = true;
            $_SESSION['username'] = $username;
            $_SESSION['profile_image'] = $data[2];
            break;
        }
    }
    fclose($fileHandle);

    if ($isLoginSuccess) {
        header('Location: index.php');
        exit;
    } else {
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
    <form method="post" action="login.php">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <?php if (isset($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <button type="submit">Se connecter</button>
    </form>
    Pas encore inscrit ? <a href="register.php">Créez un compte ici</a>
</body>

</html>