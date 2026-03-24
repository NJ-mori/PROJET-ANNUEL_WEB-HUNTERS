<?php
$host = 'localhost';
$dbname = 'wiki';
$username = 'wiki';
$password = 'Wiki123456789!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données $dbname.";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
