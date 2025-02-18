<?php 

    require("require.php");

    $pdo = db_connect();


    try {
    
        // Préparation de la requête
        $stmt = $pdo->prepare("SELECT * FROM user");
    
        // Exécution de la requête
        $stmt->execute();
    
        // Récupération des résultats sous forme de tableau associatif
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Affichage des résultats
        foreach ($users as $user) {
            echo ("L'user est " .$user['user_prenom']. " " .$user['user_nom']);
        }
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }









?>