<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo SITE_NAME; ?> - <?php echo SITE_DESCRIPTION; ?></title>
            <link rel="stylesheet" href="css/main.css">
            <script src="./js/main.js" defer></script>
        </head>
        <body class="darkMode">
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
                                </span>
                              weaky  
                            </div>
                            
                        </a>
                    </div>
                </div>
                <div class='search-bar'>
                    <button class='search-icon' >
                        <?php include ROOT . "../assets/svg/search/search.svg";  ?>
                    </button>
                    <input type='text' class='search-input' placeholder='Rechercher un article, un thème...' id='searchInput'>
                </div>
                <div class='header-right'>
                    <div class='header-profile'>
                        <div class='user-profile-container'>
                            <button class="profile-button">
                                <div class='user-profile' id='userProfile'>
                                <div class='avatar'><?php echo CURRENT_USER_INITIAL; ?></div>
                                <span class='username'><?php echo CURRENT_USER; ?></span>
                                <div class="level-badge">Lvl <?php echo CURRENT_USER_LEVEL; ?></div>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class='history'>
                        <span>
                            <img class ="history-logo" src="../assets/svg/search/clock-illu.svg" width="70"/>
                        </span>
                    </div>
                </div>
            </header>
            <div class='menu-dropdown'>
                <aside>
                    <ul>
                        <li><button><a href="../public/article.php">NAVIGATION</a></button></li>
                        <li><button><a href="../public/category.php">CATEGORIES</a></button></li>
                        <li><button><a href="../public/user.php">UTILSATEURS</a></button></li>
                    </ul>
                </aside>
            </div>
            <div class='profile-dropdown-connected'>
                <aside>
                    <ul>
                        <li><button><a href="../public/profile.php">Mon Profil</a></button></li>
                        <li><button><a href="../public/settings.php">Paramètres</a></button></li>
                        <li><button><a href="../public/admin.php">Adminstration</a></button></li>
                        <li><button><a href="#">Déconnexion</a></button></li>
                    </ul>
                </aside>
            </div>
            <div class='profile-dropdown-disconnected'>
                <aside>
                    <ul>
                        <li><button><a href="#">Insription</a></button></li>
                        <li><button><a href="#">Se Connecter</a></button></li>
                    </ul>   
                </aside>
            </div>