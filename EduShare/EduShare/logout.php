<?php
session_start();
session_destroy();  // Détruit toutes les données de session
header('Location: login.php');  // Redirige l'utilisateur vers la page de connexion
exit;
