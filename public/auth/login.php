<?php
session_start();
require("../require.php");
$pdo = db_connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Vérification si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT id_user, user_prenom, user_nom, user_pseudo, user_mdp FROM user WHERE user_mail = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["user_mdp"])) {
        // Connexion réussie → Stocker en session
        $_SESSION["user_id"] = $user["id_user"];
        $_SESSION["user_prenom"] = $user["user_prenom"];
        $_SESSION["user_nom"] = $user["user_nom"];
        $_SESSION["user_pseudo"] = $user["user_pseudo"];
        header("Location: ../index.php"); // Redirection vers la page sécurisée
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
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
    <title>Connexion | Fasael Casino</title>
</head>
<body>

    <div class="row container">
      <form class="col s12" method="POST">
        <div class="row">
          <h1>Connexion à Fasael Casino</h1>
        </div>

        <?php if (isset($error)): ?>
          <div class="card-panel red lighten-2"><?= $error ?></div>
        <?php endif; ?>

        <div class="row">
          <div class="input-field col s12">
            <input id="email" name="email" type="email" class="validate" required>
            <label for="email">Email</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <input id="password" name="password" type="password" class="validate" required>
            <label for="password">Mot de passe</label>
          </div>
        </div>

        <div class="row">
          <button class="btn waves-effect waves-light" type="submit">Se connecter
            <i class="material-icons right">login</i>
          </button>
        </div>

        <div class="row">
          <p>Pas encore inscrit ? <a href="signup.php">Créer un compte</a></p>
        </div>

      </form>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
