<?php
$currentUser = $currentUser ?? false;
?>

<header>
    <a href="/" class="logo">Eat~CALM blog</a>
    <div class="header-mobile">
        <div class="header-mobile-icon">
            <img src="/public/images/mobile-menu.png" alt="menu mobile icon">
        </div>
        <ul class="header-mobile-list">
        <?php if ($currentUser) : ?>
            <li class=<?= $_SERVER['REQUEST_URI'] === '/form-article.php' ? 'active' : '' ?>>
                <a href="/form-article.php">Écrire un article</a>
            </li>
            <li class=<?= $_SERVER['REQUEST_URI'] === '/authentication-logout.php' ? 'active' : '' ?>>
                <a href="/authentication-logout.php">Se déconnecter</a>
            </li>
            <li class="<?= $_SERVER['REQUEST_URI'] === '/profile.php' ? 'active' : '' ?>">
                <a href="/profile.php"> Mon profil </a>
            </li>

        <?php else : ?>
            <!-- <li class=<?= $_SERVER['REQUEST_URI'] === '/authentication-register.php' ? 'active' : '' ?>>
                <a href="/authentication-register.php">S'inscrire</a>
            </li> -->
            <li class=<?= $_SERVER['REQUEST_URI'] === '/authentication-login.php' ? 'active' : '' ?>>
                <a href="/authentication-login.php">Se connecter</a>
            </li>
        <?php endif; ?>
    </ul>
    </div>

</header>