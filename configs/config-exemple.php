<?php
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');
define('DB_PORT', '3306');

define('MAIL_FROM_EMAIL', '');
define('MAIL_FROM_NAME', '');

define('SITE_NAME', '');
define('SITE_DESCRIPTION', '');
define('SITE_URL', (getenv('APP_ENV') === 'prod') ? 'https://' : 'http://localhost');

// Connexion BDD
$pdo = null;

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ",dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASSWORD,
        array(PDO::ATTR_TIMEOUT => 5)
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION
    );
    log('Connexion réussie à la base de donnée ' . DB_NAME);
} catch (PDOException $e) {
    $pdo = null;
    error_log('Erreur de connexion BDD : ' . $e->getMessage());
}