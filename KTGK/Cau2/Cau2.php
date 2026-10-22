<?php
// 1. Khai bao mang gia san pham
$prices = [100, 200, 150, 300, 250];

// 2. Ham tinh tong gia
function calculateTotal($prices) {
    $total = 0;

    foreach ($prices as $price) {
        $total = $total + $price;
    }

    return $total;
}

// 3. Ham tim gia cao nhat
function findMaxPrice($prices) {
    $max = $prices[0];

    foreach ($prices as $price) {
        if ($price > $max) {
            $max = $price;
        }
    }

    return $max;
}

// 4. Goi hai ham
$total = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

// 5. In ket qua
echo "Tong gia san pham: " . $total . "<br>";
echo "Gia san pham cao nhat: " . $maxPrice;
?>