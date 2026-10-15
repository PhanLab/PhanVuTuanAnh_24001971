<?php
if (!isset($pageTitle)) $pageTitle = 'Quan ly gio hang';
require_once __DIR__ . '/../common/auth.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <style>
        body{font-family:Arial,sans-serif;max-width:1000px;margin:25px auto;padding:0 16px;line-height:1.5;color:#222}
        nav{padding:12px;background:#f1f1f1;margin-bottom:20px} nav a{margin-right:14px}
        table{border-collapse:collapse;width:100%;margin:14px 0}th,td{border:1px solid #bbb;padding:9px;text-align:left}
        input{padding:7px;max-width:100%;box-sizing:border-box}label{display:block;margin:12px 0 4px}
        button{padding:8px 12px;cursor:pointer}.error{color:#a00}.success{color:#075d20}
    </style>
</head>
<body>
<header>
    <h1>Quản lý giỏ hàng</h1>
    <nav>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="product_list.php">Danh sách sản phẩm</a>
            <a href="product_add.php">Thêm sản phẩm</a>
            <span>Xin chào, <strong><?= e($_SESSION['username'] ?? '') ?></strong></span>
            <form method="post" action="logout.php" style="display:inline">
                <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                <button type="submit">Đăng xuất</button>
            </form>
        <?php else: ?>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
        <?php endif; ?>
    </nav>
</header>
<main>
