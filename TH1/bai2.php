// Tách hàm xử lý sinh viên <br>

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

    function calculateAverageScore($students) {
        $totalScore = 0;
        $studentCount = count($students);

        foreach ($students as $student) {
            $totalScore += $student['score'];
        }

        $averageScore = $totalScore / $studentCount;
        echo "Average Score: " . $averageScore . "<br>";
    }

    function getRank($score) {
        if ($score >= 8) {
            return "Giỏi";
        } elseif ($score >= 6.5) {
            return "Khá";
        } elseif ($score >= 5) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }

    function displayStudent($students) {
        foreach ($students as $student) {
            echo "Name: " . $student['name'] . ", Age: " . $student['age'] . ", Score: " . $student['score'] . ", Rank: " . getRank($student['score']) . "<br>";
        }
    }

    
    displayStudent($students);
    calculateAverageScore($students);
?>