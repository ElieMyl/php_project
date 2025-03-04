<?php 

require("../require.php");
$pdo = db_connect();

session_start();

if (!isset($_SESSION["user_id"])) {
    echo "Erreur : Vous devez être connecté.";
    exit;
}

$user_id = $_SESSION["user_id"];
$solde = isset($_POST["solde_actuel"]) ? htmlspecialchars($_POST["solde_actuel"]) : null;

if (!is_numeric($solde) || $solde < 0) {
    echo "Erreur : Montant invalide.";
    exit;
}

try {
    $changeSolde = $pdo->prepare("UPDATE user SET user_coins = ? WHERE id_user = ?");
    $changeSolde->execute([$solde, $user_id]);

    if ($changeSolde->rowCount() > 0) {
        echo "ok";
    } else {
        echo "Erreur : Aucun changement détecté.";
    }
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
}

?>
