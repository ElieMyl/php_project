<?php 

require("require.php");
$pdo = db_connect();

session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php"); 
    exit;
}

$user = $_SESSION["user_pseudo"];

$solde_total = $pdo->prepare("SELECT user_coins FROM user WHERE id_user = ?");
$solde_total->execute([$_SESSION["user_id"]]);
$solde_total = $solde_total->fetch(PDO::FETCH_ASSOC);
$solde_total = $solde_total["user_coins"];

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

<nav class="nav-extended red darken-4">
    <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo">Fasael Casino</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="index.php#jeux"><b>Jeux</b></a></li>
            <li><a href="index.php#machine"><b>Machines à sous</b></a></li>
            <?php if ($_SESSION["user_admin"] == 1): ?>
            <li><a href="../private"><b>Admin</b></a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="wallet.php" class="btn waves-effect waves-light" id="solde"><b>Solde : <span id="solde-amount"><?php echo number_format($solde_total, 2); ?> €</span></b></a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="game.php"><b>Jeux</b></a></li>
    <li><a href="slots.php"><b>Machines à sous</b></a></li>
    <li><a href="account.php"><b>Mon Compte</b></a></li>
    <li><a href="wallet.php"><b>Solde : <span id="solde-amount-mobile"><?php echo number_format($solde_total, 2); ?> €</span></b></a></li>
</ul>

<div class="container">
    <div class="center-title">
        <h1>Bienvenue sur Fasael Casino <?php echo($user) ?>, bon jeu à toi !</h1>
    </div>
    <div class="center-title" id="jeux">
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
     <div class="center-title" id="machine">
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
     
    <div class="center-align" style="margin: 40px 0;">
        <a href="contact.php" class="waves-effect waves-light btn red darken-4">
            <i class="material-icons left">mail</i>Nous contacter
        </a>
    </div>
</div>

<footer class="page-footer red darken-4">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Fasael Casino</h5>
                <p class="grey-text text-lighten-4">Le meilleur casino en ligne pour vos jeux préférés.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Liens</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="contact.php">Contact</a></li>
                    <li><a class="grey-text text-lighten-3" href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © <?php echo date('Y'); ?> Fasael Casino
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>