<?php
    //Vérification si l'utilisateur est connecté et son ID est dans la session
    if(isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])){

        //Connexion à la base de données
        require_once("connect.php");

        //On nettoie l'ID envoyé
        $user_id = intval($_SESSION["user"]["id"]);

        //Vérification si l'ID de l'utilisateur existe et n'est pas vide dans l'URL
        if(isset($_GET["id"]) && !empty($_GET["id"])){

            //On nettoie l'ID envoyé
            $id_emploi = strip_tags($_GET["id"]);

            //Demande de la requête avec une clause WHERE pour vérifier que l'utilisateur est le créateur du stage
            $sql = "SELECT * FROM `emploi` WHERE `id_emploi` = :id_emploi AND `id_user` = :user_id";

            //Préparation de la requête
            $query = $db->prepare($sql);

            //Accrocher les paramètres
            $query->bindValue(':id_emploi', $id_emploi, PDO::PARAM_INT);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            //Exécution de la requête
            $query->execute();

            //On récupère le résultat
            $result = $query->fetch();

            //On vérifie si l'ID existe
            if(!$result){

                //Message d'erreur à afficher
                $_SESSION["erreur"] = "Vous êtes allé trop loin, aucun stage ne correspond!";

                //Redirection vers la page index.php
                header("Location: emploi.php");

                // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
                exit();
            }

        }else{

            //Message d'erreur à afficher
            $_SESSION["erreur"] = "La page demandée n'existe pas, veuillez réessayer plus tard";

            //Redirection vers la page index.php
            header("Location: emploi.php");


            // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
            exit();
        }
    } else {
        //Message d'erreur à afficher si l'utilisateur n'est pas connecté
        $_SESSION["erreur"] = "Vous devez être connecté pour accéder à cette page";

        //Redirection vers la page de connexion
        header("Location: connexion.php");

        // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
        exit();
    }
?>