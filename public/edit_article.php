<?php
define("ROOT", dirname(__DIR__));
define("CONFIG", ROOT . "/configs");
define("SRC", ROOT . "/src");

require_once CONFIG . "/config.php";
require_once SRC . "/services/ArticleService.php";
require_once SRC . "/services/LogService.php";

LogService::visit('edit_article.php');

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$idArticle = (int)($_GET['id_article'] ?? 0);
if ($idArticle === 0) {
    header('Location: article.php');
    exit;
}

$article = ArticleService::getById($idArticle);
if (!$article || $article['status'] !== 'published') {
    header('Location: article.php');
    exit;
}

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $mode    = $_POST['mode'] ?? 'version';

    if ($title === '' || $content === '') {
        $erreur = 'Le titre et le contenu sont obligatoires.';
    } else {
        if ($mode === 'overwrite') {
            ArticleService::overwrite($idArticle, $_SESSION['id_user'], $title, $content);
            $succes = 'Article modifié directement.';
        } else {
            ArticleService::createVersion($idArticle, $_SESSION['id_user'], $title, $content);
            $succes = 'Votre version a été soumise et est en attente de validation par un administrateur.';
        }
    }
}

include_once SRC . "/views/layouts/header.php";
?>

<main>
    <section>
        <h1>Modifier l'article</h1>
        <h2><?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?></h2>

        <?php if ($erreur): ?>
            <p class="error"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <?php if ($succes): ?>
            <p class="success"><?= htmlspecialchars($succes, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-field">
                <label for="title">Titre</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>

            <div class="form-field">
                <label for="content">Contenu</label>
                <textarea name="content" id="content" required><?= htmlspecialchars($article['content'], ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <div class="form-field">
                <label>Mode de modification</label>
                <label>
                    <input type="radio" name="mode" value="version" checked>
                    Proposer une nouvelle version (soumise à validation)
                </label>
                <label>
                    <input type="radio" name="mode" value="overwrite">
                    Modifier directement l'article
                </label>
            </div>

            <button type="submit">Enregistrer</button>
            <a href="view_article.php?id_article=<?= $idArticle ?>">Annuler</a>
        </form>
    </section>
</main>

<script src="https://cdn.tiny.cloud/1/ibcdpkzw0hixebb967dmj91i4u4wqprfsm8lvfeyhclk07pk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'lists link image',
        toolbar: 'undo redo | bold italic | bullist numlist | link image',
        height: 400
    });
</script>

<?php include_once SRC . '/views/layouts/footer.php'; ?>