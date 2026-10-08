<?php

require_once __DIR__ . '/model/product.php';

$id = $_GET['id'] ?? 0;

$product = getProductById($id);

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if ($name === '') {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá sản phẩm phải lớn hơn 0.";
    } elseif (
        !is_numeric($quantity) ||
        $quantity < 0 ||
        floor($quantity) != $quantity
    ) {
        $error = "Số lượng phải là số nguyên >= 0.";
    }

    if ($error === "") {

        if (updateProduct($id, $name, $price, $quantity)) {
            header("Location: product_list.php");
            exit;
        }

        $error = "Không thể cập nhật sản phẩm.";
    }
}

include __DIR__ . '/view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if ($error !== ""): ?>

    <p style="color:red;">
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form method="post">

    <p>
        <label>Tên sản phẩm:</label><br>

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($_POST['name'] ?? $product['name']) ?>"
        >
    </p>

    <p>
        <label>Giá:</label><br>

        <input
            type="number"
            name="price"
            step="0.01"
            min="0.01"
            value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>"
        >
    </p>

    <p>
        <label>Số lượng:</label><br>

        <input
            type="number"
            name="quantity"
            min="0"
            value="<?= htmlspecialchars($_POST['quantity'] ?? $product['quantity']) ?>"
        >
    </p>

    <button type="submit">Cập nhật</button>

    <a href="product_list.php">Quay lại</a>

</form>

<?php include __DIR__ . '/view/footer.php'; ?>