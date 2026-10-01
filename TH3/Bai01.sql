-- BÀI 1 – QUẢN LÝ GIỎ HÀNG

-- Tạo database
CREATE DATABASE IF NOT EXISTS shopping_cart;

-- Sử dụng database
USE shopping_cart;

SELECT DATABASE();


-- 1. TẠO BẢNG cart_items

CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);


-- 2. THÊM ÍT NHẤT 5 SẢN PHẨM

INSERT INTO cart_items (name, price, quantity)
VALUES
    ('Laptop Dell', 15000000.00, 2),
    ('Chuột Logitech', 450000.00, 10),
    ('Bàn phím cơ', 1200000.00, 6),
    ('Tai nghe Bluetooth', 850000.00, 8),
    ('Màn hình Samsung', 4500000.00, 3);


-- 3. HIỂN THỊ TOÀN BỘ SẢN PHẨM

SELECT *
FROM cart_items;


-- 4. HIỂN THỊ SẢN PHẨM CÓ GIÁ > 100000

SELECT *
FROM cart_items
WHERE price > 100000;


-- 5. HIỂN THỊ SẢN PHẨM CÓ SỐ LƯỢNG > 5

SELECT *
FROM cart_items
WHERE quantity > 5;


-- 6. SẮP XẾP SẢN PHẨM THEO GIÁ GIẢM DẦN

SELECT *
FROM cart_items
ORDER BY price DESC;


-- 7. CẬP NHẬT GIÁ CỦA MỘT SẢN PHẨM

UPDATE cart_items
SET price = 500000.00
WHERE name = 'Chuột Logitech';

-- Kiểm tra kết quả
SELECT *
FROM cart_items
WHERE name = 'Chuột Logitech';


-- 8. CẬP NHẬT SỐ LƯỢNG CỦA MỘT SẢN PHẨM

UPDATE cart_items
SET quantity = 12
WHERE name = 'Chuột Logitech';

-- Kiểm tra kết quả
SELECT *
FROM cart_items
WHERE name = 'Chuột Logitech';


-- 9. XÓA MỘT SẢN PHẨM

DELETE FROM cart_items
WHERE name = 'Tai nghe Bluetooth';

-- Kiểm tra kết quả
SELECT *
FROM cart_items;


-- 10. HIỂN THỊ TÊN, GIÁ, SỐ LƯỢNG VÀ THÀNH TIỀN

SELECT
    name,
    price,
    quantity,
    price * quantity AS total
FROM cart_items;


-- 11. TÍNH TỔNG TIỀN CỦA TOÀN BỘ GIỎ HÀNG

SELECT
    SUM(price * quantity) AS total_cart
FROM cart_items;

