<?php
include '../php/gestion_csv.php';
include '../partials/header.php';

$tutoriels = read_csv('tutoriels.csv');

echo '<main><h2>Liste des Tutoriels</h2>';
foreach ($tutoriels as $tutoriel) {
    echo "<p>{$tutoriel[1]} - Catégorie: {$tutoriel[2]}</p>";
}
echo '</main>';

include '../partials/footer.php';
?>