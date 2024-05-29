<?php
    require_once("verification_id.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details sur les recherche de stage</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <h1 class="title-center">Entreprise <?= $result["entreprise"] ?></h1>
    <div class="details">
        <p>ID : <?= $result["id"] ?></p>
        <p>STATUT : <?= $result["statut"] ?></p>
        <p>DATE : <?= $result["dates"] ?></p>
        <p>WEBSITE : <?= $result["website"] ?></p>
        <p>E-MAIL : <?= $result["email"] ?></p>
        <p>COMMENTAIRES : <?= $result["commentaires"] ?></p>
        <a href="update.php?id=<?= $result["id"]?>"><button>Modifier</button></a>
        <a href="index.php"><button>Accueil</button></a>
    </div>
</body>

</html>