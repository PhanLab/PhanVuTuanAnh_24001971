-- BÀI 2 – QUẢN LÝ VÉ XEM PHIM

-- Tạo database
CREATE DATABASE IF NOT EXISTS movie_ticket;

-- Sử dụng database
USE movie_ticket;


-- 1. TẠO BẢNG movies

CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);


-- 2. THÊM ÍT NHẤT 5 BỘ PHIM

INSERT INTO movies (title, price, total_seats, available_seats)
VALUES
    ('Avengers: Endgame', 120000.00, 100, 30),
    ('Spider-Man: No Way Home', 110000.00, 120, 70),
    ('Interstellar', 100000.00, 150, 80),
    ('Inception', 90000.00, 100, 25),
    ('The Batman', 130000.00, 80, 20);


-- 3. HIỂN THỊ TOÀN BỘ DANH SÁCH PHIM

SELECT *
FROM movies;


-- 4. HIỂN THỊ PHIM CÓ GIÁ VÉ > 100000

SELECT *
FROM movies
WHERE price > 100000;


-- 5. HIỂN THỊ PHIM CÒN > 50 GHẾ

SELECT *
FROM movies
WHERE available_seats > 50;


-- 6. SẮP XẾP PHIM THEO GIÁ VÉ GIẢM DẦN

SELECT *
FROM movies
ORDER BY price DESC;


-- 7. CẬP NHẬT SỐ GHẾ CÒN LẠI CỦA MỘT PHIM

UPDATE movies
SET available_seats = 60
WHERE title = 'Spider-Man: No Way Home';

-- Kiểm tra kết quả
SELECT *
FROM movies
WHERE title = 'Spider-Man: No Way Home';


-- 8. XÓA MỘT PHIM

DELETE FROM movies
WHERE title = 'The Batman';

-- Kiểm tra kết quả
SELECT *
FROM movies;


-- 9. HIỂN THỊ SỐ VÉ ĐÃ BÁN CỦA TỪNG PHIM

SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_tickets
FROM movies;


-- 10. TÍNH DOANH THU CỦA TỪNG PHIM

SELECT
    title,
    price,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_tickets,
    (total_seats - available_seats) * price AS revenue
FROM movies;


-- 11. TÍNH TỔNG DOANH THU CỦA TẤT CẢ PHIM

SELECT
    SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;


-- 12. TÌM PHIM CÓ SỐ VÉ BÁN RA NHIỀU NHẤT

SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_tickets
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);
