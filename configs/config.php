<?php

try {
    $pdo = new PDO(
        'mysql:host=db;dbname=wiki',
        'wiki',
        'wiki123456789!',
    );
} catch (PDOException $e) {
    $pdo = null;
    error_log('Erreur de connexion BDD: ' . $e->getMessage());
}