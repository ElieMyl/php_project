<?php
session_start();
require("../public/require.php");
$pdo = db_connect();

// Vérifier si l'utilisateur est connecté et admin
if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/auth/login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Liste des jeux | Admin</title>
</head>
<body>

    <div class="center-title">
        <h1>Liste des jeux du Fasael Casino</h1>
    </div>
    

    <div class="container">
        <table>
            <thead>
            <tr>
                <th>Nom du jeu</th>
                <th>Lien du jeux</th>
                <th>Catégorie</th>
            </tr>
            </thead>

            <tbody>

            <?php 
            
                $game_list = $pdo->prepare("SELECT * FROM jeux");
                $game_list->execute();

                while($game = $game_list->fetch(PDO::FETCH_ASSOC)){
                    $cat = $pdo->prepare("SELECT libelle_categorie FROM categorie WHERE id_categorie = ?");
                    $cat->execute([$game["id_categorie"]]);

                    $categorie = $cat->fetch(PDO::FETCH_ASSOC);

                    echo('
                    <tr>
                        <td>' .htmlspecialchars($game["libelle_jeux"]). '</td>
                        <td>' .htmlspecialchars($game["lien_jeux"]). '</td>
                        <td>' .htmlspecialchars($categorie["libelle_categorie"]). '</td>
                    </tr>
                    ');
                }
            
            
            ?>
            </tbody>


        </table>
    </div>            
    
</body>
</html>