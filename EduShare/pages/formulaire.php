<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soumettre un Tutoriel</title>
    <link rel="stylesheet" href="../CSS/formulaire.css">
</head>

<body>
    <h1>Soumettre un Tutoriel</h1>
    <form action="../php/traitement.php" method="post" enctype="multipart/form-data">
        <label for="titre">Titre du tutoriel :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie" required>
            <option value="informatique">Informatique</option>
            <option value="cuisine">Cuisine</option>
            <option value="bricolage">Bricolage</option>
            <!-- Ajoutez d'autres catégories selon vos besoins -->
        </select>

        <!-- Ajout d'un champ caché pour l'identifiant utilisateur -->
        <!-- Assurez-vous que ce code PHP est enveloppé dans une session start et que l'utilisateur est connecté -->
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

        <label for="description">Description générale :</label>
        <textarea id="description" name="description" required></textarea>

        <label for="image_principale">Image principale :</label>
        <input type="file" id="image_principale" name="image_principale" required>

        <div id="etapes-container">
            <h2>Étapes</h2>
            <div class="etape">
                <label for="etape_titre_1">Titre de l'étape 1 :</label>
                <input type="text" id="etape_titre_1" name="etape_titre[]" required>

                <label for="etape_description_1">Description de l'étape 1 :</label>
                <textarea id="etape_description_1" name="etape_description[]" required></textarea>

                <label for="etape_image_1">Image de l'étape 1 :</label>
                <input type="file" id="etape_image_1" name="etape_image[]" required>
            </div>
        </div>

        <button type="button" onclick="ajouterEtape()">Ajouter une étape</button>
        <input type="submit" value="Soumettre">
    </form>

    <script>
        let etapeCount = 1;

        function ajouterEtape() {
            etapeCount++;
            const etapesContainer = document.getElementById('etapes-container');
            const nouvelleEtape = document.createElement('div');
            nouvelleEtape.classList.add('etape');
            nouvelleEtape.innerHTML = `
                <label for="etape_titre_${etapeCount}">Titre de l'étape ${etapeCount} :</label>
                <input type="text" id="etape_titre_${etapeCount}" name="etape_titre[]" required>

                <label for="etape_description_${etapeCount}">Description de l'étape ${etapeCount} :</label>
                <textarea id="etape_description_${etapeCount}" name="etape_description[]" required></textarea>

                <label for="etape_image_${etapeCount}">Image de l'étape ${etapeCount} :</label>
                <input type="file" id="etape_image_${etapeCount}" name="etape_image[]" required>
            `;
            etapesContainer.appendChild(nouvelleEtape);
        }
    </script>
</body>

</html>