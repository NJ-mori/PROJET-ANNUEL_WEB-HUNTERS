<?php include_once "../configs/config.php"; ?> 
<!DOCTYPE html> 
<html lang="fr"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title><?php echo SITE_NAME; ?> - <?php echo SITE_DESCRIPTION; ?></title> 
        <link rel="stylesheet" href="css/main.css"> 
        <script src="./js/main.js" defer></script> 
    </head> <body class="darkMode"> 
        <header> 
            <div class ="header-left">
                <span> 
                    <button class="menu-toggle"> 
                    <img class ="bars-icon" src="../assets/svg/search/3bars.svg"/> 
                    </button> 
                </span> 
                <div class='logo-site'> 
                    <a href='index.php' class='logo-link'> 
                        <div class='logo'> 
                           <span class='logo-icon'> 
                           <img class='logo-icon' src="../assets/logo/logo_Web-Hunters_WEAKY.png" alt="Logo de WEAKY" /> 
                               </span> weaky 
                        </div> 
                    </a> 
                </div> 
            </div> 
            <div class='search-bar'> 
                <button class='search-icon' > <?php include ROOT . "../assets/svg/search/search.svg"; ?> </button> 
                <input type='text' class='search-input' placeholder='Rechercher un article, un thème...' id='searchInput'> 
            </div> 
            <div class='header-right'> 
                <div class='header-profile'> 
                    <div class='user-profile-container'> 
                        <button class="profile-button"> 
                            <div class='user-profile' id='userProfile'> 
                                <?php if (isset($_SESSION['id_user'])): ?> 
                                    <span class='avatar'><?php echo $_SESSION['id_user']; ?></span> 
                                    <span class='username'></span>
                                    <span class="level-badge">Lvl 1</span> 
                                <?php else : ?>
                                    <span class='avatar'>0</span>
                                    <span class='username'>Invité</span>
                                <?php endif; ?>
                            </div> 
                        </button> 
                    </div> 
                </div> 
                <div class='history'> 
                    <span> 
                        <img class ="history-logo" src="../assets/svg/search/clock-illu.svg" width="70"/> 
                    </span> 
                </div> 
                <div class = "chatbubble"> 
                    <span> 
                        <img class ="chatbubble-logo" src="../assets/svg/search/bubble.svg" width="70"/> 
                    </span> 
                </div> 
            </div> 
            </header> 
                <div class='menu-dropdown'> 
                    <aside> 
                        <button><a href="../public/article.php">NAVIGATION</a></button> 
                        <button><a href="../public/category.php">CATEGORIES</a></button> 
                        <button><a href="../public/user.php">UTILISATEURS</a></button>
                    </aside> 
                </div> 
                <?php if (isset($_SESSION['id_user'])) { ?> 
                <div class='profile-dropdown-connected'> 
                    <aside> 
                        <ul> 
                            <li><button><a href="../public/profile.php">Mon Profil</a></button></li> 
                            <li><button><a href="../public/settings.php">Paramètres</a></button></li> 
                            <?php if ($_SESSION['role']) { ?>
                            <li><button><a href="../public/admin.php">Administration</a></button></li> 
                            <?php } ?> 
                            <li><button><a href="../public/logout.php">Déconnexion</a></button></li>
                        </ul> 
                    </aside> 
                </div> 
                <?php } elseif (!isset($_SESSION['id_user'])) { ?>
                <div class='profile-dropdown-disconnected'> 
                    <aside> 
                        <ul> 
                            <li><button><a href="../public/signup.php">Insription</a></button></li> 
                            <li><button><a href="../public/login.php">Se Connecter</a></button></li> 
                        </ul> 
                    </aside> 
                </div> 
                <?php } ?>