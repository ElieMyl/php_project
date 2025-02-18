<?php 

function db_connect() {

$host = "localhost";
$dbname = "project_php";
$username = "root";
$password = "root";

    // Création d'une instance PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Affichage des erreurs sous forme d'exception
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mode de récupération des résultats sous forme de tableau associatif
        PDO::ATTR_EMULATE_PREPARES => false // Désactiver l'émulation des requêtes préparées pour éviter les injections SQL
    ]);

    return $pdo;

}



?>