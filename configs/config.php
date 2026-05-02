<?php
$host = '51.254.143.2';
$dbname = 'wiki';
$username = "useresgi";
$password = 'password';

try {
    $pdo = new PDO("mysql:host=$host;port=3306;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

define ("SITE_NAME", "WEAKY");
define ("SITE_DESCRIPTION", "wiki dev");
define ("CURRENT_USER_INITIAL", "S");
define ("CURRENT_USER", "Sousou");
define ("CURRENT_USER_LEVEL", 100);

session_start();