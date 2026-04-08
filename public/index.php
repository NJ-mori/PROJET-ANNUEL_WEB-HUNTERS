<?php

session_start();

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");
define("LOGO", ROOT . "/assets/logo/logo_Web-Hunters_WEAKY.png");

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
    <h1 class="">Bonjour</h1>
    <button id="mon-super-btn">Clique !</button>
<script src="js/main.js"></script>