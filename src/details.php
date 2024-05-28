<?php
    require_once("verification_id.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details sur les recherche de stage</title>
</head>
<body>
    <h1>Entreprise <?= $result["entreprise"] ?></h1>

    <p>ID : <?= $result["id"] ?></p>
    <p>STATUT : <?= $result["statut"] ?></p>
    <p>DATE : <?= $result["dates"] ?></p>
    <p>WEBSITE : <?= $result["website"] ?></p>
    <p>E-MAIL : <?= $result["mail"] ?></p>
    <p>COMMENTAIRES : <?= $result["commentaires"] ?></p>
    <a href="update.php?id=<?= $result["id"]?>"><button>Modifier</button></a>
    <a href="index.php"><button>Accueil</button></a>
</body>
</html>