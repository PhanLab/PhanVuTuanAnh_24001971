<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: product_list.php');
    exit;
}

$username = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken()) {
        $error = 'Yêu cầu không hợp lệ. Vui lòng tải lại trang và thử lại.';
    } else {
        $username = trim((string)($_POST['username'] ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $user = ($username !== '' && $password !== '') ? getUserByUsername($username) : null;
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: product_list.php');
            exit;
        }
        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}
$pageTitle = 'Đăng nhập';
require __DIR__ . '/view/header.php';
?>
<h2>Đăng nhập</h2>
<?php if (isset($_GET['registered'])): ?><p class="success">Đăng ký thành công. Hãy đăng nhập.</p><?php endif; ?>
<?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post" action="login.php">
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <label for="username">Tên đăng nhập</label>
    <input id="username" name="username" type="text" maxlength="50" required value="<?= e($username) ?>" autocomplete="username">
    <label for="password">Mật khẩu</label>
    <input id="password" name="password" type="password" required autocomplete="current-password">
    <p><button type="submit">Đăng nhập</button></p>
</form>
<p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
<?php require __DIR__ . '/view/footer.php'; ?>
