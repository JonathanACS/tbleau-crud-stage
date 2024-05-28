<?php

    //ajout des vérification pour l'id 
    require_once("verification_id.php");
    
    //connexion à la base de données (information de la connexion dans "connect.php")
    require_once("connect.php");

    //on selectionne le tableau dans la base de données
    $sql = "SELECT * FROM `stage`";

    //On prépare la requette
    $query = $db->prepare($sql);

    //On execute la requette
    $query->execute();
    
    //On stock le résultat dans un tableau associatif
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // afficher le resultat de $result
    // var_dump($result);
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
    <h1>Modifier une information du tableau de stage</h1>
    <a href="index.php"><button>Accueil</button></a>
</body>
</html>