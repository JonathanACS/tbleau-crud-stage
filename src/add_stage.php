<?php
session_start(); // Assurez-vous que la session est démarrée

// Vérification si le formulaire est rempli
if ($_POST) {
    if (isset($_POST["entreprise"]) && !empty($_POST["entreprise"])
    && isset($_POST["statut"]) && !empty($_POST["statut"])
    && isset($_POST["dates"]) && !empty($_POST["dates"])
    && isset($_POST["website"]) && !empty($_POST["website"])
    && isset($_POST["email"]) && !empty($_POST["email"])
    && isset($_POST["commentaires"]) && !empty($_POST["commentaires"])) {

        // Vérifiez si l'utilisateur est connecté et son ID est dans la session
        if (isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])) {
            $user_id = intval($_SESSION["user"]["id"]);

            // Connexion à la base de données (information de la connexion dans "connect.php")
            require_once("./include/connect.php");

            // Nettoyage des données avant de les envoyer
            $entreprise = strip_tags($_POST["entreprise"]);
            $statut = strip_tags($_POST["statut"]);
            $dates = strip_tags($_POST["dates"]);
            $website = strip_tags($_POST["website"]);
            $email = strip_tags($_POST["email"]);
            $commentaires = strip_tags($_POST["commentaires"]);

            // Préparation de la requête pour envoyer les informations dans la base de données
            $sql = "INSERT INTO `stage`(`entreprise`, `statut`, `dates`, `website`, `email`, `commentaires`, `id_users`) 
                    VALUES (:entreprise, :statut, :dates, :website, :email, :commentaires, :user_id)";        
            // Préparation de la requête 
            $query = $db->prepare($sql);
            
            // Attribution des valeurs
            $query->bindValue(':entreprise', $entreprise, PDO::PARAM_STR);
            $query->bindValue(':statut', $statut, PDO::PARAM_STR);
            $query->bindValue(':dates', $dates, PDO::PARAM_STR);
            $query->bindValue(':website', $website, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':commentaires', $commentaires, PDO::PARAM_STR);
            $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            // Exécution de la requête
            if ($query->execute()) {
                // Message à afficher 
                $_SESSION["message"] = "Stage ajouté";
            } else {
                $_SESSION["erreur"] = "Erreur lors de l'ajout du stage";
            }

            // Déconnexion de la base de données (information de la déconnexion dans "disconnect.php")
            require_once("./include/disconnect.php");

            // Redirection vers la page stage.php
            header("Location: stage.php");

            // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
            exit();
        } else {
            $_SESSION["erreur"] = "Utilisateur non connecté";
        }
    } else {
        $_SESSION["erreur"] = "Le formulaire est incomplet";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une recherche de stage</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./include/nav.php");?>
    <?php
        // Afficher le message d'erreur s'il y en a un
        if (!empty($_SESSION["erreur"])) {
            echo "<h2>" . ($_SESSION["erreur"]) . "</h2>";

            // Réinitialiser le message d'erreur après l'avoir affiché
            $_SESSION["erreur"] = ""; 
        }

        // Afficher le message de succès s'il y en a un
        if (!empty($_SESSION["message"])) {
            echo "<h2>" . ($_SESSION["message"]) . "</h2>";

            // Réinitialiser le message après l'avoir affiché
            $_SESSION["message"] = ""; 
        }
    ?>
    <h1 class="title-center">Ajouter une recherche de stage</h1>
    <form method="post">
        <div class="form">
            <label for="entreprise">Entreprise</label>
            <input type="text" id="entreprise" name="entreprise">
        </div>
        <div class="form">
            <label for="statut">Statut</label>
            <select name="statut" id="statut">
                <option value="Accepter">Accepter</option>
                <option value="En attente">En attente</option>
                <option value="Refuser">Refuser</option>
            </select>
        </div>
        <div class="form">
            <label for="dates">Date</label>
            <input type="date" id="dates" name="dates">
        </div>
        <div class="form">
            <label for="website">Website</label>
            <input type="text" id="website" name="website">
        </div>
        <div class="form">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form">
            <label for="commentaires">Commentaire</label>
            <input type="text" id="commentaires" name="commentaires">
        </div>
        <button type="submit">Envoyer</button>
    </form>
    <a href="#" onclick="history.go(-1)"><button>Retour</button></a>
</body>

</html>