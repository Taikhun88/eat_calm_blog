<?php 

$fileName = __DIR__ . '/data/articles.json';
$articles = [];

    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id = $_GET['id'] ?? '';
    if (!$id) {
        header('Location: /');
    } else {
        if (file_exists($fileName)) {
            $articles = json_decode(file_get_contents($fileName), true) ?? [];
            $articleIndex = array_search($id, array_column($articles, 'id'));
            array_splice($articles, $articleIndex, 1);
            file_put_contents($fileName, json_encode($articles));
            header('Location: /');
        }
    }
