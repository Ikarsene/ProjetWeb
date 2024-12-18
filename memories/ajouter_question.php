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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données soumises depuis le formulaire
    $theme_id = $_POST['theme_id'];
    $question_text = $_POST['question_text'];
    $answer_text = $_POST['answer_text'];

    // Vérifie si le thème sélectionné existe dans la base de données
    $sql_check_theme = "SELECT * FROM themes WHERE id = ?";
    $stmt_check = $connex->prepare($sql_check_theme); // Prépare la requête SQL
    $stmt_check->bind_param('i', $theme_id); // Lie le paramètre (id du thème) à la requête
    $stmt_check->execute(); // Exécute la requête
    $result_check = $stmt_check->get_result(); // Récupère le résultat de la requête

    // Si le thème existe
    if ($result_check->num_rows > 0) {
        // Ajoute la question à la base de données
        $sql = "INSERT INTO questions (idtheme, question, reponse) VALUES (?, ?, ?)";
        $stmt = $connex->prepare($sql); // Prépare la requête d'insertion
        $stmt->bind_param('iss', $theme_id, $question_text, $answer_text); // Lie les paramètres à la requête
        // Exécute la requête d'insertion
        if ($stmt->execute()) {
            echo "<p style='color: green;'>La question a été ajoutée avec succès.</p>";
        } else {
            echo "<p style='color: red;'>Erreur lors de l'ajout de la question.</p>";
        }
    } else {
        echo "<p style='color: red;'>Le thème sélectionné n'existe pas.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit l'encodage des caractères -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Permet de rendre la page responsive sur les appareils mobiles -->
    <title>Ajouter une Question</title> <!-- Titre de la page -->
    <link rel="stylesheet" href="myCSS.css"> <!-- Lien vers la feuille de style externe -->
</head>
<body>
    <div class="container">
        <!-- Bouton pour revenir à la page d'accueil -->
        <button onclick="window.location.href='accueil.php'">Retour à l'Accueil</button>

        <h1>Ajouter une Question</h1> <!-- Titre de la page -->

        <!-- Formulaire pour ajouter une question -->
        <form method="POST">
            <label for="theme_id">Choisir une Matière :</label>
            <select name="theme_id" id="theme_id" required>
                <?php
                // Récupère la liste des thèmes depuis la base de données
                $sql = "SELECT * FROM themes";
                $result = $connex->query($sql); // Exécute la requête pour obtenir tous les thèmes
                // Affiche chaque thème dans une option du menu déroulant
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['nomtheme']) . "</option>";
                }
                ?>
            </select>

            <label for="question_text">Question :</label>
            <textarea name="question_text" id="question_text" required></textarea> <!-- Champ pour saisir la question -->

            <label for="answer_text">Réponse :</label>
            <textarea name="answer_text" id="answer_text" required></textarea> <!-- Champ pour saisir la réponse -->

            <button type="submit">Ajouter la Question</button> <!-- Bouton pour soumettre le formulaire -->
        </form>
    </div>
</body>
</html>
