<?php
// 1. Khai bao bien
$name = "Nguyen Van A";
$score = 7.5;

// 2. Xep loai hoc sinh
if ($score >= 8) {
    $rank = "Gioi";
} elseif ($score >= 6.5) {
    $rank = "Kha";
} elseif ($score >= 5) {
    $rank = "Trung binh";
} else {
    $rank = "Yeu";
}

// 3. In ket qua
echo "Ten hoc sinh: " . $name . "<br>";
echo "Diem: " . $score . "<br>";
echo "Xep loai: " . $rank;
?>