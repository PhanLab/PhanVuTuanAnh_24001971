<?php
require_once __DIR__ . '/common/auth.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: product_list.php');
} else {
    header('Location: login.php');
}
exit;
