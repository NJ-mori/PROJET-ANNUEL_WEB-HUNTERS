<?php

session_start();

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");
define("LOGO", ROOT . "/assets/logo/logo_Web-Hunters_WEAKY.png");
define("SVG", ROOT . "/assets/svg");

require_once CONFIG . "/config.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - <?php echo SITE_DESCRIPTION; ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<?php

include_once SRC . "/views/layouts/header.php";
    
include_once SRC . '/views/layouts/footer.php';

?>
<header>
    <img src="<?php echo SVG . "/3bars-converti-depuis-png.svg"; ?>" alt="Side Bar menu icon">
    <h1><?php echo SITE_NAME; ?></h1>
    <img src="<?php echo LOGO; ?>" alt="Logo de <?php echo SITE_NAME; ?>">

</header>
<section>

    <aside id = "sidebar">
        <h2>article</h2>
        <h2>category</h2>
        <h2><a href = "" ></a></h2>
    </aside>

    <aside id = "history">
        <h2>Historique</h2>
    </aside>

    <aside id = user-settings>
        <h2>Profil</h2>
        <h2>Paramètres</h2>
        <h2>Administration</h2>
    </aside>
    
</section>

    <h1 class="">Bonjour</h1>
    <button id="mon-super-btn">Clique !</button>
<script src="js/main.js"></script>