<?php 
require("require.php");
$pdo = db_connect();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Récupération du solde comme dans index.php
$solde_total = 0;
if (isset($_SESSION["user_id"])) {
    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(
            CASE 
                WHEN id_type_transaction = 1 THEN montant_transaction 
                WHEN id_type_transaction = 2 THEN -montant_transaction
                ELSE 0
            END
        ), 0) as solde_total
        FROM transaction 
        WHERE id_user_transaction = ?
    ");
    $stmt->execute([$_SESSION["user_id"]]);
    $solde_total = $stmt->fetchColumn();
}

// Traitement du formulaire de contact
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sujet = htmlspecialchars($_POST['sujet']);
    $message = htmlspecialchars($_POST['message']);
    $email = htmlspecialchars($_POST['email']);
    $note = isset($_POST['note']) ? intval($_POST['note']) : 0;
    
    try {
        // Gestion de l'upload d'image
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if (in_array($ext, $allowed)) {
                $upload_dir = 'uploads/contact/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $new_filename = uniqid() . '.' . $ext;
                $destination = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $image_path = $destination;
                }
            }
        }

        $stmt = $pdo->prepare("INSERT INTO contact (id_user_contact, sujet_contact, message_contact, email_contact, note_contact, image_contact, date_contact) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$_SESSION["user_id"], $sujet, $message, $email, $note, $image_path]);
        $success_message = "Votre message a été envoyé avec succès !";
    } catch (Exception $e) {
        $error_message = "Une erreur est survenue lors de l'envoi du message.";
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
    <title>Contact | Fasael Casino</title>
    <style>
    .rating {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: center;
        width: 100%;
        margin: 20px 0;
    }

    .rating input {
        display: none;
    }

    .rating label {
        cursor: pointer;
        padding: 0 5px;
        font-size: 30px;
        color: #ddd;
    }

    .rating label:before {
        content: '★';
    }

    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffd700;
    }

    /* Conteneur pour le titre et les étoiles */
    .rating-container {
        text-align: center;
        margin: 20px 0;
    }

    .rating-container p {
        margin-bottom: 10px;
        font-size: 1.2em;
    }
    </style>
</head>
<body>

<nav class="nav-extended red darken-4">
    <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo">Fasael Casino</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="game.php"><b>Jeux</b></a></li>
            <li><a href="slots.php"><b>Machines à sous</b></a></li>
            <li><a href="account.php"><b>Mon Compte</b></a></li>
            <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="wallet.php" class="btn waves-effect waves-light" id="solde"><b>Solde : <span id="solde-amount"><?php echo number_format($solde_total, 2); ?> €</span></b></a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container">
    <h2 class="center-align">Contactez-nous</h2>
    
    <?php if (isset($success_message)): ?>
        <div class="card-panel green lighten-4 center-align">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="card-panel red lighten-4 center-align">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <form class="col s12" method="POST" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" class="validate" required>
                    <label for="email">Votre email pour la réponse</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="sujet" type="text" name="sujet" required>
                    <label for="sujet">Sujet</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="message" class="materialize-textarea" name="message" required></textarea>
                    <label for="message">Votre message</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="rating-container">
                        <p>Note</p>
                        <div class="rating">
                            <?php for($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?php echo $i; ?>" name="note" value="<?php echo $i; ?>" />
                            <label for="star<?php echo $i; ?>"></label>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="file-field input-field col s12">
                    <div class="btn red darken-4">
                        <span>Image</span>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Optionnel : Ajouter une image">
                    </div>
                </div>
            </div>
            <div class="row center-align">
                <button class="btn waves-effect waves-light red darken-4" type="submit">
                    Envoyer
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
    </div>
</div>

<footer class="page-footer red darken-4">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Fasael Casino</h5>
                <p class="grey-text text-lighten-4">Le meilleur casino en ligne pour vos jeux préférés.</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Liens</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="contact.php">Contact</a></li>
                    <li><a class="grey-text text-lighten-3" href="#">Mentions légales</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © <?php echo date('Y'); ?> Fasael Casino
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);

    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        var noteChecked = document.querySelector('input[name="note"]:checked');
        if (!noteChecked) {
            e.preventDefault();
            M.toast({html: 'Veuillez donner une note', classes: 'red'});
        }
    });
});
</script>

</body>
</html>
