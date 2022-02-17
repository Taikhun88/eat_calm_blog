<?php
$fileName = __DIR__ . '/data/articles.json';

$articles = [];
$categories = [];

if (file_exists($fileName)) {
    $articles = json_decode(file_get_contents($fileName), true) ?? [];
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
            $acc[$article['category']] = [...$acc[$article['category']], $article];
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
    <link rel="stylesheet" href="public/css/index.css">
    <title>Eat~CALM blog</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="category-container">
                <?php foreach ($categories as $cat => $num) : ?>
                    <h2><?= $cat ?></h2>
                    <div class="articles-container">

                        <?php foreach ($articlesPerCategories[$cat] as $a) : ?>
                            <div class="article block">
                                <div class="overflow">
                                    <div class="img-container" style="background-image:url(<?= $a['image'] ?>)">
                                    </div>
                                </div>
                                <h3><?= $a['title'] ?></h3>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

            </div>

        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>