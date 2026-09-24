<?php

class Movie
{
    private $id;
    private $title;
    private $price;
    private $totalSeats;
    private $availableSeats;

    public function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getTotalSeats()
    {
        return $this->totalSeats;
    }

    public function getAvailableSeats()
    {
        return $this->availableSeats;
    }

    public function bookTicket($quantity)
    {
        if ($quantity <= 0)
        {
            echo "Lỗi: Số vé đặt phải lớn hơn 0.<br>";
            return false;
        }

        if ($quantity > $this->availableSeats)
        {
            echo "Lỗi: Không đủ ghế trống để đặt "
                . $quantity
                . " vé cho phim "
                . $this->title
                . ".<br>";

            return false;
        }

        $this->availableSeats -= $quantity;

        echo "Đặt thành công "
            . $quantity
            . " vé cho phim "
            . $this->title
            . ".<br>";

        return true;
    }

    public function cancelTicket($quantity)
    {
        if ($quantity <= 0)
        {
            echo "Lỗi: Số vé hủy phải lớn hơn 0.<br>";
            return false;
        }

        if ($quantity > $this->getSoldSeats())
        {
            echo "Lỗi: Không thể hủy "
                . $quantity
                . " vé vì số vé đã bán không đủ.<br>";

            return false;
        }

        $this->availableSeats += $quantity;

        echo "Đã hủy "
            . $quantity
            . " vé của phim "
            . $this->title
            . ".<br>";

        return true;
    }

    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo()
    {
        echo "<div>";

        echo "<h3>" . $this->title . "</h3>";

        echo "Mã phim: " . $this->id . "<br>";
        echo "Tên phim: " . $this->title . "<br>";
        echo "Giá vé: " . number_format($this->price) . " VND<br>";
        echo "Tổng số ghế: " . $this->totalSeats . "<br>";
        echo "Số ghế còn lại: " . $this->availableSeats . "<br>";
        echo "Số vé đã bán: " . $this->getSoldSeats() . "<br>";
        echo "Doanh thu: "
            . number_format($this->getRevenue())
            . " VND<br>";

        echo "</div>";

        echo "<hr>";
    }
}


// =======================================
// CÁC FUNCTION
// =======================================

function findMovieById($movies, $id)
{
    foreach ($movies as $movie) {
        if ($movie->getId() == $id) {
            return $movie;
        }
    }

    return null;
}


function getTotalRevenue($movies)
{
    $totalRevenue = 0;

    foreach ($movies as $movie) {
        $totalRevenue += $movie->getRevenue();
    }

    return $totalRevenue;
}


function getBestSellingMovie($movies)
{
    if (empty($movies)) {
        return null;
    }

    $bestSellingMovie = $movies[0];

    foreach ($movies as $movie) {
        if ($movie->getSoldSeats() > $bestSellingMovie->getSoldSeats()) {
            $bestSellingMovie = $movie;
        }
    }

    return $bestSellingMovie;
}


// =======================================
// CHƯƠNG TRÌNH CHÍNH
// =======================================

$movies = [
    new Movie(1, "Avengers", 100000, 100),
    new Movie(2, "Avatar", 120000, 80),
    new Movie(3, "Batman", 90000, 120),
    new Movie(4, "Spider-Man", 110000, 90)
];


// Đặt vé cho Avengers
$avengers = findMovieById($movies, 1);

if ($avengers !== null) {
    $avengers->bookTicket(30);
}


// Đặt vé cho Spider-Man
$spiderman = findMovieById($movies, 4);
//$avatar = findMovieById($movies, 2);

if ($spiderman !== null) {
    $spiderman->bookTicket(50);
}


// Hủy một số vé Avengers
if ($avengers !== null) {
    $avengers->cancelTicket(10);
}


// =======================================
// HIỂN THỊ THÔNG TIN
// =======================================

echo "<h2>THÔNG TIN CÁC BỘ PHIM</h2>";

foreach ($movies as $movie) {
    $movie->displayInfo();
}


// =======================================
// TỔNG DOANH THU
// =======================================

echo "<h2>TỔNG DOANH THU</h2>";

$totalRevenue = getTotalRevenue($movies);

echo number_format($totalRevenue) . " VND";


// =======================================
// PHIM BÁN ĐƯỢC NHIỀU VÉ NHẤT
// =======================================

echo "<h2>PHIM CÓ SỐ VÉ BÁN RA NHIỀU NHẤT</h2>";

$bestSellingMovie = getBestSellingMovie($movies);

if ($bestSellingMovie !== null) {
    echo "Tên phim: "
        . $bestSellingMovie->getTitle()
        . "<br>";

    echo "Số vé đã bán: "
        . $bestSellingMovie->getSoldSeats()
        . "<br>";
}

?>