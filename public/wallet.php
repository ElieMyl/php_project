<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Mon Portefeuille | Fasael Casino</title>
</head>
<body>

<nav class="nav-extended red darken-4">
    <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo">Fasael Casino</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="game.php"><b>Jeux</b></a></li>
            <li><a href="slots.php"><b>Machines à sous</b></a></li>
            <li><a href="account.php"><b>Mon Compte</b></a></li>
            <li><a href="wallet.php" class="btn waves-effect waves-light" id="solde"><b>Solde : <span id="solde-amount">0.00 €</span></b></a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="center-align">
        <div class="big-balance" style="font-size: 2em; margin: 30px 0;">
            Solde : 0.00 €
        </div>

        <div class="action-buttons">
            <a class="btn waves-effect waves-light green">
                Déposer
                <i class="material-icons right">add</i>
            </a>
            <a class="btn waves-effect waves-light red">
                Retirer
                <i class="material-icons right">remove</i>
            </a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
