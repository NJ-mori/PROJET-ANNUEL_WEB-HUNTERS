<?php
//Configuration base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'wiki');
define('DB_PASSWORD', 'Wiki123456789');
define('DB_NAME', 'wiki');
define('DB_PORT', '3306');

// Configuration Mail
define('MAIL_FROM_EMAIL', 'noreply@sousou.artiste.fr');
define('MAIL_FROM_NAME', 'WEAKY');

// Configuration Site
define('SITE_NAME', 'WEAKY');
define('SITE_DESCRIPTION', 'Mode Développement Localhost');
define('SITE_URL', (getenv('APP_ENV') === 'prod') ? 'https://wiki.sousou-artiste.fr' : 'http://localhost');

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