<?php
define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";
include_once SRC . "/views/layouts/header.php";
?>
    
<main>
    <article>
        <h1>PROFIL</h1>
    </article>
    <section>
        <div class="profile-info">
            <h2>Informations personnelles</h2>
            <p>Username : <?= $_SESSION['username'] ?></p><button>
           <p>Email : <?= $_SESSION['email'] ?></p><button>
            <a href="edit_profile.php" class="edit-btn">Modifier</a></button>
        </div>
    </section>
</main>

<?php
include_once SRC . '/views/layouts/footer.php';
?>