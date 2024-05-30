<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();

    //connexion à la base de données (information de la connexion dans "connect.php")
    require_once("./include/connect.php");

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
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau Crud PHP</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./include/nav.php");?>
    <?php
        if(!empty($_SESSION["erreur"])) {

            //Demande pour afficher le message d'erreur trouver dans "details.php" si aucune page existe pour afficher l'id
            echo "<h3>" . ($_SESSION["erreur"]) . "</h3>"; 

            //Réinitialise le message d'erreur après l'avoir affiché
            $_SESSION["erreur"] = ""; 
        }
    ?>
    <?php
        if(!empty($_SESSION["message"])) {

            //Demande pour afficher le message  trouver dans "add.php" pour ajouter un stage
            echo "<h4>" . ($_SESSION["message"]) . "</h4>"; 

            //Réinitialise le message après l'avoir affiché
            $_SESSION["message"] = ""; 
        }
    ?>
    <?php
        if(!empty($_SESSION["supprimer"])) {

            //Demande pour afficher le message  trouver dans "delete.php" après avoir supprimer un stage
            echo "<h5>" . ($_SESSION["supprimer"]) . "</h5>"; 

            //Réinitialise le message après l'avoir affiché
            $_SESSION["supprimer"] = ""; 
        }
    ?>
    <h1 class="title-center">Accueil tableau crud sur la recherche d'emploie</h1>


    <table>
        <thead>
            <td>Entreprise</td>
            <td>Statut</td>
            <td>Date</td>
            <td>Site</td>
            <td>E-Mail</td>
            <td>Commentaire</td>
            <td>Action</td>
        </thead>
        <tbody>
            <?php 
            // pour chaque information récupéré dans $result, on affiche une nouvelle ligne dans la table HTML
                foreach($result as $stage){
            //chaque information récupéré sera identifier en tant que $stage dans le foreach
            ?>
            <tr>
                <td><?= $stage["entreprise"] ?></td>
                <td><?= $stage["statut"] ?></td>
                <td><?= $stage["dates"] ?></td>
                <td><?= $stage["website"] ?></td>
                <td><?= $stage["email"] ?></td>
                <td><?= $stage["commentaires"] ?></td>
                <td>
                    <a href="details_stage.php?id=<?=$stage["id"]?>">Voir</a>
                    <a href="update_stage.php?id=<?=$stage["id"]?>">Modifier</a>
                    <a href="delete_stage.php?id=<?=$stage["id"]?>">Supprimer</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="add_stage.php"><button>Ajouter un stage</button></a>
</body>

</html>