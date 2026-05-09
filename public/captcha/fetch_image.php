<?php
require_once __DIR__ . '/config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare('
        SELECT id, filename, image_data, mime_type
        FROM captcha_images
        WHERE active = TRUE AND image_data IS NOT NULL
        ORDER BY RAND()
        LIMIT 1
    ');
    $stmt->execute();
    $selected = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$selected) {
        logAction('fetch_image: No active captcha images found.');
        http_response_code(404);
        echo json_encode(['error' => 'No active captcha images found']);
        exit;
    }

    logAction("fetch_image: Served image id={$selected['id']} filename={$selected['filename']}.");

    echo json_encode([
        'id' => $selected['id'],
        'filename' => $selected['filename'],
        'imageData' => base64_encode($selected['image_data']),
        'mimeType' => $selected['mime_type']
    ]);
} catch (Exception $ex) {
    logAction('fetch_image: Exception: ' . $ex->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $ex->getMessage()]);
}