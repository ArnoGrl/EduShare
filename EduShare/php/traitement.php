<?php
include '../php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);

    $normalizedTitle = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($titre));
    $imagesDirectory = "../images/$normalizedTitle";
    if (!is_dir($imagesDirectory)) {
        mkdir($imagesDirectory, 0777, true);
    }

    $imagePaths = [];

    // Téléchargement de l'image principale
    $imagePrincipale = $_FILES['image_principale'];
    $imagePrincipaleName = $normalizedTitle . '_main.' . pathinfo($imagePrincipale['name'], PATHINFO_EXTENSION);
    $imagePrincipalePath = $imagesDirectory . '/' . $imagePrincipaleName;
    if (move_uploaded_file($imagePrincipale['tmp_name'], $imagePrincipalePath)) {
        $imagePaths[] = $imagePrincipalePath;
    } else {
        $imagePaths[] = "Failed to upload main image";
    }

    // Préparation des données pour l'écriture dans le fichier CSV
    $id = uniqid();
    $ligne = "$id;$titre;$description;$imagePrincipalePath;";

    // Ajout de la première étape
    $etape_titre_1 = htmlspecialchars($_POST['etape_titre'][0]);
    $etape_description_1 = htmlspecialchars($_POST['etape_description'][0]);
    $etape_image_1 = $_FILES['etape_image']['name'][0];
    $etape_image_tmp_1 = $_FILES['etape_image']['tmp_name'][0];
    $extension_1 = pathinfo($etape_image_1, PATHINFO_EXTENSION);
    $etape_image_name_1 = $normalizedTitle . '_etape_1.' . $extension_1;
    $etape_image_path_1 = $imagesDirectory . '/' . $etape_image_name_1;

    if (move_uploaded_file($etape_image_tmp_1, $etape_image_path_1)) {
        $imagePaths[] = $etape_image_path_1;
        $ligne .= "$etape_titre_1;$etape_description_1;$etape_image_path_1;";
    } else {
        $imagePaths[] = "Failed to upload step 1 image";
    }

    // Ajout des autres étapes
    for ($i = 1; $i < count($_FILES['etape_image']['name']); $i++) {
        $etape_titre = htmlspecialchars($_POST['etape_titre'][$i]);
        $etape_description = htmlspecialchars($_POST['etape_description'][$i]);
        $etape_image = $_FILES['etape_image']['name'][$i];
        $etape_image_tmp = $_FILES['etape_image']['tmp_name'][$i];
        $extension = pathinfo($etape_image, PATHINFO_EXTENSION);
        $etape_image_name = $normalizedTitle . '_etape_' . ($i + 1) . '.' . $extension;
        $etape_image_path = $imagesDirectory . '/' . $etape_image_name;
        if (move_uploaded_file($etape_image_tmp, $etape_image_path)) {
            $imagePaths[] = $etape_image_path;
            $ligne .= "$etape_titre;$etape_description;$etape_image_path;";
        } else {
            $imagePaths[] = "Failed to upload step " . ($i + 1) . " image";
        }
    }

    // Ajout de la note initiale (0) à la fin de la ligne
    $ligne .= "0\n";
    $csvFile = CSV_TUTO;

    // Écriture dans le fichier CSV
    $fichier = fopen($csvFile, "a");
    if ($fichier) {
        fwrite($fichier, $ligne);
        fclose($fichier);

        // Copie des informations dans un autre fichier CSV
        copierInformationsDansAutreCSV($id, $titre, $description, $imagePrincipalePath, $imagePaths);

        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Soumettre un Tutoriel</title>
        <link rel='stylesheet' href='styles.css'>
        </head>
        <body>
        <p>Le tutoriel a été soumis avec succès !</p>
        <p><a href='/index.php'>Retour à la page d'accueil</a></p>
        </body>
        </html>";
    } else {
        echo "Erreur lors de l'ouverture du fichier CSV.";
    }
} else {
    echo "Méthode de requête non valide.";
}

function copierInformationsDansAutreCSV($id, $titre, $description, $imagePrincipalPath, $imagePaths)
{
    // Chemin du fichier CSV de destination
    define('CSV_PATH', '/home/arno/Bureau/EduShare/data/OTHER_TUTORIEL.csv');

    // Ouvrir le fichier CSV de destination en mode écriture
    $fichier_destination = fopen(CSV_PATH, "a");

    // Générer l'URL
    $url = "tutoriel.php?id=$id";

    // Écrire les informations dans le fichier CSV de destination
    fputcsv($fichier_destination, array($id, $titre, $description, $imagePrincipalPath, 0, $url), ';');

    // Fermer le fichier CSV de destination
    fclose($fichier_destination);
}
