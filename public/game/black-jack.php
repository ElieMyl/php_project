<?php

require("../require.php");
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
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bj/bj.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <title>Jeu de Casino - Blackjack</title>
</head>
<body>

<nav class="nav-extended red darken-4">
    <div class="nav-wrapper container">
        <a href="../../index.php" class="brand-logo">Fasael Casino</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="../index.php#jeux"><b>Jeux</b></a></li>
            <li><a href="../index.php#machine"><b>Machines à sous</b></a></li>
            <?php if ($_SESSION["user_admin"] == 1): ?>
            <li><a href="../../private"><b>Admin</b></a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="../wallet.php" class="btn waves-effect waves-light" id="solde"><b>Solde : <span id="solde-amount"><?php echo $solde_total; ?> €</span></b></a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

  <div class="container-bj">
    <h1>Jeu de Casino - Blackjack</h1>
    <div class="top-section">
     
      <div class="video-container">
        <iframe src="https://www.youtube.com/embed/g1Ej38PSL84?autoplay=1&mute=1&loop=1&playlist=g1Ej38PSL84" 
        frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="bet-section">
        <h2>Placez votre mise</h2>
        <div class="bet-container">
          <input type="number" id="betAmount" placeholder="Montant de la mise">
          <button id="mise">Miser</button>
        </div>
      </div>
    </div>
  </div>
<script src="bj/bj.js"></script>
</body>
</html>
