<?php
// Démarrage de la session pour accéder aux données de session.
session_start();

// Vérification si l'utilisateur est connecté, sinon redirection vers la page de connexion.
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
    <!-- Barre de navigation avec message de bienvenue et bouton de déconnexion -->
    <nav class="top-nav">
        <div class="welcome-message">
            Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </div>
        <a href="logout.php" class="logout-button">Déconnexion</a>
    </nav>

    <!-- En-tête avec champ de recherche (non fonctionnel ici) -->
    <header>
        <div class="search-container">
            <input type="search" placeholder="Rechercher des tutoriels..." id="search-bar">
        </div>
    </header>

    <main>
        <!-- Lien pour retourner à la page d'accueil -->
        <div class="back-to-home">
            <a href="../index.php" class="back-to-home">Retour à l'accueil</a>
        </div>

        <!-- Section qui affiche les tutoriels de la catégorie sélectionnée -->
        <section class="tutoriel-tendance">
            <h2>Tutoriels dans la catégorie : <?php echo htmlspecialchars($_GET['categorie']); ?></h2>
            <?php
            // Chemin vers le fichier CSV contenant les données des tutoriels
            $csvFile = '../data/vignette.csv';
            // Récupération de la catégorie à partir de l'URL (GET request)
            $selectedCategory = isset($_GET['categorie']) ? $_GET['categorie'] : '';

            // Vérification si une catégorie a bien été sélectionnée
            if ($selectedCategory != '') {
                // Ouverture du fichier CSV en lecture seule
                if (($handle = fopen($csvFile, "r")) !== FALSE) {
                    // Lecture des données du fichier CSV ligne par ligne
                    while (($data = fgetcsv($handle, 10000000, ";")) !== FALSE) {
                        // Comparaison de la catégorie du tutoriel avec la catégorie sélectionnée
                        if (strtolower(trim($data[6])) == strtolower(trim($selectedCategory))) {
                            // Affichage du tutoriel correspondant à la catégorie
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
                    // Fermeture du fichier CSV après lecture
                    fclose($handle);
                } else {
                    // Message d'erreur en cas de problème à l'ouverture du fichier
                    echo "<p>Erreur d'ouverture du fichier CSV.</p>";
                }
            } else {
                // Message si aucune catégorie n'est sélectionnée
                echo "<p>Aucune catégorie sélectionnée.</p>";
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