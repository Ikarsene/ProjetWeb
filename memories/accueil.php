<?php
// Démarre une session PHP pour accéder aux variables de session
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de login
if (!isset($_SESSION['login'])) {
    header("Location: index.php"); // Redirige vers la page de login
    exit(); // Arrête l'exécution du script
}
?>
<script>
function myFunction() {
   var element = document.body;
   element.classList.toggle("dark-mode");
}
</script>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit le charset de la page en UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Assure que la page est responsive sur les appareils mobiles -->
    <title>Page d'Accueil</title> <!-- Titre de la page -->
    <link rel="stylesheet" href="myCSS.css"> <!-- Lien vers un fichier CSS externe -->
    <style>
        /* Style général du corps de la page */
        body {
            font-family: 'Arial', sans-serif; /* Police utilisée sur la page */
            background-color: #121212; /* Fond plus foncé */
            color: white; /* Couleur du texte en blanc */
            margin: 0; /* Enlève les marges par défaut */
            padding: 0; /* Enlève les espacements par défaut */
            display: flex; /* Utilisation de Flexbox pour centrer le contenu */
            justify-content: center; /* Centre horizontalement */
            align-items: center; /* Centre verticalement */
            height: 100vh; /* Hauteur de la fenêtre à 100% */
            overflow: hidden; /* Empêche le débordement */
        }
        .dark-mode 
        {
            background-color: white; 
            color: black;
        }
        /* Style du conteneur principal */
        .container {
            width: 100%; /* Utilise toute la largeur disponible */
            max-width: 1200px; /* Largeur maximale de 1200px */
            padding: 20px; /* Ajoute de l'espace autour du contenu */
            background-color: #1e1e1e; /* Fond sombre */
            border-radius: 15px; /* Coins arrondis */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6); /* Ombre portée */
        }
        
        /* Style du titre principal */
        h1 {
            text-align: center; /* Centre le texte */
            color: #0066cc; /* Bleu foncé pour le titre */
            font-size: 2.5em; /* Taille du texte */
            margin-bottom: 20px; /* Espacement en bas du titre */
            letter-spacing: 2px; /* Espacement entre les lettres */
        }
        
        /* Style du contenu principal */
        .content {
            background-color: #1e1e1e; /* Fond sombre */
            padding: 30px; /* Ajoute de l'espace autour du contenu */
            border-radius: 10px; /* Coins arrondis */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4); /* Ombre portée */
        }
        
        /* Style des boutons */
        .content button {
            background-color: #0066cc; /* Bleu foncé pour le bouton */
            color: white; /* Texte du bouton en blanc */
            padding: 15px 25px; /* Espacement à l'intérieur du bouton */
            border: none; /* Aucune bordure */
            border-radius: 8px; /* Coins arrondis */
            font-size: 18px; /* Taille du texte */
            cursor: pointer; /* Change le curseur en main quand on survole le bouton */
            transition: background-color 0.3s, transform 0.2s ease-in-out; /* Animation sur l'effet de survol */
            width: 100%; /* Le bouton prend toute la largeur du conteneur */
            margin: 10px 0; /* Espacement entre les boutons */
        }
        
        /* Style des boutons au survol */
        .content button:hover {
            background-color: #004d99; /* Couleur plus foncée au survol */
            transform: scale(1.05); /* Agrandissement du bouton */
        }
        
        /* Style des cartes contenant les informations */
        .card {
            background-color: #333; /* Fond plus foncé pour les cartes */
            padding: 20px; /* Espacement à l'intérieur de la carte */
            border-radius: 10px; /* Coins arrondis */
            margin-bottom: 15px; /* Espacement en bas de chaque carte */
            text-align: center; /* Centrage du texte dans la carte */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3); /* Ombre portée */
        }
        
        /* Style du titre dans les cartes */
        .card h2 {
            color: #00bfff; /* Bleu clair pour le titre */
            font-size: 2em; /* Taille du texte du titre */
            margin-bottom: 20px; /* Espacement en bas du titre */
        }
        
        /* Style du texte dans les cartes */
        .card p {
            font-size: 1.2em; /* Taille du texte */
            margin-bottom: 20px; /* Espacement en bas du texte */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Affiche un message de bienvenue avec le nom de l'utilisateur connecté -->
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['login']); ?></h1>

        <!-- Contenu principal de la page -->
        <div class="content">
            <!-- Carte avec les différentes actions possibles -->
            <div class="card">
                <h2>Actions disponibles</h2> <!-- Titre de la carte -->
                <p>Choisissez une action ci-dessous pour commencer à gérer les questions, ajouter des utilisateurs ou réviser vos questions.</p>
                <!-- Boutons permettant d'accéder à différentes pages -->
                <button onclick="window.location.href='ajouter_question.php'">Ajouter une Question</button>
                <button onclick="window.location.href='ajouter_utilisateur.php'">Ajouter un Utilisateur</button>
                <button onclick="window.location.href='questions.php'">Réviser les Questions</button>
                <button onclick="window.location.href='themes.php'">Gérer les thèmes</button>
                <button onclick="myFunction()">Toggle dark mode</button>
                <div class="bouttondeconexion">                             
                    <button onclick="window.location.href='deconnexion.php'">Déconnexion</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
