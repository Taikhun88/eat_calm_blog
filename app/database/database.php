<?php

$dns = 'mysql:host=localhost;dbname=blog';
$user = 'root';
$pwd = '@0yGzs6C9_';

try {
    $pdo = new PDO($dns, $user, $pwd, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "ERROR : " . $e->getMessage();
    throw new Exception($e->getMessage());
}

return $pdo;