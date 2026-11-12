-- TH8: PHP + Vue.js
-- Database name is chosen for this exercise: th8_php_vuejs.

CREATE DATABASE IF NOT EXISTS th8_php_vuejs
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE th8_php_vuejs;

CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    CONSTRAINT chk_products_price_positive CHECK (price > 0),
    CONSTRAINT chk_products_stock_nonnegative CHECK (stock >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Import this file once into a new database to create the three sample rows.
INSERT INTO products (name, price, stock) VALUES
    ('Bút bi', 5000, 20),
    ('Vở ô ly', 12000, 15),
    ('Thước kẻ', 8000, 0);
