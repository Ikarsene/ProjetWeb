<?php
// Démarre la session pour accéder aux variables de session (comme $_SESSION['login'])
session_start();

// Vérifie si l'utilisateur est connecté en vérifiant la variable de session 'login'
// Si l'utilisateur n'est pas connecté, il est redirigé vers la page de login
if (!isset($_SESSION['login'])) {
    header("Location: index.php"); // Redirection vers la page de login
    exit(); // Arrêt de l'exécution du script
}

// Inclusion du fichier de connexion à la base de données
require_once('admin/connex.inc.php');

// Vérifie si le formulaire a été soumis (méthode POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les données du formulaire
    $login = $_POST['login']; // Récupère le login de l'utilisateur
    $passwd = password_hash($_POST['passwd'], PASSWORD_DEFAULT); // Hachage du mot de passe avant de le stocker

    // Vérifie si le login existe déjà dans la base de données
    $sql_check = "SELECT * FROM users WHERE login = ?"; // Requête pour vérifier l'existence du login
    $stmt_check = $connex->prepare($sql_check); // Prépare la requête SQL
    $stmt_check->bind_param('s', $login); // Lie le paramètre 'login' à la requête
    $stmt_check->execute(); // Exécute la requête
    $result_check = $stmt_check->get_result(); // Récupère le résultat de la requête

    // Si un utilisateur avec ce login existe déjà
    if ($result_check->num_rows > 0) {
        echo "<p style='color: red;'>Ce login est déjà utilisé !</p>";
    } else {
        // Insère le nouvel utilisateur dans la base de données
        $sql = "INSERT INTO users (login, passwd) VALUES (?, ?)"; // Requête d'insertion
        $stmt = $connex->prepare($sql); // Prépare la requête d'insertion
        $stmt->bind_param('ss', $login, $passwd); // Lie les paramètres 'login' et 'passwd' à la requête
        // Exécute la requête d'insertion
        if ($stmt->execute()) {
            echo "<p style='color: green;'>Utilisateur ajouté avec succès !</p>";
        } else {
            echo "<p style='color: red;'>Erreur lors de l'ajout de l'utilisateur.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit l'encodage des caractères -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Permet de rendre la page responsive sur les appareils mobiles -->
    <title>Ajouter un Utilisateur</title> <!-- Titre de la page -->
    <link rel="stylesheet" href="myCSS.css"> <!-- Lien vers la feuille de style externe -->
</head>
<body>
    <div class="container">
        <!-- Bouton pour revenir à la page d'accueil -->
        <button onclick="window.location.href='accueil.php'">Retour à l'Accueil</button>

        <h1>Ajouter un Nouvel Utilisateur</h1> <!-- Titre de la page -->

        <!-- Formulaire pour ajouter un utilisateur -->
        <form method="POST">
            <label for="login">Login :</label>
            <input type="text" name="login" required> <!-- Champ pour entrer le login de l'utilisateur -->

            <label for="passwd">Mot de Passe :</label>
            <input type="password" name="passwd" required> <!-- Champ pour entrer le mot de passe de l'utilisateur -->

            <button type="submit">Ajouter l'Utilisateur</button> <!-- Bouton pour soumettre le formulaire -->
        </form>
    </div>
</body>
</html>
