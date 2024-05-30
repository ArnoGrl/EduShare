<?php
// Démarrage de la session pour accéder aux données de session
session_start();

// Si l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
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
    <!-- Barre de navigation avec message de bienvenue et bouton de déconnexion -->
    <nav class="top-nav">
        <div class="welcome-message">
            Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </div>
        <a href="logout.php" class="logout-button">Déconnexion</a>
    </nav>

    <!-- En-tête avec formulaire de recherche -->
    <header>
        <div class="search-container">
            <form method="GET" action="recherche.php">
                <input type="search" name="query" placeholder="Rechercher des tutoriels..." id="search-bar" value="<?php echo htmlspecialchars($_GET['query'] ?? '', ENT_QUOTES); ?>">
            </form>
        </div>
    </header>

    <!-- Lien pour retourner à l'accueil du site -->
    <div class="back-to-home">
        <a href="../index.php" class="back-to-home">Retour à l'accueil</a>
    </div>

    <main class="main-content">
        <!-- Section affichant les résultats de recherche -->
        <section class="tutoriel-tendance">
            <h2>Résultats de la recherche</h2>
            <?php
            // Définition du chemin vers le fichier CSV contenant les données des tutoriels
            $csvFile = '../data/vignette.csv';

            // Récupération du mot-clé de recherche à partir des données envoyées par GET
            $query = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : '';

            // Ouverture du fichier CSV pour lecture
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                $resultsFound = false;  // Indicateur si des résultats ont été trouvés

                // Lecture ligne par ligne du fichier CSV
                while (($data = fgetcsv($handle, 10000000, ";")) !== FALSE) {
                    // Recherche de la correspondance du mot-clé dans le titre du tutoriel
                    if ($query === '' || strpos(strtolower($data[1]), $query) !== FALSE) {
                        $resultsFound = true;
                        echo '<div class="tutoriel">';
                        echo '<img src="' . htmlspecialchars($data[3]) . '" alt="' . htmlspecialchars($data[1]) . '">';
                        echo '<div class="tuto-info">';
                        echo '<h3>' . htmlspecialchars($data[1]) . '</h3>';
                        echo '<p>' . htmlspecialchars($data[2]) . '</p>';
                        echo '<a href="../pages/tutoriel.php?id=' . htmlspecialchars($data[0]) . '">Accéder au tutoriel</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                // Fermeture du fichier après la lecture
                fclose($handle);

                // Si aucun résultat trouvé, affiche un message
                if (!$resultsFound) {
                    echo '<p>Aucun tutoriel trouvé pour "' . htmlspecialchars($query) . '".</p>';
                }
            }
            ?>
        </section>
    </main>
    <!-- Pied de page avec droits d'auteur -->
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>