// Xử lý danh sách sinh viên <br>

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

    // Functions
    function findBestStudent($students) {
        $bestStudent = null;
        $bestScore = 0;

        foreach ($students as $student) {
            if ($student['score'] > $bestScore) {
                $bestScore = $student['score'];
                $bestStudent = $student;
            }
        }

        return $bestStudent['name'];
    }
    
    function findWorstStudent($students) {
        $worstStudent = null;
        $worstScore = 10;

        foreach ($students as $student) {
            if ($student['score'] < $worstScore) {
                $worstScore = $student['score'];
                $worstStudent = $student;
            }
        }

        return $worstStudent['name'];
    }   

    function countPassedStudents($students) {
        $passedCount = 0;

        foreach ($students as $student) {
            if ($student['score'] >= 5) {
                $passedCount++;
            }
        }

        return $passedCount;
    }

    function findStudentByName($students, $name) {
        foreach ($students as $student) {
            if ($student['name'] === $name) {
                return $student;
            }
        }
        return null;
    }

    // Display functions

    echo "Best Student: " . findBestStudent($students) . "<br>";
    echo "Worst Student: " . findWorstStudent($students) . "<br>";
    echo "Passed Students: " . countPassedStudents($students) . "<br>";
    echo "Nguyen Van A: " . "Age: " . findStudentByName($students, "Nguyen Van A")['age'] . " - Score: " . findStudentByName($students, "Nguyen Van A")['score'] . "<br>";
?>