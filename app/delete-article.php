<?php
require_once __DIR__ . '/database/database.php';
$authenticationDB = require_once __DIR__ . '/database/security.php';

if (!$currentUser) {
    header('Location: /');
}
$articleDatabase = require_once __DIR__ . './database/models/ArticleDatabase.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);

$id = $_GET['id'] ?? '';

if ($id) {
    $article = $articleDatabase->fetchUserArticle($id);
    if ($article['author'] === $currentUser['id']) {
        $articleDatabase->deleteOne($id);
    }
} 
header('Location: /');
