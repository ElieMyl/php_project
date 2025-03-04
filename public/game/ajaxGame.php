<?php 

require("../require.php");
$pdo = db_connect();

session_start();

if (!isset($_SESSION["user_id"])) {
    echo "Erreur : Vous devez être connecté.";
    exit;
}

$user_id = $_SESSION["user_id"];

$mise = "";

if (isset($_POST["mise"])) {
    $mise = htmlspecialchars($_POST["mise"]);

    if (!is_numeric($mise) || $mise < 0) {
        echo "Erreur : Montant invalide.";
        exit;
    }

    $resultats = ["Gagné", "Perdu", "Égalité"];
    $resultatFinal = $resultats[array_rand($resultats)];

    if ($resultatFinal == "Gagné") {
        $changeSolde = $pdo->prepare("UPDATE user SET user_coins = user_coins + ? WHERE id_user = ?");
        $changeSolde->execute([$mise, $user_id]);

        echo "Gagné";
    } else if ($resultatFinal == "Égalité") {
        echo "Égalité";
    } else {
        $changeSolde = $pdo->prepare("UPDATE user SET user_coins = user_coins - ? WHERE id_user = ?");
        $changeSolde->execute([$mise, $user_id]);

        echo "Perdu";
    }
} else {
    echo "Erreur : Aucune mise détectée.";
}






?>