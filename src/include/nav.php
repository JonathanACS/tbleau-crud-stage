<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php if(!isset($_SESSION["user"])): ?>
        <li><a href="inscription_users.php">Inscription</a></li>
        <li><a href="connexion_users.php">Se connecter</a></li>
        <?php else: ?>
        <li><a href="profil.php">Votre Profil</a></li>
        <p>Bonjour <span class="pseudo"><?= ($_SESSION["user"]["pseudo"]) ?></span></p>
        <li><a href="deconnexion_user.php">Se déconnecter</a></li>
        <?php endif; ?>
    </ul>
</nav>