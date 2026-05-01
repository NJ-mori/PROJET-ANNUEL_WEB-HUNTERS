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
            <h1>PROFIL</h1>
        </article>
    </section>
</main>

<?php
include_once SRC . '/views/layouts/footer.php';
?>