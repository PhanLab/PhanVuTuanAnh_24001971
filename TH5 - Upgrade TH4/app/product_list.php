<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';

$pageTitle = 'Danh sách sản phẩm';
$products = getAllProducts();
require __DIR__ . '/view/header.php';
?>
<h2>Danh sách sản phẩm</h2>
<?php if (($_GET['msg'] ?? '') === 'added'): ?><p class="success">Đã thêm sản phẩm.</p><?php endif; ?>
<?php if (($_GET['msg'] ?? '') === 'updated'): ?><p class="success">Đã cập nhật sản phẩm.</p><?php endif; ?>
<?php if (($_GET['msg'] ?? '') === 'deleted'): ?><p class="success">Đã xóa sản phẩm.</p><?php endif; ?>
<p><a href="product_add.php">Thêm sản phẩm mới</a></p>
<?php if (!$products): ?>
    <p>Chưa có sản phẩm hoặc không thể tải danh sách.</p>
<?php else: ?>
<table>
    <thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Số lượng</th><th>Chức năng</th></tr></thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= (int)$product['id'] ?></td>
            <td><?= e($product['name']) ?></td>
            <td><?= number_format((float)$product['price'], 2, ',', '.') ?></td>
            <td><?= (int)$product['quantity'] ?></td>
            <td>
                <a href="product_edit.php?id=<?= (int)$product['id'] ?>">Sửa</a> |
                <a href="product_delete.php?id=<?= (int)$product['id'] ?>">Xóa</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php require __DIR__ . '/view/footer.php'; ?>
