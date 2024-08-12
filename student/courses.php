<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'courses';
    $linkjs = "";
    $pageTitle = " الدورات ";
    $_SESSION['Avatar'] = '';
    $infoUser = '';
    include "init.php";
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
    ?>
        <!-- Start courses -->
        <div class="courses">
          <h1 class="p-relative">الدورات</h1>
          <div class="my-courses w-full m-20 gap-20 bg-white rad-10 p-20">
            <h2 class="mt-0 mb-10">الدورات</h2>
            <p class="c-grey"> البحث عن الدورات المناسبة لك . </p> 

            <div class="search-area">
            </div>


            <div class="courses-page d-grid m-20 gap-20">
              <?php 
                  $date = date("Y-m-d");
                  $stmt = $con->prepare("SELECT courses.UserID UserID_Course,
                                                courses.Avatar Avatar_Cours,
                                                userss.Avatar Avatar_Teacher,
                                                Title, Describtion, Price 
                                                                            FROM courses JOIN userss ON courses.TeacherID = userss.UserID WHERE TypeUser = 'Teacher' AND courses.End >= '$date' AND courses.Start <= '$date' AND courses.Status = 1");
                  $stmt->execute(array());
                  $courses = $stmt->fetchAll();
                  if ($stmt->rowCount() == 0) {
                    echo '<h2 class="c-red p-20"> لا يوجد دورات . </h2>';
                  }else {
                    if ($_SESSION['ID'] != 'vistor') {
                      $stmt = $con->prepare("SELECT O_CourseID, O_RegStatus FROM orders WHERE O_StudentID = ? AND O_RegStatus = 0");
                      $stmt->execute(array($_SESSION['ID']));
                      $Orders = $stmt->fetchAll();
                    }
                    foreach ($courses as $course) {
                      $inActiveOrder = false;
                      $activeOrder = false;
                      if ($_SESSION['ID'] != 'vistor') {
                        foreach ($Orders as $order) {
                          if ($course['UserID_Course'] == $order['O_CourseID']) {
                            if ($order['O_RegStatus'] == 0) {
                              $inActiveOrder = true;
                            }else {
                              $activeOrder = true;
                            }
                          }
                        }
                      }
                      $total_subscirberes = getCount('orders', " WHERE O_UserID = ".$course['UserID_Course']." AND O_RegStatus = 1");
                        ?>
                          <div class="course txt-c bg-white rad-6 p-relative">
                              <img class="cover" src="<?php echo $upload.'imags/imgcourses/'.$course['Avatar_Cours']; ?>" alt="" />
                              <img class="instructor" src="<?php echo $upload.'imags/Avatar/'.$course['Avatar_Teacher']; ?>" alt="" />
                              <div class="p-20">
                                <h4 class="m-0 c-black"> <?php echo $course['Title']; ?> </h4>
                                <p class="description c-grey mt-15 fs-14">
                                <?php echo $course['Describtion']; ?>
                                </p>
                              </div>
                              <div class="info p-15 p-relative between-flex">
                                <span class="c-grey">
                                  <i class="fa-solid fa-dollar-sign"></i>
                                  <?php echo $course['Price']; ?>
                                </span>
                                <?php
                                  if ($inActiveOrder == true) {
                                      echo '<button class="btn-shape bg-red c-white box"> تحت الطلب </button>';
                                  }elseif ($activeOrder == true) {
                                      echo '<button class="btn-shape bg-blue c-white box"> تم الإشتراك </button>';
                                  }else {
                                      echo '<a href="infocourse.php?UserID='.$course['UserID_Course'].'" class="btn-shape bg-green c-white box"> اشترك الآن </a>';
                                  } 
                                ?>
                                <span class="c-grey">
                                  <i class="fa-regular fa-user"></i>
                                  <?php echo $total_subscirberes; ?>
                                </span>
                              </div>
                          </div>
                        <?php
                    }
                  }
              ?>
            </div>
          </div>
        </div>
        <!-- End courses -->
        <script>
         let studentid = '<?php echo $_SESSION['ID']; ?>';
        </script>
    <?php
    include $tpl . "footer.php"; 
ob_end_flush();
?>