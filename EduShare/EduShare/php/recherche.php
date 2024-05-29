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
    <link rel="stylesheet" href="../CSS/recherche.css">
    <title>EduShare - Recherche</title>
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
            <form method="GET" action="recherche.php">
                <input type="search" name="query" placeholder="Rechercher des tutoriels..." id="search-bar" value="<?php echo htmlspecialchars($_GET['query'] ?? '', ENT_QUOTES); ?>">
            </form>
        </div>
    </header>
    <div class="back-to-home">
        <a href="../index.php" class="back-to-home">Retour à l'accueil</a>
    </div>
    <main class="main-content">

        <section class="tutoriel-tendance">
            <h2>Résultats de la recherche</h2>
            <?php
            // Chemin vers le fichier CSV
            $csvFile = '../data/vignette.csv';

            // Récupérer le mot-clé de recherche
            $query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

            // Ouverture du fichier en lecture seule
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                $resultsFound = false;

                // Boucle à travers les données du fichier CSV
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    // Recherche par mot clé dans le titre du tutoriel (colonne 2 du CSV)
                    if ($query === '' || strpos(strtolower($data[1]), $query) !== FALSE) {
                        $resultsFound = true;
                        echo '<div class="tutoriel">';
                        // Assurez-vous que l'index des données correspond bien à votre structure CSV
                        echo '<img src="' . htmlspecialchars($data[3]) . '" alt="' . htmlspecialchars($data[1]) . '">';
                        echo '<div class="tuto-info">';
                        echo '<h3>' . htmlspecialchars($data[1]) . '</h3>';
                        echo '<p>' . htmlspecialchars($data[2]) . '</p>';
                        echo '<a href="pages/tutoriel.php?id=' . htmlspecialchars($data[0]) . '">Accéder au tutoriel</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                fclose($handle);

                if (!$resultsFound) {
                    echo '<p>Aucun tutoriel trouvé pour "' . htmlspecialchars($query) . '".</p>';
                }
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>