<header>
    <div class='header-left'>
        <a href='#'>
            <div class='logo'>
                <div class='logo-icon'>
                    <img 
                        src="<?php echo LOGO;?>" 
                        alt="logo WEAKY" 
                    />
                </div>
                Wiki
            </div>
        </a>

        <div class='search-bar'>
            <span class='search-icon'>
                <?php include ROOT . "/assets/svg/search/search.svg"; ?>
            </span>
            <input type='text' class='search-input' placeholder='Rechercher un article, un thème...' id='searchInput'>
        </div>
    </div>

    <div class='header-profile'>
        <div class='user-profile-container'>
            <div class='user-profile' id='userProfile'>
                <div class='avatar'><?php echo CURRENT_USER_INITIAL; ?></div>
                <span class='username'><?php echo CURRENT_USER; ?></span>
                <div class="level-badge">Lvl <?php echo CURRENT_USER_LEVEL; ?></div>
            </div>
        </div>
    </div>

    <div class="nav-bar">
        <nav class="WEAKY-HOME">
            <a href="#"> WEAKY </a>
        </nav>
    </div>
</header>