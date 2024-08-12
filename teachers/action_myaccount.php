<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';

        if (isset($_POST['action']) && $_POST['action'] == 'PersonalInfo') {
            $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);

            $check_userid = checkItem('UserID', 'userss', $userid);
            if ($check_userid > 0) {
                $stmt = $con->prepare("SELECT PersonalInfo FROM userss WHERE UserID = ? LIMIT 1");
                $stmt->execute(array($userid));
                $row = $stmt->fetch();

                if ($row['PersonalInfo'] == 0) {
                    $stmt = $con->prepare("UPDATE userss SET PersonalInfo = ? WHERE UserID = ?");
                    $stmt->execute(array(1, $userid));
                    echo 'success';
                }else {
                    $stmt = $con->prepare("UPDATE userss SET PersonalInfo = ? WHERE UserID = ?");
                    $stmt->execute(array(0, $userid));
                    echo 'success';
                }

            }else {
                echo 'There is no that id';
            }
        }

    }
?>