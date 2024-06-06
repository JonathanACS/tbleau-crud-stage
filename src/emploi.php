<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();

    // Vérifiez si l'utilisateur est connecté et son ID est dans la session
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {

    // Redirigez vers la page de création de compte si l'utilisateur n'est pas connecté
    header("Location: connexion_users.php");
    exit();
}

    // Vérifier si l'utilisateur est connecté
    if(isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])) {
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $_SESSION["user"]["id"];

        //connexion à la base de données (information de la connexion dans "connect.php")
        require_once("./include/connect.php");

        //on selectionne le tableau dans la base de données pour l'utilisateur connecté
        $sql = "SELECT * FROM `emploi` WHERE `id_user` = :user_id ORDER BY `emploi`.`id_emploi` DESC";

        //On prépare la requette
        $query = $db->prepare($sql);

        //On bind l'ID de l'utilisateur à la requête
        $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        //On execute la requette
        $query->execute();
        
        //On stock le résultat dans un tableau associatif
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        // afficher le resultat de $result
        // var_dump($result);
    } else {
        // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
        header("Location: login.php");
        exit(); // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
    }
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
    <h1 class="title-center">Accueil tableau crud sur la recherche d'emploi</h1>
    <table>
        <thead>
            <td>Entreprise</td>
            <td>Statut</td>
            <td>Relance</td>
            <td>Site</td>
            <td>E-Mail</td>
            <td>Commentaire</td>
            <td>Action</td>
        </thead>
        <tbody>
            <?php 
            // pour chaque information récupéré dans $result, on affiche une nouvelle ligne dans la table HTML
                foreach($result as $emploi){
            //chaque information récupéré sera identifier en tant que $stage dans le foreach
            ?>
            <tr>
                <td><?= $emploi["entreprise"] ?></td>
                <td><?= $emploi["statut"] ?></td>
                <td><?= $emploi["relance"] ?></td>
                <td><?= $emploi["website"] ?></td>
                <td><?= $emploi["email"] ?></td>
                <td><?= $emploi["commentaire"] ?></td>
                <td>
                    <a href="details_emploi.php?id=<?=$emploi["id_emploi"]?>">Voir</a>
                    <a href="update_emploi.php?id=<?=$emploi["id_emploi"]?>">Modifier</a>
                    <a href="delete_emploi.php?id=<?=$emploi["id_emploi"]?>">Supprimer</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="add_emploi.php"><button>Ajouter une recherche d'emploi</button></a>
    <a href="#" onclick="history.go(-1)"><button>Retour</button></a>

</body>

</html>