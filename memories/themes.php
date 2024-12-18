<?php
session_start();  // Démarre une nouvelle session ou reprend une session existante
if (!isset($_SESSION['login'])) {  // Vérifie si l'utilisateur est connecté
    header("Location: index.php");  // Si l'utilisateur n'est pas connecté, il est redirigé vers la page de login
    exit();  // Arrête l'exécution du script
}

require_once('admin/connex.inc.php');  // Inclut le fichier de connexion à la base de données



// Vérifie si le thème existe déjà dans la base de données
$sql_check = "SELECT * FROM users WHERE themes = ?"; // Requête pour vérifier l'existence du login
$stmt_check = $connex->prepare($sql_check); // Prépare la requête SQL
$stmt_check->bind_param('s', $themes); // Lie le paramètre 'themes' à la requête
$stmt_check->execute(); // Exécute la requête
$result_check = $stmt_check->get_result(); // Récupère le résultat de la requête

// Si un theme existe déjà
if ($result_check->num_rows > 0) {
    echo "<p style='color: red;'>Ce theme est déjà utilisé !</p>";
} else {
    // Insère le nouveau thème dans la base de données
    $sql = "INSERT INTO themes (id, nomtheme) VALUES (?, ?)"; // Requête d'insertion
    $stmt = $connex->prepare($sql); // Prépare la requête d'insertion
    $stmt->bind_param('ss', $themes); // Lie les paramètres 'theme' à la requête
    // Exécute la requête d'insertion
    if ($stmt->execute()) {
        echo "<p style='color: green;'>Thème ajouté avec succès !</p>";
    } else {
        echo "<p style='color: red;'>Erreur lors de l'ajout du thème.</p>";
    }
}