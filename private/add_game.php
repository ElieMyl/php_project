<?php
session_start();
require("../public/require.php");
$pdo = db_connect();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/auth/login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT user_admin FROM user WHERE id_user = ?");
$stmt->execute([$_SESSION["user_id"]]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user["user_admin"] != 1) {
    echo "Accès refusé. Vous n'êtes pas administrateur.";
    exit;
}

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_name = trim($_POST["game_name"]);
    $description = trim($_POST["description"]);
    $link = trim($_POST["link"]);
    $id_categorie = $_POST["id_categorie"];
    $image_name = null;

    if (empty($game_name) || empty($description) || empty($link) || empty($id_categorie)) {
        $errors[] = "Tous les champs sont requis.";
    }

    if (!empty($_FILES["game_image"]["name"])) {
        $target_dir = "../public/img/";
        $image_name = uniqid() . "_" . basename($_FILES["game_image"]["name"]); // Générer un nom unique
        $target_file = $target_dir . $image_name;
        $image_tmp = $_FILES["game_image"]["tmp_name"];

        $check = getimagesize($image_tmp);
        if ($check === false) {
            $errors[] = "Le fichier n'est pas une image valide.";
        }
    } else {
        $errors[] = "Veuillez ajouter une image pour le jeu.";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO jeux (libelle_jeux, description_jeux, image_jeux, lien_jeux, id_categorie) VALUES (?, ?, ?, ?, ?)");
            $success = $stmt->execute([$game_name, $description, $image_name, $link, $id_categorie]);

            if ($success) {
                if (!move_uploaded_file($image_tmp, $target_file)) {
                    $pdo->prepare("DELETE FROM jeux WHERE libelle_jeux = ?")->execute([$game_name]);
                    $errors[] = "L'image n'a pas pu être enregistrée. L'ajout du jeu a été annulé.";
                    $success = false;
                }
            } else {
                $errors[] = "Erreur lors de l'ajout du jeu en base de données.";
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Add a game | Admin</title>
</head>
<body>

<div class="container">
    <h1>Ajout d'un jeu au Fasael Casino</h1>

    <?php if (!empty($errors)): ?>
        <div class="card-panel red lighten-2">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="card-panel green lighten-2">Le jeu a été ajouté avec succès !</div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="input-field col s6">
                <input id="game_name" name="game_name" type="text" class="validate" required>
                <label for="game_name">Nom du jeu</label>
            </div>
            <div class="input-field col s6">
                <input id="description" name="description" type="text" class="validate" required>
                <label for="description">Description</label>
            </div>
        </div>

        <div class="row">
            <div class="file-field input-field col s6">
                <div class="btn">
                    <span>Image du jeu</span>
                    <input type="file" name="game_image" required>
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>

            <div class="input-field col s6">
                <input id="link" name="link" type="text" class="validate" required>
                <label for="link">Lien du jeu</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <select name="id_categorie" required>
                    <option value="" disabled selected>Choix de la catégorie</option>
                    <?php 
                    $cat = $pdo->prepare("SELECT * FROM categorie");
                    $cat->execute();

                    while ($categorie = $cat->fetch(PDO::FETCH_ASSOC)) { 
                        echo '<option value="' . htmlspecialchars($categorie["id_categorie"]) . '">' . htmlspecialchars($categorie["libelle_categorie"]) . '</option>';
                    }
                    ?>
                </select>
                <label>Catégorie de jeux</label>
            </div>
        </div>

        <div class="row">
            <button class="btn waves-effect waves-light" type="submit">Ajouter
                <i class="material-icons right">send</i>
            </button>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var elems = document.querySelectorAll("select");
    M.FormSelect.init(elems);
});
</script>
</body>
</html>
