<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'dashboard';
    $linkjs = "";
    $pageTitle = " لوحة التحكم ";
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
        <!-- Start dashboard -->
        <div class="active dashboard">
          <h1 class="p-relative">لوحة التحكم</h1>
          <div class="wrapper d-grid gap-20">
            <!-- Start Welcome Widget -->
            <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
              <div class="intro p-20 d-flex space-between bg-eee">
                <div>
                  <h2 class="m-0">أهلا بك مرة أخرى ...</h2>
                  <p class="c-grey mt-5"> <?php if (empty($infoUser)) {echo 'الاسم...';} else {echo $infoUser['FName'].' '.$infoUser['SName'];}?> </p>
                </div>
                <img class="hide-mobile" src="<?php echo $upload; ?>imags/Avatar/welcome.png" alt="" />
              </div>
              <?php 
                if ($_SESSION['Avatar'] == '') {
                    echo '<img src="'.$upload.'imags/Avatar/defaultImg.png" alt="" class="avatar">';
                }else {
                    echo '<img src="'.$upload.'imags/Avatar/'.$_SESSION['Avatar'].'" alt="" class="avatar">';
                }
                ?>
              <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                <div> <?php if (empty($infoUser)) {echo 'الاسم...';} else {echo $infoUser['FName'].' '.$infoUser['SName'];}?> <span class="d-block c-grey fs-14 mt-10">طالب</span></div>
                <div><?php if (empty($infoUser)) {echo 'عدد النقاط ...';} else {echo 'عدد النقاط ... '; echo 'قريبا ...';}?> <span class="d-block c-grey fs-14 mt-10">نقطة</span></div>
                <!-- <div>$8500 <span class="d-block c-grey fs-14 mt-10">Earned</span></div> -->
              </div>
              <a href="myaccount.php" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">حسابي</a>
            </div>
            <!-- End Welcome Widget -->
          </div>

          <div class="my-courses m-20 gap-20 bg-white rad-10 p-20">
            <h2 class="mt-0 mb-10">دوراتي</h2>
            <p class="c-grey">الدورات التي تم الإشتراك بها أو الدورات التي تحت الطلب</p>  

            <?php 
              if (empty($infoUser)) {
                echo '<p class="c-green"> للأشتراك في الدرورات قم بإنشاء حسابك الآن ... </p>';
                echo '<a href="../signup.php" class="btn-shape bg-green c-white box"> أنشئ حسابك الآن </a>';
              }else {
                echo '<div class="courses-page d-grid gap-20">';

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
                    if ($inActiveOrder == true || $activeOrder == true) {
                      ?>
                      <a href="courselevels.php?UserID=<?php echo $course['UserID_Course'];?>">
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
                                  }
                                ?>
                                <span class="c-grey">
                                  <i class="fa-regular fa-user"></i>
                                  <?php echo $total_subscirberes; ?>
                                </span>
                              </div>
                          </div>
                        </a>
                      <?php
                    }
                  }
                }
                echo '</div>';
              }

            ?>


          </div>


        </div>
        <!-- End dashboard -->
        <script>
         let studentid = '<?php echo $_SESSION['ID']; ?>';
        </script>
    <?php
    include $tpl . "footer.php"; 
ob_end_flush();
?>