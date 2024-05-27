<?php
    require_once("connect.php");

    $sql = "SELECT * FROM `tableau_stage`";

    $query = $db->prepare($sql);

    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    
    // var_dump($result);
    // afficher le resultat de $result
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau Crud PHP</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <h1>Tableau crud stage</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Entreprise</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Date de relance</th>
                <th>Type de postulation</th>
                <th>Website</th>
                <th>Intitulé du poste</th>
                <th>Type de contract</th>
                <th>Mail</th>
                <th>Commentaires</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // pour chaque information récupéré dans $result, on affiche une nouvelle ligne dans la table HTML
                foreach($result as $stage){
            //chaque information récupéré sera identifier en tant que $stage dans le foreach
            ?>
                <tr>
                    <td><?= $stage["id"] ?></td>
                    <td><?= $stage["entreprise"] ?></td>
                    <td><?= $stage["statut"] ?></td>
                    <td><?= $stage["date"] ?></td>
                    <td><?= $stage["date_de_relance"] ?></td>
                    <td><?= $stage["type_de_postulation"] ?></td>
                    <td><?= $stage["website"] ?></td>
                    <td><?= $stage["intitulé_du_poste"] ?></td>
                    <td><?= $stage["type_de_contract"] ?></td>
                    <td><?= $stage["mail"] ?></td>
                    <td><?= $stage["commentaires"] ?></td>
                    <td><a href="details.php"></a>Voir</td>
                    <td><a href="modifier.php"></a>Modifier</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="add.php">Ajouter un stage</a>
</body>
</html>