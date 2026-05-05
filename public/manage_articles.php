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
        <h2>Liste des utilisateurs</h2>

</div>
    </section>