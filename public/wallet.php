<?php

require("require.php");
$pdo = db_connect();

session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php"); 
    exit;
}

$solde_user = $pdo->prepare("SELECT user_coins FROM user WHERE id_user = ?");
$solde_user->execute([$_SESSION["user_id"]]);
$solde_user = $solde_user->fetch(PDO::FETCH_ASSOC);
$solde_user = $solde_user["user_coins"];


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Mon Portefeuille | Fasael Casino</title>
</head>
<body>

<nav class="nav-extended red darken-4">
    <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo">Fasael Casino</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="index.php#jeux"><b>Jeux</b></a></li>
            <li><a href="index.php#machine"><b>Machines à sous</b></a></li>
            <li><a href="wallet.php" class="btn waves-effect waves-light" id="solde"><b>Solde : <span id="solde-amount"><?php echo($solde_user) ?>€</span></b></a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="center-align">
        <div class="big-balance" style="font-size: 2em; margin: 30px 0;">
            Solde : <?php echo($solde_user) ?> €
        </div>

        <div class="action-buttons">
            <a class="btn waves-effect waves-light green depot">
                Déposer
                <i class="material-icons right">add</i>
            </a>
            <a class="btn waves-effect waves-light red retrait">
                Retirer
                <i class="material-icons right">remove</i>
            </a>
        </div>
    </div>
</div>
<div class="container">
    <table>
        <thead>
        <tr>
            <th>Date</th>
            <th>Montant</th>
            <th>Type</th>
        </tr>
        </thead>

        <tbody>
        <?php

        $history = $pdo->prepare("SELECT * FROM transaction WHERE id_user_transaction = ?");
        $history->execute([$_SESSION["user_id"]]);

        while ($transaction = $history->fetch(PDO::FETCH_ASSOC)) {
            if ($transaction["id_type_transaction"] == 1) {
                $type = "Dépôt";
            } else {
                $type = "Retrait";
            }
            echo('
            <tr>
                <td>' .$transaction['date_transaction']. '</td>
                <td>' .$transaction['montant_transaction']. '</td>
                <td>' .$type. '</td>
            </tr>
            ');
        }

        ?>
        </tbody>
    </table>
</div>

<!-- Modals -->
<div id="modalDepot" class="modal">
    <div class="modal-content">
        <h4>Déposer de l'argent</h4>
        <div class="input-field">
            <input type="number" id="montantDepot" min="10" placeholder="Entrez un montant">
            <label for="montantDepot">Montant à déposer (min 10€)</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn red">Annuler</a>
        <a href="#!" class="btn green" id="validerDepot">Valider</a>
    </div>
</div>

<div id="modalRetrait" class="modal">
    <div class="modal-content">
        <h4>Retirer de l'argent</h4>
        <div class="input-field">
            <input type="number" id="montantRetrait" min="10" placeholder="Entrez un montant">
            <label for="montantRetrait">Montant à retirer (min 10€)</label>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn red">Annuler</a>
        <a href="#!" class="btn green" id="validerRetrait">Valider</a>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="js/wallet.js"></script>
</body>
</html>
