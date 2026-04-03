<?php

session_start();

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

include ('header.php');

?>

<div class="background-logo">
    <img class="logo-site" src=".\assets\logo\logo_Web-Hunters_WEAKY.png" alt="logo WEAKY" />
</div>
<div class="background-text-welcome">
    <h3>Bienvenue sur WEAKY</h3>
    <h5>
        Vous pouvez utilisez la barre latérale ou la barre de recherche pour rechercher le sujet qui vous intéresse ou voulez mettre à jour.
    </h5>
</div>

<?php

include_once('footer.php');