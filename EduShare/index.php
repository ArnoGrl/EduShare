<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    // Démarrage ou continuation de la session pour accéder aux variables de session
    session_start();
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit;
    }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>EduShare - Accueil</title>
</head>

<body>
    <!-- Barre de navigation supérieure -->
    <nav class="top-nav">
        <!-- Message de bienvenue avec le nom de l'utilisateur -->
        <div class="welcome-message">
            Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!
        </div>
        <!-- Liens pour soumettre un nouveau tutoriel et se déconnecter -->
        <p><a href="/pages/formulaire.php" class="submit-button">Soumettre un nouveau tutoriel</a></p>
        <a href="logout.php" class="logout-button">Déconnexion</a>
    </nav>

    <!-- Barre de recherche -->
    <header>
        <div class="search-container">
            <form method="GET" action="/php/recherche.php">
                <input type="search" name="query" placeholder="Rechercher des tutoriels..." id="search-bar" value="<?php echo htmlspecialchars($_GET['query'] ?? '', ENT_QUOTES); ?>">
            </form>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="main-content">
        <!-- Menu des catégories de tutoriels disponibles -->
        <nav class="category-menu">
            <ul>
                <?php
                // Liste des catégories de tutoriels
                $categories = [
                    "Agriculture", "Animation", "Architecture", "Artisanat", "Astrologie", "Astronomie",
                    "Automatisation", "Automobile", "Aviation", "Bâtiment", "Beauté", "Bourse",
                    "Bricolage", "Business", "Chimie", "Communication", "Comptabilité", "Cuisine",
                    "Culture", "Cybersécurité", "Danse", "Design", "Développement Durable",
                    "Développement Personnel", "Droit", "Économie", "Éducation", "Électronique",
                    "Énergétique", "Environnement", "Finance", "Fitness", "Formation en Ligne",
                    "Gaming", "Gastronomie", "Gestion de Projets", "Graphisme", "Histoire",
                    "Hôtellerie", "Informatique", "Ingénierie", "Internet des Objets (IoT)",
                    "Investissement", "Jardinage", "Journalisme", "Langues", "Leadership",
                    "Littérature", "Logistique", "Management", "Marketing", "Mathématiques",
                    "Médecine", "Musique", "Naturopathie", "Nutrition", "Paramédical", "Peinture",
                    "Philosophie", "Photographie", "Plomberie", "Programmation", "Psychologie",
                    "Réseaux", "Robotique", "Rédaction", "Sciences", "Science des Données",
                    "Sciences Sociales", "Sculpture", "Sécurité Informatique", "SEO",
                    "Soins Infirmiers", "Sport", "Stylisme", "Théâtre", "Tourisme", "Trading",
                    "Transport", "UX/UI Design", "Ventes", "Vidéo", "Visualisation de Données",
                    "Vocal", "Web Design", "Web Marketing", "WordPress", "Yoga"
                ];
                // Génération dynamique des liens de catégories
                foreach ($categories as $category) {
                    echo '<li><a class="category-link" href="/php/categorie.php?categorie=' . urlencode($category) . '">' . htmlspecialchars($category) . '</a></li>';
                }
                ?>
            </ul>
        </nav>

        <!-- Section affichant les tutoriels tendance -->
        <section class="tutoriel-tendance">
            <h2>Nos Tuto Tendance</h2>
            <?php
            // Chemin vers le fichier CSV contenant les données des tutoriels
            $csvFile = 'data/vignette.csv';
            // Ouverture du fichier CSV
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Lecture des données du fichier CSV et affichage des tutoriels
                while (($data = fgetcsv($handle, 1000000, ";")) !== FALSE) {
                    echo '<div class="tutoriel">';
                    echo '<img src="' . htmlspecialchars($data[3]) . '" alt="' . htmlspecialchars($data[1]) . '">';
                    echo '<div class="tuto-info">';
                    echo '<h3>' . htmlspecialchars($data[1]) . '</h3>';
                    echo '<p>' . htmlspecialchars($data[2]) . '</p>';
                    echo '<a href="pages/tutoriel.php?id=' . htmlspecialchars($data[0]) . '">Accéder au tutoriel</a>';
                    echo '</div>';
                    echo '</div>';
                }
                fclose($handle);
            }
            ?>
        </section>
    </main>

    <!-- Pied de page -->
    <footer>
        <p>&copy; 2024 EduShare. Tous droits réservés.</p>
    </footer>
</body>

</html>