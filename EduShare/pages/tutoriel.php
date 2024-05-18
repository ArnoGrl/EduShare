<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/tutoriel.css">
    <title>EduShare - Tutoriel</title>
</head>

<body>
    <header>
    </header>
    <main>
        <section class="tutoriel">
            <?php
            header('Content-Type: text/html; charset=UTF-8');
            include '../php/config.php';
            $tutorielId = $_GET['id'];
            $csvFile = CSV_TUTO;

            if (!file_exists($csvFile)) {
                echo "Le fichier CSV n'existe pas à l'emplacement spécifié.";
            } else {
                $handle = fopen($csvFile, "r");
                if ($handle === FALSE) {
                    echo "Impossible d'ouvrir le fichier CSV.";
                } else {
                    $found = false;
                    while (($data = fgetcsv($handle, 10000, ";")) !== FALSE) {
                        if ($data[0] == $tutorielId) {
                            echo "<div class='tutoriel-detail'>";
                            echo "<h1>" . htmlspecialchars($data[1]) . "</h1>";
                            echo "<p class='description'>" . htmlspecialchars($data[2]) . "</p>";
                            // Ignore the main image and note
                            $numParts = (count($data) - 5) / 3;
                            for ($i = 0; $i < $numParts; $i++) {
                                $index = 4 + $i * 3;
                                $step = $i + 1;
                                $class = $i % 2 == 0 ? "left" : "right";
                                echo "<div class='part part-$class'>";
                                echo "<h2>ÉTAPE $step : " . htmlspecialchars($data[$index]) . "</h2>";
                                echo "<p>" . htmlspecialchars($data[$index + 1]) . "</p>";
                                echo "<img src='" . htmlspecialchars($data[$index + 2]) . "' class='image'>";
                                echo "</div>";
                            }
                            echo "</div>";
                            $found = true;
                            break;
                        }
                    }
                    fclose($handle);
                    if (!$found) {
                        echo "Aucun tutoriel correspondant à l'ID fourni n'a été trouvé.";
                    }
                }
            }
            ?>
            <a href="/index.php">Retour à la liste des tutoriels</a>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>