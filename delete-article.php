<?php
require_once __DIR__ . '/database/database.php';

$articleDatabase = require_once __DIR__ . './database/models/ArticleDatabase.php';

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$id = $_GET['id'] ?? '';

if ($id) {
    $articleDatabase->deleteOne($id);
} 
header('Location: /');
