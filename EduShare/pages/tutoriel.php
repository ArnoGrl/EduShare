<?php
include '../php/gestion_csv.php';
include '../partials/header.php';

// Simulons que l'ID du tutoriel vient de GET pour cet exemple
$tutoriel_id = $_GET['id'] ?? 1;
$tutoriels = read_csv('tutoriels.csv');
$tutoriel = $tutoriels[$tutoriel_id - 1];

echo '<main>';
echo "<h2>{$tutoriel[1]}</h2>";
echo "<p>Catégorie: {$tutoriel[2]}</p>";
echo "<p>Contenu: {$tutoriel[3]}</p>";
echo '</main>';

include '../partials/footer.php';
?>