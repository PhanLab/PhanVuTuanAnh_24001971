<?php
/**
 * Products REST-style API for the TH8 PHP + Vue.js exercise.
 * GET    /api/products.php          - list products
 * POST   /api/products.php          - create a product (JSON body)
 * PUT    /api/products.php?id=1     - update a product (JSON body)
 * DELETE /api/products.php?id=1     - delete a product
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $statusCode, array $payload): void
{
    http_response_code($statusCode);
    echo json_encode(
        $payload,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    exit;
}

function read_json_body(): array
{
    $rawBody = file_get_contents('php://input');
    $decoded = json_decode($rawBody ?: '', true);

    if (!is_array($decoded)) {
        respond(400, [
            'success' => false,
            'message' => 'Dữ liệu gửi lên phải là JSON object hợp lệ.',
        ]);
    }

    return $decoded;
}

/** Return an integer for JSON integers or integer strings; reject floats. */
function parse_integer($value): ?int
{
    if (is_int($value)) {
        return $value;
    }

    if (!is_string($value) || !preg_match('/^-?\d+$/D', $value)) {
        return null;
    }

    $parsed = filter_var($value, FILTER_VALIDATE_INT);
    return $parsed === false ? null : $parsed;
}

function validate_product(array $input): array
{
    $name = $input['name'] ?? null;
    $price = parse_integer($input['price'] ?? null);
    $stock = parse_integer($input['stock'] ?? null);

    if (!is_string($name)) {
        respond(422, ['success' => false, 'message' => 'Tên sản phẩm phải là chuỗi.']);
    }

    $name = trim($name);
    $characterCount = preg_match_all('/[\s\S]/u', $name);

    if ($characterCount === false || $characterCount < 1 || $characterCount > 100) {
        respond(422, [
            'success' => false,
            'message' => 'Tên sản phẩm phải có từ 1 đến 100 ký tự sau khi bỏ khoảng trắng hai đầu.',
        ]);
    }

    // MySQL INT is a signed 32-bit integer. Keep values inside its safe range.
    if ($price === null || $price < 1 || $price > 2147483647) {
        respond(422, [
            'success' => false,
            'message' => 'Đơn giá phải là số nguyên lớn hơn 0.',
        ]);
    }

    if ($stock === null || $stock < 0 || $stock > 2147483647) {
        respond(422, [
            'success' => false,
            'message' => 'Số lượng tồn phải là số nguyên không âm.',
        ]);
    }

    return [
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
    ];
}

function read_product_id(): int
{
    $rawId = $_GET['id'] ?? null;
    $id = parse_integer($rawId);

    if ($id === null || $id < 1) {
        respond(400, ['success' => false, 'message' => 'Mã sản phẩm không hợp lệ.']);
    }

    return $id;
}

function product_by_id(PDO $pdo, int $id): ?array
{
    $statement = $pdo->prepare(
        'SELECT id, name, price, stock FROM products WHERE id = :id'
    );
    $statement->execute(['id' => $id]);
    $product = $statement->fetch();

    if ($product === false) {
        return null;
    }

    $product['id'] = (int) $product['id'];
    $product['price'] = (int) $product['price'];
    $product['stock'] = (int) $product['stock'];
    return $product;
}

try {
    require __DIR__ . '/../config/database.php';

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    if ($method === 'GET') {
        $statement = $pdo->query(
            'SELECT id, name, price, stock FROM products ORDER BY id ASC'
        );
        $products = $statement->fetchAll();

        foreach ($products as &$product) {
            $product['id'] = (int) $product['id'];
            $product['price'] = (int) $product['price'];
            $product['stock'] = (int) $product['stock'];
        }
        unset($product);

        respond(200, ['success' => true, 'data' => $products]);
    }

    if ($method === 'POST') {
        $product = validate_product(read_json_body());
        $statement = $pdo->prepare(
            'INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)'
        );
        $statement->execute($product);

        $newProduct = product_by_id($pdo, (int) $pdo->lastInsertId());
        respond(201, [
            'success' => true,
            'message' => 'Thêm sản phẩm thành công.',
            'data' => $newProduct,
        ]);
    }

    if ($method === 'PUT') {
        $id = read_product_id();
        $product = validate_product(read_json_body());

        if (product_by_id($pdo, $id) === null) {
            respond(404, ['success' => false, 'message' => 'Không tìm thấy sản phẩm cần sửa.']);
        }

        $statement = $pdo->prepare(
            'UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id'
        );
        $statement->execute([
            'name' => $product['name'],
            'price' => $product['price'],
            'stock' => $product['stock'],
            'id' => $id,
        ]);

        respond(200, [
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công.',
            'data' => product_by_id($pdo, $id),
        ]);
    }

    if ($method === 'DELETE') {
        $id = read_product_id();
        $statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);

        if ($statement->rowCount() === 0) {
            respond(404, ['success' => false, 'message' => 'Không tìm thấy sản phẩm cần xóa.']);
        }

        respond(200, ['success' => true, 'message' => 'Xóa sản phẩm thành công.']);
    }

    header('Allow: GET, POST, PUT, DELETE');
    respond(405, ['success' => false, 'message' => 'Phương thức HTTP không được hỗ trợ.']);
} catch (PDOException $exception) {
    error_log('[TH8 API] Database error: ' . $exception->getMessage());
    respond(500, [
        'success' => false,
        'message' => 'Không thể xử lý dữ liệu với cơ sở dữ liệu. Hãy kiểm tra cấu hình MySQL.',
    ]);
} catch (Throwable $exception) {
    error_log('[TH8 API] Unexpected error: ' . $exception->getMessage());
    respond(500, ['success' => false, 'message' => 'Đã xảy ra lỗi máy chủ.']);
}
