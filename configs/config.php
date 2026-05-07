<?php

session_start();

$host = '51.254.143.2';
$dbname = 'wiki';
$username = "partage"; //useresgi  /  //partage 
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

function log_action($pdo) {
    $page = basename($_SERVER['PHP_SELF']);
    $iduser = $_SESSION['id_user'] ?? null;
    $stmt = $pdo->prepare("INSERT INTO log (id_user, page) VALUES (?, ?)");
    $stmt->execute([$iduser, $page]);
}

log_action($pdo);