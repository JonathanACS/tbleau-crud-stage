<?php
    //on démare la session, la session sert à envoyer des message/garder les informations d'une page à l'autre
    session_start();


    //Vérification si l'id existe et si il n'est pas vide dans l'url
    if(isset($_GET["id"]) && !empty($_GET["id"])){

        //Connexion à la base de données
        require_once("./include/connect.php");

        //on nettoie l'id envoyer
        $id = strip_tags($_GET["id"]);

        //Demande de la requette
        $sql = "SELECT * FROM `emploi` WHERE `id_emploi` = :id;";

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
            header("Location: emploi.php");

            // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
            exit();
        }
                //Demande de la requette
                $sql = "DELETE FROM `emploi` WHERE `id_emploi` = :id;";


                //Préparation de la requette
                $query = $db->prepare($sql);

                //accrocher les parametre 
                $query->bindValue(':id', $id, PDO::PARAM_INT);

                //execution de la requette
                $query->execute();

                //Message d'erreur à afficher
                $_SESSION["supprimer"] = "information du emploi supprimer";

                //Rediréction vers la page index.php
            header("Location: emploi.php");

    }else{

        //Message d'erreur à afficher
        $_SESSION["erreur"] = "La page en question n'existe pas encore, reviens plus tard";

        //Rediréction vers la page index.php
        header("Location: emploi.php");


        // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
        exit();
    };
?>