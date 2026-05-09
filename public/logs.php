<?php

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

if (isset($_POST['delete_all'])) {

    $sql = "DELETE FROM log";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['delete_one'])) {

    $id_log = $_POST['id_log'];

    $sql = "DELETE FROM log WHERE id_log = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_log]);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$sql = "
SELECT 
    l.id_log, 
    l.id_user, 
    u.username, 
    l.temps, 
    l.page 
    FROM log l
    JOIN users u ON u.id_user = l.id_user
    ORDER BY id_log ASC
";

$stmt = $pdo->query($sql);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
include_once SRC . "/views/layouts/header.php";
?>

<h2>Liste des logs</h2>
<div style="margin-bottom: 20px;">
    <form method="POST">
        <button type="submit" name="delete_all">Supprimer tous les logs</button>
    </form>
</div>
<div class="container">
<?php foreach ($logs as $log): ?>
    <div class="card">
        <h3>
            #<?= $log['id_log'] ?> - username : <?= htmlspecialchars($log['username']) ?>
        </h3>
        <p>id : <?= $log['id_user'] ?></p>
        <p>time : <?= $log['temps'] ?></p>
        <p>page : <?= htmlspecialchars($log['page']) ?></p>
        <form method="POST">
            <input type="hidden" name="id_log" value="<?= $log['id_log'] ?>">
            <button type="submit" name="delete_one">Supprimer ce log</button>
        </form>
    </div>
<?php endforeach; ?>
</div>