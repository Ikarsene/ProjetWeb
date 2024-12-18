<?php
// Démarre la session pour accéder aux variables de session (comme $_SESSION['login'])
session_start();

// Inclusion du fichier de connexion à la base de données
require_once('admin/connex.inc.php');

// Variables pour indiquer les erreurs lors de la connexion
$erreurID = false;
$erreurMDP = false;

// Vérifie si les champs d'identifiant et de mot de passe ont été soumis
if (isset($_POST['uname']) && $_POST['uname'] != "" && isset($_POST['psw']) && $_POST['psw'] != "") {
    // Assainissement des entrées pour éviter les injections SQL et les caractères malveillants
    $login = mysqli_real_escape_string($connex, htmlentities($_POST['uname'])); // Assainit le login
    $passwd = mysqli_real_escape_string($connex, htmlentities($_POST['psw'])); // Assainit le mot de passe
    
    // Requête pour vérifier si un utilisateur avec ce login existe
    $sql = "SELECT * FROM users WHERE login = '".$login."'";
    $req = mysqli_query($connex, $sql); // Exécute la requête SQL
    
    // Si l'utilisateur existe dans la base de données
    if (mysqli_num_rows($req) != 0) {
        // Récupère les informations de l'utilisateur
        $row = mysqli_fetch_object($req);
        $hash = $row->passwd; // Récupère le mot de passe haché de l'utilisateur

        // Vérifie si le mot de passe saisi correspond au mot de passe haché
        if (password_verify($passwd, $hash)) {
            // Si les identifiants sont corrects, redirige vers la page d'accueil
            $_SESSION['login'] = $row->login; // Sauvegarde le login dans la session
            $_SESSION['id'] = $row->id; // Sauvegarde l'ID de l'utilisateur dans la session
            header("location: accueil.php"); // Redirection vers la page d'accueil
        } else {
            // Si le mot de passe est incorrect
            $erreurMDP = true;
        }
    } else {
        // Si le login n'existe pas dans la base de données
        $erreurID = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit l'encodage des caractères -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Rendre la page responsive sur les appareils mobiles -->
    <title>Connexion</title> <!-- Titre de la page -->
    <link rel="stylesheet" href="myCSS.css"> <!-- Lien vers la feuille de style externe -->
    <style>
        body {
            font-family: Arial, sans-serif; /* Police de caractère */
            background-color: #1e1e1e; /* Fond sombre */
            color: white; /* Texte en blanc */
            margin: 0; /* Retirer les marges par défaut */
            padding: 0; /* Retirer les paddings par défaut */
            display: flex; /* Utilisation de flexbox pour centrer les éléments */
            justify-content: center; /* Centrer horizontalement */
            align-items: center; /* Centrer verticalement */
            height: 100vh; /* Hauteur de la fenêtre du navigateur */
            flex-direction: column; /* Disposition en colonne */
        }
        
        h2 {
            color: #00bfff; /* Couleur bleue pour le titre */
            margin-bottom: 20px; /* Marge sous le titre */
        }
        .comment {
            color: red; /* Couleur rouge pour les messages d'erreur */
            margin: 10px 0; /* Marge autour des messages d'erreur */
            font-size: 14px; /* Taille de police plus petite pour les messages d'erreur */
        }
        label {
            font-size: 14px; /* Taille de police pour les labels */
            margin-bottom: 5px; /* Marge sous les labels */
            display: block; /* Chaque label occupe une ligne */
            color: #fff; /* Texte des labels en blanc */
        }
        input[type="text"], input[type="password"] {
            width: 100%; /* Largeur complète des champs de texte */
            padding: 10px; /* Espacement interne des champs */
            margin: 10px 0; /* Marge verticale entre les champs */
            border-radius: 5px; /* Coins arrondis des champs */
            border: 1px solid #ccc; /* Bordure gris clair */
            background-color: #555; /* Fond sombre des champs */
            color: white; /* Texte des champs en blanc */
        }
        button {
            width: 100%; /* Largeur complète du bouton */
            padding: 10px; /* Espacement interne du bouton */
            background-color: #00bfff; /* Couleur de fond du bouton */
            color: white; /* Couleur du texte du bouton */
            border: none; /* Suppression de la bordure du bouton */
            border-radius: 5px; /* Coins arrondis du bouton */
            cursor: pointer; /* Curseur pointer lorsque la souris passe dessus */
            font-size: 16px; /* Taille de police du bouton */
            transition: background-color 0.3s; /* Transition pour le changement de couleur au survol */
        }
        button:hover {
            background-color: #009acd; /* Couleur du bouton au survol */
        }
    </style>
</head>
<body>
    <!-- Formulaire de connexion -->
    <form action="index.php" method="post">
        <!-- Conteneur pour l'avatar -->
        <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar"> <!-- Image de l'avatar -->
        </div>

        <!-- Conteneur principal du formulaire -->
        <div class="container">
            <h2>Se connecter</h2>
            
            <!-- Affichage des erreurs si l'utilisateur ou le mot de passe est incorrect -->
            <?php
                if ($erreurID) echo '<p class="comment">Login inconnu</p>';
                if ($erreurMDP) echo '<p class="comment">Mot de passe incorrect</p>';
            ?>
            
            <!-- Champs pour l'identifiant -->
            <label for="uname"><b>Identifiant</b></label>
            <input type="text" placeholder="Entrez votre identifiant" name="uname" required>

            <!-- Champs pour le mot de passe -->
            <label for="psw"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrez votre mot de passe" name="psw" required>

            <!-- Bouton de soumission du formulaire -->
            <button type="submit">Se connecter</button>
        </div>
    </form>
</body>
</html>
