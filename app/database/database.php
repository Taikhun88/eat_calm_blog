<?php

// $dns = 'mysql:host=localhost;dbname=blog';
// $user = 'root';
// $pwd = 'root';
$configData = parse_ini_file('./config.ini');
// var_dump($configData);

try {
    $pdo = new PDO($configData['DATABASE_DNS'], $configData['DATABASE_USERNAME'], $configData['DATABASE_PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "ERROR : " . $e->getMessage();
    throw new Exception($e->getTraceAsString());
}

return $pdo;