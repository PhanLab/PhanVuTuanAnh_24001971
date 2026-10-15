<?php
require_once __DIR__ . '/common/auth.php';
requireLogin();
require_once __DIR__ . '/model/product.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$pageTitle = 'Xác nhận xóa sản phẩm';
$error = '';
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken()) {
        $error = 'Yêu cầu không hợp lệ. Vui lòng tải lại trang.';
    } elseif (($_POST['confirm'] ?? '') !== 'yes') {
        header('Location: product_list.php');
        exit;
    } elseif (deleteProduct($id)) {
        header('Location: product_list.php?msg=deleted');
        exit;
    } else {
        $error = 'Không thể xóa sản phẩm. Có thể sản phẩm đã bị xóa trước đó.';
    }
}

require __DIR__ . '/view/header.php';
?>
<h2>Xác nhận xóa sản phẩm</h2>
<?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<p>Bạn có chắc chắn muốn xóa sản phẩm <strong><?= e($product['name']) ?></strong> (ID <?= (int)$id ?> không?</p>
<form method="post" action="product_delete.php?id=<?= (int)$id ?>">
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <input type="hidden" name="confirm" value="yes">
    <button type="submit">Xác nhận xóa</button>
    <a href="product_list.php">Hủy</a>
</form>
<?php require __DIR__ . '/view/footer.php'; ?>
