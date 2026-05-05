<?php

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

if ($_SESSION['role'] != '1') {
    header('Location: index.php');
    echo "Vous n'avez pas les droits pour accéder à cette page.";
    exit;
}

$sql = "SELECT id, username, email FROM USER ORDER BY id ASC";
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
            <a href="manage_users.php" class="admin-link">Gérer les utilisateurs</a>
            <a href="manage_articles.php" class="admin-link">Gérer les articles</a>
            <a href="manage_categories.php" class="admin-link">Gérer les catégories</a>
            <a href="index.php" class="admin-link">Revenir à l'accueil</a>
        </div>
        <div>
            <h2>Gérer les utilisateurs</h2>
            <p><strong>Ajouter un utilisateur :</strong></p>
            <form class="add-user"action="add_user.php" method="POST">
                <input type="text" name="username" placeholder="Nom d'utilisateur" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <select name="role">
                    <option value="0">Utilisateur</option>
                    <option value="1">Administrateur</option>
                </select>
                <button type="submit">Ajouter</button>
                </form>
                <p><strong>Liste des utilisateurs :</strong></p>
                <div class="container">
                <?php foreach ($users as $user): ?>
                    <div class="card">
                        <h3>#<?= $user['id'] ?> - <?= $user['username'] ?></h3>
                        <p>Email : <?= $user['email'] ?></p>
                        <button class="edit-btn"><a href="edit_user.php"></a>Modifier</button>
                    </div>
                <?php endforeach; ?>
        </div>
    </section>