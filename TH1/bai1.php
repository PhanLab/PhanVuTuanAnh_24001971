// Làm quen với biến, mảng và vòng lặp trong PHP

<?php
    $students = [
        [
            "name" => 'Nguyen Van A',
            "age" => 20,
            "score" => 8.5
        ],
        [
            "name" => "Tran Thi Binh",
            "age" => 21,
            "score" => 6.5
        ],
        [
            "name" => "Le Van Cuong",
            "age" => 19,
            "score" => 4.5
        ],
        [
            "name" => "Pham Thi Dung",
            "age" => 20,
            "score" => 7.5
        ]
    ];

    $totalScore = 0;
    $studentCount = count($students);

    foreach ($students as $student) {
        echo "Name: " . $student['name'] . ", Age: " . $student['age'] . ", Score: " . $student['score'] . "<br>";
        $totalScore += $student['score'];
    }

    $averageScore = $totalScore / $studentCount;
    echo "Average Score: " . $averageScore . "<br>";
?>