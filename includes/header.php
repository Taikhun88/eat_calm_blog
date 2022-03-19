<header>
    <a href="/" class="logo">Eat~CALM blog</a>
    <ul class="header-menu">
        <li class=<?= $_SERVER['REQUEST_URI'] === '/form-article.php' ? 'active' : '' ?>>
            <a href="/form-article.php">Écrire un article</a>
        </li>
        <li class=<?= $_SERVER['REQUEST_URI'] === '/authentication-register.php' ? 'active' : '' ?>>
            <a href="/authentication-register.php">S'inscrire</a>
        </li>
        <li class=<?= $_SERVER['REQUEST_URI'] === '/authentication-login.php' ? 'active' : '' ?>>
            <a href="/authentication-login.php">Se connecter</a>
        </li>
        <li class=<?= $_SERVER['REQUEST_URI'] === '/profile.php' ? 'active' : '' ?>>
            <a href="/profile.php">Mon profil</a>
        </li>
        <li class=<?= $_SERVER['REQUEST_URI'] === '/authentication-logout.php' ? 'active' : '' ?>>
            <a href="/authentication-logout.php">Se déconnecter</a>
        </li>
    </ul>
</header>