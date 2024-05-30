<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    // session_start();


    //Vérification si le formulaire est remplie
    if($_POST){
        if (isset($_POST["entreprise"]) && !empty($_POST["entreprise"])
        && isset($_POST["statut"]) && !empty($_POST["statut"])
        && isset($_POST["dates"]) && !empty($_POST["dates"])
        && isset($_POST["website"]) && !empty($_POST["website"])
        && isset($_POST["email"]) && !empty($_POST["email"])
        && isset($_POST["commentaires"]) && !empty($_POST["commentaires"])){
        
        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("./include/connect.php");

        //on nettoie les données avant de les envoyer
        $entreprise = strip_tags($_POST["entreprise"]);
        $statut = strip_tags($_POST["statut"]);
        $dates = strip_tags($_POST["dates"]);
        $website = strip_tags($_POST["website"]);
        $email = strip_tags($_POST["email"]);
        $commentaires = strip_tags($_POST["commentaires"]);

        //Préparation de la requette pour envoyer les informations dans la base de données
        $sql = "INSERT INTO `stage`(`entreprise`, `statut`, `dates`, `website`, `email`, `commentaires`) VALUE (:entreprise, :statut, :dates, :website, :email, :commentaires);";
        
        //préparation de la requette 
        $query = $db->prepare($sql);
        
        //Attribution des valeur
        $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
        $query->bindValue(':statut', $statut, PDO::PARAM_STR);
        $query->bindValue(':dates', $dates, PDO::PARAM_STR);
        $query->bindValue(':website', $website, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':commentaires', $commentaires, PDO::PARAM_STR);

        //execution de la requette
        $query->execute();
        
        //Message à afficher 
        $_SESSION["message"] = "Stage ajouter";

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une recherche de stage</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./include/nav.php");?>
    <?php
        //Demande pour afficher le message d'erreur trouver dans "details.php" si aucune page existe pour afficher l'id
        if(!empty($_SESSION["erreur"])) {
            echo "<h2>" . ($_SESSION["erreur"]) . "</h2>";

            //Réinitialise le message d'erreur après l'avoir affiché
            $_SESSION["erreur"] = ""; 
        }
    ?>
    <h1 class="title-center">Ajouter une recherche de stage</h1>
    <form method="post">
        <div class="form">
            <label for="entreprise">Entreprise</label>
            <input type="text" id="entreprise" name="entreprise">
        </div>
        <div class="form">
            <label for="statut">Staut</label>
            <select name="statut" id="statut" value="">
                <option value="accepter">Accepter</option>
                <option value="en attente">En attente</option>
                <option value="refuser">Refuser</option>
            </select>
        </div>
        <div class="form">
            <label for="dates">Date</label>
            <input type="date" id="dates" name="dates">
        </div>
        <div class="form">
            <label for="website">Website</label>
            <input type="text" id="website" name="website">
        </div>
        <div class="form">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email">
        </div>
        <div class="form">
            <label for="commentaires">Commentaire</label>
            <input type="text" id="commentaires" name="commentaires">
        </div>
        <button type="submit">Envoyer</button>
    </form>

    <a href="index.php"><button>Accueil</button></a>
</body>

</html>