<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';

$name = '';
$price = '';
$quantity = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken()) {
        $error = 'Yêu cầu không hợp lệ. Vui lòng tải lại trang.';
    } else {
        $name = trim((string)($_POST['name'] ?? ''));
        $price = trim((string)($_POST['price'] ?? ''));
        $quantity = trim((string)($_POST['quantity'] ?? ''));
        if ($name === '') {
            $error = 'Tên sản phẩm không được để trống.';
        } elseif (mb_strlen($name) > 100) {
            $error = 'Tên sản phẩm không được dài quá 100 ký tự.';
        } elseif (!is_numeric($price) || (float)$price <= 0 || (float)$price > 99999999.99) {
            $error = 'Giá phải là số lớn hơn 0 và không vượt quá 99.999.999,99.';
        } elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false || (int)$quantity < 0) {
            $error = 'Số lượng phải là số nguyên không âm.';
        } elseif ((int)$quantity > 2147483647) {
            $error = 'Số lượng quá lớn.';
        } elseif (addProduct($name, (float)$price, (int)$quantity)) {
            header('Location: product_list.php?msg=added');
            exit;
        } else {
            $error = 'Không thể thêm sản phẩm. Vui lòng thử lại.';
        }
    }
}
$pageTitle = 'Thêm sản phẩm';
require __DIR__ . '/view/header.php';
?>
<h2>Thêm sản phẩm</h2>
<?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post" action="product_add.php">
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <label for="name">Tên sản phẩm</label>
    <input id="name" name="name" type="text" maxlength="100" required value="<?= e($name) ?>">
    <label for="price">Giá</label>
    <input id="price" name="price" type="number" min="0.01" max="99999999.99" step="0.01" required value="<?= e($price) ?>">
    <label for="quantity">Số lượng</label>
    <input id="quantity" name="quantity" type="number" min="0" step="1" required value="<?= e($quantity) ?>">
    <p><button type="submit">Thêm sản phẩm</button> <a href="product_list.php">Hủy</a></p>
</form>
<?php require __DIR__ . '/view/footer.php'; ?>
