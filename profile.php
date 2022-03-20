<?php
require_once __DIR__ . '/database/database.php';
require_once __DIR__ . '/database/security.php';

$articleDatabase = require_once __DIR__ . '/database/models/ArticleDatabase.php';

$articles = [];
$currentUser = isLoggedIn();

if (!$currentUser) {
    header('Location: /');
}

$articles = $articleDatabase->fetchUserArticle($currentUser['id']);
// var_dump($articles);
// exit;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/profile.css">
    <title>Mon profil - Eat~CALM blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <h1>Mon espace</h1>
            <h2>Mes informations personnelles</h2>
            <div class="info-container">
                <ul>
                    <li>
                        <p> <strong>Prénom :</strong>
                            <?= $currentUser['firstname'] ?></p>
                    </li>
                    <li>
                        <p> <strong>Nom de famille :</strong>
                            <?= $currentUser['lastname'] ?></p>
                    </li>
                    <li>
                        <p><strong>Email :</strong>
                            <?= $currentUser['email'] ?></p>
                    </li>
                </ul>
            </div>
            <h2>Mes articles</h2>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>