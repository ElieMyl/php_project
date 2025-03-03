<?php 

    require("require.php");
    $pdo = db_connect();

    session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["user_pseudo"];


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Accueil | Fasael Casino</title>
</head>
<body>

<div class="container">
    <div class="center-title">
        <h1>Bienvenue sur Fasael Casino <?php echo($user) ?>, bon jeu à toi !</h1>
    </div>
    <div class="center-title">
        <h2>Jeux</h2>
    </div>
    <div class="row">


    <?php

    $game_list_jeux = $pdo->prepare("SELECT * FROM jeux WHERE id_categorie = 1");
    $game_list_jeux->execute();

    while($jeux = $game_list_jeux->fetch(PDO::FETCH_ASSOC)){
        $name = strtolower(str_replace(' ', '-', $jeux["libelle_jeux"]));
        echo('
        
        
        
            <div class="col l6">
                <div class="card">
                    <div class="card-image">
                    <img src="img/' . htmlspecialchars($jeux["image_jeux"]). '" height="284.22">
                    <span class="card-title">' .htmlspecialchars($jeux["libelle_jeux"]). '</span>
                    <a href="game/' . htmlspecialchars($name) . '.php"class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">play_arrow</i></a>
                    </div>
                </div>
            </div>
        
        
        ');
    }



    ?>
     </div>
     <div class="center-title">
        <h2>Machine à sous</h2>
    </div>
    <div class="row">


    <?php

    $game_list_machine = $pdo->prepare("SELECT * FROM jeux WHERE id_categorie = 2");
    $game_list_machine->execute();

    while($machine = $game_list_machine->fetch(PDO::FETCH_ASSOC)){
        $name = strtolower(str_replace(' ', '-', $machine["libelle_jeux"]));
        echo('
        
            <div class="col l6">
                <div class="card">
                    <div class="card-image">
                    <img src="img/' .htmlspecialchars($machine["image_jeux"]). '" height="284.22">
                    <span class="card-title">' .htmlspecialchars($machine["libelle_jeux"]). '</span>
                    <a href="game/' . htmlspecialchars($name) . '.php"class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">play_arrow</i></a>
                    </div>
                </div>
            </div>

            ');
    };


    ?>

    </div>
     

</div>




</body>
</html>