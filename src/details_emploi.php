<?php
    session_start();

    include_once("./include/verification_id_emploi.php");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails sur les recherches d'emploi</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./include/nav.php");?>
    <h1 class="title-center">Entreprise <span class="entreprise"><?= $result["entreprise"] ?></span></h1>
    <div class="details">
        <p>STATUT : <?= $result["statut"] ?></p>
        <p>DATE : <?= $result["dates"] ?></p>
        <p>RELANCE : <?= $result["relance"] ?></p>
        <p>WEBSITE : <?= $result["website"] ?></p>
        <p>E-MAIL : <?= $result["email"] ?></p>
        <p>COMMENTAIRES : <?= $result["commentaire"] ?></p>
        <a href="update_emploi.php?id=<?= $result["id_emploi"]?>"><button>Modifier</button></a>
        <a href="#" onclick="history.go(-1)"><button>Retour</button></a>
    </div>
</body>

</html>