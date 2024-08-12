<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';
        $LIMITQUESTIONES = 100;

        if (isset($_POST['action']) && $_POST['action'] == 'writeInTheFile') {
            $content_json_file = $_POST['contentJsonFile'];
            $file_id =  filter_var($_POST['file_id'], FILTER_SANITIZE_NUMBER_INT);
            $file_name = filter_var($_POST['file_name'], FILTER_SANITIZE_STRING);
            $question_count =  filter_var($_POST['questionCount'], FILTER_SANITIZE_NUMBER_INT);
            if (empty($file_name)) {
                echo 'There is no that id';
            }else {
                if (file_exists($file_name) === FALSE) {
                    echo 'There is no that id';
                }else {
                    $stmt = $con->prepare("UPDATE tests SET CountQues = ? WHERE UserID = ?");
                    $stmt->execute(array($question_count, $file_id));

                    $questiones = json_decode($content_json_file, true);
                    // foreach ($questiones as $question) {
                    //     if (isset($question["type_item"]) && $question["type_item"] == 'question') {
                    //         // $question["img-title"];
                    //     }
                    // }

                    file_put_contents($file_name, "$content_json_file");
                    echo 'success';
                }
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'showquestiones') {
            $the_section = filter_var($_POST['the_section'], FILTER_SANITIZE_STRING);
            $sec_question = filter_var($_POST['sec_question'], FILTER_SANITIZE_STRING);
            if (empty($sec_question) || empty($the_section)) {
                echo 'empty';
            }else {
                $where = '';
                if ($the_section == 'الكل') {
                    $where = '';
                }elseif ($the_section !== 'الكل' && $sec_question !== 'الكل') {
                    $where = " WHERE theSection = '$the_section' AND secQuestion = '$sec_question' ";
                }elseif ($sec_question == 'الكل') {
                    $where = " WHERE theSection = '$the_section' ";
                }

                $stmt = $con->prepare("SELECT * FROM question_bank $where LIMIT $LIMITQUESTIONES");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                $index = 0;
                $content = '[';
                foreach($rows as $row) {
                    if ($index > 0) {$content .= ',';}
                    if ($row['typeItem'] == 'question') {
                        $content .= '{
                            "id": "'.$row['UserID'].'",
                            "type_item": "question",
                            "the_section": "'.$row['theSection'].'",
                            "sec_question": "'.$row['secQuestion'].'",
                            "math": "'.$row['math'].'",
                            "suffling": "'.$row['suffling'].'",
                            "multans": "'.$row['multans'].'",
                            "title": "'.$row['title'].'",
                            "answeres": '.$row['answeres'].',
                            "right_answeres" : '.$row['rightAnsweres'].',
                            "explain": "'.$row['explainQ'].'",
                            "the_code": "'.$row['theCode'].'",
                            "teacherID": "'.$row['TeacherID'].'"
                        }';
                    }elseif ($row['typeItem'] == 'pargraph') {
                        $content .= '{
                            "id": "'.$row['UserID'].'",
                            "type_item": "pargraph",
                            "pargraph": "'.$row['title'].'",
                            "the_code": "'.$row['theCode'].'",
                            "teacherID": "'.$row['TeacherID'].'"
                        }';
                    }
                    $index++;
                }
                $content .= ']';
                echo $content;
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'loadmorequestiones') {
            $offset = filter_var($_POST['offset'], FILTER_SANITIZE_NUMBER_INT);
            $new_offset = $LIMITQUESTIONES * $offset;
            $sec_question = filter_var($_POST['sec_question'], FILTER_SANITIZE_STRING);
            $the_section = filter_var($_POST['the_section'], FILTER_SANITIZE_STRING);
            $where = '';
            if (empty($sec_question) || empty($the_section)) {
                echo 'empty';
            }else {
                if ($sec_question == 'الكل') {
                    $where = '';
                }elseif ($sec_question !== 'الكل' && $the_section !== 'الكل') {
                    $where = " WHERE secQuestion = '$sec_question' AND theSection = '$the_section' ";
                }elseif ($sec_question !== 'الكل') {
                    $where = " WHERE secQuestion = '$sec_question' ";
                }elseif ($the_section !== 'الكل') {
                    $where = " WHERE theSection = '$the_section' ";
                }
                $stmt = $con->prepare("SELECT * FROM question_bank $where ORDER BY UserID ASC LIMIT $LIMITQUESTIONES OFFSET $new_offset");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if ($stmt->rowCount() == 0) {
                    echo 'This is all questions';
                }else {
                    $index = 0;
                    $content = '[';
                    foreach($rows as $row) {
                        if ($index > 0) {$content .= ',';}
                        if ($row['typeItem'] == 'question') {
                            $content .= '{
                                "id": "'.$row['UserID'].'",
                                "type_item": "question",
                                "the_section": "'.$row['theSection'].'",
                                "sec_question": "'.$row['secQuestion'].'",
                                "math": "'.$row['math'].'",
                                "suffling": "'.$row['suffling'].'",
                                "multans": "'.$row['multans'].'",
                                "title": "'.$row['title'].'",
                                "answeres": '.$row['answeres'].',
                                "right_answeres" : '.$row['rightAnsweres'].',
                                "explain": "'.$row['explainQ'].'",
                                "the_code": "'.$row['theCode'].'",
                                "teacherID": "'.$row['TeacherID'].'"
                            }';
                        }elseif ($row['typeItem'] == 'pargraph') {
                            $content .= '{
                                "id": "'.$row['UserID'].'",
                                "type_item": "pargraph",
                                "pargraph": "'.$row['title'].'",
                                "the_code": "'.$row['theCode'].'",
                                "teacherID": "'.$row['TeacherID'].'"
                            }';
                        }
                        $index++;
                    }
                    $content .= ']';
                    echo $content;
                }
            }

        }elseif (isset($_POST['action']) && $_POST['action'] == 'addnewquestiones') {
            $content_json_file = $_POST['contentJsonFile'];
            $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
            if (empty($content_json_file)) {
                echo 'empty';
            }else {
                $questiones = json_decode($content_json_file, true);
                foreach ($questiones as $question) {
                    if ($question["type_item"] == 'question') {
                        
                        $epmtyAns = true;
                        foreach ($question['answeres'] as $ans) {
                            if (!empty($ans)) {$epmtyAns = false;}
                        }

                        $epmtyRihgtAns = true;
                        foreach ($question['right_answeres'] as $rihgtAns) {
                            if ($rihgtAns == 0) {
                                $epmtyRihgtAns = false;
                            }elseif (!empty($rihgtAns)) {
                                $epmtyRihgtAns = false;
                            }
                        }

                        if (!empty($question['title']) && !empty($question['explain']) && $epmtyAns == false && $epmtyRihgtAns == false) {
                            $stmt = $con->prepare("INSERT INTO question_bank  (typeItem, theSection, secQuestion, math, suffling, multans, title, answeres, rightAnsweres, explainQ, theCode, TeacherID, Date)
                                                                        VALUES(:typeItem, :theSection, :secQuestion, :math, :suffling, :multans, :title, :answeres, :rightAnsweres, :explainQ, :theCode, :TeacherID, now())");
                            $stmt->execute(array (
                                ':typeItem'     => 'question',
                                ':theSection'   => $question['the_section'],
                                ':secQuestion'  => $question['sec_question'],
                                ':math'         => $question['math'],
                                ':suffling'     => $question['suffling'],
                                ':multans'      => $question['multans'],
                                ':title'        => $question['title'],
                                ':answeres'     => json_encode($question['answeres']),
                                ':rightAnsweres'=> json_encode($question['right_answeres']),
                                ':explainQ'      => $question['explain'],
                                ':theCode'      => $question['the_code'],
                                ':TeacherID'      => $teacher_id
                            ));
                        }
                    }elseif ($question["type_item"] == 'pargraph') {
                        $stmt = $con->prepare("INSERT INTO question_bank  (typeItem, title, theSection, secQuestion, theCode, TeacherID, Date)
                                VALUES(:typeItem, :title, :theSection, :secQuestion, :theCode, :TeacherID, now())");
                        
                        $stmt->execute(array (
                            ':typeItem'   => 'pargraph',
                            ':title'      => $question['pargraph'],
                            ':theSection' => 'لفظي',
                            ':secQuestion'=> 'إستيعاب المقروء',
                            ':theCode'    => $question['the_code'],
                            ':TeacherID' => $teacher_id
                        ));
                    }
                }
                echo 'success';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'getdataquestion') {
            $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
            $stmt =  $con->prepare("SELECT * FROM question_bank WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($user_id));
            $row = $stmt->fetch();
            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                if ($row['TeacherID'] != $teacher_id) {
                    echo 'This is not for you';
                }else {
                    $content = '[';
                    if ($row['typeItem'] == 'question') {
                        $content .= '{
                            "id": "'.$row['UserID'].'",
                            "type_item": "question",
                            "the_section": "'.$row['theSection'].'",
                            "sec_question": "'.$row['secQuestion'].'",
                            "math": "'.$row['math'].'",
                            "suffling": "'.$row['suffling'].'",
                            "multans": "'.$row['multans'].'",
                            "title": "'.$row['title'].'",
                            "answeres": '.$row['answeres'].',
                            "right_answeres" : '.$row['rightAnsweres'].',
                            "explain": "'.$row['explainQ'].'",
                            "the_code": "'.$row['theCode'].'",
                            "teacherID": "'.$row['TeacherID'].'"
                        }';
                    }elseif ($row['typeItem'] == 'pargraph') {
                        $content .= '{
                            "id": "'.$row['UserID'].'",
                            "type_item": "pargraph",
                            "pargraph": "'.$row['title'].'",
                            "the_code": "'.$row['theCode'].'",
                            "teacherID": "'.$row['TeacherID'].'"
                        }';
                    }
                    $content .= ']';
                    echo $content;
                }
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'updatequestion') {
            $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
            $content_json_file = $_POST['contentJsonFile'];
            if (empty($content_json_file)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM question_bank WHERE UserID = ? LIMIT 1");
                $stmt->execute(array($user_id));
                $row = $stmt->fetch();
                if ($stmt->rowCount() == 0) {
                    echo 'there is no that id';
                }else {
                    if ($row['TeacherID'] != $teacher_id) {
                        echo 'This is not for you';
                    }else {
                        $questiones = json_decode($content_json_file, true);
                        foreach ($questiones as $question) {
                            if ($question["type_item"] == 'question') {
                                $epmtyAns = true;
                                foreach ($question['answeres'] as $ans) {
                                    if (!empty($ans)) {$epmtyAns = false;}
                                }
        
                                $epmtyRihgtAns = true;
                                foreach ($question['right_answeres'] as $rihgtAns) {
                                    if ($rihgtAns == 0) {
                                        $epmtyRihgtAns = false;
                                    }elseif (!empty($rihgtAns)) {
                                        $epmtyRihgtAns = false;
                                    }
                                }
                                if (!empty($question['title']) && !empty($question['explain']) && $epmtyAns == false && $epmtyRihgtAns == false) {
                                    $stmt = $con->prepare("UPDATE question_bank SET 
                                                                                    typeItem = ?,
                                                                                    theSection = ?, 
                                                                                    secQuestion = ?, 
                                                                                    math = ?, 
                                                                                    suffling = ?, 
                                                                                    multans = ?, 
                                                                                    title = ?, 
                                                                                    answeres = ?, 
                                                                                    rightAnsweres = ?, 
                                                                                    explainQ = ?, 
                                                                                    theCode = ?
                                                                                WHERE UserID = ? AND TeacherID = ?");
                                    $stmt->execute(array ('question', 
                                                            $question['the_section'],
                                                            $question['sec_question'],
                                                            $question['math'],
                                                            $question['suffling'],
                                                            $question['multans'],
                                                            $question['title'],
                                                            json_encode($question['answeres']),
                                                            json_encode($question['right_answeres']),
                                                            $question['explain'],
                                                            $question['the_code'],
                                                            $user_id,
                                                            $teacher_id));
                                }
                            }elseif ($question["type_item"] == 'pargraph') {
                                $stmt = $con->prepare("UPDATE question_bank SET typeItem = ?,
                                                                                title = ?, 
                                                                                theSection = ?, 
                                                                                secQuestion = ?, 
                                                                                theCode = ?
                                                                            WHERE UserID = ? AND TeacherID = ?");
                                
                                $stmt->execute(array ('pargraph',
                                                        $question['pargraph'],
                                                        'لفظي',
                                                        'إستيعاب المقروء',
                                                        $question['the_code'],
                                                        $user_id,
                                                        $teacher_id
                                ));
                            }
                        }
                        echo 'success';
                    }
                }
            
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'deletequestion') {
            $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacher_id'], FILTER_SANITIZE_NUMBER_INT);
            $stmt =  $con->prepare("SELECT TeacherID FROM question_bank WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($user_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                if ($row['TeacherID'] != $teacher_id) {
                    echo 'This is not for you';
                }else {
                    $stmt = $con->prepare("DELETE FROM question_bank WHERE UserID = :userid");
                    $stmt->bindparam(":userid", $user_id);
                    $stmt->execute();
                    echo 'success';
                }
            }
        }
    }