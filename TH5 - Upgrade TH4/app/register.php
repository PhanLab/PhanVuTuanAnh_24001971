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
        if ($username === '' || $password === '') {
            $error = 'Tên đăng nhập và mật khẩu không được để trống.';
        } elseif (mb_strlen($username) > 50) {
            $error = 'Tên đăng nhập không được dài quá 50 ký tự.';
        } elseif (preg_match('/\s/', $username)) {
            $error = 'Tên đăng nhập không được chứa khoảng trắng.';
        } elseif (strlen($password) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
        } elseif (getUserByUsername($username)) {
            $error = 'Tên đăng nhập đã tồn tại.';
        } elseif (registerUser($username, $password)) {
            header('Location: login.php?registered=1');
            exit;
        } else {
            // Bao gom truong hop username bi trung do hai request dong thoi.
            $error = 'Không thể đăng ký. Tên đăng nhập có thể đã tồn tại.';
        }
    }
}
$pageTitle = 'Đăng ký';
require __DIR__ . '/view/header.php';
?>
<h2>Đăng ký tài khoản</h2>
<?php if ($error !== ''): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<form method="post" action="register.php">
    <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
    <label for="username">Tên đăng nhập</label>
    <input id="username" name="username" type="text" maxlength="50" required value="<?= e($username) ?>" autocomplete="username">
    <label for="password">Mật khẩu (ít nhất 6 ký tự)</label>
    <input id="password" name="password" type="password" minlength="6" required autocomplete="new-password">
    <p><button type="submit">Đăng ký</button></p>
</form>
<p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
<?php require __DIR__ . '/view/footer.php'; ?>
