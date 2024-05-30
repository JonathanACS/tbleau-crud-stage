<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
        <?php if(!isset($_SESSION["user"])): ?>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="connexion_users.php">Se connecter</a></li>
        <?php else: ?>
        <li><a href="profil.php">Profil</a></li>
        <p>Bonjour <?= ($_SESSION["user"]["pseudo"]) ?></p>
        <li><a href="deconnexion_user.php">Se déconnecter</a></li>
        <?php endif; ?>
    </ul>
</nav>