<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();

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
    <title>Tableau Crud PHP</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <?php
        if(!empty($_SESSION["erreur"])) {

            //Demande pour afficher le message d'erreur trouver dans "details.php" si aucune page existe pour afficher l'id
            echo "<h2>" . ($_SESSION["erreur"]) . "</h2>"; 

            //Réinitialise le message d'erreur après l'avoir affiché
            $_SESSION["erreur"] = ""; 
        }
    ?>
    <?php
        if(!empty($_SESSION["message"])) {

            //Demande pour afficher le message  trouver dans "add.php" pour ajouter un stage
            echo "<h2>" . ($_SESSION["message"]) . "</h2>"; 

            //Réinitialise le message après l'avoir affiché
            $_SESSION["message"] = ""; 
        }
    ?>

    <h1>Accueil tableau crud sur la recherche de stage</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Entreprise</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Website</th>
                <th>Mail</th>
                <th>Commentaire</th>
                <th>Action</th>
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
                    <td><?= $stage["dates"] ?></td>
                    <td><?= $stage["website"] ?></td>
                    <td><?= $stage["mail"] ?></td>
                    <td><?= $stage["commentaires"] ?></td>
                    <td><a href="details.php?id=<?=$stage["id"]?>">Voir</a></td>
                    <td><a href="update.php?id=<?=$stage["id"]?>">Modifier</a></td>

                    
                    <td><a href="delete.php?id=<?=$stage["id"]?>">Supprimer</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="add.php"><button>Ajouter un stage</button></a>
</body>
</html>