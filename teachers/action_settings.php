<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';

        if (isset($_POST['action']) && $_POST['action'] == 'updateInfoUser') {
            $user_id = filter_var($_POST['idUser'], FILTER_SANITIZE_NUMBER_INT);
            $avatar_img_name = $_FILES['avatar']['name'];
            $avatar_img_tmp_name = $_FILES['avatar']['tmp_name'];
            $avatar_img_size = ($_FILES['avatar']['size']) / 1024 / 1024;
            $Fname = filter_var($_POST['FName'], FILTER_SANITIZE_STRING);
            $Sname = filter_var($_POST['SName'], FILTER_SANITIZE_STRING);
            $Email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
            $phoneNumber = filter_var($_POST['phoneNumber'], FILTER_SANITIZE_NUMBER_INT);

            if (empty($user_id) || empty($Fname) || empty($Sname) || empty($Email) || empty($phoneNumber)) {
                echo 'empty';
            }else {
                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($avatar_img_name, PATHINFO_EXTENSION);
                if (!empty($avatar_img_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {
                    if ((filter_var($Email, FILTER_VALIDATE_EMAIL) === FALSE)) {
                        echo 'email is not valid';
                    }else {
                        if ($avatar_img_size > 30) {
                            echo 'img is big';
                        }else {
                            if (strlen($phoneNumber)  !== 10) {
                                echo 'phone number is not a valid number';
                            }else {
                                $stmt = $con->prepare("SELECT Avatar FROM userss WHERE UserID = ? LIMIT 1");
                                $stmt->execute(array($user_id));
                                $row = $stmt->fetch();
                                if ($stmt->rowCount() > 0) {
        
                                    if (!empty($avatar_img_tmp_name)) {
                                        $img_up_name = rand(0, 10000).'_'.time().'_'.$avatar_img_name;
                                        move_uploaded_file($avatar_img_tmp_name, $upload.'imags/Avatar/'.$img_up_name);
                                        $stmt = $con->prepare("UPDATE userss SET 
                                                                                Avatar = ?
                                                                            WHERE UserID = ?");
                                        $stmt->execute(array($img_up_name, $user_id));
                                        if (file_exists($upload."imags/Avatar/".$row['Avatar']) !== false) {
                                            unlink($upload."imags/Avatar/".$row['Avatar']);
                                        }
                                    }
                                    $stmt = $con->prepare("UPDATE userss SET 
                                                                            FName = ?,
                                                                            SName =?,
                                                                            Email = ?,
                                                                            PhoneNumber = ?
                                                                        WHERE UserID = ?");
                                    $stmt->execute(array($Fname, $Sname, $Email, $phoneNumber , $user_id));
                                    echo'success';
                                }else {
                                    echo 'There is no that id';
                                }
                            }
                        }
                    }
                }
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'updateSocial') {
            $user_id = filter_var($_POST['idUser'], FILTER_SANITIZE_NUMBER_INT);
            $twitter = filter_var($_POST['twitter'], FILTER_SANITIZE_URL);
            $facebook = filter_var($_POST['facebook'], FILTER_SANITIZE_URL);
            $linkedin = filter_var($_POST['linkedin'], FILTER_SANITIZE_URL);
            $youtube = filter_var($_POST['youtube'], FILTER_SANITIZE_URL);

            if (empty($user_id)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM userss WHERE UserID = ? LIMIT 1");
                $stmt->execute(array($user_id));
                $row = $stmt->fetch();
                if ($stmt->rowCount() > 0) {
                    $stmt = $con->prepare("UPDATE userss SET 
                                                            Twitter = ?,
                                                            Facebook =?,
                                                            Linkedin = ?,
                                                            Youtube	 = ?
                                                        WHERE UserID = ?");
                    $stmt->execute(array($twitter, $facebook, $linkedin, $youtube , $user_id));
                    echo'success';
                }else {
                    echo 'There is no that id';
                }
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'changepass') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $oldpass = filter_var($_POST['oldpass'], FILTER_SANITIZE_STRING);
            $newpass = filter_var($_POST['newpass'], FILTER_SANITIZE_STRING);
            $confirmpass = filter_var($_POST['confirmpass'], FILTER_SANITIZE_STRING);

            if (empty($user_id) || empty($oldpass) || empty($newpass) || empty($confirmpass)) {
                echo 'empty';
            }else {
                if ($newpass !== $confirmpass) {
                    echo 'newpass is not equal to confirmpass';
                }else {
                    $check_userid = checkItem('UserID', 'courses', $user_id);
                    if ($check_userid = 0) {
                        echo 'there is no that id';
                    }else {
                        $userpass = getDates('PassWord', 'userss', ' WHERE UserID = ?', $user_id);
                        if (password_verify($oldpass, $userpass) === false) {
                            echo 'oldpass is not equal to userpass';
                        }else {
                            $passcount = 0;
                            $stmt = $con->prepare("SELECT
                                                    password
                                                FROM
                                                    userss");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            $arraypass = array();
                            foreach ($rows as $row) {
                                $arraypass[] = $row['password'];
                            }
                            foreach ($arraypass as $pass) {
                                if (password_verify($newpass, $pass)) {
                                    $passcount = 1;
                                }
                            }
                            if ($passcount === 1) {
                                echo 'this pass is used';
                            }else {
                                $hashedpass = password_hash($newpass, PASSWORD_DEFAULT);
                                $stmt = $con->prepare("UPDATE userss SET password = ?, LastChahgePassDate = now() WHERE UserID = ?");
                                $stmt->execute(array($hashedpass, $user_id));
                                echo 'success';
                            }
                        }
                    }
                }
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'stylecolor') {
            $mainColor = filter_var($_POST['maincolor'], FILTER_SANITIZE_STRING);
            $mainColoralt = filter_var($_POST['maincoloralt'], FILTER_SANITIZE_STRING);
            setcookie('style[maincolor]', $mainColor, strtotime('+1 year'));
            setcookie('style[maincoloralt]', $mainColoralt, strtotime('+1 year'));
            echo 'success';
        }elseif (isset($_POST['action']) && $_POST['action'] == 'designlinks') {
            $designlinks = filter_var($_POST['designlinks'], FILTER_SANITIZE_STRING);
            setcookie('style[designlinks]', $designlinks, strtotime('+1 year'));
            echo 'success';
        }
    }
?>