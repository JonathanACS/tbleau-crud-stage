<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();


    //Vérification si le formulaire est remplie
    if($_POST){
        if (isset($_POST["id_stage"]) && !empty($_POST["id_stage"])
        && isset($_POST["entreprise"]) && !empty($_POST["entreprise"])
        && isset($_POST["statut"]) && !empty($_POST["statut"])
        && isset($_POST["dates"]) && !empty($_POST["dates"])
        && isset($_POST["website"]) && !empty($_POST["website"])
        && isset($_POST["email"]) && !empty($_POST["email"])
        && isset($_POST["commentaires"]) && !empty($_POST["commentaires"])){
        
        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("./include/connect.php");

        //on nettoie les données avant de les envoyer
        $id_stage = strip_tags($_POST["id_stage"]);
        $entreprise = strip_tags($_POST["entreprise"]);
        $statut = strip_tags($_POST["statut"]);
        $dates = strip_tags($_POST["dates"]);
        $website = strip_tags($_POST["website"]);
        $email = strip_tags($_POST["email"]);
        $commentaires = strip_tags($_POST["commentaires"]);

        //Préparation de la requette pour mettre à jour les informations dans la base de données
        $sql = "UPDATE `stage` SET `entreprise`=:entreprise, `statut`=:statut, `dates`=:dates, `website`=:website, `email`=:email, `commentaires`=:commentaires WHERE `id_stage`=:id_stage;";

        
        //préparation de la requette 
        $query = $db->prepare($sql);
        
        //Attribution des valeur
        $query->bindValue(':id_stage', $id_stage, PDO::PARAM_INT);
        $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
        $query->bindValue(':statut', $statut, PDO::PARAM_STR);
        $query->bindValue(':dates', $dates, PDO::PARAM_STR);
        $query->bindValue(':website', $website, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':commentaires', $commentaires, PDO::PARAM_STR);

        //execution de la requette
        $query->execute();
        
        //Message à afficher 
        $_SESSION["message"] = "Information du stage modifier";

        //déconnexion de la base de données (information de la déconnexion dans "disconnect.php")
        require_once("./include/disconnect.php");

        //Rediréction vers la page index.php
        header("Location: stage.php");

        // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
        exit();

    }else{
        $_SESSION["erreur"] = "le formulaire est incomplet";
    }
}




    //Vérification si l'utilisateur est connecté et son ID est dans la session
    if(isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])){

        //Connexion à la base de données
        require_once("./include/connect.php");

        //On nettoie l'ID envoyé
        $user_id = intval($_SESSION["user"]["id"]);

        //Vérification si l'ID de l'utilisateur existe et n'est pas vide dans l'URL
        if(isset($_GET["id"]) && !empty($_GET["id"])){

            //On nettoie l'ID envoyé
            $id_stage = strip_tags($_GET["id"]);

            //Demande de la requête avec une clause WHERE pour vérifier que l'utilisateur est le créateur du stage
            $sql = "SELECT * FROM `stage` WHERE `id_stage` = :id_stage AND `id_users` = :user_id";

            //Préparation de la requête
            $query = $db->prepare($sql);

            //Accrocher les paramètres
            $query->bindValue(':id_stage', $id_stage, PDO::PARAM_INT);
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
                header("Location: stage.php");

                // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
                exit();
            }

        }else{

            //Message d'erreur à afficher
            $_SESSION["erreur"] = "La page demandée n'existe pas, veuillez réessayer plus tard";



            //Redirection vers la page index.php
            header("Location: stage.php");

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
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le tableau de stage</title>
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>
    <?php include_once("./include/nav.php");?>
    <h1 class="title-center">Modifier une information du tableau de stage</h1>
    <form method="post">
        <div class="form">
            <label for="entreprise">Entreprise</label>
            <input type="text" id="entreprise" name="entreprise" value="<?=$result["entreprise"] ?>">
        </div>
        <div class="form">
            <label for="statut">Statut</label>
            <input type="text" id="statut" name="statut" value="<?=$result["statut"] ?>">
        </div>
        <div class="form">
            <label for="dates">Date</label>
            <input type="date" id="dates" name="dates" value="<?=$result["dates"] ?>">
        </div>
        <div class="form">
            <label for="website">Website</label>
            <input type="text" id="website" name="website" value="<?=$result["website"] ?>">
        </div>
        <div class="form">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?=$result["email"] ?>">
        </div>
        <div class="form">
            <label for="commentaires">Commentaire</label>
            <input type="text" id="commentaires" name="commentaires" value="<?=$result["commentaires"] ?>">
        </div>

        <input type="hidden" name="id_stage" value="<?=$result["id_stage"]?>">
        <button type="submit">Envoyer</button>
    </form>
    <a href="#" onclick="history.go(-1)"><button>Retour</button></a>
</body>

</html>