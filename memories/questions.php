<?php
session_start();  // Démarre une nouvelle session ou reprend une session existante
if (!isset($_SESSION['login'])) {  // Vérifie si l'utilisateur est connecté
    header("Location: index.php");  // Si l'utilisateur n'est pas connecté, il est redirigé vers la page de login
    exit();  // Arrête l'exécution du script
}

require_once('admin/connex.inc.php');  // Inclut le fichier de connexion à la base de données

// Récupérer les thèmes depuis la base de données
$sql_themes = "SELECT id, nomtheme FROM themes";
$stmt_themes = $connex->prepare($sql_themes);
$stmt_themes->execute();
$result_themes = $stmt_themes->get_result();
$themes = $result_themes->fetch_all(MYSQLI_ASSOC);


// Récupérer l'ID de la matière choisie (par défaut, 1 si aucune matière n'est sélectionnée)
$theme_id = $_POST['theme_id'] ?? 1; 

// Requête pour récupérer les questions liées au thème sélectionné
$sql = "SELECT * FROM questions WHERE idtheme = ?";  // Utilisation de la requête préparée
$stmt = $connex->prepare($sql);  // Prépare la requête
$stmt->bind_param('i', $theme_id);  // Lie le paramètre $theme_id à la requête
$stmt->execute();  // Exécute la requête
$result = $stmt->get_result();  // Récupère le résultat de la requête
$questions = $result->fetch_all(MYSQLI_ASSOC);  // Récupère toutes les questions sous forme de tableau associatif

if (!$questions) {  // Si aucune question n'a été trouvée pour ce thème
    echo "<p>Aucune question disponible pour ce thème.</p>";  // Affiche un message d'erreur
    exit();  // Arrête l'exécution du script
}

// Gérer l'enregistrement de l'évaluation lorsque le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evaluation']) && isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];  // Récupère l'ID de la question
    $evaluation = (int)$_POST['evaluation'];  // Récupère l'évaluation (1 à 5)
    $user_id = $_SESSION['id'];  // Récupère l'ID de l'utilisateur connecté

    // Calculer la date de réapparition en fonction de l'évaluation (logique simplifiée)
    $nbre_jours = match ($evaluation) {
        1 => 1,  // Si l'utilisateur a oublié, la prochaine révision sera dans 1 jour
        2 => 3,  // Si l'utilisateur a moyennement mémorisé, la révision sera dans 3 jours
        3 => 5,  // Révision dans 5 jours
        4 => 7,  // Révision dans 7 jours
        5 => 10, // Révision dans 10 jours
        default => 1,  // Par défaut, révision dans 1 jour
    };

    // Calculer la prochaine date de réapparition
    $date_reap = date('Y-m-d', strtotime("+$nbre_jours days"));

    // Insérer l'évaluation dans la table datepresentation
    $sql_insert = "INSERT INTO datepresentation (iduser, idquestion, memorisation, prochainedate, idcycle) 
                   VALUES (?, ?, ?, ?, ?)";  // Requête pour insérer les données dans la table
    $stmt_insert = $connex->prepare($sql_insert);  // Prépare la requête
    $idcycle = 1;  // Cycle de révision (peut être ajusté selon la logique)
    $stmt_insert->bind_param('iiisi', $user_id, $question_id, $evaluation, $date_reap, $idcycle);  // Lie les paramètres à la requête

    if ($stmt_insert->execute()) {  // Si l'insertion réussit
        // Redirige vers la question suivante
        header("Location: questions.php?questionIndex=" . ($_POST['questionIndex'] + 1)); 
        exit();  // Arrête l'exécution du script
    } else {
        echo "<p>Erreur lors de l'enregistrement de l'évaluation.</p>";  // Affiche une erreur si l'insertion échoue
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Révision des Questions</title>
    <link rel="stylesheet" href="myCSS.css">  <!-- Lien vers le fichier CSS pour les styles -->
    <style>
        .container {
            max-width: 900px;  /* Limite la largeur du conteneur */
            margin: 50px auto;  /* Centrage du conteneur */
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Ombre autour du conteneur */
        }
        h1 {
            text-align: center;
            color: #0066cc;  /* Couleur du titre */
            margin-bottom: 20px;
        }

        /* Styles pour la carte retournable */
        .card {
            width: 100%;
            height: 200px;  /* Hauteur de la carte */
            background-color: #444;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);  /* Ombre de la carte */
            perspective: 1000px;  /* Perspective pour la rotation */
            margin: 15px 0;
        }

        .card-inner {
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            position: relative;
        }

        .card:hover .card-inner {
            transform: rotateY(180deg);  /* Rotation de la carte au survol */
        }

        .card-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;  /* Cache l'autre côté de la carte */
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 15px;
            box-sizing: border-box;
            border-radius: 10px;
        }

        .card-front {
            background-color: #444;
        }

        .card-back {
            background-color: #555;
            transform: rotateY(180deg);  /* Retourne la carte */
        }

        .answer {
            background-color: #555;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: #0066cc;
        }

        input[type="range"] {
            width: 100%;  /* Largeur du curseur de l'évaluation */
            margin: 10px 0;
        }

        button {
            background-color: #0066cc;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004d99;  /* Changement de couleur au survol */
        }
    </style>
</head>
<body>
    <div class="container">
        <button onclick="window.location.href='accueil.php'" style="background-color: #0066cc; margin-bottom: 20px;">Retour à l'Accueil</button>

        <h1>Révision des Questions</h1>
        <label for="theme_id">Choisissez la matière :</label> 
        <form method="POST" action="questions.php">
            <select name="theme_id" id="theme_id" onchange="this.form.submit()"> 
                <?php foreach ($themes as $theme) { ?> 
                    <option value="<?php echo $theme['id']; ?>"><?php echo htmlspecialchars($theme['nomtheme']); ?></option> 
                <?php } ?> 
            </select>
        </form>

        <?php 
        // Obtenir l'index de la question à afficher (par défaut 0)
        $questionIndex = $_GET['questionIndex'] ?? 0;  
        $totalQuestions = count($questions);  // Nombre total de questions pour le thème

        if ($totalQuestions > 0 && $questionIndex < $totalQuestions) {  // Vérifie si la question est valide
            $question = $questions[$questionIndex];  // Récupère la question à afficher
            ?>
            <div class="card">
                <div class="card-inner">
                    <div class="card-face card-front">
                        <h3><?php echo htmlspecialchars($question['question']); ?></h3>  <!-- Affiche la question -->
                    </div>
                    <div class="card-face card-back">
                        <p><?php echo htmlspecialchars($question['reponse']); ?></p>  <!-- Affiche la réponse -->
                        <form method="POST" action="questions.php">
                            
                            <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">  <!-- ID de la question -->
                            <input type="hidden" name="questionIndex" value="<?php echo $questionIndex; ?>">  <!-- Index de la question -->
                            <label for="evaluation">Évaluation (1 - oublié, 5 - bien mémorisé) :</label>
                            <input type="range" name="evaluation" min="1" max="5" required>  <!-- Curseur pour évaluer la question -->
                            <button type="submit">Soumettre</button>  <!-- Bouton pour soumettre l'évaluation -->
                        </form>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <p>Toutes les questions ont été révisées !</p>  <!-- Message si toutes les questions ont été révisées -->
        <?php } ?>
    </div>
</body>
</html>
