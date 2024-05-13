<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
                // Boucle à travers les données du fichier CSV
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    echo '<div class="tutoriel">';
                    echo '<img src="path_to_image/' . htmlspecialchars($data[0]) . '" alt="' . htmlspecialchars($data[1]) . '">';
                    echo '<div class="tuto-info">';
                    echo '<h3>' . htmlspecialchars($data[1]) . '</h3>';
                    echo '<p>' . htmlspecialchars($data[2]) . '</p>';
                    echo '<a href="#">Accéder au tutoriel</a>';
                    echo '<span>⭐⭐⭐⭐⭐</span>';
                    echo '</div>';
                    echo '</div>';
                }
                fclose($handle);
            }
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>