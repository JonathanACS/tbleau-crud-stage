<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();


    //Vérification si le formulaire est remplie
    if($_POST){
        if (isset($_POST["id"]) && !empty($_POST["id"])
        && isset($_POST["entreprise"]) && !empty($_POST["entreprise"])
        && isset($_POST["statut"]) && !empty($_POST["statut"])
        && isset($_POST["dates"]) && !empty($_POST["dates"])
        && isset($_POST["website"]) && !empty($_POST["website"])
        && isset($_POST["mail"]) && !empty($_POST["mail"])
        && isset($_POST["commentaires"]) && !empty($_POST["commentaires"])){
        
        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("connect.php");

        //on nettoie les données avant de les envoyer
        $id = strip_tags($_POST["id"]);
        $entreprise = strip_tags($_POST["entreprise"]);
        $statut = strip_tags($_POST["statut"]);
        $dates = strip_tags($_POST["dates"]);
        $website = strip_tags($_POST["website"]);
        $mail = strip_tags($_POST["mail"]);
        $commentaires = strip_tags($_POST["commentaires"]);

        //Préparation de la requette pour mettre à jour les informations dans la base de données
        $sql = "UPDATE `stage` SET `entreprise`=:entreprise, `statut`=:statut, `dates`=:dates, `website`=:website, `mail`=:mail, `commentaires`=:commentaires WHERE `id`=:id;";

        
        //préparation de la requette 
        $query = $db->prepare($sql);
        
        //Attribution des valeur
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
        $query->bindValue(':statut', $statut, PDO::PARAM_STR);
        $query->bindValue(':dates', $dates, PDO::PARAM_STR);
        $query->bindValue(':website', $website, PDO::PARAM_STR);
        $query->bindValue(':mail', $mail, PDO::PARAM_STR);
        $query->bindValue(':commentaires', $commentaires, PDO::PARAM_STR);

        //execution de la requette
        $query->execute();
        
        //Message à afficher 
        $_SESSION["message"] = "Information du stage modifier";

        //déconnexion de la base de données (information de la déconnexion dans "disconnect.php")
        require_once("disconnect.php");

        //Rediréction vers la page index.php
        header("Location: index.php");

        // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
        exit();

    }else{
        $_SESSION["erreur"] = "le formulaire est incomplet";
    }
}




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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le tableau de stage</title>
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>

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
            <label for="mail">E-mail</label>
            <input type="text" id="mail" name="mail" value="<?=$result["mail"] ?>">
        </div>
        <div class="form">
            <label for="commentaires">Commentaire</label>
            <input type="text" id="commentaires" name="commentaires" value="<?=$result["commentaires"] ?>">
        </div>

        <input type="hidden" name="id" value="<?=$result["id"]?>">
        <button type="submit">Envoyer</button>
    </form>

    <a href="index.php"><button>Accueil</button></a>
</body>

</html>