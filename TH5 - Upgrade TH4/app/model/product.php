<?php
declare(strict_types=1);
require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts(): array
{
    global $conn;
    $result = $conn->query('SELECT id, name, price, quantity FROM products ORDER BY id ASC');
    if (!$result) return [];
    $products = [];
    while ($row = $result->fetch_assoc()) $products[] = $row;
    $result->free();
    return $products;
}

function getProductById(int $id): ?array
{
    global $conn;
    $stmt = $conn->prepare('SELECT id, name, price, quantity FROM products WHERE id = ?');
    if (!$stmt) return null;
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) { $stmt->close(); return null; }
    $result = $stmt->get_result();
    $row = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    return $row ?: null;
}

function addProduct(string $name, float $price, int $quantity): bool
{
    global $conn;
    $stmt = $conn->prepare('INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)');
    if (!$stmt) return false;
    $stmt->bind_param('sdi', $name, $price, $quantity);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function updateProduct(int $id, string $name, float $price, int $quantity): bool
{
    global $conn;
    $stmt = $conn->prepare('UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?');
    if (!$stmt) return false;
    $stmt->bind_param('sdii', $name, $price, $quantity, $id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function deleteProduct(int $id): bool
{
    global $conn;
    $stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
    if (!$stmt) return false;
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute() && $stmt->affected_rows === 1;
    $stmt->close();
    return $ok;
}
