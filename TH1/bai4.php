//  Lập trình hướng đối tượng

<?php
    class Student {
        private $name;
        private $age;
        private $score;

        // Constructor mặc định là __construct
        public function __construct($name, $age, $score) {
            $this->name = $name;
            $this->age = $age;
            $this->score = $score;
        }

        function getRank() {
            if ($this->score >= 8) {
                return "Giỏi";
            } elseif ($this->score >= 6.5) {
                return "Khá";
            } elseif ($this->score >= 5) {
                return "Trung bình";
            } else {
                return "Yếu";
            }
        }

        function getName() {
            return $this->name;
        }
        function getScore() {
            return $this->score;
        }
        function getAge() {
            return $this->age;
        }

        function isPassed() {
            return $this->score >= 5;
        }

        function display() {
            echo "Name: " . $this->name . ", Age: " . $this->age . ", Score: " . $this->score . ", Rank: " . $this->getRank() . ", Passed: " . ($this->isPassed() ? "Yes" : "No") . "<br>";
        }
    }



    $students = [
        $student1 = new Student("Nguyen Van An", 20, 8.5),
        $student2 = new Student("Tran Thi Binh", 21, 6.5),
        $student3 = new Student("Le Van Cuong", 19, 4.5),
        $student4 = new Student("Pham Thi Dung", 20, 7.5),
    ];

    function findBestStudent($students) {
        $bestStudent = null;
        $bestScore = 0;
        foreach ($students as $student) {
            if ($student->getScore() > $bestScore) {
                $bestScore = $student->getScore();
                $bestStudent = $student;
            }
        }
        return $bestStudent->getName();
    }

    function countPassedStudent($students) {
        $count = 0;
        foreach ($students as $student) {
            if ($student->isPassed()) {
                $count++;
            }
        }
        return $count;
    }

    function calculateAverageScore($students) {
        $totalScore = 0;
        $studentCount = count($students);
        foreach ($students as $student) {
            $totalScore += $student->getScore();
        }
        return $totalScore / $studentCount;
    }

    foreach ($students as $student) {
        $student->display();
    }

    echo "<br>Highest Score: " . findBestStudent($students);
    echo "<br>Number of Passed Students: " . countPassedStudent($students);
    echo "<br>Average Score: " . calculateAverageScore($students);

?>