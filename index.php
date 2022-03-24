<?php
require __DIR__ . '/database/database.php';
$authenticationDB = require_once __DIR__ . '/database/security.php';

$currentUser = $authenticationDB->isLoggedIn();
$articleDatabase = require_once __DIR__ . './database/models/ArticleDatabase.php';

$articles = $articleDatabase->fetchAll();
// var_dump($articles);
// exit;
$categories = [];

// Data for local version
// $fileName = __DIR__ . '/data/articles.json';
// $articles = [];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedCat = $_GET['cat'] ?? '';

// We sent the data to the mysql server so we readapted the code here below
if (count($articles)) {
    $cattMp = array_map(fn ($a) => $a['category'], $articles);
    $categories = array_reduce($cattMp, function ($acc, $cat) {
        if (isset($acc[$cat])) {
            $acc[$cat]++;
        } else {
            $acc[$cat] = 1;
        }
        return $acc;
    }, []);

    $articlesPerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article['category']])) {
            $acc[$article['category']][] = $article;
        } else {
            $acc[$article['category']] = [$article];
        }
        return $acc;
    }, []);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/index.css">
    <title>Eat~CALM blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="postsfeed-container">
                <div class="postsfeed-container">
                    <ul class="category-container">
                        <li class=<?= $selectedCat ? '' : 'cat-active' ?>>
                            <a href="/">Tous les articles <span class="small">(<?= count($articles) ?>)</span></a>
                        </li>

                        <?php foreach ($categories as $catName => $catNum) : ?>
                            <li class=<?= $selectedCat ===  $catName ? 'cat-active' : '' ?>>
                                <a href="/?cat=<?= $catName ?>"> <?= $catName ?><span class="small">(<?= $catNum ?>)</span> </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="postsfeed-content">
                    <?php if (!$selectedCat) : ?>

                        <?php foreach ($categories as $cat => $num) : ?>
                            <h2><?= $cat ?></h2>
                            <div class="articles-container">
                                <?php foreach ($articlesPerCategories[$cat] as $a) : ?>
                                    <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                                        <div class="overflow">
                                            <div class="img-container" style="background-image:url(<?= $a['image'] ?>)">
                                            </div>
                                        </div>
                                        <h3><?= $a['title'] ?></h3>
                                        <?php if ($a['author']) : ?>
                                            <div class="article-author">
                                                <p> <?= $a['firstname'] . ' ' . $a['lastname'] ?> </p>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <h2><?= $selectedCat ?></h2>
                        <div class="articles-container">
                            <?php foreach ($articlesPerCategories[$selectedCat] as $a) : ?>
                                <a href="/show-article.php?id=<?= $a['id'] ?>" class="article block">
                                    <div class="overflow">
                                        <div class="img-container" style="background-image:url(<?= $a['image'] ?>)">
                                        </div>
                                    </div>
                                    <h3><?= $a['title'] ?></h3>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>