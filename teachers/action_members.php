<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';

        if (isset($_POST['action']) && $_POST['action'] == 'search') {
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseid'], FILTER_SANITIZE_STRING);
            $membersstatus = filter_var($_POST['membersstatus'], FILTER_SANITIZE_STRING);
            $data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);
            $From_To = $_POST['From_To'];

            $course_id_search = '';
            if ($course_id !== 'all') {
                $course_id_search = " AND O_CourseID  = $course_id ";
            }
            $membersstatus_search = '';
            if ($membersstatus !== 'all') {
                if ($membersstatus == 'active') {
                    $membersstatus_search = " AND O_RegStatus = 1";
                }elseif ($membersstatus == 'pending') {
                    $membersstatus_search = " AND O_RegStatus = 0";
                }
            }
            $data_search = '';
            if (!empty($data)) {
                $data_search = " AND CONCAT(FName, SName, Email ) LIKE '%$data%' ";
            }
            $stmt = $con->prepare("SELECT * FROM orders JOIN userss ON orders.O_StudentID = userss.UserID WHERE O_TeacherID = $teacher_id $course_id_search $membersstatus_search $data_search $From_To ORDER BY `orders`.`O_UserID` ASC LIMIT $LIMIT");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                echo 'success';
                foreach ($rows as $row) {
                    echo '<tr class="p-relative">';
                    echo '<td class="nowrap"></td>';
                    echo '<td class="nowrap">'.$row['FName'].'</td>';
                    echo '<td class="nowrap">'.$row['SName'].'</td>';
                    echo '<td class="nowrap">'.$row['Email'].'</td>';
                    echo '<td class="nowrap">'; if ($row['O_RegStatus'] == 0) {echo'<span class="label btn-shape bg-red c-white status"> خامل </span>';}else {echo'<span class="label btn-shape bg-green c-white status"> فعال </span>';} echo '</td>';
                    echo '<td class="nowrap">'.$row['O_Date'].'</td>';
                    echo '<td>'; 
                      echo '<div>'; 
                      if ($row['O_RegStatus'] == 0) {
                        echo '<button class="btn-shape c-white bg-green m-5 inable-member" data-id="'.$row['UserID'].'">تفعيل</button>';
                      }
                      if ($row['O_RegStatus'] == 1) {
                        echo '<button class="btn-shape c-white bg-red m-5 inable-member" data-id="'.$row['UserID'].'">تعطيل</button>'; 
                      }
                        echo '<button class="btn-shape c-white bg-blue m-5 view-member" data-id="'.$row['UserID'].'">عرض</button>';  
                      echo '</div>'; 
                    echo '</td>';
                  echo '</tr>';
                }
                if ($stmt->rowCount() > $LIMIT) {
                    echo '
                    <tr class="load-more-skeleton">
                      <td class="nowrap"></td>
                      <td><p></p></td>
                      <td><p></p></td>
                      <td><p></p></td>
                      <td><p></p></td>
                      <td><p></p></td>
                      <td><p></p></td>
                    </tr> ';
                }

                // echo '||'.$membersstatus_search.$data_search.$From_To;
            }else {
                echo 'There is no data';
            }
            echo '||'.$course_id_search.$membersstatus_search.$data_search.$From_To;
        }elseif (isset($_POST['action']) && $_POST['action'] == 'viewMoreDetailsBut') {
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $student_id = filter_var($_POST['studentid'], FILTER_SANITIZE_NUMBER_INT);
            
            $stmt = $con->prepare("SELECT * FROM orders JOIN userss ON orders.O_StudentID = userss.UserID WHERE O_TeacherID = ? AND O_StudentID = ? LIMIT 1");
            $stmt->execute(array($teacher_id, $student_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() > 0) {
                echo 
                '
                <div class="my-account">
                    <div class="profile-page m-20">
                        <div class="overview bg-white rad-10 d-flex align-center">
                            <div class="avatar-box txt-c p-20">
                                ';
                                    if ($row['Avatar'] == '') {
                                        echo '<img src="'.$upload.'imags/Avatar/defaultImg.png" alt="">';
                                    }else {
                                        echo '<img src="'.$upload.'imags/Avatar'.$row['Avatar'].'" alt="">';
                                    }
                                echo'
                                <h3 class="m-0"> '.$row['FName'].' '.$row['SName'].' </h3>
                            </div>
                            <div class="info-box w-full txt-c-mobile">
                                <div class="box p-20 d-flex align-center">
                                    <div class="fs-14">
                                        <span class="c-grey"> البريد الإلكتروني : </span>
                                        <span> '.$row['Email'].' </span>
                                    </div>
                                    <div class="fs-14">
                                        <span class="c-grey">الاسم كامل : </span>
                                        <span> '.$row['FName'].' '.$row['SName'].' </span>
                                    </div>
                                    <div class="fs-14">
                                        <span class="c-grey">رقم الهاتف : </span>
                                        <span> '.$row['PhoneNumber'].' </span>
                                    </div>
                                    <div class="fs-14">
                                        <span class="c-grey"> الجنس :  </span>
                                        <span>'; if ($row['Sex'] == 'man') {echo ' ذكر ';}else {echo ' أنثى ';} echo'</span>
                                    </div>
                                </div>
                                <div class="box p-20 d-flex align-center">
                                    <div class="fs-14">
                                        <span class="c-grey"> النقاط : </span>
                                        <span> 300 نقطة </span>
                                    </div>
                                    <div class="fs-14">
                                        <span class="c-grey"> الحالة : </span>
                                        <span> ';  if ($row['O_RegStatus'] == 0) {echo'<span class="label btn-shape bg-red c-white"> خامل </span>';}else {echo'<span class="label btn-shape bg-green c-white"> فعال </span>';} echo' </span>
                                    </div>
                                    <div class="fs-14">
                                        <span class="c-grey"> إختباراته : </span>
                                        <span> <a href="" class="btn-shape c-white bg-blue"> عرض </a> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
                echo 'success';
            }else {
                echo 'There is no that id';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'statusmember') {
            $teacherid = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $studentid = filter_var($_POST['studentid'], FILTER_SANITIZE_NUMBER_INT);

            echo 'success';

            $check_userid = checkItem('O_UserID', 'orders', $userid);
            if ($check_userid > 0) {
                
            }else {
                echo 'There is no that id';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'loadmoreinfo') {
            $offset = filter_var($_POST['offset'], FILTER_SANITIZE_NUMBER_INT);
            $teacherid = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            // $dosersh = filter_var($_POST['dosersh'], FILTER_SANITIZE_STRING);
            $where = $_POST['where'];
            $new_offset = $LIMIT * $offset;
            // if ($dosersh == 'false') {
            //     $where = " AND O_RegStatus = 0 ";
            // }
            $stmt = $con->prepare("SELECT * FROM orders JOIN userss ON orders.O_StudentID = userss.UserID WHERE O_TeacherID = $teacherid $where ORDER BY `orders`.`O_UserID` ASC LIMIT $LIMIT OFFSET $new_offset");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if ($stmt->rowCount() > 0) {
                echo 'success';
                foreach ($rows as $row) {
                    echo '<tr class="p-relative">';
                    echo '<td class="nowrap"></td>';
                    echo '<td class="nowrap">'.$row['FName'].'</td>';
                    echo '<td class="nowrap">'.$row['SName'].'</td>';
                    echo '<td class="nowrap">'.$row['Email'].'</td>';
                    echo '<td class="nowrap">'; if ($row['O_RegStatus'] == 0) {echo'<span class="label btn-shape bg-red c-white status"> خامل </span>';}else {echo'<span class="label btn-shape bg-green c-white status"> فعال </span>';} echo '</td>';
                    echo '<td class="nowrap">'.$row['O_Date'].'</td>';
                    echo '<td>'; 
                      echo '<div>'; 
                      if ($row['O_RegStatus'] == 0) {
                        echo '<button class="btn-shape c-white bg-green m-5 inable-member" data-id="'.$row['UserID'].'">تفعيل</button>';
                      }
                      if ($row['O_RegStatus'] == 1) {
                        echo '<button class="btn-shape c-white bg-red m-5 inable-member" data-id="'.$row['UserID'].'">تعطيل</button>'; 
                      }
                        echo '<button class="btn-shape c-white bg-blue m-5 view-member" data-id="'.$row['UserID'].'">عرض</button>';  
                      echo '</div>'; 
                    echo '</td>';
                  echo '</tr>';
                }
                echo '
                <tr class="load-more-skeleton">
                    <td class="nowrap"></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                </tr> ';
            }else {
                echo 'That is all information';
            }
        }

    }