<?php
    session_start();

    include_once("./include/verification_id_emploie.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails sur les recherches d'emploie</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./include/nav.php");?>
    <h1 class="title-center">Entreprise <?= $result["entreprise"] ?></h1>
    <div class="details">
        <p>STATUT : <?= $result["statut"] ?></p>
        <p>DATE : <?= $result["dates"] ?></p>
        <p>DATE : <?= $result["relance"] ?></p>
        <p>WEBSITE : <?= $result["website"] ?></p>
        <p>E-MAIL : <?= $result["email"] ?></p>
        <p>COMMENTAIRES : <?= $result["commentaire"] ?></p>
        <a href="update_emploie.php?id=<?= $result["id_emploie"]?>"><button>Modifier</button></a>
        <a href="#" onclick="history.go(-1)"><button>Retour</button></a>
    </div>
</body>

</html>