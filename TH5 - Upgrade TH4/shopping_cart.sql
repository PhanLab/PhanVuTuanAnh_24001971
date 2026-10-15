CREATE DATABASE IF NOT EXISTS shopping_cart CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT UNSIGNED NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Du lieu san pham mau: chi chay khoi INSERT nay mot lan de tranh lap du lieu.
INSERT INTO products (name, price, quantity) VALUES
('Laptop', 15000000.00, 10),
('Chuot khong day', 350000.00, 25),
('Ban phim co', 1200000.00, 15),
('Tai nghe', 800000.00, 20),
('Man hinh', 4500000.00, 8);

-- Tai khoan mau: admin / 123456. Gia tri password duoi day la ket qua password_hash().
INSERT IGNORE INTO users (username, password) VALUES
('admin', '$2y$12$rFpYK21DmRK7d0kPVu57VOnKahMf4X4ex1OJTy4lsmMG280r01cca');
