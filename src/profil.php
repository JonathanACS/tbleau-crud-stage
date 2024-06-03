<?php
    // //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();
    
    //vérification si l'utilisateur est déjà connecter ou pas
    if(!isset($_SESSION["user"])){
        header("Location: connexion_users.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profil</title>
    <link rel="stylesheet" href="./css/style.css" />

</head>

<body>
    <?php include_once("./include/nav.php");?>
    <h1>Profil de <span class="prenom"><?= $_SESSION["user"]["pseudo"]?></span></h1>

    <p>Pseudo : <?= $_SESSION["user"]["pseudo"]?></p>
    <p>Email : <?= $_SESSION["user"]["email"]?></p>
    <a href="stage.php"><button>stage</button></a>
    <a href="emploie.php"><button>emploi</button></a>
    <a href="delete_users.php"><button>Supprimer mon compte</button></a>

</body>

</html>