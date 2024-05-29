<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <title>EduShare - Catégorie</title>
</head>

<body>
    <nav class="top-nav">
        <div class="welcome-message">
            Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </div>
        <a href="logout.php" class="logout-button">Déconnexion</a>
    </nav>
    <header>
        <div class="search-container">
            <input type="search" placeholder="Rechercher des tutoriels..." id="search-bar">
        </div>
    </header>
    <main>
        <div class="back-to-home">
            <a href="../index.php" class="back-to-home">Retour à l'accueil</a>
        </div>
        <section class="tutoriel-tendance">
            <h2>Tutoriels dans la catégorie : <?php echo htmlspecialchars($_GET['categorie']); ?></h2>
            <?php
            // Chemin vers le fichier CSV
            $csvFile = '../data/vignette.csv';
            $selectedCategory = isset($_GET['categorie']) ? $_GET['categorie'] : '';

            // Vérifier si une catégorie est sélectionnée
            if ($selectedCategory != '') {
                // Ouverture du fichier en lecture seule
                if (($handle = fopen($csvFile, "r")) !== FALSE) {
                    // Boucle à travers les données du fichier CSV
                    while (($data = fgetcsv($handle, 10000000, ";")) !== FALSE) {
                        // Vérifier si la catégorie correspond à la catégorie sélectionnée
                        if (strtolower(trim($data[6])) == strtolower(trim($selectedCategory))) {
                            echo '<div class="tutoriel">';
                            // Assurez-vous que l'index des données correspond bien à votre structure CSV
                            echo '<img src="' . htmlspecialchars($data[3]) . '" alt="' . htmlspecialchars($data[1]) . '">';
                            echo '<div class="tuto-info">';
                            echo '<h3>' . htmlspecialchars($data[1]) . '</h3>';
                            echo '<p>' . htmlspecialchars($data[2]) . '</p>';
                            echo '<a href="../pages/tutoriel.php?id=' . htmlspecialchars($data[0]) . '">Accéder au tutoriel</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    fclose($handle);
                } else {
                    echo "<p>Erreur d'ouverture du fichier CSV.</p>";
                }
            } else {
                echo "<p>Aucune catégorie sélectionnée.</p>";
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>