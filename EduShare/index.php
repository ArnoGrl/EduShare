<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>EduShare - Accueil</title>
</head>

<body>
    <header>
        <div class="search-container">
            <input type="search" placeholder="Rechercher des tutoriels..." id="search-bar">
        </div>
    </header>
    <main>
        <section class="tutoriel-tendance">
            <h2>Nos Tuto Tendance</h2>
            <?php
            // Chemin vers le fichier CSV
            $csvFile = 'data/tutoriels.csv';

            // Ouverture du fichier en lecture seule
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Sauter l'en-tête si présent (décommentez la ligne suivante si votre CSV a un en-tête)
                // fgetcsv($handle, 1000, ",");

                // Boucle à travers les données du fichier CSV
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    echo '<div class="tutoriel">';
                    // Assurez-vous que l'index des données correspond bien à votre structure CSV
                    echo '<img src="' . htmlspecialchars($data[3]) . '" alt="' . htmlspecialchars($data[1]) . '">';
                    echo '<div class="tuto-info">';
                    echo '<h3>' . htmlspecialchars($data[1]) . '</h3>';
                    echo '<p>' . htmlspecialchars($data[2]) . '</p>';
                    echo '<a href="pages/tutoriel.php?id=' . htmlspecialchars($data[0]) . '">Accéder au tutoriel</a>';
                    echo '<span>' . str_repeat('⭐', intval($data[4])) . '</span>';
                    echo '</div>';
                    echo '</div>';
                }
                fclose($handle);
            }
            ?>

        </section>
        <p><a href="/pages/formulaire.php">Soumettre un nouveau tutoriel</a></p>
    </main>
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>