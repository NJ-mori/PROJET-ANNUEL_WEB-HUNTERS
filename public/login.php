<?PHP


define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        header('Location: profile.php');
        exit;
    } else {
        $erreur = 'Nom d\'utilisateur ou mot de passe incorrect.';
    }
    if ($_SESSION['id_user'] = $user['id_user']) {
        echo "Vous êtes déja connecté.";
        exit;
    }
}
include_once SRC . "/views/layouts/header.php";
?>  

  <main class="main-content">
    <h2 class="section-title">Connexion</h2>

    <?php if ($erreur): ?>
      <p class="form-erreur"><?= htmlspecialchars($erreur) ?></p>
    <?php endif; ?>

    <form class="auth-form" method="POST" action="login.php">
      <div class="form-groupe">
        <label for="username">username</label>
        <input type="text" id="username" name="username" required autofocus>
      </div>
      <div class="form-groupe">
        <label for="password">password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="form-btn">log_in</button>
      <a href="signup.php" class="form-btn form-btn-outline">sign_up</a>
    </form>
  </main>

<?php
include_once SRC . "/views/layouts/footer.php";
?>