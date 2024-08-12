<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'courses';
    $linkjs = "";
    $pageTitle = " معلومات الدورة ";
    $_SESSION['Avatar'] = '';
    $infoUser = '';
    include "init.php";
    if (isset($_GET['UserID']) == false && empty($_GET['UserID'])) {
        header('location: logout.php');
        exit();
    }else {
        $date = date("Y-m-d");
        $stmt = $con->prepare("SELECT courses.UserID UserID_Course,
                                      courses.TeacherID TeacherID_Course,
                                      courses.Avatar Avatar_Cours,
                                      userss.Avatar Avatar_Teacher,
                                      Title, Describtion, Price,
                                      FName, SName, Email,PhoneNumber,
                                      Twitter, Facebook, LinkedIn, Youtube
                                                                  FROM courses JOIN userss ON courses.TeacherID = userss.UserID WHERE TypeUser = 'Teacher' AND courses.UserID = ? AND courses.End >= '$date' AND courses.Start <= '$date' AND courses.Status = 1 LIMIT 1");
        $stmt->execute(array($_GET['UserID']));
        $infoCourse = $stmt->fetch();
        
        if ($stmt->rowCount() == 0) {
            header('location: logout.php');
            exit();
        }else {
            if (isset($_SESSION['ID']) == false || empty($_SESSION['ID'])) {
                $_SESSION['ID'] = 'vistor';
              }else {
                if ($_SESSION['ID'] != 'vistor') {
                  $ID = filter_var($_SESSION['ID'], FILTER_SANITIZE_NUMBER_INT);
                  $stmt = $con->prepare("SELECT * FROM userss WHERE UserID = ? LIMIT 1");
                  $stmt->execute(array($ID));
                  $infoUser = $stmt->fetch();
                  if ($stmt->rowCount() == 0) {
                    header('location: logout.php');
                    exit();
                  }else {
                    if ($infoUser['TypeUser'] !== 'Student') {
                      header('location: logout.php');
                      exit();
                    }else {
                      $_SESSION['Avatar'] = $infoUser['Avatar'];
                      $_SESSION['ID'] = $infoUser['UserID'];
                    }
                  }
                }
              }
              include $tpl . "header.php";
              if ($_SESSION['ID'] != 'vistor') {
                  $stmt = $con->prepare("SELECT O_UserID, O_RegStatus FROM orders WHERE O_StudentID = ?");
                  $stmt->execute(array($_SESSION['ID']));
                  $supscribOrders = $stmt->fetchAll();

                  $stmt = $con->prepare("SELECT O_CourseID, O_RegStatus FROM orders WHERE O_StudentID = ? AND O_RegStatus = 0");
                  $stmt->execute(array($_SESSION['ID']));
                  $Orders = $stmt->fetchAll();
                }
              ?>
                    <!-- Start courses -->
                    <div class="courses">
                        <h1 class="p-relative"> معلومات عن الدورة </h1>
                        <div class="my-courses w-full m-20 gap-20 bg-white rad-10 p-20">
                            <h2 class="mt-0 mb-10">معلومات عن الدورة </h2>
                            <p class="c-grey"> معرض معلومات الدورة وكل مايخصها وتقيمات المشتركين وآراؤهم والمزيد. </p> 

                            <div class="search-area">
                            </div>

                            <div class="courses-page center-flex m-20">
                                <div class="course txt-c bg-white rad-6 p-relative">
                                    <img class="cover" src="<?php echo $upload.'imags/imgcourses/'.$infoCourse['Avatar_Cours']; ?>" alt="" />
                                    <img class="instructor" src="<?php echo $upload.'imags/Avatar/'.$infoCourse['Avatar_Teacher']; ?>" alt="" />
                                    <div class="p-20">
                                    <h4 class="m-0 c-black"> <?php echo $infoCourse['Title']; ?> </h4>
                                    <p class="description c-grey mt-15 fs-14">
                                    <?php echo $infoCourse['Describtion']; ?>
                                    </p>
                                    </div>
                                    <div class="info p-15 p-relative between-flex">
                                    <span class="c-grey">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                        <?php echo $infoCourse['Price']; ?>
                                    </span>
                                    <?php
                                        $total_subscirberes = getCount('orders', " WHERE O_UserID = ".$infoCourse['UserID_Course']." AND O_RegStatus = 1");
                                    ?>
                                    <?php if ($_SESSION['ID'] == 'vistor') {?>
                                        <button class="btn-shape bg-green c-white box" onclick="signUpNow()"> اشترك الآن </button>
                                    <?php }else {
                                        $inActiveOrder = false;
                                        $activeOrder = false;
                                        if ($_SESSION['ID'] != 'vistor') {
                                            foreach ($Orders as $order) {
                                              if ($infoCourse['UserID_Course'] == $order['O_CourseID']) {
                                                if ($order['O_RegStatus'] == 0) {
                                                  $inActiveOrder = true;
                                                }else {
                                                  $activeOrder = true;
                                                }
                                              }
                                            }
                                        }
                                        
                                        if ($inActiveOrder == true) {
                                            echo '<button class="btn-shape bg-red c-white box"> تحت الطلب </button>';
                                        }elseif ($activeOrder == true) {
                                            echo '<button class="btn-shape bg-green c-white box"> تم الإشتراك </button>';
                                        }else {
                                            echo '<button class="btn-shape bg-green c-white box" onclick="subscribNow()"> اشترك الآن </button>';
                                        }
                                        
                                    } ?>
                                    <span class="c-grey">
                                        <i class="fa-regular fa-user"></i>
                                        <?php echo $total_subscirberes; ?>
                                    </span>
                                    </div>
                                </div>
                                <div class="popup center-flex">
                                    <div class="parent-popup border-ccc rad-10">
                                    <div class="head-popup p-15 between-flex">
                                        <span> </span>
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    <div class="content-popup p-15">
                                        <div class="popup-error" style="color: var(--red-color);"></div>
                                        <div class="content-popup-child">

                                        </div>
                                    </div>
                                    </div>
                                </div>

                            </div>
                            <div class="courses-page d-grid m-20 gap-20 ">
                                <div class="fs-14">
                                    <span class="c-grey"> العنوان :  </span>
                                    <span> <?php echo $infoCourse['Title']; ?> </span>
                                </div>
                                <div class="fs-14">
                                    <span class="c-grey"> السعر :  </span>
                                    <span> <?php echo $infoCourse['Price'] ?> <i class="fa-solid fa-dollar-sign"></i> </span>
                                </div>
                                <div class="fs-14">
                                    <span class="c-grey"> عدد المشتركين :  </span>
                                    <span> <?php echo $total_subscirberes; ?> </span>
                                </div>
                                <div class="fs-14">
                                    <span class="c-grey"> إسم منشئ الدورة :  </span>
                                    <span> <?php echo $infoCourse['FName'] . ' ' . $infoCourse['SName']; ?> </span>
                                </div>
                                <div class="fs-14">
                                    <span class="c-grey"> بريد منشئ الدورة :  </span>
                                    <span> <?php echo $infoCourse['Email']; ?> </span>
                                </div>
                                <div class="fs-14">
                                    <span class="c-grey"> رقم منشئ الدورة :  </span>
                                    <span> <?php echo $infoCourse['PhoneNumber']; ?> </span>
                                </div>
                                <?php
                                    if (!empty($infoCourse['Twitter'])) {
                                        echo '<div class="fs-14">
                                        <span class="c-grey"> تويتر منشئ الدورة :  </span>
                                        <a href="'.$infoCourse['Twitter'].'"> '.$infoCourse['Twitter'].' </a>
                                        </div>';
                                    }
                                    if (!empty($infoCourse['Facebook'])) {
                                        echo '<div class="fs-14">
                                        <span class="c-grey"> فيس بوك منشئ الدورة :  </span>
                                        <a href="'.$infoCourse['Facebook'].'"> '.$infoCourse['Facebook'].' </a>
                                        </div>';
                                    }
                                    if (!empty($infoCourse['LinkedIn'])) {
                                        echo '<div class="fs-14">
                                        <span class="c-grey"> لينكد إن منشئ الدورة :  </span>
                                        <a href="'.$infoCourse['LinkedIn'].'"> '.$infoCourse['LinkedIn'].' </a>
                                        </div>';
                                    }
                                    if (!empty($infoCourse['Youtube'])) {
                                        echo '<div class="fs-14">
                                        <span class="c-grey"> يوتيوب منشئ الدورة :  </span>
                                        <a href="'.$infoCourse['Youtube'].'"> '.$infoCourse['Youtube'].' </a>
                                        </div>';
                                    }
                                ?>
                            </div>
                            <div class="d-grid m-20 gap-20">
                                <h3> آراء المشتركين ... قريبا ... </h3>
                            </div>
                        </div>
                    </div>
                    <!-- End courses -->
                    <script>
                        let CourseID = '<?php echo $infoCourse['UserID_Course']; ?>';
                        let teacherid = '<?php echo $infoCourse['TeacherID_Course']; ?>';
                        let studentid = '<?php echo $_SESSION['ID']; ?>';
                    </script>
                    <script src="<?php echo $js; ?>infocourse.js"></script>
              <?php
              include $tpl . "footer.php"; 
        }
    }
ob_end_flush();
?>