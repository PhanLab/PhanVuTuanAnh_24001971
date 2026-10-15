<?php
declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_OFF);
$host = 'localhost';
$dbUser = 'root';       // Sua neu MySQL cua ban dung tai khoan khac
$dbPassword = '';       // Sua neu MySQL cua ban co mat khau
$dbName = 'shopping_cart';

$conn = new mysqli($host, $dbUser, $dbPassword, $dbName);
if ($conn->connect_error) {
    error_log('Database connection error: ' . $conn->connect_error);
    http_response_code(500);
    exit('Khong the ket noi database. Hay kiem tra MySQL va thong tin trong common/dbConnect.php.');
}
$conn->set_charset('utf8mb4');
