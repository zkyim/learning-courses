<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';

        if (isset($_POST['action']) && $_POST['action'] == 'addNewCourse') {
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $img_course_name = $_FILES['imgcourse']['name'];
            $img_course_tmp_name = $_FILES['imgcourse']['tmp_name'];
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $describtion = filter_var($_POST['describtion'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $type_course = filter_var($_POST['typecourse'], FILTER_SANITIZE_STRING);
            $start = filter_var($_POST['start'], FILTER_SANITIZE_STRING);
            $end = filter_var($_POST['end'], FILTER_SANITIZE_STRING);

    
            if (empty($teacher_id) || empty($img_course_name) || empty($title) || empty($name) || empty($describtion) || empty($type_course) || empty($start) || empty($end) || $price == '') {
                echo 'empty';
            }else {
                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($img_course_name, PATHINFO_EXTENSION);
                if (!empty($img_course_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {

                    $img_up_name = rand(0, 10000).'_'.time().'_'.$img_course_name;
                    move_uploaded_file($img_course_tmp_name, $upload.'imags/imgcourses/'.$img_up_name);
    
                    $stmt = $con->prepare("INSERT INTO courses (TeacherID, Avatar, Name, Title, Describtion, Price, TypeCourse, Start, End, Status, Date)
                                                        VALUES(:TeacherID, :Avatar, :Name, :Title, :Describtion, :Price, :TypeCourse, :Start, :End, :Status, now())");
                    
                    $stmt->execute(array(
                        ':TeacherID'    => $teacher_id, 
                        ':Avatar'       => $img_up_name,
                        ':Name'         => $name, 
                        ':Title'        => $title, 
                        ':Describtion'  => $describtion, 
                        ':Price'        => $price,
                        ':TypeCourse'   => $type_course, 
                        ':Start'        => $start, 
                        ':End'          => $end, 
                        ':Status'       => 0));
                        
                    $stmt = $con->prepare("SELECT UserID FROM `courses` ORDER BY UserID DESC LIMIT 1");
                    $stmt->execute();
                    $row = $stmt->fetch();
                        
                    $stmt = $con->prepare("SELECT category FROM `category` WHERE C_UserID = $type_course");
                    $stmt->execute();
                    $typecourse = $stmt->fetch();


                    echo 'success';
                    echo '<td></td>';
                    echo '<td>'.$name.'</td>';
                    echo '<td>'.$typecourse['category'].'</td>';
                    echo '<td>'.$title.'</td>';
                    echo '<td>'.$price.'</td>';
                    $date = date('Y-m-d');
                    echo '<td>'; if ($date < $start) { echo ' <span class="btn-shape bg-red c-white nowrap"> لم تبدأ </span> '; }elseif ($date >= $start && $date <= $end) {echo ' <span class="btn-shape bg-blue c-white nowrap"> مستمرة </span> ';}elseif($date > $end) {echo '<span class="btn-shape bg-green c-white nowrap"> انتهت </span>';} echo'</td>';
                    echo '<td class="nowrap">'.$start.'</td>';
                    echo '<td class="nowrap">'.$end.'</td>';
                    echo '<td class="nowrap">'.date('Y-m-d').'</td>';
                    echo '<td class="nowrap p-relative"> 
                    <div>
                        <button class="nowrap btn-shape bg-green m-5 c-white edite-course" data-ID="'.$row['UserID'].'"> تعديل </button> 
                        <button class="nowrap btn-shape bg-blue m-5 c-white view-course" data-ID="'.$row['UserID'].'"> عرض </button>
                        <button class="nowrap btn-shape bg-blue m-5 c-white inable-course" data-ID="'.$row['UserID'].'"> إظهار </button>
                        <button class="nowrap btn-shape bg-red m-5 c-white delete-course" data-ID="'.$row['UserID'].'"> حذف </button>
                    </div>
                    </td>';
                }
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'search') {
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $typecourse = filter_var($_POST['typecourse'], FILTER_SANITIZE_STRING);
            $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
            $data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);
            $From_To = $_POST['From_To'];

            $typecourse_search = '';
            if ($typecourse !== 'all') {
                $typecourse_search = " AND TypeCourse = $typecourse ";
            }
            $status_search = '';
            if ($status !== 'all') {
                $date = date('Y-m-d');
                if ($status == 'NotStart') {
                    $status_search = " AND Start > '$date' ";
                }elseif ($status == 'Start') {
                    $status_search = " AND End >= '$date' AND Start <= '$date' ";
                }elseif ($status == 'Finsh') {
                    $status_search = " AND End < '$date' ";
                }
            }
            $data_search = '';
            if (!empty($data)) {
                $data_search = " AND CONCAT(Name, Title) LIKE '%$data%' ";
            }
            $stmt = $con->prepare("SELECT * FROM courses JOIN category ON courses.TypeCourse = category.C_UserID WHERE TeacherID = $teacher_id $typecourse_search $status_search $data_search $From_To LIMIT $LIMIT");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if ($stmt->rowCount() > 0) {
                echo 'success';
                foreach ($rows as $row) {
                    echo '<tr class="p-relative">';
                      echo '<td></td>';
                      echo '<td>'.$row['Name'].'</td>';
                      echo '<td>'.$row['category'].'</td>';
                      echo '<td>'.$row['Title'].'</td>';
                      echo '<td>'.$row['Price'].'</td>';
                      $date = date('Y-m-d');
                      echo '<td>'; if ($date < $row['Start']) { echo ' <span class="btn-shape bg-red c-white nowrap"> لم تبدأ </span> '; }elseif ($date >= $row['Start'] && $date <= $row['End']) {echo ' <span class="btn-shape bg-blue c-white nowrap"> مستمرة </span> ';}elseif($date > $row['End']) {echo '<span class="btn-shape bg-green c-white nowrap"> انتهت </span>';} echo'</td>';
                      echo '<td class="nowrap">'.$row['Start'].'</td>';
                      echo '<td class="nowrap">'.$row['End'].'</td>';
                      echo '<td class="nowrap">'.$row['Date'].'</td>';
                      echo '<td class="nowrap p-relative"> 
                      <div>
                        <button class="nowrap btn-shape bg-green m-5 c-white edite-course" data-ID="'.$row['UserID'].'"> تعديل </button> 
                        <button class="nowrap btn-shape bg-blue m-5 c-white view-course" data-ID="'.$row['UserID'].'"> عرض </button>
                        <button class="nowrap btn-shape bg-blue m-5 c-white inable-course" data-ID="'.$row['UserID'].'"> إظهار </button>
                        <button class="nowrap btn-shape bg-red m-5 c-white delete-course" data-ID="'.$row['UserID'].'"> حذف </button>
                      </div>  
                    </td>';
                    echo '</tr>';
                }
                if (getCount("courses", "WHERE TeacherID = $teacher_id $typecourse_search $status_search $data_search $From_To") > $LIMIT) {
                    echo '
                    <tr class="load-more-skeleton">
                        <td class="nowrap"></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                    </tr>
                    ';
                }

                echo '||'.$status_search.$typecourse_search.$data_search.$From_To;
            }else {
                echo 'There is no data';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'getdata') {
            $User_ID = filter_var($_POST['User_ID'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("SELECT * FROM courses WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($User_ID));
            $row = $stmt->fetch();
            
            if ($stmt->rowCount() > 0) {
                echo 'success';
                echo '{"UserID" : "'.$row['UserID'].'",
                    "Name" : "'. $row['Name']. '",
                    "Title" : "'. $row['Title'].'",
                    "Describtion" : "'.$row['Describtion'].'",
                    "Avatar" : "'.$row['Avatar'].'",
                    "TypeCourse" : "'.$row['TypeCourse'].'",
                    "Price" : "'. $row['Price'].'",
                    "Start" : "'.$row['Start'].'",
                    "End" : "'.$row['End'].'"}';
            }else {
                echo 'There is no that id';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $img_course_name = $_FILES['imgcourse']['name'];
            $img_course_tmp_name = $_FILES['imgcourse']['tmp_name'];
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $describtion = filter_var($_POST['describtion'], FILTER_SANITIZE_STRING);
            $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $type_course = filter_var($_POST['typecourse'], FILTER_SANITIZE_STRING);
            $start = filter_var($_POST['start'], FILTER_SANITIZE_STRING);
            $end = filter_var($_POST['end'], FILTER_SANITIZE_STRING);


            if (empty($teacher_id) || empty($title) || empty($name) || empty($describtion) || empty($type_course) || empty($start) || empty($end) || $price == '') {
                echo 'empty';
            }else {
                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($img_course_name, PATHINFO_EXTENSION);
                if (!empty($img_course_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {
    
                    $stmt = $con->prepare("SELECT Avatar, Date FROM courses WHERE UserID = ? LIMIT 1");
                    $stmt->execute(array($user_id));
                    $row = $stmt->fetch();

                    if ($stmt->rowCount() > 0) {
                        $img_up_name = $row['Avatar'];
                        if (!empty($img_course_tmp_name)) {
                            $img_up_name = rand(0, 10000).'_'.time().'_'.$img_course_name;
                            move_uploaded_file($img_course_tmp_name, $upload.'imags/imgcourses/'.$img_up_name);
                            if (file_exists($upload."imags/imgcourses/".$row['Avatar']) !== false) {
                                unlink($upload."imags/imgcourses/".$row['Avatar']);
                            }
                        }
    
                        $stmt = $con->prepare("UPDATE courses SET 
                                                                    TeacherID = ?,
                                                                    Avatar =?,
                                                                    Title = ?, 
                                                                    Name = ?, 
                                                                    Describtion = ?, 
                                                                    Price = ?,
                                                                    TypeCourse = ?, 
                                                                    Start = ?,
                                                                    End = ?
                                                                WHERE UserID = ?");
                        $stmt->execute(array($teacher_id, $img_up_name, $title, $name, $describtion, $price, $type_course, $start, $end, $user_id));
                        echo'success';

                        $stmt = $con->prepare("SELECT category FROM `category` WHERE C_UserID = $type_course");
                        $stmt->execute();
                        $typecourse = $stmt->fetch();
                        echo '<td></td>';
                        echo '<td>'.$name.'</td>';
                        echo '<td>'.$typecourse['category'].'</td>';
                        echo '<td>'.$title.'</td>';
                        echo '<td>'.$price.'</td>';
                        $date = date('Y-m-d');
                        echo '<td>'; if ($date < $start) { echo ' <span class="btn-shape bg-red c-white nowrap"> لم تبدأ </span> '; }elseif ($date >= $start && $date <= $end) {echo ' <span class="btn-shape bg-blue c-white nowrap"> مستمرة </span> ';}elseif($date > $end) {echo '<span class="btn-shape bg-green c-white nowrap"> انتهت </span>';} echo'</td>';
                        echo '<td class="nowrap">'.$start.'</td>';
                        echo '<td class="nowrap">'.$end.'</td>';
                        echo '<td class="nowrap">'.$row['Date'].'</td>';
                        echo '<td class="nowrap p-relative"> 
                        <div>
                            <button class="nowrap btn-shape bg-green m-5 c-white edite-course" data-ID="'.$user_id.'"> تعديل </button>
                            <button class="nowrap btn-shape bg-blue m-5 c-white view-course" data-ID="'.$user_id.'"> عرض </button>
                            <button class="nowrap btn-shape bg-blue m-5 c-white inable-course" data-ID="'.$user_id.'"> إظهار </button>
                            <button class="nowrap btn-shape bg-red m-5 c-white delete-course" data-ID="'.$user_id.'"> حذف </button>
                        </div>
                        </td>';
                    }else {
                        echo 'There is no that id';
                    }
                    
                }
            }

        
        }elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
            $teacherid = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_var($_POST['ID'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("SELECT * FROM courses WHERE UserID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($userid, $teacherid));
            $row = $stmt->fetch();

            if ($stmt->rowCount() > 0) {

                $stmt = $con->prepare("SELECT Avatar FROM courses WHERE UserID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($userid, $teacherid));
                $row = $stmt->fetch();
                if (file_exists("imags/imgcourses/".$row['Avatar'])) {
                    unlink($upload."imags/imgcourses/".$row['Avatar']);
                }

                $stmt = $con->prepare("DELETE FROM courses WHERE UserID = :userid");
                $stmt->bindparam(":userid", $userid);
                $stmt->execute();

                echo 'success';
            }else {
                echo 'There is no that id';
            }

        }elseif (isset($_POST['action']) && $_POST['action'] == 'viewMoreDetailsBut') {
            $teacherid = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("SELECT * FROM courses JOIN category ON courses.TypeCourse = category.C_UserID WHERE UserID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($userid, $teacherid));
            $row = $stmt->fetch();

            if ($stmt->rowCount() > 0) {

                echo 
                '
                <div class="cont-moredetails">
                    <h3 class="m-10">هذا ما يراه المستخدمون</h3>
                    <div class="course txt-c bg-white rad-6 p-relative">
                    <img class="cover" src="'.$upload.'imags/imgcourses/'.$row['Avatar'].'" alt="" />
                    <?php
                    <img src="imags/Avatar" alt="" class="instructor">
                    <div class="p-20">
                    <h4 class="m-0 c-black"> '.$row['Title'].' </h4>
                    <p class="description c-grey mt-15 fs-14"> '.$row['Describtion'].' </p>
                    </div>
                    <div class="info p-15 p-relative between-flex">
                        <span class="c-grey">
                            '.$row['Price'].'
                            <i class="fa-solid fa-dollar-sign"></i>
                        </span>
                        <span class="c-grey">
                        <i class="fa-regular fa-user"></i>
                        عدد المشتركين
                        </span>
                    </div>
                    </div>
                    <div class="more-details mt-20">
                        <h3 class="m-0 mb-10">المزيد من المعلومات</h3>
                        <div class="c-grey">الاسم :  <span class="c-black"> '.$row['Name'].' </span> </div>
                        <div class="c-grey">نوع الدورة :  <span class="c-black"> '.$row['category'].' </span> </div>
                        <div class="c-grey">بداية الدورة :  <span class="c-black"> '.$row['Start'].' </span> </div>
                        <div class="c-grey">نهاية الدورة :  <span class="c-black"> '.$row['End'].' </span> </div>
                        <div class="c-grey">تاريخ إنشاء الدورة :  <span class="c-black"> '.$row['Date'].' </span> </div>
                        <div class="c-grey"> المكسب  :  <span class="c-black"> 100$ </span> </div>
                    </div>
                </div>
                ';
                
                echo 'success';
            }else {
                echo 'There is no that id';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'Status') {

            $teacherid = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $userid = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $check_userid = checkItem('UserID', 'courses', $userid);
            if ($check_userid > 0) {
                $stmt = $con->prepare("SELECT Status FROM courses WHERE UserID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($userid, $teacherid));
                $row = $stmt->fetch();
                
                if ($row['Status'] == 1) {
                    $status = 0;
                }else {
                    $status = 1;
                }

                $stmt = $con->prepare("UPDATE courses SET Status = $status WHERE UserID = ? AND TeacherID =?");
                $stmt->execute(array($userid, $teacherid));
                echo 'success';
            }else {
                echo 'There is no that id';
            }
        }elseif (isset($_POST['action']) && $_POST['action'] == 'loadmoreinfo') {
            $offset = filter_var($_POST['offset'], FILTER_SANITIZE_NUMBER_INT);
            $teacherid = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $where = $_POST['where'];
            $new_offset = $LIMIT * $offset;
            $stmt = $con->prepare("SELECT * FROM courses JOIN category ON courses.TypeCourse = category.C_UserID WHERE TeacherID = $teacherid $where ORDER BY `courses`.`UserID` ASC LIMIT $LIMIT OFFSET $new_offset");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if ($stmt->rowCount() > 0) {
                echo 'success';
                foreach ($rows as $row) {
                    echo '<tr class="p-relative">';
                      echo '<td></td>';
                      echo '<td>'.$row['Name'].'</td>';
                      echo '<td>'.$row['category'].'</td>';
                      echo '<td>'.$row['Title'].'</td>';
                      echo '<td>'.$row['Price'].'</td>';
                      $date = date('Y-m-d');
                      echo '<td>'; if ($date < $row['Start']) { echo ' <span class="btn-shape bg-red c-white nowrap"> لم تبدأ </span> '; }elseif ($date >= $row['Start'] && $date <= $row['End']) {echo ' <span class="btn-shape bg-blue c-white nowrap"> مستمرة </span> ';}elseif($date > $row['End']) {echo '<span class="btn-shape bg-green c-white nowrap"> انتهت </span>';} echo'</td>';
                      echo '<td class="nowrap">'.$row['Start'].'</td>';
                      echo '<td class="nowrap">'.$row['End'].'</td>';
                      echo '<td class="nowrap">'.$row['Date'].'</td>';
                      echo '<td class="nowrap p-relative"> 
                      <div>
                        <button class="nowrap btn-shape bg-green m-5 c-white edite-course" data-ID="'.$row['UserID'].'"> تعديل </button> 
                        <button class="nowrap btn-shape bg-blue m-5 c-white view-course" data-ID="'.$row['UserID'].'"> عرض </button>
                        <button class="nowrap btn-shape bg-blue m-5 c-white inable-course" data-ID="'.$row['UserID'].'"> إظهار </button>
                        <button class="nowrap btn-shape bg-red m-5 c-white delete-course" data-ID="'.$row['UserID'].'"> حذف </button>
                      </div>  
                    </td>';
                    echo '</tr>';
                }
                    echo 
                    '
                    <tr class="load-more-skeleton">
                        <td class="nowrap"></td>
                        <td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
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