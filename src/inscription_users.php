<?php
// Démarrage de la session
session_start();

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION["user"])) {
    header("Location: profil.php");
    exit;
}

// Vérification si le formulaire est soumis
if (!empty($_POST)) {
    if (isset($_POST["username"]) && !empty($_POST["username"])
        && isset($_POST["email"]) && !empty($_POST["email"])
        && isset($_POST["pass"]) && !empty($_POST["pass"])) {

        // Connexion à la base de données (information de la connexion dans "connect.php")
        require_once("./include/connect.php");

        // Nettoyage des données avant de les envoyer
        $username = strip_tags($_POST["username"]);
        $email = strip_tags($_POST["email"]);
        $pass = strip_tags($_POST["pass"]);

        $_SESSION["error"] = [];

        // Vérification si l'adresse email est correcte
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"][] = "L'adresse email est incorrecte";
        }

        // Vérification si l'email existe déjà dans la base de données
        $sql = "SELECT * FROM `users` WHERE `email` = :email";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["error"][] = "L'adresse email est déjà utilisée";
        }

        if (empty($_SESSION["error"])) {

            // Hachage du mot de passe (pour ne pas le déchiffrer)
            $pass = password_hash($pass, PASSWORD_ARGON2ID);

            // Définir le rôle par défaut
            $roles = 'ROLE_USER';

            // Préparation de la requête pour envoyer les informations dans la base de données
            $sql = "INSERT INTO `users`(`username`, `email`, `pass`, `roles`) VALUES (:username, :email, :pass, :roles)";

            // Préparation de la requête
            $query = $db->prepare($sql);

            // Attribution des valeurs
            $query->bindValue(':username', $username, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':pass', $pass, PDO::PARAM_STR);
            $query->bindValue(':roles', $roles, PDO::PARAM_STR);

            // Exécution de la requête
            $query->execute();

            // Récupération de l'id de l'utilisateur
            $id = $db->lastInsertId();

            // On va stocker dans $_SESSION
            $_SESSION["user"] = [
                "id" => $id,
                "pseudo" => $username,
                "email" => $_POST["email"],
                "roles" => ["ROLE_USER"]
            ];

            unset($pass);

            // Message à afficher 
            $_SESSION["succes"] = "compte créer avec succès!";

            // Redirection vers la page pour la page des profils
            header("Location: profil.php");

            // Assurez-vous qu'aucun autre code ne soit exécuté après la redirection
            exit();
        }
    } else {
        $_SESSION["error"] = ["Le formulaire est incomplet"];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer votre compte</title>
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <?php include_once("./include/nav.php");?>
    <?php
        if (!empty($_SESSION["error"])) {
            echo "<h3>" . implode("<br>", $_SESSION["error"]) . "</h3>";

            // Réinitialiser le message d'erreur après l'avoir affiché
            $_SESSION["error"] = []; 
        }
    ?>
    <h1 class="title-center">Remplissez le formulaire pour créer votre compte</h1>
    <form method="post">
        <div class="form">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username">
        </div>
        <div class="form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form">
            <label for="pass">Mot de passe</label>
            <input type="password" id="pass" name="pass">
        </div>
        <button type="submit">Créer votre compte!</button>
    </form>
    <a href="#" onclick="history.go(-1)"><button>Retour</button></a>

</body>

</html>