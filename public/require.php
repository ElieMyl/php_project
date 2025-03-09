<?php 

function db_connect() {

$host = "localhost";
$dbname = "project_php";
$username = "root";
$password = "root";

    // Création d'une instance PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);

    return $pdo;

}
function auth_admin() {

    if ($_SESSION["user_admin"] !== 1) {
        header("Location: ../public/auth/login.php");
        exit;
    }

}



?>