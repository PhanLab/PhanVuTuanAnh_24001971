<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$pageTitle = 'Sửa sản phẩm';
if ($id === false || $id === null || $id < 1) {
    require __DIR__ . '/view/header.php';
    echo '<p class="error">ID sản phẩm không hợp lệ.</p><p><a href="product_list.php">Quay lại danh sách</a></p>';
    require __DIR__ . '/view/footer.php';
    exit;
}
$product = getProductById($id);
if (!$product) {
    require __DIR__ . '/view/header.php';
    echo '<p class="error">Không tìm thấy sản phẩm hoặc sản phẩm đã bị xóa.</p><p><a href="product_list.php">Quay lại danh sách</a></p>';
    require __DIR__ . '/view/footer.php';
    exit;
}

$name = (string)$product['name'];
$price = (string)$product['price'];
$quantity = (string)$product['quantity'];
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
        } elseif (updateProduct($id, $name, (float)$price, (int)$quantity)) {
            header('Location: product_list.php?msg=updated');
            exit;
        } else {
            $error = 'Không thể cập nhật sản phẩm. Vui lòng thử lại.';
        }
    }
}
?>
<?php require __DIR__ . '/view/header.php'; ?>
<h2>Sửa sản phẩm #<?= (int)$id ?></h2>
<?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post" action="product_edit.php?id=<?= (int)$id ?>">
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <label for="name">Tên sản phẩm</label>
    <input id="name" name="name" type="text" maxlength="100" required value="<?= e($name) ?>">
    <label for="price">Giá</label>
    <input id="price" name="price" type="number" min="0.01" max="99999999.99" step="0.01" required value="<?= e($price) ?>">
    <label for="quantity">Số lượng</label>
    <input id="quantity" name="quantity" type="number" min="0" step="1" required value="<?= e($quantity) ?>">
    <p><button type="submit">Lưu thay đổi</button> <a href="product_list.php">Hủy</a></p>
</form>
<?php require __DIR__ . '/view/footer.php'; ?>
