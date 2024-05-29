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
    <p> Merci de ne pas utiliser de point virgule, pour éviter tout problème d'affichage. </p>
    <form action="../php/traitement.php" method="post" enctype="multipart/form-data">
        <label for="titre">Titre du tutoriel :</label>
        <input type="text" id="titre" name="titre" required>

        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie" required>
            <option value="agriculture">Agriculture</option>
            <option value="animation">Animation</option>
            <option value="architecture">Architecture</option>
            <option value="artisanat">Artisanat</option>
            <option value="astrologie">Astrologie</option>
            <option value="astronomie">Astronomie</option>
            <option value="automatisation">Automatisation</option>
            <option value="automobile">Automobile</option>
            <option value="aviation">Aviation</option>
            <option value="bâtiment">Bâtiment</option>
            <option value="beauté">Beauté</option>
            <option value="bourse">Bourse</option>
            <option value="bricolage">Bricolage</option>
            <option value="business">Business</option>
            <option value="chimie">Chimie</option>
            <option value="communication">Communication</option>
            <option value="comptabilité">Comptabilité</option>
            <option value="cuisine">Cuisine</option>
            <option value="culture">Culture</option>
            <option value="cybersécurité">Cybersécurité</option>
            <option value="danse">Danse</option>
            <option value="design">Design</option>
            <option value="développement-durable">Développement Durable</option>
            <option value="développement-personnel">Développement Personnel</option>
            <option value="droit">Droit</option>
            <option value="économie">Économie</option>
            <option value="éducation">Éducation</option>
            <option value="électronique">Électronique</option>
            <option value="énergétique">Énergétique</option>
            <option value="environnement">Environnement</option>
            <option value="finance">Finance</option>
            <option value="fitness">Fitness</option>
            <option value="formation-en-ligne">Formation en Ligne</option>
            <option value="gaming">Gaming</option>
            <option value="gastronomie">Gastronomie</option>
            <option value="gestion-de-projets">Gestion de Projets</option>
            <option value="graphisme">Graphisme</option>
            <option value="histoire">Histoire</option>
            <option value="hôtellerie">Hôtellerie</option>
            <option value="informatique">Informatique</option>
            <option value="ingénierie">Ingénierie</option>
            <option value="internet-des-objets">Internet des Objets (IoT)</option>
            <option value="investissement">Investissement</option>
            <option value="jardinage">Jardinage</option>
            <option value="journalisme">Journalisme</option>
            <option value="langues">Langues</option>
            <option value="leadership">Leadership</option>
            <option value="littérature">Littérature</option>
            <option value="logistique">Logistique</option>
            <option value="management">Management</option>
            <option value="marketing">Marketing</option>
            <option value="mathématiques">Mathématiques</option>
            <option value="médecine">Médecine</option>
            <option value="musique">Musique</option>
            <option value="naturopathie">Naturopathie</option>
            <option value="nutrition">Nutrition</option>
            <option value="paramédical">Paramédical</option>
            <option value="peinture">Peinture</option>
            <option value="philosophie">Philosophie</option>
            <option value="photographie">Photographie</option>
            <option value="plomberie">Plomberie</option>
            <option value="programmation">Programmation</option>
            <option value="psychologie">Psychologie</option>
            <option value="réseaux">Réseaux</option>
            <option value="robotique">Robotique</option>
            <option value="rédaction">Rédaction</option>
            <option value="sciences">Sciences</option>
            <option value="science-des-données">Science des Données</option>
            <option value="sciences-sociales">Sciences Sociales</option>
            <option value="sculpture">Sculpture</option>
            <option value="sécurité-informatique">Sécurité Informatique</option>
            <option value="seo">SEO</option>
            <option value="soins-infirmiers">Soins Infirmiers</option>
            <option value="sport">Sport</option>
            <option value="stylisme">Stylisme</option>
            <option value="théâtre">Théâtre</option>
            <option value="tourisme">Tourisme</option>
            <option value="trading">Trading</option>
            <option value="transport">Transport</option>
            <option value="ux-ui-design">UX/UI Design</option>
            <option value="ventes">Ventes</option>
            <option value="vidéo">Vidéo</option>
            <option value="visualisation-de-données">Visualisation de Données</option>
            <option value="vocal">Vocal</option>
            <option value="web-design">Web Design</option>
            <option value="web-marketing">Web Marketing</option>
            <option value="wordpress">WordPress</option>
            <option value="yoga">Yoga</option>
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