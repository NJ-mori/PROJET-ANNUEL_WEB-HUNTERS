<?php
session_start();
require_once __DIR__ . '/../configs/config.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $captcha_valid = $_POST['captcha_valid'] ?? '0';

    if ($captcha_valid !== '1') {
        $erreur = 'Veuillez compléter le captcha avant de vous connecter.';
    } elseif ($username === '' || $password === '') {
        $erreur = 'Veuillez remplir tous les champs.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'] ?? null;

            header('Location: index.php');
            exit;
        } else {
            $erreur = 'Nom d’utilisateur ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - WEAKY</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="captcha/style.css">
</head>
<body>
    <?php include_once __DIR__ . '/../src/views/layouts/header.php'; ?>

    <main style="padding: 32px; min-height: calc(100vh - 128px); overflow-y: auto;">
        <div class="container" style="justify-content: center;">
            <div class="card" style="width: 100%; max-width: 520px; height: auto;">
                <h2 style="margin-bottom: 16px;">Connexion</h2>

                <?php if (!empty($erreur)): ?>
                    <p class="status-message fail-message" style="margin-bottom: 16px;">
                        <?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                <?php endif; ?>

                <form method="POST" id="loginForm">
                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        <div>
                            <label for="username" style="display:block; margin-bottom:6px;">Nom d'utilisateur</label>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                required
                                style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid var(--border-color); background:var(--bg-tertiary); color:var(--text-primary);"
                            >
                        </div>

                        <div>
                            <label for="password" style="display:block; margin-bottom:6px;">Mot de passe</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                style="width:100%; padding:10px 12px; border-radius:8px; border:1px solid var(--border-color); background:var(--bg-tertiary); color:var(--text-primary);"
                            >
                        </div>

                        <div class="captcha-login-block">
                            <p class="section-title">Captcha</p>
                            <p style="margin-bottom:10px;">Rearrange the pieces into the correct order</p>

                            <div id="game">
                                <div id="parts"></div>
                            </div>

                            <div class="captcha-actions">
                                <button type="button" id="validateBtn">Validate</button>
                                <button type="button" id="resetBtn">Reset puzzle</button>
                            </div>

                            <p id="status" class="status-message"></p>
                            <input type="hidden" name="captcha_valid" id="captcha_valid" value="0">
                        </div>

                        <button
                            type="submit"
                            style="padding:12px 16px; border:none; border-radius:8px; background:var(--accent-purple); color:white; font-weight:600; cursor:pointer;"
                        >
                            Se connecter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include_once __DIR__ . '/../src/views/layouts/footer.php'; ?>

    <script src="js/main.js"></script>
    <script src="captcha/captcha.js"></script>
    <script>
        window.captchaSolved = false;

        const loginForm = document.getElementById('loginForm');
        const captchaStatus = document.getElementById('status');

        if (loginForm) {
            loginForm.addEventListener('submit', function (event) {
                if (!window.captchaSolved) {
                    event.preventDefault();
                    if (captchaStatus) {
                        captchaStatus.textContent = 'Veuillez valider le captcha avant de continuer.';
                        captchaStatus.classList.remove('success-message');
                        captchaStatus.classList.add('fail-message');
                    }
                }
            });
        }
    </script>
</body>
</html>