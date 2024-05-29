<?php
    session_start();

    //Vérification si le formulaire est remplie
    if($_POST){
        if (isset($_POST["username"]) && !empty($_POST["username"])
        && isset($_POST["email"]) && !empty($_POST["email"])
        && isset($_POST["pass"]) && !empty($_POST["pass"])){
        
        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("connect.php");

        //on nettoie les données avant de les envoyer
        $username = strip_tags($_POST["username"]);
        $email = strip_tags($_POST["email"]);
        $pass = strip_tags($_POST["pass"]);
        
        //vérification si l'adresse email est correct 
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            die("l'adresse email est incorrecte");
        }

        // ajouter les différents paramètres ici 
        //hash du mot de pass (pour ne pas le déchifrer)
        $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);

        // voir le mot de pass "hasher"
        // die($pass);

        //Préparation de la requette pour envoyer les informations dans la base de données
        $sql = "INSERT INTO `users`(`username`, `email`,`pass`, `roles`) VALUES (:username, :email, `$pass`, '[\"ROLE_USER\"]`)";
        
        //préparation de la requette 
        $query = $db->prepare($sql);
        
        //Attribution des valeur
        $query->bindValue(':username', $username, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':pass', $pass, PDO::PARAM_STR);

        //execution de la requette
        $query->execute();

        //connexion de l'utilisateur
        
        //Message à afficher 
        $_SESSION["message"] = "Compte crée!";

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
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer votre compte</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php
        if(!empty($_SESSION["erreur"])) {

            //Demande pour afficher le message d'erreur trouver dans "details.php" si aucune page existe pour afficher l'id
            echo "<h3>" . ($_SESSION["erreur"]) . "</h3>"; 

            //Réinitialise le message d'erreur après l'avoir affiché
            $_SESSION["erreur"] = ""; 
        }
    ?>
    <h1 class="title-center">Remplissez le formulaire pour créer votre compte</h1>
    <form method="post">
        <div class="form">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form">
            <label for="pass">Mot de passe</label>
            <input type="password" id="pass" name="pass">
        </div>
        <button type="submit">Envoyer</button>
    </form>
    <a href="index.php"><button>Retour</button></a>
</body>

</html>