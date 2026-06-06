<?php

class BanService {

    public static function ban(int $idUser, string $reason = ''): void {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET is_banned = 1, ban_reason = ? WHERE id_user = ?");
        $stmt->execute([$reason, $idUser]);
    }

    public static function unban(int $idUser): void {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE users SET is_banned = 0, ban_reason = NULL WHERE id_user = ?");
        $stmt->execute([$idUser]);
    }

    public static function isBanned(int $idUser): bool {
        global $pdo;
        $stmt = $pdo->prepare("SELECT is_banned FROM users WHERE id_user = ?");
        $stmt->execute([$idUser]);
        return (bool)$stmt->fetchColumn();
    }

    public static function allUsers(): array {
        global $pdo;
        $stmt = $pdo->query("
            SELECT id_user, username, email, is_banned, ban_reason, created_at
            FROM users
            ORDER BY is_banned DESC, username ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}