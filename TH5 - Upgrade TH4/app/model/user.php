<?php
declare(strict_types=1);
require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername(string $username): ?array
{
    global $conn;
    $stmt = $conn->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
    if (!$stmt) return null;
    $stmt->bind_param('s', $username);
    if (!$stmt->execute()) { $stmt->close(); return null; }
    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    return $user ?: null;
}

function registerUser(string $username, string $plainPassword): bool
{
    global $conn;
    $passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT);
    if ($passwordHash === false) return false;
    $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
    if (!$stmt) return false;
    $stmt->bind_param('ss', $username, $passwordHash);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
