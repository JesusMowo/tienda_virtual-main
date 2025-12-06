<?php
class User {
    public static function findByEmail($conn, $email) {
        $stmt = $conn->prepare('SELECT id, name, email, password, role, created_at FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_object();
    }

    public static function findById($conn, $id) {
        $stmt = $conn->prepare('SELECT id, name, email, role, created_at FROM users WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_object();
    }
}
