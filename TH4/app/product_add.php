<?php

require_once __DIR__ . '/model/product.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if ($name === '') {
        $error = "Tên sản phẩm không được rỗng.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = "Giá sản phẩm phải lớn hơn 0.";
    } elseif (!filter_var($quantity, FILTER_VALIDATE_INT) === false && $quantity >= 0) {
        // hợp lệ
    } elseif (!is_numeric($quantity) || $quantity < 0 || floor($quantity) != $quantity) {
        $error = "Số lượng phải là số nguyên >= 0.";
    }

    if ($error === "") {

        if (addProduct($name, $price, $quantity)) {
            header("Location: product_list.php");
            exit;
        }

        $error = "Không thể thêm sản phẩm.";
    }
}

include __DIR__ . '/view/header.php';
?>

<h2>Thêm sản phẩm</h2>

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
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
        >
    </p>

    <p>
        <label>Giá:</label><br>
        <input
            type="number"
            name="price"
            step="0.01"
            min="0.01"
            value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"
        >
    </p>

    <p>
        <label>Số lượng:</label><br>
        <input
            type="number"
            name="quantity"
            min="0"
            value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>"
        >
    </p>

    <button type="submit">Thêm sản phẩm</button>

    <a href="product_list.php">Quay lại</a>

</form>

<?php include __DIR__ . '/view/footer.php'; ?>