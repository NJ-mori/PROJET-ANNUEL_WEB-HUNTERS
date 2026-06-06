<?php
define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

header('Content-Type: application/json; charset=utf-8'); 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Méthode non autorisée']);
    exit;
}

$body = json_decode(file_get_contents('php://input'), true);
$q    = trim($body['q'] ?? '');

if (mb_strlen($q) < 2) {
    echo json_encode(['results' => [], 'count' => 0, 'query' => $q]);
    exit;
}

$like = '%' . $q . '%';

try {
    $stmt = $pdo->prepare("
        SELECT u.id_user,
               u.username,
               u.bio,
               r.name AS role
        FROM users u
        JOIN roles r ON r.role_id = u.role_id
        WHERE u.username LIKE :q
           OR u.bio      LIKE :q
        ORDER BY u.username ASC
        LIMIT 50
    ");
    $stmt->execute([':q' => $like]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'results' => $results,
        'count'   => count($results),
        'query'   => $q
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur BDD : ' . $e->getMessage(), 'results' => [], 'count' => 0]);
}