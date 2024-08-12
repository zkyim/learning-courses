<?php
  ob_start();
  session_start();
  session_regenerate_id();

  // $linkCss = ".css";
  $linkjs = "my_chart.js";
  $pageName = 'dashboard';
  $pageTitle = " لوحة التحكم ";
  include "init.php";

  if (isset($_SESSION['ID']) == false || empty($_SESSION['ID'])) {
    header('location: logout.php');
    exit();
  }else {
    $ID = filter_var($_SESSION['ID'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = $con->prepare("SELECT * FROM userss WHERE UserID = ? LIMIT 1");
    $stmt->execute(array($ID));
    $infoUser = $stmt->fetch();
    if ($stmt->rowCount() == 0) {
      header('location: logout.php');
      exit();
    }else {
      if ($infoUser['TypeUser'] !== 'Teacher') {
        header('location: logout.php');
        exit();
      }else {
        $_SESSION['Avatar'] = $infoUser['Avatar'];
        $From_To = '';
        if(isset($_GET['datefrom']) && isset($_GET['dateto'])) {
          $date_from = filter_var($_GET['datefrom'], FILTER_SANITIZE_STRING);
          $date_to = filter_var($_GET['dateto'], FILTER_SANITIZE_STRING);
          if (!empty($date_from) &&!empty($date_to)) {
            $From_To = " AND O_Date <= '$date_to' AND O_Date >= '$date_from' ";
          }elseif (!empty($date_from)) {
            $From_To = " AND O_Date >= '$date_from' ";
          }elseif (!empty($date_to)) {
            $From_To = " AND O_Date <= '$date_to' ";
          }
        }
        $stmt = $con->prepare("SELECT * FROM orders WHERE O_TeacherID = ? $From_To");
        $stmt->execute(array($ID));
        $rows = $stmt->fetchAll();
        ?>
          <div class="dashboard">
            <h1 class="p-relative">لوحة التحكم</h1>

            <div class="search-area p-20 m-20 bg-eee rad-10">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-flex align-center block-mobile cont-search">
                <span class="w-full cont-date">
                  <label for="datefrom" class="d-block">من</label>
                  <input type="date" id="datefrom" name="datefrom" class="w-full p-10 bg-white rad-6 border-ccc">
                </span>
                <span class="w-full cont-date">
                  <label for="dateto" class="d-block">إلى</label>
                  <input type="date" id="dateto" name="dateto" class="w-full p-10 bg-white rad-6 border-ccc">
                </span>
                <input type="submit" value="بحث" class="btn-shape bg-blue c-white block-mobile">
              </form>
            </div>

            <div class="cards p-20 m-20 rad-10 ">
              <ul class="d-grid gap-20">
                <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <div class="content"><div class="c-grey">عدد الأعضاء : </div><div class="num"><?php echo getCount("orders", "WHERE O_TeacherID = ".$ID." $From_To"); ?></div></div>
                  <div class="icon"><i class="fa-solid fa-users"></i></div>
                </li>
                <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <div class="content"><div class="c-grey">الأعضاء الخاملة  : </div><div class="num"><?php echo getCount("orders", "WHERE O_TeacherID = ".$ID." AND O_RegStatus = 0 $From_To"); ?></div></div>
                  <div class="icon"><i class="fa-solid fa-users-gear"></i></div>
                </li>
                <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <?php 
                    $stmt = $con->prepare("SELECT SUM(Price) FROM orders WHERE O_TeacherID = ".$ID." AND O_RegStatus = 1 $From_To");
                    $stmt->execute();
                    $totaleMony = $stmt->fetchColumn();
                    if (empty($totaleMony)) {$totaleMony = 0;}
                    $stmt = $con->prepare("SELECT SUM(courses.Price) FROM courses JOIN orders WHERE O_TeacherID = ".$ID." AND O_RegStatus = 1  $From_To");
                    $stmt->execute();
                    $realMony = $stmt->fetchColumn();
                    if (empty($realMony)) {$realMony = 0;}
                  ?>
                  <div class="content">
                    <span class="d-block"><span class="c-grey">المبلغ الإفتراضي : </span><span> <?php echo $totaleMony; ?>$</span></span>
                    <span class="d-block"><span class="c-grey"> المبلغ الفعلي : </span><span> <?php echo $realMony; ?>$</span></span>
                  </div>
                  <div class="icon"><i class="fa-solid fa-dollar-sign"></i></div>
                </li>
                <!-- <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <div class="content"><div class="c-grey"> الرسائل : </div><div class="num">43</div></div>
                  <div class="icon"><i class="fa-regular fa-comments"></i></div>
                </li> -->
              </ul>
            </div>

            <div class="statistics p-20 m-20 rad-10 bg-white">
              <h2 class="mt-0">إحصائات الأعضاء والمكسب</h2>
              <p class="c-grey"> هذا الشكل يمثل إحصائات الأعضاء الجدد والمكسب . </p>
              <p class="c-grey"> متوفر قريبا ... </p>
              <div class="chart">
                <!-- <canvas id="myChart"></canvas> -->
              </div>
            </div>

            <div class="wrapper d-grid gap-20">
              <!-- Start Welcome Widget -->
              <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
                <div class="intro p-20 d-flex space-between bg-eee">
                  <div>
                    <h2 class="m-0">أهلا بك مرة أخرى ...</h2>
                    <p class="c-grey mt-5"> <?php echo $infoUser['FName'].' '.$infoUser['SName'];?> </p>
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
                  <div> <?php echo $infoUser['FName'].' '.$infoUser['SName'];?> <span class="d-block c-grey fs-14 mt-10">معلم</span></div>
                  <?php 
                    $thisMonth = date('Y-m');
                    $stmt = $con->prepare("SELECT SUM(Price) FROM orders WHERE O_TeacherID = ".$ID." AND O_RegStatus = 1 AND $thisMonth-1 >= O_DateOfStatr AND $thisMonth-31 <= O_DateOfStatr");
                    $stmt->execute();
                    $totaleMony = $stmt->fetchColumn();
                    if (empty($totaleMony)) {$totaleMony = 0;}
                  ?>
                  <div>$<?php echo $totaleMony; ?> <span class="d-block c-grey fs-14 mt-10">هذا الشهر</span></div>
                </div>
                <a href="myaccount.php" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">حسابي</a>
              </div>
              <!-- End Welcome Widget -->
            </div>

          </div>
          <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
        <?php
        include $tpl . "footer.php"; 
      }
    }
  }
  ob_end_flush();

?>