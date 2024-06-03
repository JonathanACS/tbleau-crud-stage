<?php

    // //lancement de la session
    // session_start();

    // //vérification si l'utilisateur est déjà connecter ou pas
    // if(!isset($_SESSION["user"])){
    //     header("Location: connexion_users.php");
    //     exit;
    // }

    // //supprime une variable
    // unset($_SESSION["user"]);

    // //Rediréction vers la page pour la page des profils
    // header("Location: index.php");

    // // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
    // exit();
    
//---------------------------------------------------------------------------//
    
// Lancement de la session
session_start();

// Vérification si l'utilisateur est déjà connecté ou pas
if (!isset($_SESSION["user"])) {
    header("Location: connexion_users.php");
    exit();
}

// Supprimer toutes les variables de session
$_SESSION = array();

// Si vous voulez détruire complètement la session, vous devez aussi supprimer le cookie de session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Redirection vers la page d'accueil ou de connexion
header("Location: index.php");

// Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
exit();

?>