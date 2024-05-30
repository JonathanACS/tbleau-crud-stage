<?php
    //lancement de la session
    session_start();

    //vérification si l'utilisateur est déjà connecter ou pas
    if(!isset($_SESSION["user"])){
        header("Location: connexion_users.php");
        exit;
    }

    //supprime une variable
    unset($_SESSION["user"]);

    //Rediréction vers la page pour la page des profils
    header("Location: index.php");

    // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
    exit();

?>