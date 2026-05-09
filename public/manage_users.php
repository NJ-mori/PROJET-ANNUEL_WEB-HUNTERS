<?php

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

$sql = "SELECT id_user, username, email FROM users ORDER BY id_user ASC";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once SRC . "/views/layouts/header.php";

?>

<main>
    <section>
        <article>
            <h1>ADMINISTRATION</h1>
        </article>
        <div class="admin-bar">
            <button><a href="admin.php" class="admin-link">HOME</a></button>
            <button><a href="manage_users.php" class="admin-link">MANAGE_USER</a></button>
            <button><a href="manage_articles.php" class="admin-link">MANAGE_ARTICLE</a></button>
            <button><a href="manage_categories.php" class="admin-link">MANAGE_SECTOR</a></button>
            <button><a href="logs.php" class="admin-link">LOGS</a></button>
            <button><a href="index.php" class="admin-link">RETURN -> HOME</a></button>
        </div>
        <div>
            <h2>MANAGE_USER :</h2>
            <p><strong>ADD USER :</strong></p>
            <form class="add-user"action="add_user.php" method="POST">
                <input type="text" name="username" placeholder="USERNAME :" required>
                <input type="email" name="email" placeholder="EMAIL :" required>
                <input type="password" name="password" placeholder="PASSWORD :" required>
                <select name="role">
                    <option value="0">USER</option>
                    <option value="1">ADMIN</option>
                </select>
                <button type="submit"><a href="add_user.php"></a>Ajouter</button>
            </form>
            <p><strong>DELETE_USER :</strong></p>
            <form class="del-user"action="delete_user.php" method="POST">
                <input type="text" name="id" placeholder="ID USER :" required>
                <button type="submit"><a href="delete_user.php"></a>Supprimer</button>
            </form>
            <p><strong>Liste des utilisateurs :</strong></p>
            <div class="container">
            <?php foreach ($users as $user): ?>
                <div class="card">
                    <h3>#<?= $user['id_user'] ?> - <?= $user['username'] ?></h3>
                    <p>Email : <?= $user['email'] ?></p>
                    <!--<p>Role : <?= $user['role'] ?></p>-->
                </div>
            <?php endforeach; ?>  
        </div>
    </section>
    <!--<form class="add-user"action="add_user.php" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe">
        <select name="role">
            <option value="0">Utilisateur</option>
            <option value="1">Administrateur</option>
        </select>
        <button type="submit">Ajouter</button>
    </form>  -->