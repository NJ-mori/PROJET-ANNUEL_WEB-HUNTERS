<?php
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM captcha_images WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    logAction("delete: Deleted image id=$id.");
}

header('Location: admin.php');
exit;