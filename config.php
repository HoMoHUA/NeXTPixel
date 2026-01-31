<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('DB_HOST', 'localhost');

define('DB_USER', 'nxgbufsb_HoMo');

define('DB_PASS', '@HoMo13833831');

define('DB_NAME', 'nxgbufsb_NP');

define('OPENAI_API_KEY', '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');

define('SITE_URL', 'https://nextpixel.top/'); 

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    
    die("خطا در اتصال به دیتابیس: " . $e->getMessage());
}

?>
