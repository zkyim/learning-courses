<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';

        if (isset($_POST['action']) && $_POST['action'] == 'addNewOrder') {
            $teacher_id = filter_var($_POST['TeacherID'], FILTER_SANITIZE_NUMBER_INT);
            $student_id = filter_var($_POST['StudentID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['CourseID'], FILTER_SANITIZE_NUMBER_INT);

            $check_userid = checkItem('UserID', 'userss', $student_id);
            if ($check_userid == 0) {
                echo 'There is no that id';
            }else {
                $stmt = $con->prepare("INSERT INTO orders (O_TeacherID, O_StudentID, O_CourseID, O_Date)
                                                    VALUES(:O_TeacherID, :O_StudentID, :O_CourseID, now())");
                $stmt->execute(array(
                    ':O_TeacherID' => $teacher_id,
                    ':O_StudentID' => $student_id,
                    ':O_CourseID' => $course_id
                ));
                echo 'success';
            }
        }

    }
?>