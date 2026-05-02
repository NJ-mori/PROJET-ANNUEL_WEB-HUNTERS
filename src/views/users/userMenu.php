<div class='header-profile'>
    <div class='user-profile-container user-profile' id='userProfile'>
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class='avatar'>Dev</div>
        <span class='username'><?php echo $_SESSION['username']; ?></span>

        <div class='profile-menu' id='profileMenu'>
            <a href='#' class='menu-item' id='profileLink'>
                Mon profile
            </a> 
            <hr class='menu-divider'>
            <a href='/auth/logout' class='menu-item danger' id='logoutLink'>
                Se déconnecter
            </a>
        </div>
        <?php else: ?>
        <div class='auth-links'>
            <p>Vous n'êtes pas connecté.</p>
            <a href='/auth/signup' class='btn-primary'>S'inscrire</a>
            <a href='/auth/login' class='btn-secondary'>Se connecter</a>
        </div>
    </div>
</div>