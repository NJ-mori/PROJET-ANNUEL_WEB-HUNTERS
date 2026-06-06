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
    SELECT a.id_article,
           a.title,
           a.content,
           a.status,
           a.created_at,
           u.username      AS auteur,
           c.name          AS categorie
    FROM articles a
    LEFT JOIN users      u ON u.id_user     = a.id_user
    LEFT JOIN categories c ON c.id_category = a.id_category
    WHERE a.status = 'published'
      AND (
           a.title   LIKE :q
        OR a.content LIKE :q
      )
    ORDER BY a.created_at DESC
    LIMIT 50
    ");
$stmt->execute([':q' => $like]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as &$article) {
    $article['excerpt'] = mb_substr(strip_tags($article['content']), 0, 180) . '…';
    unset($article['content']);
}

echo json_encode([
    'results' => $results,
    'count'   => count($results),
    'query'   => $q
]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur BDD : ' . $e->getMessage(), 'results' => [], 'count' => 0]);
}