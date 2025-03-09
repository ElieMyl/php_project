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

if (isset($_POST["mise"]) && $_POST["mise"] != "" && $_POST['gameId'] != "") {
    $mise = htmlspecialchars($_POST["mise"]);
    $game_id = htmlspecialchars($_POST["gameId"]);

    if (!is_numeric($mise) || $mise < 0) {
        echo "Erreur : Montant invalide.";
        exit;
    }

    $resultats = ["Gagné", "Perdu", "Égalité"];
    $resultatFinal = $resultats[array_rand($resultats)];

    if ($resultatFinal == "Gagné") {
        $changeSolde = $pdo->prepare("UPDATE user SET user_coins = user_coins + ? WHERE id_user = ?");
        $changeSolde->execute([$mise, $user_id]);
        $result = "1";

        echo "Gagné";
    } else if ($resultatFinal == "Égalité") {
        echo "Égalité";
        $result = "3";
    } else {
        $changeSolde = $pdo->prepare("UPDATE user SET user_coins = user_coins - ? WHERE id_user = ?");
        $changeSolde->execute([$mise, $user_id]);

        $result = "2";

        echo "Perdu";
    }

    $date = date('d-m-Y');


    $historique = $pdo->prepare("INSERT INTO historique_jeux (montant_historique, date_historique, id_user_historique, id_jeux_historique, id_type_historique) 
    VALUES (?, ?, ?, ?, ?)");
    $historique->execute([$mise, $date, $user_id, $game_id, $result]);

} else {
    echo "Erreur : Aucune mise détectée.";
}








?>