<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Définition du jeu de caractères utilisé -->
    <meta charset="UTF-8">
    <!-- Permet un affichage correct sur les différents appareils -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Lien vers le fichier CSS pour le style de la page -->
    <link rel="stylesheet" href="../CSS/tutoriel.css">
    <!-- Titre de la page -->
    <title>EduShare - Tutoriel</title>
</head>

<body>
    <!-- En-tête de la page (vide pour l'instant) -->
    <header>
    </header>

    <!-- Section principale de la page -->
    <main>
        <!-- Section contenant le tutoriel -->
        <section class="tutoriel">
            <?php
            // Définit le type de contenu comme HTML avec encodage UTF-8
            header('Content-Type: text/html; charset=UTF-8');
            // Inclut le fichier de configuration
            include '../php/config.php';

            // Récupère l'ID du tutoriel depuis les paramètres GET de l'URL
            $tutorielId = $_GET['id'];
            // Chemin vers le fichier CSV contenant les tutoriels
            $csvFile = '../data/tutoriel.csv';

            // Vérifie si le fichier CSV existe
            if (!file_exists($csvFile)) {
                // Affiche un message d'erreur si le fichier CSV n'existe pas
                echo "Le fichier CSV n'existe pas à l'emplacement spécifié.";
            } else {
                // Ouvre le fichier CSV en mode lecture
                $handle = fopen($csvFile, "r");
                if ($handle === FALSE) {
                    // Affiche un message d'erreur si le fichier ne peut pas être ouvert
                    echo "Impossible d'ouvrir le fichier CSV.";
                } else {
                    // Variable pour vérifier si le tutoriel a été trouvé
                    $found = false;
                    // Parcourt chaque ligne du fichier CSV
                    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                        // Vérifie si l'ID du tutoriel correspond à celui recherché
                        if ($data[0] == $tutorielId) {
                            // Affiche les détails du tutoriel
                            echo "<div class='tutoriel-detail'>";
                            echo "<h1>" . htmlspecialchars($data[1]) . "</h1>"; // Titre du tutoriel
                            echo "<p class='description'>" . htmlspecialchars($data[2]) . "</p>"; // Description du tutoriel
                            // Ignore l'image principale et la note

                            // Calcule le nombre de parties dans le tutoriel
                            $numParts = (count($data) - 6) / 3;
                            // Boucle pour afficher chaque partie du tutoriel
                            for ($i = 0; $i < $numParts; $i++) {
                                $index = 4 + $i * 3; // Index de la partie actuelle
                                $step = $i + 1; // Numéro de l'étape
                                $class = $i % 2 == 0 ? "left" : "right"; // Classe CSS pour alternance gauche/droite
                                echo "<div class='part part-$class'>";
                                echo "<h2>ÉTAPE $step : " . htmlspecialchars($data[$index]) . "</h2>"; // Titre de l'étape
                                echo "<p>" . htmlspecialchars($data[$index + 1]) . "</p>"; // Description de l'étape
                                echo "<img src='" . htmlspecialchars($data[$index + 2]) . "' class='image'>"; // Image de l'étape
                                echo "</div>";
                            }
                            echo "</div>";
                            $found = true; // Marque le tutoriel comme trouvé
                            break; // Sort de la boucle
                        }
                    }
                    fclose($handle); // Ferme le fichier CSV
                    if (!$found) {
                        // Affiche un message d'erreur si aucun tutoriel correspondant n'a été trouvé
                        echo "Aucun tutoriel correspondant à l'ID fourni n'a été trouvé.";
                    }
                }
            }
            ?>
            <!-- Lien pour retourner à la liste des tutoriels -->
            <a href="/index.php">Retour à la liste des tutoriels</a>
        </section>
    </main>

    <!-- Pied de page -->
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>