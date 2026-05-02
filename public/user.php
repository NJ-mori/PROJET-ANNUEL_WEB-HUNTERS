<?php
define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";
include_once SRC . "/views/layouts/header.php";
?>
    
<main>
    <section>
        <article>
            <h1>UTILISATEURS</h1>
        </article>
    </section>

<?php
$sql = "SELECT id, username, email FROM USER ORDER BY id ASC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Liste des utilisateurs</h2>

<div class="container">

<?php foreach ($users as $user): ?>
    <div class="card">
        <h3>#<?= $user['id'] ?> - <?= $user['username'] ?></h3>
        <p>Email : <?= $user['email'] ?></p>
    </div>
<?php endforeach; ?>

</div>

</main>

<?php
include_once SRC . '/views/layouts/footer.php';
?>