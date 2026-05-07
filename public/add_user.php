<?php

define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (strlen($username) < 3 || strlen($username) > 20) {
        $erreur = 'Le nom d\'utilisateur doit contenir entre 3 et 20 caractères.';
    } elseif (strlen($password) < 6) {
        $erreur = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        $stmt = $pdo->prepare('SELECT id_user FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $erreur = 'Ce nom d\'utilisateur est déjà pris.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $username,
                trim($_POST['email']),
                $hash,  
                $role,
                date('Y-m-d H:i:s')
            ]);

            header('Location: manage_users.php');
            exit;
        }
    }
}
?>