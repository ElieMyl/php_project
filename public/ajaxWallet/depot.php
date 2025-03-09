<?php 

require("../require.php");
$pdo = db_connect();

session_start();

if (!isset($_SESSION["user_id"])) {
    echo "Erreur : Vous devez être connecté.";
    exit;
}

$user_id = $_SESSION["user_id"];
$date = date('d-m-Y');
$montant = $_POST["montant"];
$type = 1;

if (!is_numeric($_POST["solde_actuel"]) || $_POST["solde_actuel"] < 0) {
    echo "Erreur : Montant invalide.";
    exit;
} else {
    $solde = $_POST["solde_actuel"];
}

try {
    $changeSolde = $pdo->prepare("UPDATE user SET user_coins = ? WHERE id_user = ?");
    $changeSolde->execute([$solde, $user_id]);

    if ($changeSolde->rowCount() > 0) {
        echo "ok";
        $transaction = $pdo->prepare("INSERT INTO transaction (montant_transaction, date_transaction, id_user_transaction, id_type_transaction) VALUES(?,?,?,?)");
        $transaction->execute([$montant, $date, $user_id, $type]);
    } else {
        echo "Erreur : Aucun changement détecté.";
    }
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}

?>
