<?php
include "header.php";
include_once "config.php";

$sql = "SELECT id, filename, image_data, mime_type, active, reseted, completed, failed, created_at FROM captcha_images ORDER BY id";
$statement = $pdo->query($sql);
if (!$statement) {
    logAction("admin: Failed to query captcha_images.");
    http_response_code(500);
    die('Erreur 2');
}
$images = $statement->fetchAll();

logAction("admin: Page loaded, " . count($images) . " images.");

$totalsStmt = $pdo->query("SELECT SUM(completed) as total_completed, SUM(failed) as total_failed, SUM(reseted) as total_reseted FROM captcha_images");
$totals = $totalsStmt->fetch(PDO::FETCH_ASSOC);
