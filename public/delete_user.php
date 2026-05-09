<?php

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");
require_once CONFIG . "/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id_user'];

    $sql = "DELETE FROM users WHERE id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $userId, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: manage_users.php');
    exit;
}