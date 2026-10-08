<?php

require_once __DIR__ . '/model/product.php';

$id = $_GET['id'] ?? 0;

$product = getProductById($id);

include __DIR__ . '/view/header.php';

if (!$product) {

    echo "<p>Sản phẩm không tồn tại.</p>";
    echo '<a href="product_list.php">Quay lại</a>';

} else {

    if (deleteProduct($id)) {

        echo "<p>Xóa sản phẩm thành công.</p>";

    } else {

        echo "<p>Không thể xóa sản phẩm.</p>";
    }

    echo '<a href="product_list.php">Quay lại danh sách</a>';
}

include __DIR__ . '/view/footer.php';
?>