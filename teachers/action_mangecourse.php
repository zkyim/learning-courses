<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        date_default_timezone_set('Asia/Riyadh');
        include 'init_ajax.php';

        if (isset($_POST['action']) && $_POST['action'] == 'nameCourses') {
            $typecourse = filter_var($_POST['typecourse'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("SELECT * FROM courses WHERE TypeCourse = ? AND TeacherID = ?");
            $stmt->execute(array($typecourse ,$teacher_id));
            $rows = $stmt->fetchAll();
            if (isset($rows[0]) && !empty($rows[0])) {
                foreach ($rows as $row) {
                    echo '<div class="container-lable p-relative">';
                        echo '<input type="radio" id="'.$row['Name'].'" name="coursename" value="'.$row['UserID'].'" data-userid="" onclick="courseNameClick (this)">';
                        echo '<label for="'.$row['Name'].'"> <span> '.$row['Name'].' </span> </label>';
                        echo '<a href="courses.php">';
                            echo '<span class="dots">';
                                echo '<i class="fa-solid fa-ellipsis-vertical p-5"></i>';
                                echo '<div class="container-menu">';
                                    echo '<div class="edit"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div>';
                                    echo '<div class="delete"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div>';
                                echo '</div>';
                            echo '</span> ';
                        echo '</a>';
                    echo '</div>';
                }
                echo ' || success';
            }else {
                echo 'there is no data to display';
            }


        }else if (isset($_POST['action']) && $_POST['action'] == 'courselevels') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("SELECT * FROM courselevels WHERE CetegoryID = ? AND CourseID = ? AND TeacherID = ?");
            $stmt->execute(array($cetegory_id ,$course_id, $teacher_id));
            $rows = $stmt->fetchAll();
            if (isset($rows[0]) && !empty($rows[0])) {
                foreach ($rows as $row) {
                    echo '<div class="container-lable p-relative">';
                        echo '<input type="radio" id="'.$row['Name'].'" name="courselevele" value="'.$row['UserID'].'" data-userid="" onclick="courseLeveleClick (this)">';
                        echo '<label for="'.$row['Name'].'"> <span> '.$row['Name'].' </span> </label>';
                        echo '<span class="dots">';
                            echo '<i class="fa-solid fa-ellipsis-vertical p-5" onclick="openmenulevel (this)"></i>';
                            echo '<div class="container-menu">';
                                echo '<div class="edit" data-userid="'.$row['UserID'].'" onclick="updatelevel (this)"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div>';
                                echo '<div class="delete" data-userid="'.$row['UserID'].'" onclick="deletelevel (this)"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div>';
                            echo '</div>';
                        echo '</span> ';
                    echo '</div>';
                }
                echo ' || success';
            }else {
                echo 'there is no data to display';
            }


        }else if (isset($_POST['action']) && $_POST['action'] == 'addCourseLevel') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $img_level_name = $_FILES['imglevel']['name'];
            $img_level_tmp_name = $_FILES['imglevel']['tmp_name'];

            if (empty($name) || empty($cetegory_id) || empty($course_id) || empty($teacher_id) || empty($img_level_name)) {
                echo 'empty';
            }else {

                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($img_level_name, PATHINFO_EXTENSION);
                if (!empty($img_level_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {

                    $img_up_name = rand(0, 10000).'_'.time().'_'.$img_level_name;
                    move_uploaded_file($img_level_tmp_name, $upload.'imags/imgcourses/'.$img_up_name);

                    $stmt = $con->prepare("INSERT INTO courselevels (CetegoryID, CourseID, TeacherID, Name, ImgLevel, Date)
                                            VALUES(:CetegoryID, :CourseID, :TeacherID, :Name, :ImgLevel, now())"
                    );
                    $stmt->execute(array(
                                    ':CetegoryID'  => $cetegory_id,
                                    ':CourseID'    => $course_id,
                                    ':TeacherID'   => $teacher_id,
                                    ':Name'        => $name,
                                    ':ImgLevel'    => $img_up_name
                    ));

                    $stmt = $con->prepare("SELECT * FROM courselevels WHERE CetegoryID = ? AND CourseID = ? AND TeacherID = ?");
                    $stmt->execute(array($cetegory_id ,$course_id, $teacher_id));
                    $rows = $stmt->fetchAll();
                    if (isset($rows[0]) && !empty($rows[0])) {
                        foreach ($rows as $row) {
                            echo '<div class="container-lable p-relative">';
                                echo '<input type="radio" id="'.$row['Name'].'" name="courselevele" value="'.$row['UserID'].'" data-userid="" onclick="courseLeveleClick (this)">';
                                echo '<label for="'.$row['Name'].'"> <span> '.$row['Name'].' </span> </label>';
                                echo '<span class="dots">';
                                    echo '<i class="fa-solid fa-ellipsis-vertical p-5" onclick="openmenulevel (this)"></i>';
                                    echo '<div class="container-menu">';
                                        echo '<div class="edit" data-userid="'.$row['UserID'].'" onclick="updatelevel (this)"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div>';
                                        echo '<div class="delete" data-userid="'.$row['UserID'].'" onclick="deletelevel (this)"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div>';
                                    echo '</div>';
                                echo '</span> ';
                            echo '</div>';
                        }
                        echo ' || success';
                    }else {
                        echo 'there is no data to display';
                    }
                    
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'getdatacourseLevel') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            if (empty($cetegory_id) || empty($course_id) || empty($teacher_id) || empty($user_id)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM courselevels WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '<form action="#">
                        <input type="hidden" name="action" value="editCourseLevel">
                        <input type="hidden" name="userid" value="'.$user_id.'">
                        <input type="hidden" name="cetegoryID" value="'.$cetegory_id.'">
                        <input type="hidden" name="courseID" value="'.$course_id.'">
                        <input type="hidden" name="teacherid" value="'.$teacher_id.'">
                        <div class="course">
                            <div class="img-course" style="border: none;">
                                <label for="imglevel" class="p-relative uploaded"> 
                                <span>صورة المستوى</span>
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <input type="file" id="imglevel" name="imglevel" onchange="uploadimg(this)">
                                </label>
                                <img src="'.$upload.'imags/imgcourses/'.$row['ImgLevel'].'">
                            </div>
                        </div>
                        <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20" type="text" name="name" placeholder="اسم المستوى" value="'.$row['Name'].'" />
                        <div class="buttons-popup p-15 pt-0">
                            <button class="action-course btn-shape bg-blue c-white d-block w-full">تعديل</button>
                        </div>
                    </form>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'editCourseLevel') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $img_level_name = $_FILES['imglevel']['name'];
            $img_level_tmp_name = $_FILES['imglevel']['tmp_name'];


            if (empty($name) || empty($cetegory_id) || empty($course_id) || empty($teacher_id) || empty($user_id)) {
                echo 'empty';
            }else {

                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($img_level_name, PATHINFO_EXTENSION);
                if (!empty($img_level_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {

                    $stmt = $con->prepare("SELECT ImgLevel FROM courselevels WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND TeacherID = ? LIMIT 1");
                    $stmt->execute(array($user_id,$cetegory_id, $course_id, $teacher_id));
                    $row = $stmt->fetch();

                    if ($stmt->rowCount() == 0) {
                        echo 'There is no that id';
                    }else {
                        $img_up_name = $row['ImgLevel'];
                        if (!empty($img_level_tmp_name)) {
                            $img_up_name = rand(0, 10000).'_'.time().'_'.$img_level_name;
                            move_uploaded_file($img_level_tmp_name, $upload.'imags/imgcourses/'.$img_up_name);
                            if (file_exists($upload."imags/imgcourses/".$row['ImgLevel']) !== false) {
                                unlink($upload."imags/imgcourses/".$row['ImgLevel']);
                            }
                        }

                        $stmt = $con->prepare("UPDATE courselevels SET
                                                                        Name = ?,
                                                                        ImgLevel = ?
                                                                    WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND TeacherID = ? ");
                        $stmt->execute(array($name, $img_up_name, $user_id,$cetegory_id, $course_id, $teacher_id));

                        echo $name;
                        echo ' || success';

                    }
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deleteLevel') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt =  $con->prepare("SELECT ImgLevel FROM courselevels WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($user_id, $cetegory_id, $course_id, $teacher_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                if (file_exists($upload."imags/imgcourses/".$row['ImgLevel'])) {
                    unlink($upload."imags/imgcourses/".$row['ImgLevel']);
                }
                $stmt = $con->prepare("DELETE FROM courselevels WHERE UserID = :userid");
                $stmt->bindparam(":userid", $user_id);
                $stmt->execute();
                echo 'success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'subjects') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_ID = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt = $con->prepare("SELECT * FROM subjects WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND TeacherID = ?");
            $stmt->execute(array($cetegory_id ,$course_id, $level_ID, $teacher_id));
            $rows = $stmt->fetchAll();
            if (isset($rows[0]) && !empty($rows[0])) {
                foreach ($rows as $row) {
                    echo '<div class="container-lable p-relative">';
                        echo '<input type="radio" id="'.$row['Name'].'" name="subject" value="'.$row['UserID'].'" data-userid="" onclick="subjectClick (this)">';
                        echo '<label for="'.$row['Name'].'"> <span> '.$row['Name'].' </span> </label>';
                        echo '<span class="dots">';
                            echo '<i class="fa-solid fa-ellipsis-vertical p-5" onclick="openmenulevel (this)"></i>';
                            echo '<div class="container-menu">';
                                echo '<div class="edit" data-userid="'.$row['UserID'].'" onclick="updateSubject (this)"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div>';
                                echo '<div class="delete" data-userid="'.$row['UserID'].'" onclick="deleteSubject (this)"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div>';
                            echo '</div>';
                        echo '</span> ';
                    echo '</div>';
                }
                echo ' || success';
            }else {
                echo 'there is no data to display';
            }

        }else if (isset($_POST['action']) && $_POST['action'] == 'addsubject') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $img_subject_name = $_FILES['imglevel']['name'];
            $img_subject_tmp_name = $_FILES['imglevel']['tmp_name'];

            if (empty($name) || empty($cetegory_id) || empty($course_id) || empty($teacher_id) || empty($level_id) || empty($img_subject_name)) {
                echo 'empty';
            }else {

                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($img_subject_name, PATHINFO_EXTENSION);
                if (!empty($img_subject_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {

                    $img_up_name = rand(0, 10000).'_'.time().'_'.$img_subject_name;
                    move_uploaded_file($img_subject_tmp_name, $upload.'imags/imgcourses/'.$img_up_name);

                    $stmt = $con->prepare("INSERT INTO subjects (CetegoryID, CourseID, LevelID, TeacherID, Name, ImgSubject, Date)
                                            VALUES(:CetegoryID, :CourseID, :LevelID, :TeacherID, :Name, :ImgSubject, now())"
                    );
                    $stmt->execute(array(
                                    ':CetegoryID'  => $cetegory_id,
                                    ':CourseID'    => $course_id,
                                    ':LevelID'   => $level_id,
                                    ':TeacherID'   => $teacher_id,
                                    ':Name'        => $name,
                                    ':ImgSubject'    => $img_up_name
                    ));

                    $stmt = $con->prepare("SELECT * FROM subjects WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND TeacherID = ?");
                    $stmt->execute(array($cetegory_id ,$course_id, $level_id, $teacher_id));
                    $rows = $stmt->fetchAll();
                    if (isset($rows[0]) && !empty($rows[0])) {
                        foreach ($rows as $row) {
                            echo '<div class="container-lable p-relative">';
                                echo '<input type="radio" id="'.$row['Name'].'" name="subject" value="'.$row['UserID'].'" data-userid="" onclick="subjectClick (this)">';
                                echo '<label for="'.$row['Name'].'"> <span> '.$row['Name'].' </span> </label>';
                                echo '<span class="dots">';
                                    echo '<i class="fa-solid fa-ellipsis-vertical p-5" onclick="openmenulevel (this)"></i>';
                                    echo '<div class="container-menu">';
                                        echo '<div class="edit" data-userid="'.$row['UserID'].'" onclick="updateSubject (this)"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div>';
                                        echo '<div class="delete" data-userid="'.$row['UserID'].'" onclick="deleteSubject (this)"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div>';
                                    echo '</div>';
                                echo '</span> ';
                            echo '</div>';
                        }
                        echo ' || success';
                    }else {
                        echo 'there is no data to display';
                    }
                    
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'getdatasubject') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($teacher_id) || empty($user_id)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM subjects WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $level_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '<form action="#">
                        <input type="hidden" name="action" value="editsubject">
                        <input type="hidden" name="userid" value="'.$user_id.'">
                        <input type="hidden" name="cetegoryID" value="'.$cetegory_id.'">
                        <input type="hidden" name="courseID" value="'.$course_id.'">
                        <input type="hidden" name="levelID" value="'.$level_id.'">
                        <input type="hidden" name="teacherid" value="'.$teacher_id.'">
                        <div class="course">
                            <div class="img-course" style="border: none;">
                                <label for="imgsubject" class="p-relative uploaded"> 
                                <span>صورة المستوى</span>
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <input type="file" id="imgsubject" name="imgsubject" onchange="uploadimg(this)">
                                </label>
                                <img src="'.$upload.'imags/imgcourses/'.$row['ImgSubject'].'">
                            </div>
                        </div>
                        <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20" type="text" name="name" placeholder="اسم المستوى" value="'.$row['Name'].'" />
                        <div class="buttons-popup p-15 pt-0">
                            <button class="action-course btn-shape bg-blue c-white d-block w-full">تعديل</button>
                        </div>
                    </form>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'editsubject') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $img_subject_name = $_FILES['imgsubject']['name'];
            $img_subject_tmp_name = $_FILES['imgsubject']['tmp_name'];

            if (empty($name) || empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($teacher_id) || empty($user_id)) {
                echo 'empty';
            }else {

                $fileAllowedExte = array('jpg', 'jpeg', 'png', 'gif');
                $img_E = pathinfo($img_subject_name, PATHINFO_EXTENSION);
                if (!empty($img_subject_name)  && !in_array($img_E, $fileAllowedExte)) {
                    echo 'This is not a valid image file';
                }else {

                    $stmt = $con->prepare("SELECT ImgSubject FROM subjects WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND TeacherID = ? LIMIT 1");
                    $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id ,$teacher_id));
                    $row = $stmt->fetch();

                    if ($stmt->rowCount() == 0) {
                        echo 'There is no that id';
                    }else {
                        $img_up_name = $row['ImgSubject'];
                        if (!empty($img_subject_tmp_name)) {
                            $img_up_name = rand(0, 10000).'_'.time().'_'.$img_subject_name;
                            move_uploaded_file($img_subject_tmp_name, $upload.'imags/imgcourses/'.$img_up_name);
                            if (file_exists($upload."imags/imgcourses/".$row['ImgSubject']) !== false) {
                                unlink($upload."imags/imgcourses/".$row['ImgSubject']);
                            }
                        }

                        $stmt = $con->prepare("UPDATE subjects SET
                                                                        Name = ?,
                                                                        ImgSubject = ?
                                                                    WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND TeacherID = ?");
                        $stmt->execute(array($name, $img_up_name, $user_id, $cetegory_id, $course_id, $level_id,$teacher_id));
                        echo $name;
                        echo ' || success';

                    }
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deletesubject') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt =  $con->prepare("SELECT ImgSubject FROM subjects WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $teacher_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                if (file_exists($upload."imags/imgcourses/".$row['ImgSubject'])) {
                    unlink($upload."imags/imgcourses/".$row['ImgSubject']);
                }
                $stmt = $con->prepare("DELETE FROM subjects WHERE UserID = :userid");
                $stmt->bindparam(":userid", $user_id);
                $stmt->execute();
                echo 'success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'search') {
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);
            if ($class === 'lessons' || $class === 'files' || $class === 'schedule' || $class === 'tests') {
                $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
                $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
                $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
                $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
                $teacher_id = filter_var($_POST['teacherID'], FILTER_SANITIZE_NUMBER_INT);
                $data = filter_var($_POST['data'], FILTER_SANITIZE_STRING);

                if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($class)) {
                    echo 'empty';
                }else {
                    $data_search = '';
                    if (!empty($data)) {
                        $data_search = " AND CONCAT(Title) LIKE '%$data%' ";
                    }
                    $stmt = $con->prepare("SELECT * FROM $class WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND LevelID = $level_id AND SubjectID = $subject_id AND TeacherID = $teacher_id $data_search LIMIT $LIMIT");
                    $stmt->execute();
                    $rows = $stmt->fetchAll();
                    if ($class === 'lessons' || $class === 'files') {
                        if ($stmt->rowCount() == 0) {
                            echo '|| there is no data to display';
                        }else {
                            echo '<table class="fs-15 w-full">';
                                echo '<thead>';
                                echo '<tr class="p-relative">';
                                    echo '<td>العدد</td>';
                                    if ($class == 'lessons') {
                                        echo '<td>النوع</td>';
                                    }
                                    echo '<td>العنوان</td>';
                                    echo '<td>التاريخ</td>';
                                    echo '<td>لوحة التحكم</td>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody class="body-search">';
                                    foreach ($rows as $row) {
                                        echo '<tr class="p-relative">';
                                            echo '<td></td>';
                                            if ($class == 'lessons') {
                                                echo '<td>';
                                                if ($class == 'lessons' && $row['TypeLesson']=='video') {echo'فيديو';} else {echo'رابط';}
                                                echo '</td>';
                                            }
                                            echo '<td>'.$row['Title'].'</td>';
                                            echo '<td>'.$row['Date'].'</td>';
                                            echo '<td> 
                                                    <div>
                                                        <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editFiles(this)"> تعديل </button>
                                                        <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweFiles(this)"> معلومات أكثر  </button>
                                                        <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteFiles(this)"> حذف </button>
                                                    </div>
                                                </td>';
                                        echo '</tr>';
                                    }
                                    if (getCount("$class", " WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND LevelID = $level_id AND SubjectID = $subject_id AND TeacherID = $teacher_id $data_search") > $LIMIT) {
                                        echo '<tr class="load-more-skeleton">';
                                            echo '<td class="nowrap"></td>';
                                            echo '<td><p></p></td>';
                                            if ($class==='lessons') {echo '<td><p></p></td>';}
                                            echo '<td><p></p></td>';
                                            echo '<td><p></p></td>';
                                        echo '</tr>';
                                    }
                                echo '</tbody>';
                            echo '</table>';
                            echo '|| success';
                        }
                    }else if ($class === 'tests') {
                        if ($stmt->rowCount() == 0) {
                            echo '|| there is no data to display';
                        }else {
                            echo '<div class="sec-ques">';
                                echo '<div class=" d-flex align-center mb-15"> <span class="">أقسام الأسئلة</span> : ';
                                    echo '<ul class="">';
                                        $stmt = $con->prepare("SELECT * FROM section_question WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?");
                                        $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                                        $rowssec = $stmt->fetchAll();
                                        foreach ($rowssec as $row) {
                                            echo '<li class=""> <span> '.$row['Title'].'</span><span class="dots"><i class="fa-solid fa-ellipsis-vertical p-5" onclick="openmenulevel (this)"></i><div class="container-menu"><div class="edit" data-userid="'.$row['UserID'].'" onclick="updatesecques (this)"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div><div class="delete" data-userid="'.$row['UserID'].'" onclick="deletesecques (this)"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div></div></span></li>';
                                        }
                                    echo '</ul>';
                                    echo '<div class="w-fit"><label onclick="openPopupsecques(this)"><i class="fa-regular fa-square-plus"></i></label></div>';
                                echo '</div>';
                            echo '</div>';
                            echo '<table class="fs-15 w-full">';
                                echo '<thead>';
                                    echo '<tr class="p-relative">';
                                        echo '<td>العدد</td>';
                                        echo '<td>العنوان</td>';
                                        echo '<td>عدد الاسئلة</td>';
                                        echo '<td> المدة </td>';
                                        echo '<td>التاريخ</td>';
                                        echo '<td>لوحة التحكم</td>';
                                    echo '</tr>';
                                echo '</thead>';
                                echo '<tbody class="body-search">';
                                    echo '<tr class="p-relative">';
                                        echo '<tr class="p-relative">';
                                        echo '<td></td>';
                                        echo '<td> بنك الأسئلة </td>';
                                        echo '<td> بنك </td>';
                                        echo '<td> لا يوجد </td>';
                                        echo '<td> 2023 </td>';
                                        echo '<td> 
                                                <div>
                                                    <a href="question_bank.php"><button class="nowrap btn-shape bg-green m-5 c-white"> الإختبار </button></a>
                                                </div>
                                            </td>';
                                    echo '</tr>';
                                    foreach ($rows as $row) {
                                            echo '<td></td>';
                                            echo '<td>'.$row['Title'].'</td>';
                                            echo '<td>'.$row['CountQues'].'</td>';
                                            echo '<td>';
                                            if ($row['Duration'] == 'one') {echo'دقيقة لكل سؤال';}elseif($row['Duration'] == 'tow'){echo'دقيقتين لكل سؤال';}elseif($row['Duration'] == 'infinity'){echo'مفتوح';}
                                            echo'</td>';
                                            echo '<td>'.$row['Date'].'</td>';
                                            echo '<td> 
                                                    <div>
                                                        <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editTest(this)"> تعديل </button>
                                                        <a href="create-test.php?id='.$row['UserID'].'"><button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'"> الإختبار </button></a>
                                                        <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweTest(this)"> معلومات أكثر  </button>
                                                        <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteTest(this)"> حذف </button>
                                                    </div>
                                                </td>';
                                        echo '</tr>';
                                    }
                                    if (getCount("$class", " WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND LevelID = $level_id AND SubjectID = $subject_id AND TeacherID = $teacher_id $data_search") > $LIMIT) {
                                        echo '
                                        <tr class="load-more-skeleton">
                                            <td class="nowrap"></td>
                                            <td><p></p></td>
                                            <td><p></p></td>
                                            <td><p></p></td>
                                            <td><p></p></td>
                                            <td><p></p></td>
                                        </tr>
                                        ';
                                    }
                                echo '</tbody>';
                            echo '</table>';
                            echo '|| success';
                        }
                    }else if ($class === 'schedule') {
                        $stmt = $con->prepare("SELECT Start, End FROM courses WHERE UserID = $course_id AND TeacherID = $teacher_id LIMIT 1");
                        $stmt->execute();
                        $row = $stmt->fetch();
                        echo '<div class="buttons-next-prev">';
                            echo '<span class="prev"><i class="fa-solid fa-chevron-right c-grey"></i></span>';
                            echo '<div class="date-course"> <sapn class="end"> '.$row['End'].' </span> --- <sapn class="start"> '.$row['Start'].' </span>  </div>';
                            echo '<span class="next"><i class="fa-solid fa-chevron-left c-grey"></i></span>';
                        echo '</div>';
                        echo '<table class="fs-15 w-full schedule">';
                            echo '<thead>';
                                echo '<tr class="p-relative">';
                                    echo '<td> النوع </td>';
                                    echo '<td> <div>الأحد <span>  </span></div> </td>';
                                    echo '<td> <div>الإثنين <span>  </span></div> </td>';
                                    echo '<td> <div>الثلاثاء <span>  </span></div> </td>';
                                    echo '<td> <div>الأربعاء <span>  </span></div> </td>';
                                    echo '<td> <div>الخميس <span>  </span></div> </td>';
                                    echo '<td> <div>الجمعة <span>  </span></div> </td>';
                                    echo '<td> <div>السبت <span>  </span></div> </td>';
                                echo '</tr>';
                            echo '</thead>';
                            echo '<tbody class="body-search">';
                                echo '<tr class="p-relative">';
                                    $stmt = $con->prepare("SELECT Name FROM subjects WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND LevelID = $level_id AND UserID = $subject_id AND TeacherID = $teacher_id $data_search LIMIT 1");
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                    $subject = $row['Name'];
                                    $stmt = $con->prepare("SELECT Name FROM courselevels WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND UserID = $level_id AND TeacherID = $teacher_id $data_search LIMIT 1");
                                    $stmt->execute();
                                    $row = $stmt->fetch();
                                    $level = $row['Name'];
                                    echo '<td class="nowrap"> : '.$subject.' من '.$level.' </td>';
                                    echo '<td> <div> <i class="fa-solid fa-ellipsis-vertical"></i> <div>  </div> </div> </td>';
                                    echo '<td> <div>  </div> </td>';
                                    echo '<td> <div>  </div> </td>';
                                    echo '<td> <div>  </div> </td>';
                                    echo '<td> <div>  </div> </td>';
                                    echo '<td> <div>  </div> </td>';
                                    echo '<td> <div>  </div> </td>';
                                echo '</tr>';
                            echo '</tbody>';
                        echo '</table>';
                        echo ' || success';
                    }
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'loadmoreinfo') {
            $offset = filter_var($_POST['offset'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherID'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);
            $new_offset = $LIMIT * $offset;
            if ($class === 'lessons' || $class === 'files') {
                $stmt = $con->prepare("SELECT * FROM $class WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND LevelID = $level_id AND SubjectID = $subject_id AND TeacherID = $teacher_id ORDER BY UserID ASC LIMIT $LIMIT OFFSET $new_offset");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if ($stmt->rowCount() > 0) {
                    echo 'success';
                    foreach ($rows as $row) {
                        echo '<tr class="p-relative">';
                            echo '<td></td>';
                            if ($class == 'lessons') {
                                echo '<td>';
                                if ($class == 'lessons' && $row['TypeLesson']=='video') {echo'فيديو';} else {echo'رابط';}
                                echo '</td>';
                            }
                            echo '<td>'.$row['Title'].'</td>';
                            echo '<td>'.$row['Date'].'</td>';
                            echo '<td> 
                                    <div>
                                        <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editFiles(this)"> تعديل </button>
                                        <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweFiles(this)"> معلومات أكثر  </button>
                                        <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteFiles(this)"> حذف </button>
                                    </div>
                                </td>';
                        echo '</tr>';
                    }
                    echo 
                    '
                    <tr class="load-more-skeleton">
                        <td class="nowrap"></td>';
                        if ($class == 'lessons') {
                            echo '<td><p></p></td>';
                        }
                        echo '<td><p></p></td>
                        <td><p></p></td>
                        <td><p></p></td>
                    </tr> ';
    
                }else {
                    echo 'That is all information';
                }

            }else if ($class == 'tests') {
                $stmt = $con->prepare("SELECT * FROM $class WHERE CetegoryID = $cetegory_id AND CourseID = $course_id AND LevelID = $level_id AND SubjectID = $subject_id AND TeacherID = $teacher_id ORDER BY UserID ASC LIMIT $LIMIT OFFSET $new_offset");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if ($stmt->rowCount() > 0) {
                    echo 'success';
                    foreach ($rows as $row) {
                        echo '<tr class="p-relative">';
                        echo '<td></td>';
                        echo '<td>'.$row['Title'].'</td>';
                        echo '<td>'.$row['CountQues'].'</td>';
                        echo '<td>';
                        if ($row['Duration'] == 'one') {echo'دقيقة لكل سؤال';}elseif($row['Duration'] == 'tow'){echo'دقيقتين لكل سؤال';}elseif($row['Duration'] == 'infinity'){echo'مفتوح';}
                        echo'</td>';
                        echo '<td>'.$row['Date'].'</td>';
                        echo '<td> 
                                <div>
                                    <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editTest(this)"> تعديل </button>
                                    <a href="create-test.php?id='.$row['UserID'].'"><button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'"> الإختبار </button></a>
                                    <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweTest(this)"> معلومات أكثر  </button>
                                    <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteTest(this)"> حذف </button>
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
                    </tr> ';
    
                }else {
                    echo 'That is all information';
                }
            }else {

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'insertfile') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            if ($class === 'lessons' && $_POST['typevideo'] === 'link') {
            }else {
                if (isset($_FILES['file'])) {
                    $file_name = $_FILES['file']['name'];
                    $file_tmp_name = $_FILES['file']['tmp_name'];
                }else {
                    echo 'empty';
                }
            }

            if (empty($title) || empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($class) || empty($teacher_id)) {
                echo 'empty';
            }else {
                if ($class === 'lessons' && isset($_POST['typevideo']) && $_POST['typevideo'] == 'link') {
                    $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
                    if (empty($url)) {
                        echo 'empty';
                    }else {
                        $stmt = $con->prepare("INSERT INTO $class (CetegoryID, CourseID, LevelID, SubjectID, TeacherID, Title, TypeLesson, Url, Date)
                        VALUES(:CetegoryID, :CourseID, :LevelID, :SubjectID, :TeacherID, :Title,:TypeLesson, :Url, now())"
                                                );
                        $stmt->execute(array(
                                    ':CetegoryID'  => $cetegory_id,
                                    ':CourseID'    => $course_id,
                                    ':LevelID'   => $level_id,
                                    ':SubjectID'   => $subject_id,
                                    ':TeacherID'   => $teacher_id,
                                    ':Title'        => $title,
                                    ':TypeLesson'  => 'link',
                                    ':Url'    => $url
                                        ));
                        $stmt = $con->prepare("SELECT * FROM $class WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ORDER BY UserID DESC LIMIT 1");
                        $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                        $row = $stmt->fetch();
                        echo '<tr class="p-relative">';
                            echo '<td></td>';
                            echo '<td>رابط</td>';
                            echo '<td>'.$row['Title'].'</td>';
                            echo '<td>'.$row['Date'].'</td>';
                            echo '<td> 
                                    <div>
                                        <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editFiles(this)"> تعديل </button>
                                        <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweFiles(this)"> معلومات أكثر </button>
                                        <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteFiles(this)"> حذف </button>
                                    </div>
                                </td>';
                        echo '</tr>';
                        echo ' || success';
                    }
                }else {
                    if ($class === 'lessons') {
                        $fileAllowedExte = array('mp4');
                    }else if ($class === 'files') {
                        $fileAllowedExte = array('docx', 'pdf', 'pptx');
                    }
                    $file_E = pathinfo($file_name, PATHINFO_EXTENSION);
                    if (!empty($file_name)  && !in_array($file_E, $fileAllowedExte)) {
                        echo 'This is not a valid image file';
                    }else {
                        $file_up_name = rand(0, 10000).'_'.time().'_'.$file_name;
                        if ($class === 'lessons') {
                            move_uploaded_file($file_tmp_name, $upload.'files/videos/'.$file_up_name);
                        }else if ($class === 'files') {
                            move_uploaded_file($file_tmp_name, $upload.'files/files/'.$file_up_name);
                        }
                        $stmt = $con->prepare("INSERT INTO $class (CetegoryID, CourseID, LevelID, SubjectID, TeacherID, Title, FileName, Date)
                                                VALUES(:CetegoryID, :CourseID, :LevelID, :SubjectID, :TeacherID, :Title, :FileName, now())"
                        );
                        $stmt->execute(array(
                                        ':CetegoryID'  => $cetegory_id,
                                        ':CourseID'    => $course_id,
                                        ':LevelID'   => $level_id,
                                        ':SubjectID'   => $subject_id,
                                        ':TeacherID'   => $teacher_id,
                                        ':Title'        => $title,
                                        ':FileName'    => $file_up_name
                        ));
                        $stmt = $con->prepare("SELECT * FROM $class WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ORDER BY UserID DESC LIMIT 1");
                        $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                        $row = $stmt->fetch();
                        echo '<tr class="p-relative">';
                            echo '<td></td>';
                            if ($class === 'lessons') {
                                echo '<td>فيديو</td>';
                            }
                            echo '<td>'.$row['Title'].'</td>';
                            echo '<td>'.$row['Date'].'</td>';
                            echo '<td> 
                                    <div>
                                        <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editFiles(this)"> تعديل </button>
                                        <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweFiles(this)"> معلومات أكثر </button>
                                        <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteFiles(this)"> حذف </button>
                                    </div>
                                </td>';
                        echo '</tr>';
                    }
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'getdatafile') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($user_id) || empty($class)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '<form action="#">';
                    if ($class === 'lessons') {
                        echo '<div class="d-flex align-center b-none mb-20 option">  <input type="radio" name="typevideo" id="video" value="video"'; if ($class == 'lessons' && $row['TypeLesson']=='video') {echo 'checked';} echo '/> <label for="video" data-type="video" onclick="showVL(this)">فيديو</label>  <input type="radio" name="typevideo" id="link" value="link"';if ($row['TypeLesson']=='link') {echo 'checked';} echo'/> <label for="link" data-type="link" onclick="showVL(this)">رابط</label>  </div>';
                    }
                    echo '<div class="course">
                            <div class="img-course" style="display:';if ($class == 'lessons' && $row['TypeLesson']=='link') {echo 'none';}else {echo 'block';} echo';" style="border: none;">
                                <label for="file" class="p-relative '; if ($class == 'lessons' && $row['TypeLesson']=='video') { echo ' uploaded';}elseif($class=='files') { echo ' uploaded';} echo'"> 
                                <span></span>
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <input type="file" id="file" name="file">
                                </label>
                                ';
                                if ($class === 'lessons') {
                                    if ($class == 'lessons' && $row['TypeLesson']=='video') {
                                        if (file_exists($upload.'files/videos/'.$row['FileName'])) {
                                            echo '<video src="'.$upload.'files/videos/'.$row['FileName'].'" controls width="100%" height="100%" preload="metadata"></video>';
                                        }else {
                                            echo '<div class="c-red"> الملف غير موجود </div>';
                                        }
                                    }
                                }else if ($class === 'files') {
                                    if (file_exists($upload.'files/files/'.$row['FileName'])) {
                                        $file_E = pathinfo($row['FileName'], PATHINFO_EXTENSION);
                                        if ($file_E === 'pdf') {
                                            echo '<iframe src="'.$upload.'files/files/'.$row['FileName'].'" width="100%" height="300px"></iframe>';
                                        }else {
                                            echo '<div class="c-red"> لا يمكن عرض الملف </div>';
                                        }
                                    }else {
                                        echo '<div class="c-red"> الملف غير موجود </div>';
                                    }
                                }
                                echo'
                                <input type="hidden" name="action" value="editfile">
                                <input type="hidden" name="userid" value="'.$user_id.'">
                                <input type="hidden" name="cetegoryID" value="'.$cetegory_id.'">
                                <input type="hidden" name="courseID" value="'.$course_id.'">
                                <input type="hidden" name="levelID" value="'.$level_id.'">
                                <input type="hidden" name="subjectID" value="'.$subject_id.'">
                                <input type="hidden" name="teacherid" value="'.$teacher_id.'">
                                <input type="hidden" name="class" value="'.$class.'">
                            </div>
                            <div class="progress-Area"></div>
                        </div>
                        <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20" type="text" name="title" placeholder="العنوان" value="'.$row['Title'].'">';
                        if ($class === 'lessons') {
                            echo '<input class="b-none border-ccc p-10 rad-6 d-block w-full mb-20 mt-20" type="url" name="url" placeholder="الرابط" value="'.$row['Url'].'" style="display:';if($class == 'lessons' && $row['TypeLesson']=='link'){echo 'block';}else{echo 'none';}echo';">';
                        }
                        echo '<div class="buttons-popup p-15 pt-0"><button class="btn-shape bg-blue c-white d-block w-full submit">تعديل</button></div>
                    </form>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'editfile') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            if ($class === 'lessons' && $_POST['typevideo'] === 'link') {
            }else {
                if (isset($_FILES['file'])) {
                    $file_name = $_FILES['file']['name'];
                    $file_tmp_name = $_FILES['file']['tmp_name'];
                }else {
                    echo 'empty';
                }
            }

            if (empty($title) || empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($class) || empty($teacher_id)) {
                echo 'empty';
            }else {
                if ($class === 'lessons' && isset($_POST['typevideo']) && $_POST['typevideo'] == 'link') {
                    $url = filter_var($_POST['url'], FILTER_VALIDATE_URL);
                    $stmt = $con->prepare("SELECT FileName FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                    $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                    $row = $stmt->fetch();
                    if (!empty($row['FileName'])) {
                        if (file_exists($upload.'files/videos/'.$row['FileName']) !== false) {
                            unlink($upload.'files/videos/'.$row['FileName']);
                        }
                    }
                    $stmt = $con->prepare("UPDATE $class SET
                                                            Title = ?,
                                                            Url = ?,
                                                            TypeLesson = ?,
                                                            FileName = ?
                                                        WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ");
                    $stmt->execute(array($title, $url, 'link', '', $user_id,$cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));

                    $stmt = $con->prepare("SELECT * FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                    $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                        $row = $stmt->fetch();
                        echo '<tr class="p-relative">';
                        echo '<td></td>';
                        if ($class == 'lessons') {
                        echo '<td>';
                        if ($class == 'lessons' && $row['TypeLesson']=='video') {echo'فيديو';} else {echo'رابط';}
                        echo '</td>';
                        }
                        echo '<td>'.$row['Title'].'</td>';
                        echo '<td>'.$row['Date'].'</td>';
                        echo '<td> 
                        <div>
                        <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editFiles(this)"> تعديل </button>
                        <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweFiles(this)"> معلومات أكثر </button>
                        <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteFiles(this)"> حذف </button>
                        </div>
                        </td>';
                    echo '</tr>';
                    echo ' || success';

                }else {
                    if ($class === 'lessons') {
                        $fileAllowedExte = array('mp4');
                    }else if ($class === 'files') {
                        $fileAllowedExte = array('docx', 'pdf', 'pptx');
                    }
                    $file_E = pathinfo($file_name, PATHINFO_EXTENSION);
                    if (!empty($file_name)  && !in_array($file_E, $fileAllowedExte)) {
                        echo 'This is not a valid image file';
                    }else {
                        $stmt = $con->prepare("SELECT FileName FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                        $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                        $row = $stmt->fetch();
    
                        if ($stmt->rowCount() == 0) {
                            echo 'There is no that id';
                        }else {
                            $file_up_name = $row['FileName'];
                            if (!empty($file_name)) {
                                $file_up_name = rand(0, 10000).'_'.time().'_'.$file_name;
                                if ($class === 'lessons') {
                                    move_uploaded_file($file_tmp_name, $upload.'files/videos/'.$file_up_name);
                                    if (file_exists($upload.'files/videos/'.$row['FileName']) !== false) {
                                        unlink($upload.'files/videos/'.$row['FileName']);
                                    }
                                }else if ($class === 'files') {
                                    move_uploaded_file($file_tmp_name, $upload.'files/files/'.$file_up_name);
                                    if (file_exists($upload.'files/files/'.$row['FileName']) !== false) {
                                        unlink($upload.'files/files/'.$row['FileName']);
                                    }
                                }
    
                            }

                            $stmt = $con->prepare("UPDATE $class SET
                                                                            Title = ?,
                                                                            FileName = ?
                                                                        WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ");
                            $stmt->execute(array($title, $file_up_name, $user_id,$cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                            if ($class === 'lessons') {
                                $stmt = $con->prepare("UPDATE $class SET
                                                                TypeLesson = ?
                                                            WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ");
                                $stmt->execute(array('video', $user_id,$cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                            }
                            $stmt = $con->prepare("SELECT * FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                            $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                            $row = $stmt->fetch();
                            echo '<tr class="p-relative">';
                                echo '<td></td>';
                                if ($class == 'lessons') {
                                    echo '<td>';
                                    if ($class == 'lessons' && $row['TypeLesson']=='video') {echo'فيديو';} else {echo'رابط';}
                                    echo '</td>';
                                }
                                echo '<td>'.$row['Title'].'</td>';
                                echo '<td>'.$row['Date'].'</td>';
                                echo '<td> 
                                        <div>
                                            <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editFiles(this)"> تعديل </button>
                                            <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweFiles(this)"> معلومات أكثر </button>
                                            <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteFiles(this)"> حذف </button>
                                        </div>
                                    </td>';
                            echo '</tr>';
                            echo ' || success';
                        }
                    }
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deletefile') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            $stmt =  $con->prepare("SELECT FileName FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                
                if ($class === 'lessons') {
                    if (file_exists($upload.'files/videos/'.$row['FileName']) !== false) {
                        unlink($upload.'files/videos/'.$row['FileName']);
                    }
                }else if ($class === 'files') {
                    if (file_exists($upload.'files/files/'.$row['FileName']) !== false) {
                        unlink($upload.'files/files/'.$row['FileName']);
                    }
                }
                $stmt = $con->prepare("DELETE FROM $class WHERE UserID = :userid");
                $stmt->bindparam(":userid", $user_id);
                $stmt->execute();
                echo 'success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deleteallfile') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            $stmt =  $con->prepare("SELECT UserID, FileName FROM $class WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?");
            $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
            $rows = $stmt->fetchAll();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                foreach ($rows as $row) {
                    $user_id = $row['UserID'];
                    if ($class === 'lessons') {
                        if (file_exists($upload.'files/videos/'.$row['FileName']) !== false) {
                            unlink($upload.'files/videos/'.$row['FileName']);
                        }
                    }else if ($class === 'files') {
                        if (file_exists($upload.'files/files/'.$row['FileName']) !== false) {
                            unlink($upload.'files/files/'.$row['FileName']);
                        }
                    }
                    $stmt = $con->prepare("DELETE FROM $class WHERE UserID = :userid");
                    $stmt->bindparam(":userid", $user_id);
                    $stmt->execute();
                }
                echo 'success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'moreinfofile') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($user_id) || empty($class)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '
                        <div class="course">
                        <div class="m-10"> العنوان : '.$row['Title'].' </div>';
                            if ($class === 'lessons') {echo '<div class="m-10"> النوع : '; if ($row['TypeLesson'] == 'video') {echo ' فيديو ';}else {echo ' رابط ';}echo '</div>';}
                            if ($class === 'lessons' && $row['TypeLesson'] == 'link') {echo '<div class="m-10"> الرابط : '.$row['Url'].' </div>';}
                            echo '<div class="img-course" style="border: none;">';
                                if ($class === 'lessons') {
                                    if ($row['TypeLesson'] == 'video') {
                                        if (file_exists($upload.'files/videos/'.$row['FileName'])) {
                                            echo '<video src="'.$upload.'files/videos/'.$row['FileName'].'" controls width="100%" height="100%" preload="metadata"></video>';
                                        }else {
                                            echo '<div class="c-red"> الملف غير موجود </div>';
                                        }
                                    }else if ($row['TypeLesson'] == 'link') {
                                        echo '<iframe src="'.$row['Url'].'" width="100%" height="300px"></iframe>';
                                    }
                                }else if ($class === 'files') {
                                    if (file_exists($upload.'files/files/'.$row['FileName'])) {
                                        $file_E = pathinfo($row['FileName'], PATHINFO_EXTENSION);
                                        if ($file_E === 'pdf') {
                                            echo '<iframe src="'.$upload.'files/files/'.$row['FileName'].'" width="100%" height="300px"></iframe>';
                                        }else {
                                            echo '<div class="c-red"> لا يمكن عرض الملف </div>';
                                        }
                                    }else {
                                        echo '<div class="c-red"> الملف غير موجود </div>';
                                    }
                                }
                                echo'
                            </div>
                        </div>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'addTest') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $countatTempts = filter_var($_POST['countattempts'], FILTER_SANITIZE_STRING);
            $duration = filter_var($_POST['duration'], FILTER_SANITIZE_STRING);
            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($title) || empty($countatTempts) || empty($duration)) {
                echo 'empty';
            }else {
                $randoFileName = rand(0, 1000000).'_'.$course_id.'_'.$teacher_id.'_'.$title;
                $stmt = $con->prepare("INSERT INTO tests (CetegoryID, CourseID, LevelID, SubjectID, TeacherID, Title, CountAttempts, Duration, FileName, Date)
                                                    VALUES(:CetegoryID, :CourseID, :LevelID, :SubjectID, :TeacherID, :Title, :CountAttempts, :Duration, :FileName, now())"
                                                    );
                $stmt->execute(array(
                        ':CetegoryID'  => $cetegory_id,
                        ':CourseID'    => $course_id,
                        ':LevelID'   => $level_id,
                        ':SubjectID'   => $subject_id,
                        ':TeacherID'   => $teacher_id,
                        ':Title'        => $title,
                        ':CountAttempts'    => $countatTempts,
                        ':Duration'    => $duration,
                        ':FileName'    => $randoFileName
                ));
                fopen($upload.'json/'.$randoFileName.'.json', 'w');
                file_put_contents($upload.'json/'.$randoFileName.'.json','[]');
                $stmt = $con->prepare("SELECT * FROM tests WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ORDER BY UserID DESC LIMIT 1");
                $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                echo '<tr class="p-relative">';
                    echo '<td></td>';
                    echo '<td>'.$row['Title'].'</td>';
                    echo '<td>'.$row['CountQues'].'</td>';
                    echo '<td>';
                    if ($row['Duration'] == 'one') {echo'دقيقة لكل سؤال';}elseif($row['Duration'] == 'tow'){echo'دقيقتين لكل سؤال';}elseif($row['Duration'] == 'infinity'){echo'مفتوح';}
                    echo'</td>';
                    echo '<td>'.$row['Date'].'</td>';
                    echo '<td> 
                        <div>
                            <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editTest(this)"> تعديل </button>
                            <a href="create-test.php?id='.$row['UserID'].'"><button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'"> الإختبار </button></a>
                            <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweTest(this)"> معلومات أكثر  </button>
                            <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteTest(this)"> حذف </button>
                        </div>
                    </td>';
                echo '</tr>';
                echo '|| success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'getdatatest') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);
            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($user_id) || empty($class)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM tests WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '<form action="#">
                            <input type="hidden" name="action" value="updatetest">
                            <input type="hidden" name="userid" value="'.$user_id.'">
                            <input type="hidden" name="cetegoryID" value="'.$cetegory_id.'">
                            <input type="hidden" name="courseID" value="'.$course_id.'">
                            <input type="hidden" name="levelID" value="'.$level_id.'">
                            <input type="hidden" name="subjectID" value="'.$subject_id.'">
                            <input type="hidden" name="teacherid" value="'.$teacher_id.'">
                            <input type="hidden" name="class" value="'.$class.'">
                            <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20" type="text" name="title" placeholder="العنوان" value="'.$row['Title'].'">
                            <label for="duration" class="mt-15"> الوقت </label>
                            <select class="border-ccc p-10 rad-6 d-block w-full" name="duration" id="duration">
                                <option value="one" '; if ($row['Duration'] == 'one'){echo 'selected';} echo'> دقيقة لكل سؤال </option>
                                <option value="tow" '; if ($row['Duration'] == 'tow'){echo 'selected';} echo'> دقيقتين لكل سؤال </option>
                                <option value="infinity"'; if ($row['Duration'] == 'infinity'){echo 'selected';} echo'> مفتوح </option>
                            </select>
                            <label for="countattempts" class="mt-15"> عدد المحاولات </label>
                            <select class="border-ccc p-10 rad-6 d-block w-full" name="countattempts" id="countattempts">
                                <option value="infinity"'; if ($row['CountAttempts'] == 'infinity'){echo 'selected';} echo'>لا نهائي</option>
                                <option value="oneattempt"'; if ($row['CountAttempts'] == 'oneattempt'){echo 'selected';} echo'>محاولة واحدة</option>
                            </select>
                            <div class="buttons-popup p-15 pt-0"><button class="btn-shape bg-blue c-white d-block w-full submit">تعديل</button></div>
                        </form>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'updatetest') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $countatTempts = filter_var($_POST['countattempts'], FILTER_SANITIZE_STRING);
            $duration = filter_var($_POST['duration'], FILTER_SANITIZE_STRING);
            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($title) || empty($countatTempts) || empty($duration)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT FileName FROM tests WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?  LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                $oldFilName = $row['FileName'];
                $randoFileName = rand(0, 1000000).'_'.$course_id.'_'.$teacher_id.'_'.$title;
                rename($upload.'json/'.$oldFilName.'.json', $upload.'json/'.$randoFileName.'.json');
                $stmt = $con->prepare("UPDATE tests SET
                                                    FileName = ?,
                                                    Title = ?,
                                                    CountAttempts = ?,
                                                    Duration = ?
                                                    WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ");
                $stmt->execute(array($randoFileName, $title, $countatTempts, $duration, $user_id,$cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                $stmt = $con->prepare("SELECT * FROM tests WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?  LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                echo '<tr class="p-relative">';
                    echo '<td></td>';
                    echo '<td>'.$row['Title'].'</td>';
                    echo '<td>'.$row['CountQues'].'</td>';
                    echo '<td>';
                    if ($row['Duration'] == 'one') {echo'دقيقة لكل سؤال';}elseif($row['Duration'] == 'tow'){echo'دقيقتين لكل سؤال';}elseif($row['Duration'] == 'infinity'){echo'مفتوح';}
                    echo'</td>';
                    echo '<td>'.$row['Date'].'</td>';
                    echo '<td> 
                        <div>
                            <button class="nowrap btn-shape bg-green m-5 c-white" data-userid="'.$row['UserID'].'" onclick="editTest(this)"> تعديل </button>
                            <button class="nowrap btn-shape bg-blue m-5 c-white" data-userid="'.$row['UserID'].'" onclick="viweTest(this)"> معلومات أكثر  </button>
                            <button class="nowrap btn-shape bg-red m-5 c-white" data-userid="'.$row['UserID'].'" onclick="deleteTest(this)"> حذف </button>
                        </div>
                    </td>';
                echo '</tr>';
                echo '|| success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deletetest') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            $stmt =  $con->prepare("SELECT * FROM tests WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                $stmt = $con->prepare("SELECT FileName FROM tests WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?  LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                $FilName = $row['FileName'].'.json';
                if (file_exists($upload.'json/'.$FilName) !== false) {
                    unlink($upload.'json/'.$FilName);
                }
                $stmt = $con->prepare("DELETE FROM tests WHERE UserID = :userid");
                $stmt->bindparam(":userid", $user_id);
                $stmt->execute();
                echo 'success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deletealltest') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            $stmt =  $con->prepare("SELECT * FROM tests WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?");
            $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
            $rows = $stmt->fetchAll();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                foreach ($rows as $row) {
                    $user_id = $row['UserID'];
                    $stmt = $con->prepare("SELECT FileName FROM tests WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?  LIMIT 1");
                    $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                    $FilName = $stmt->fetch()['FileName'].'.json';
                    if (file_exists($upload.'json/'.$FilName) !== false) {
                        unlink($upload.'json/'.$FilName);
                    }
                    $stmt = $con->prepare("DELETE FROM tests WHERE UserID = :userid");
                    $stmt->bindparam(":userid", $user_id);
                    $stmt->execute();
                }
                echo 'success';
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'moreinfotest') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $class = filter_var($_POST['class'], FILTER_SANITIZE_STRING);

            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($user_id) || empty($class)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM $class WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '<div class="p-10 course">';
                            echo '<div class="m-10"> العنوان : '.$row['Title'].' </div>';
                            echo '<div class="m-10"> المدة : '; if ($row['Duration'] == 'one') {echo'دقيقة لكل سؤال';}elseif($row['Duration'] == 'tow'){echo'دقيقتين لكل سؤال';}elseif($row['Duration'] == 'infinity'){echo'مفتوح';} echo '</div>';
                            echo '<div class="m-10"> عدد المحاولات : '; if ($row['CountAttempts'] == 'oneattempt') {echo'محاولة واحدة';}elseif($row['CountAttempts'] == 'infinity'){echo'مفتوح';} echo '</div>';
                            echo '<div class="m-10"> عدد الأسئلة : '.$row['CountQues'].'</div>';
                            echo '<div class="m-10"> التاريخ : '.$row['Date'].' </div>';
                        echo '</div>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }

            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'addsecques') {
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($title)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("INSERT INTO section_question (CetegoryID, CourseID, LevelID, SubjectID, TeacherID, Title, Date)
                                                    VALUES(:CetegoryID, :CourseID, :LevelID, :SubjectID, :TeacherID, :Title, now())"
                                                    );
                $stmt->execute(array(
                        ':CetegoryID'  => $cetegory_id,
                        ':CourseID'    => $course_id,
                        ':LevelID'     => $level_id,
                        ':SubjectID'   => $subject_id,
                        ':TeacherID'   => $teacher_id,
                        ':Title'       => $title
                ));
                $stmt = $con->prepare("SELECT * FROM section_question WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? ORDER BY UserID DESC LIMIT 1");
                $stmt->execute(array($cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                echo '<li> <span>'.$row['Title'].'</span> <span class="dots"><i class="fa-solid fa-ellipsis-vertical p-5" onclick="openmenulevel (this)"></i><div class="container-menu"><div class="edit" data-userid="9" onclick="updatesecques (this)"> <span> تعديل </span> <i class="fa-regular fa-pen-to-square"></i> </div><div class="delete" data-userid="9" onclick="deletesecques (this)"> <span> حذف </span> <i class="fa-regular fa-trash-can"></i> </div></div></span></li>';
                echo ' || success';

            }
        }else if(isset($_POST['action']) && $_POST['action'] == 'getdatasecques') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            if (empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($subject_id) || empty($teacher_id) || empty($user_id)) {
                echo 'empty';
            }else {
                $stmt = $con->prepare("SELECT * FROM section_question WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id ,$course_id, $level_id, $subject_id, $teacher_id));
                $row = $stmt->fetch();
                if (isset($row) && !empty($row)) {
                    echo '<form action="#">
                            <input type="hidden" name="action" value="editsecques">
                            <input type="hidden" name="userid" value="'.$user_id.'">
                            <input type="hidden" name="cetegoryID" value="'.$cetegory_id.'">
                            <input type="hidden" name="courseID" value="'.$course_id.'">
                            <input type="hidden" name="levelID" value="'.$level_id.'">
                            <input type="hidden" name="subjectID" value="'.$subject_id.'">
                            <input type="hidden" name="teacherid" value="'.$teacher_id.'">
                            <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20 mb-20" type="text" name="title" placeholder="العنوان" value="'.$row['Title'].'">
                            <div class="buttons-popup p-15 pt-0"><button class="btn-shape bg-blue c-white d-block w-full submit">تعديل</button></div>
                        </form>';
                    echo ' || success';
                }else {
                    echo 'there is no that id';
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'editsecques') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);

            if (empty($title) || empty($cetegory_id) || empty($course_id) || empty($level_id) || empty($teacher_id) || empty($user_id)) {
                echo 'empty';
            }else {


                $stmt = $con->prepare("SELECT UserID FROM section_question WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
                $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id ,$subject_id, $teacher_id));
                $row = $stmt->fetch();

                if ($stmt->rowCount() == 0) {
                    echo 'There is no that id';
                }else {
                    $stmt = $con->prepare("UPDATE section_question SET
                                                                    Title = ?
                                                                WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?");
                    $stmt->execute(array($title, $user_id, $cetegory_id, $course_id, $level_id, $subject_id,$teacher_id));
                    echo $title;
                    echo ' || success';
                }
            }
        }else if (isset($_POST['action']) && $_POST['action'] == 'deletesecques') {
            $user_id = filter_var($_POST['userid'], FILTER_SANITIZE_NUMBER_INT);
            $cetegory_id = filter_var($_POST['cetegoryID'], FILTER_SANITIZE_NUMBER_INT);
            $course_id = filter_var($_POST['courseID'], FILTER_SANITIZE_NUMBER_INT);
            $level_id = filter_var($_POST['levelID'], FILTER_SANITIZE_NUMBER_INT);
            $subject_id = filter_var($_POST['subjectID'], FILTER_SANITIZE_NUMBER_INT);
            $teacher_id = filter_var($_POST['teacherid'], FILTER_SANITIZE_NUMBER_INT);

            $stmt =  $con->prepare("SELECT UserID FROM section_question WHERE UserID = ? AND CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ? LIMIT 1");
            $stmt->execute(array($user_id, $cetegory_id, $course_id, $level_id, $subject_id, $teacher_id));
            $row = $stmt->fetch();

            if ($stmt->rowCount() == 0) {
                echo 'there is no that id';
            }else {
                $stmt = $con->prepare("DELETE FROM section_question WHERE UserID = :userid");
                $stmt->bindparam(":userid", $user_id);
                $stmt->execute();
                echo 'success';
            }
        }
    }
?>