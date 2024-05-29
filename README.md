# EduShare - Plateforme de partage de tutoriels en ligne

Bienvenue sur le dépôt GitHub du projet EduShare, une plateforme dédiée au partage de tutoriels en ligne. Ce site permet aux utilisateurs de publier, rechercher et consulter des tutoriels sur divers sujets.

## Fonctionnalités

- **Inscription et Connexion** : Création de compte sécurisée avec validation de mot de passe (minimum 8 caractères). Connexion requise pour accéder aux fonctionnalités.
- **Recherche de Tutoriels** : Utilisez la barre de recherche sur la page d'accueil pour trouver des tutoriels par mots-clés.
- **Catégories** : Navigation aisée grâce aux catégories de tutoriels disponibles sur la partie gauche de l'onglet "Nos tutoriels tendance".
- **Consultation de Tutoriels** : Accédez aux tutoriels en cliquant sur "Accéder au tutoriel".
- **Soumission de Tutoriels** : Soumettez vos propres tutoriels via le bouton "Soumettre un tutoriel". Les images d'illustration sont obligatoires.
- **Déconnexion** : Bouton de déconnexion disponible pour se retourner sur la page de connexion.

## Prérequis

Pour exécuter ce projet localement, vous aurez besoin d'un serveur PHP. Nous recommandons l'utilisation de l'extension "PHP Server" sur Visual Studio Code.

## Installation

1. Clonez ce dépôt ou téléchargez le code source.
2. Ouvrez un terminal et naviguez jusqu'au dossier racine du projet, `EduShare`.
3. Lancez un serveur PHP. Sur Visual Studio Code, vous pouvez utiliser la combinaison de touches `Ctrl+Shift+P`, puis tapez `PHP Server: Serve Project`.

## Structure des fichiers

- **index.php** - Page principale du site.
- **categorie.php** - Gestion des tutoriels par catégorie.
- **formulaire.php**, **traitement.php** - Gestion des soumissions de nouveaux tutoriels.
- **login.php**, **register.php**, **logout.php** - Gestion de l'authentification des utilisateurs.
- **validation.js** - Scripts pour la validation côté client.
- **/CSS** - Contient les fichiers CSS pour le style du site.
- **/data** - Contient les fichiers CSV pour la gestion des données utilisateur et des tutoriels.
- **/images** - Dossier pour les images utilisées sur le site.

## Configuration des droits d'accès

Si vous rencontrez des problèmes d'exécution, assurez-vous que le dossier `EduShare` et ses sous-dossiers ont les droits d'accès appropriés. Sur un système Unix/Linux, vous pouvez exécuter :

```bash
chmod -R 755 /chemin/vers/EduShare
