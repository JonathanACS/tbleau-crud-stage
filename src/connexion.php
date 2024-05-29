<?php
    session_start();
    
    if(!empty($_POST)){

        // on vérifie si tout les champs sont remplie
        if(isset($_POST["email"], $_POST["pass"])
        && !empty($_POST["email"]) && !empty($_POST["pass"]))
        
        //on vérifie si l'email en est un
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            die("l'adresse email est incorrecte");
        }
        
        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("connect.php");

        
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