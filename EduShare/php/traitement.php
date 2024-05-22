<?php
include 'config.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $categorie = htmlspecialchars($_POST['categorie']); // Nouveau
    $userId = htmlspecialchars($_POST['user_id']); // Nouveau

    $normalizedTitle = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($titre));
    $imagesDirectory = "../images/TUTORIEL_PICTURE/$normalizedTitle";
    if (!is_dir($imagesDirectory)) {
        mkdir($imagesDirectory, 0777, true);
    }

    $imagePaths = [];

    // Téléchargement de l'image principale
    if (isset($_FILES['image_principale']) && $_FILES['image_principale']['error'] == UPLOAD_ERR_OK) {
        $imagePrincipale = $_FILES['image_principale'];
        $imagePrincipaleExtension = pathinfo($imagePrincipale['name'], PATHINFO_EXTENSION);
        $imagePrincipaleName = $normalizedTitle . '_main.' . $imagePrincipaleExtension;
        $imagePrincipalePath = $imagesDirectory . '/' . $imagePrincipaleName;

        if (move_uploaded_file($imagePrincipale['tmp_name'], $imagePrincipalePath)) {
            $imagePaths[] = $imagePrincipalePath;
        } else {
            echo "Échec du téléchargement de l'image principale.<br>";
        }
    } else {
        echo "Problème de fichier reçu : Erreur " . $_FILES['image_principale']['error'] . "<br>";
    }

    // Préparation des données pour l'écriture dans le fichier CSV
    $id = uniqid();
    $ligne = "$id;$titre;$description;$imagePrincipalePath;";

    // Ajout de la première étape
    if (isset($_POST['etape_titre'][0])) {
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

    // Ajouter la catégorie et l'user ID à la fin de la ligne CSV
    $ligne .= "$categorie;$userId\n";
    $csvFile = '../data/tutoriel.csv';

    // Écriture dans le fichier CSV
    $fichier = fopen($csvFile, "a");
    if ($fichier) {
        fwrite($fichier, $ligne);
        fclose($fichier);

        // Copie des informations dans un autre fichier CSV
        copierInformationsDansAutreCSV($id, $titre, $description, $imagePrincipalePath, $imagePaths, $categorie, $userId);

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

function copierInformationsDansAutreCSV($id, $titre, $description, $imagePrincipalPath, $imagePaths, $categorie, $userId)
{
    // Ouvrir le fichier CSV de destination en mode écriture
    $csvFile2 = '../data/vignette.csv';
    $fichier_destination = fopen($csvFile2, "a");

    // Générer l'URL
    $url = "tutoriel.php?id=$id";

    // Écrire les informations dans le fichier CSV de destination
    fputcsv($fichier_destination, array($id, $titre, $description, $imagePrincipalPath, 0, $url, $categorie, $userId), ';');

    // Fermer le fichier CSV de destination
    fclose($fichier_destination);
}
