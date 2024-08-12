<?php
  ob_start();
  session_start();
  session_regenerate_id();

  // $linkCss = ".css";
  $linkjs = "action_mangecourse.js";
  $pageName = 'mangecourse';
  $pageTitle = " إدارة ";

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
            $From_To = " AND Date <= '$date_to' AND Date >= '$date_from' ";
          }elseif (!empty($date_from)) {
            $From_To = " AND Date >= '$date_from' ";
          }elseif (!empty($date_to)) {
            $From_To = " AND Date <= '$date_to' ";
          }
        }
        $stmt = $con->prepare("SELECT * FROM courses JOIN category ON courses.TypeCourse = category.C_UserID WHERE TeacherID = ? $From_To ORDER BY `courses`.`UserID` ASC LIMIT $LIMIT");
        $stmt->execute(array($ID));
        $rows = $stmt->fetchAll();
        ?>
          <!-- Start Mange -->
          <div class="mange-cours">
            <h1 class="p-relative">إدارة الدورات</h1>
    
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
    
            <div class="cards p-20 rad-10 ">
              <?php $date = date("Y-m-d"); ?>
              <ul class="d-grid gap-20">
                <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <div class="content"><div class="c-grey"> عدد الدروس : </div><div class="num"><?php echo getCount("lessons", " WHERE TeacherID = ".$ID." $From_To"); ?> </div></div>
                  <div class="icon"><i class="fa-solid fa-tv"></i></div>
                </li>
                <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <div class="content"><div class="c-grey"> عدد الإختبارات  : </div><div class="num"><?php echo getCount("tests", " WHERE TeacherID = ".$ID." $From_To"); ?> </div></div>
                  <div class="icon"><i class="fa-solid fa-align-center"></i></i></div>
                </li>
                <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                  <div class="content"><div class="c-grey"> عدد الملفات : </div><div class="num"><?php echo getCount("files", " WHERE TeacherID = ".$ID." $From_To"); ?> </div></div>
                  <div class="icon"><i class="fa-solid fa-file-arrow-up"></i></i></div>
                </li>
              </ul>
            </div>
    
            <div class="table p-20 m-20 rad-10 bg-white">
    
              <div class="option option1 d-flex block-mobile">
                <?php 
                  $stmt = $con->prepare("SELECT * FROM category");
                  $stmt->execute();
                  $rows = $stmt->fetchAll();
                  foreach ($rows as $row) {
                    echo '<div class="container-lable">';
                      echo '<input type="radio" id="'.$row['category'].'" name="categoryID" value="'.$row['C_UserID'].'">';
                      echo '<label for="'.$row['category'].'">'.$row['category'].'</label>';
                    echo '</div>';
                  }
                ?>
              </div>
    
              <div class="option option2 d-flex  block-mobile p-relative" style="visibility:hidden;">
              </div>
    
              <div class="option option3 basictype d-flex block-mobile"  style="visibility:hidden;">
              </div>
    
              <div class="option option4 d-flex  block-mobile" style="visibility:hidden;">
              </div>
    
              <div class="option option5 d-flex  block-mobile" style="visibility:hidden;">
                <div class="container-lable">
                  <input type="radio" id="lesson" name="typeaction" value="lessons" onclick="viweInputSearch(this)">
                  <label for="lesson"> دروس </label>
                </div>
                <div class="container-lable">
                  <input type="radio" id="test" name="typeaction" value="tests" onclick="viweInputSearch(this)">
                  <label for="test"> إختبارات </label>
                </div>
                <div class="container-lable">
                  <input type="radio" id="files" name="typeaction" value="files" onclick="viweInputSearch(this)">
                  <label for="files"> ملفات </label>
                </div>
                <div class="container-lable">
                  <input type="radio" id="schedule" name="typeaction" value="schedule" onclick="viweInputSearch(this)">
                  <label for="schedule"> جدول الحصص </label>
                </div>
              </div>
    
              <div class="search-area p-20 mt-20 mb-20 bg-eee rad-10" style="visibility:hidden;">
                <div class="cont-search d-flex align-center block-mobile">
                    <span class="search-input p-relative block-mobile">
                      <input type="text" name="data" placeholder=" بحث من خلال الاسم أو غيره " class="border-ccc">
                      <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="submit" value="بحث" class="btn-shape bg-blue c-white block-mobile search-courses" onclick="search()">
                </div>
              </div>
    
              <div class="popup center-flex">
                <div class="parent-popup border-ccc rad-10">
                  <div class="head-popup p-15 between-flex">
                    <span>أضف دورتك الجديدة الآن ...</span>
                    <i class="fa-solid fa-xmark"></i>
                  </div>
                  <div class="content-popup p-15">
                    <div class="popup-error" style="color: var(--red-color);"></div>
                    <div class="content-popup-child"></div>
                  </div>
                </div>
              </div>
    
              <div class="responsive-table">
              </div>
              <div class="addClass mt-15"></div>
    
            </div>
    
          </div>
          <!-- End Mange -->
    
          <script>
            let formTo = '<?php echo $From_To; ?>';
            let teacherid = '<?php echo $ID; ?>';
          </script>
        <?php
        include $tpl . "footer.php"; 
      }
    }
  }
  ob_end_flush();
?>