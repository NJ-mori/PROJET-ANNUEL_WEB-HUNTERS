<header>
    <div class='header-left'>
        <a href='/'>
            <div class='logo'>
                <div class='logo-icon'>
                    <img 
                        src="<?php echo ROOT . "../assets/logo/logo_Web-Hunters_WEAKY.png";?>" 
                        alt="logo WEAKY" 
                    />
                </div>
                WEAKY
            </div>
        </a>

        <div class='search-bar'>
            <span class='search-icon'>
                <?php include ROOT . "/assets/svg/search/search.svg"; ?>
            </span>
            <input type='text' class='search-input' placeholder='Rechercher un article, un thème...' id='searchInput'>
        </div>
    </div>

    <div class='theme-page'>
        <button id='btn-theme' onclick='toggleTheme()' class='btn-theme-change'>Theme Mode</button>
    </div>

    <?php require_once SRC . '/views/users/userMenu.php'; ?>

    <div class="history">
        <span>
            <img src='<?php include ROOT . "/assets/svg/search/clock-illu.svg"; ?>' class='history' width='70' />
        </span>             
    </div>
</header>