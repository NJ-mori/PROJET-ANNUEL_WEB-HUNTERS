<?php

class ArticleService
{
    public static function publicList($limit = null, $idCategory = null)
    {
        global $pdo;

        $params = [];
        $sql = "
        SELECT a.id_article, a.id_category, a.title, a.content, a.created_at, a.updated_at, c.name AS category_name
        FROM articles a
        LEFT JOIN categories c ON c.id_category = a.id_category
        WHERE a.status = 'published'
        ";

        if ($idCategory !== null) {
            $sql .= ' AND a.id_category = ?';
            $params[] = $idCategory;
        }

        $sql .= ' ORDER BY a.updated_at DESC';

        if ($limit !== null) {
            $sql .= ' LIMIT ' . (int)$limit;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function allForAdmin()
    {
        global $pdo;

        $sql = "
        SELECT a.id_article, a.id_category, a.id_user, a.title, a.content, a.status, a.created_at, a.updated_at, c.name AS category_name, u.username
        FROM articles a
        LEFT JOIN categories c ON c.id_category = a.id_category
        LEFT JOIN users u ON u.id_user = a.id_user
        ORDER BY a.updated_at DESC
        ";

        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($idArticle)
    {
        global $pdo;

        $stmt = $pdo->prepare('SELECT id_article, id_category, title, content, status FROM articles WHERE id_article = ?');
        $stmt->execute([$idArticle]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findPublished($idArticle)
    {
        global $pdo;

        $sql = "
        SELECT a.id_article, a.id_category, a.title, a.content, a.created_at, a.updated_at, c.name AS category_name
        FROM articles a
        LEFT JOIN categories c ON c.id_category = a.id_category
        WHERE a.id_article = ? AND a.status = 'published'
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idArticle]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($idCategory, $idUser, $title, $content, $status)
    {
        global $pdo;

        $stmt = $pdo->prepare('INSERT INTO articles (id_category, id_user, title, content, status) VALUES (?, ?, ?, ?, ?)');
        return $stmt->execute([$idCategory, $idUser, $title, $content, $status]);
    }

    public static function update($idArticle, $idCategory, $title, $content, $status)
    {
        global $pdo;

        $stmt = $pdo->prepare('UPDATE articles SET id_category = ?, title = ?, content = ?, status = ? WHERE id_article = ?');
        return $stmt->execute([$idCategory, $title, $content, $status, $idArticle]);
    }

    public static function delete($idArticle)
    {
        global $pdo;

        $stmt = $pdo->prepare('DELETE FROM articles WHERE id_article = ?');
        return $stmt->execute([$idArticle]);
    }
public static function getVersions(int $idArticle): array {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT v.*, u.username
        FROM articles_versions v
        LEFT JOIN users u ON u.id_user = v.id_user
        WHERE v.id_article = ?
        ORDER BY v.version_number DESC
    ");
    $stmt->execute([$idArticle]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function getVersion(int $idVersion): array|false {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT v.*, u.username
        FROM articles_versions v
        LEFT JOIN users u ON u.id_user = v.id_user
        WHERE v.id_version = ?
    ");
    $stmt->execute([$idVersion]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public static function getCurrentVersion(int $idArticle): array|false {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT v.*, u.username
        FROM articles_versions v
        LEFT JOIN users u ON u.id_user = v.id_user
        WHERE v.id_article = ? AND v.status = 'approved'
        ORDER BY v.version_number DESC
        LIMIT 1
    ");
    $stmt->execute([$idArticle]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public static function createVersion(int $idArticle, int $idUser, string $title, string $content): void {
    global $pdo;
    $stmt = $pdo->prepare("SELECT COALESCE(MAX(version_number), 0) + 1 FROM articles_versions WHERE id_article = ?");
    $stmt->execute([$idArticle]);
    $nextVersion = (int)$stmt->fetchColumn();

    $stmt = $pdo->prepare("
        INSERT INTO articles_versions (id_article, id_user, title, content, version_number, status)
        VALUES (?, ?, ?, ?, ?, 'pending')
    ");
    $stmt->execute([$idArticle, $idUser, $title, $content, $nextVersion]);
}

public static function overwrite(int $idArticle, int $idUser, string $title, string $content): void {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE articles SET title = ?, content = ?, updated_at = NOW() WHERE id_article = ?");
    $stmt->execute([$title, $content, $idArticle]);

    $stmt2 = $pdo->prepare("SELECT COALESCE(MAX(version_number), 0) + 1 FROM articles_versions WHERE id_article = ?");
    $stmt2->execute([$idArticle]);
    $nextVersion = (int)$stmt2->fetchColumn();

    $stmt3 = $pdo->prepare("
        INSERT INTO articles_versions (id_article, id_user, title, content, version_number, status)
        VALUES (?, ?, ?, ?, ?, 'approved')
    ");
    $stmt3->execute([$idArticle, $idUser, $title, $content, $nextVersion]);
}

public static function approveVersion(int $idVersion): void {
    global $pdo;
    $version = self::getVersion($idVersion);
    if (!$version) return;

    $pdo->prepare("UPDATE articles_versions SET status = 'approved' WHERE id_version = ?")->execute([$idVersion]);
    $pdo->prepare("UPDATE articles SET title = ?, content = ?, updated_at = NOW() WHERE id_article = ?")
        ->execute([$version['title'], $version['content'], $version['id_article']]);
}

public static function rejectVersion(int $idVersion): void {
    global $pdo;
    $pdo->prepare("UPDATE articles_versions SET status = 'rejected' WHERE id_version = ?")->execute([$idVersion]);
}
public static function getById(int $idArticle): array|false {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT a.*, c.name AS category_name, u.username
        FROM articles a
        LEFT JOIN categories c ON c.id_category = a.id_category
        LEFT JOIN users u ON u.id_user = a.id_user
        WHERE a.id_article = ?
    ");
    $stmt->execute([$idArticle]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
