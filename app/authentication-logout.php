<?php
require_once __DIR__ . '/database/database.php';
$authenticationDb = require_once __DIR__ . '/database/security.php';

$sessionId = $_COOKIE['session'];
if ($sessionId) {
    $authenticationDb->logout($sessionId);
    header('Location: /authentication-login.php');
}

