<?php

// Init Database
require("../require.php");
$pdo = db_connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer et nettoyer les données du formulaire
    $prenom = trim($_POST["first_name"]);
    $nom = trim($_POST["last_name"]);
    $pseudo = trim($_POST["pseudo"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $birth = trim($_POST["birth"]);

    // Vérification du format de la date (JJ/MM/AAAA)
    if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $birth)) {
        $error = "Format de date invalide. Utilisez JJ/MM/AAAA.";
    } else {
        // Convertir la date au format YYYY-MM-DD pour la BDD
        list($jour, $mois, $annee) = explode("/", $birth);
        $dateNaissance = DateTime::createFromFormat("d/m/Y", "$jour/$mois/$annee");

        if (!$dateNaissance) {
            $error = "Date de naissance invalide.";
        } else {
            // Vérifier l'âge
            $aujourdhui = new DateTime();
            $age = $aujourdhui->diff($dateNaissance)->y;

            if ($age < 18) {
                $error = "Vous devez avoir au moins 18 ans pour vous inscrire.";
            } else {
                // Vérifier si l'email est déjà utilisé
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE user_mail = ?");
                $stmt->execute([$email]);
                if ($stmt->fetchColumn() > 0) {
                    $error = "Cet email est déjà utilisé.";
                } else {
                    // Hachage du mot de passe
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Insertion en BDD
                    $stmt = $pdo->prepare("INSERT INTO user (user_prenom, user_nom, user_pseudo, user_mail, user_mdp, user_birth) VALUES (?, ?, ?, ?, ?, ?)");
                    if ($stmt->execute([$prenom, $nom, $pseudo, $email, $hashedPassword, $dateNaissance->format("Y-m-d")])) {
                        $success = "Inscription réussie !";
                    } else {
                        $error = "Erreur lors de l'inscription.";
                    }
                }
            }
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
    <title>Inscription Fasael Casino</title>
</head>
<body>

    <div class="row container">
      <form class="col s12" method="POST">
        <div class="row">
          <h1>Inscription au Fasael Casino</h1>
        </div>

        <?php if (isset($error)): ?>
          <div class="card-panel red lighten-2"><?= $error ?></div>
        <?php elseif (isset($success)): ?>
          <div class="card-panel green lighten-2"><?= $success ?></div>
        <?php endif; ?>

        <div class="row">
          <div class="input-field col s6">
            <input id="first_name" name="first_name" type="text" class="validate" required>
            <label for="first_name">First Name</label>
          </div>
          <div class="input-field col s6">
            <input id="last_name" name="last_name" type="text" class="validate" required>
            <label for="last_name">Last Name</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="email" name="email" type="email" class="validate" required>
            <label for="email">Email</label>
          </div>
          <div class="input-field col s6">
            <input id="password" name="password" type="password" class="validate" required>
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s6">
            <input id="pseudo" name="pseudo" type="text" class="validate" required>
            <label for="pseudo">Pseudo</label>
          </div>
          <div class="input-field col s6">
            <input id="birth" name="birth" type="text" placeholder="JJ/MM/AAAA" maxlength="10" oninput="formatDate(this)" required>
            <label for="birth">Birthdate</label>
          </div>
        </div>
        <div class="row">
          <button class="btn waves-effect waves-light" type="submit">Submit
            <i class="material-icons right">send</i>
          </button>
        </div>
      </form>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
  function formatDate(input) {
    let value = input.value.replace(/\D/g, ''); // Supprime tout sauf les chiffres
    if (value.length > 2) {
      value = value.slice(0, 2) + '/' + value.slice(2);
    }
    if (value.length > 5) {
      value = value.slice(0, 5) + '/' + value.slice(5, 9);
    }
    input.value = value;
  }
</script>
</body>
</html>
