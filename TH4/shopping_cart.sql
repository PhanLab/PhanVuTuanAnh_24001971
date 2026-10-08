CREATE DATABASE IF NOT EXISTS shopping_cart
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Laptop', 15000000.00, 10),
('Chuột không dây', 350000.00, 25),
('Bàn phím cơ', 1200000.00, 15),
('Tai nghe', 800000.00, 20),
('Màn hình', 4500000.00, 8);