<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();
    
    //vérification si l'utilisateur est déjà connecter ou pas
    if(isset($_SESSION["user"])){
        header("Location: profil.php");
        exit;
    }
    
    if(!empty($_POST)){

        // on vérifie si tout les champs sont remplie
        if(isset($_POST["email"], $_POST["pass"])
        && !empty($_POST["email"]) && !empty($_POST["pass"]))
        
        //on vérifie si l'email en est un
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            die("l'adresse email est incorrecte");
        }
        
        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("./include/connect.php");

        //selection de la base de données pour vérifier le mail
        $sql = "SELECT * FROM `users` WHERE `email` = :email";

        //préparation de la requette
        $query = $db->prepare($sql);

        //bind value de email
        $query->bindValue(":email", $_POST['email'], PDO::PARAM_STR);

        //execution de la requette
        $query->execute();


        $user = $query->fetch();

        //si l'utilisateur existe pas
        if(!$user){
            die("l'utilisateur et/ou le mot de passe est incorrect");
        }
        
        //si le mot de passe est incorrecte 
        if(!password_verify($_POST["pass"], $user["pass"])){
            die("l'utilisateur et/ou le mot de passe est incorrect");
        }

        //si l'utilisateur et le mot de passe sont correcte
        //on va pouvoir connetcter l'utilisateur/ouvrir la session

        //on va stocker dans $_SESSION
        $_SESSION["user"] = [
            "id" => $user["id"],
            "pseudo" => $user["username"],
            "email" => $user["email"],
            "roles" => $user["roles"]
        ];

        //Rediréction vers la page pour la page des profils
        header("Location: profil.php");

        // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
        exit();

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
    <?php include_once("./include/nav.php");?>
    <h1 class="title-center">Connectez-vous</h1>
    <form method="post">
        <div class="form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form">
            <label for="pass">Mot de passe</label>
            <input type="password" id="pass" name="pass">
        </div>
        <button type="submit">Se connecter</button>
    </form>
    <a href="index.php"><button>Retour</button></a>

</body>

</html>