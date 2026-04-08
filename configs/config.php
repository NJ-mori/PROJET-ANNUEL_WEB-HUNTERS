<?php
$host = 'localhost';
$dbname = 'wiki';
$username = 'wiki';
$password = 'Wiki123456789!';

try {
    $pdo = new PDO(
        "mysql:host=$host;
        dbname=$dbname", 
        $username, 
        $password
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE, 
        PDO::ERRMODE_EXCEPTION
    );
    log('Connexion réussie à la base de donnée $dbname.');
} catch (PDOException $e) {
    $pdo = null;
    error_log('Erreur de connexion BDD : ' . $e->getMessage());
}

define ("SITE_NAME", "WEAKY");
define ("SITE_DESCRIPTION", "wiki dev");
define ("CURRENT_USER_INITIAL", "S");
define ("CURRENT_USER", "Sousou");
define ("CURRENT_USER_LEVEL", 100);