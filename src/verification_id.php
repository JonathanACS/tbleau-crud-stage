<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();


    //Vérification si l'id existe et si il n'est pas vide dans l'url
    if(isset($_GET["id"]) && !empty($_GET["id"])){

        //Connexion à la base de données
        require_once("connect.php");

        //on nettoie l'id envoyer
        $id = strip_tags($_GET["id"]);

        //Demande de la requette
        $sql = "SELECT * FROM `stage` WHERE `id` = :id;";

        //Préparation de la requette
        $query = $db->prepare($sql);

        //accrocher les parametre 
        $query->bindValue(':id', $id, PDO::PARAM_INT);

        //execution de la requette
        $query->execute();

        //on récupère le resultat
        $result = $query->fetch();

        //on vérifie si l'id existe
        if(!$result){

            //Message d'erreur à afficher
            $_SESSION["erreur"] = "l'id en question existe pas encore, reviens plus tard";

            //Rediréction vers la page index.php
            header("Location: index.php");

            // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
            exit();
        }

    }else{

        //Message d'erreur à afficher
        $_SESSION["erreur"] = "La page en question n'existe pas encore, reviens plus tard";

        //Rediréction vers la page index.php
        header("Location: index.php");

        // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
        exit();
    };
?>