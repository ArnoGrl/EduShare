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
            $tutorielId = $_GET['id']; // Récupérer l'ID du tutoriel depuis l'URL
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
                            $Titre = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[1])));
                            $description = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[2])));
                            $titre_1 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[3])));
                            $description_1 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[4])));
                            $titre_2 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[6])));
                            $description_2 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[7])));
                            $titre_3 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[9])));
                            $description_3 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[10])));
                            $titre_4 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[12])));
                            $description_4 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[13])));
                            $titre_5 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[15])));
                            $description_5 = nl2br(htmlspecialchars(str_replace("\\n", "\n", $data[16])));

                            echo "<div class='tutoriel-detail'>";
                            echo "<img src='" . htmlspecialchars($data[5]) . "' class='image-1'>";
                            echo "<h1>" . $Titre . "</h1>";
                            echo "<p>" . $description . "</p>";


                            echo "<h2>" . $titre_1 . "</h2>";
                            echo "<p>" . $description_1 . "</p>";
                            echo "<img src='" . htmlspecialchars($data[8]) . "' class='image-2'>";

                            echo "<h2>" . $titre_2 . "</h2>";
                            echo "<p>" . $description_2 . "</p>";
                            echo "<img src='" . htmlspecialchars($data[11]) . "' class='image-3'>";

                            echo "<h2>" . $titre_3 . "</h2>";
                            echo "<p>" . $description_3 . "</p>";
                            echo "<img src='" . htmlspecialchars($data[14]) . "' class='image-4'>";

                            echo "<h2>" . $titre_4 . "</h2>";
                            echo "<p>" . $description_4 . "</p>";
                            echo "<img src='" . htmlspecialchars($data[17]) . "' class='image-5'>";

                            echo "</div>";
                            $found = true;
                            break; // Arrêter la lecture une fois le tutoriel trouvé
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