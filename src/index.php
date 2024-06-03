<?php
    //on démare la session, la session sert à envoyer des message d'une page à l'autre
    session_start();
    
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
    <!-- <h1 class="title-center">Accueil tableau crud</h1> -->
    <h1 class="title-center">Tableau CRUD en PHP</h1>
    <p class="title-center">Gérez vos candidatures de stage et d'emploi facilement et efficacement</p>
    <section>
        <div class="container">
            <div class="card">
                <h2>Ajouter une recherche de stage</h2>
                <p>Enregistrez vos candidatures et suivez leur statut</p>
                <a href="add_stage.php"><button>Ajouter un stage</button></a>
            </div>
            <div class="card">
                <h2>Voir toutes les candidatures</h2>
                <p>Consultez toutes vos candidatures de stage</p>
                <a href="stage.php"><button>Voir les candidatures</button></a>
            </div>
        </div>
        <div class="container">
            <div class="card">
                <h2>Ajouter une recherche d'emploi</h2>
                <p>Enregistrez vos candidatures et suivez leur statut</p>
                <a href="add_emploie.php"><button>Ajouter un stage</button></a>
            </div>
            <div class="card">
                <h2>Voir toutes les candidatures</h2>
                <p>Consultez toutes vos candidatures d'emploi</p>
                <a href="emploie.php"><button>Voir les candidatures</button></a>
            </div>
        </div>
    </section>
</body>
</body>

</html>