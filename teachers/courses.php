<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'courses';
    $linkjs = "action_courses.js";
    $pageTitle = " الدورات ";
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
          $stmt->execute(array($_SESSION['ID']));
          $rows = $stmt->fetchAll();
          ?>
            <!-- Start courses -->
            <div class="courses">
                <h1 class="p-relative">الدورات</h1>
    
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
                  <?php $date = date("Y-m-d"); ?>
                  <ul class="d-grid gap-20">
                    <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                      <div class="content"><div class="c-grey"> لم تبدأ : </div><div class="num"> <?php echo getCount("courses", " WHERE TeacherID = ".$_SESSION['ID']." AND Start > '$date' $From_To"); ?> </div></div>
                      <div class="icon"><i class="fa-solid fa-hourglass-start"></i></div>
                    </li>
                    <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                      <div class="content"><div class="c-grey"> مستمرة  : </div><div class="num"><?php echo getCount("courses", " WHERE TeacherID = ".$_SESSION['ID']." AND  End >= '$date' AND Start <= '$date' $From_To "); ?></div></div>
                      <div class="icon"><i class="fa-solid fa-hourglass-half"></i></i></div>
                    </li>
                    <li class="d-flex border-ccc bg-white shadow between-flex p-20 rad-10">
                      <div class="content"><div class="c-grey"> انتهت : </div><div class="num"><?php echo getCount("courses", " WHERE TeacherID = ".$_SESSION['ID']." AND  End < '$date' $From_To "); ?></div></div>
                      <div class="icon"><i class="fa-solid fa-hourglass-end"></i></i></div>
                    </li>
                  </ul>
                </div>
    
                <div class="table p-20 m-20 rad-10 bg-white">
    
                  <form action="#" class="search-courses-form">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="From_To" value="<?php echo $From_To; ?>">
                    <input type="hidden" name="teacherid" value="<?php echo $_SESSION['ID'];?>">
                    <div class="option d-flex  block-mobile">
                      <?php
                      $stmt = $con->prepare("SELECT * FROM category");
                      $stmt->execute();
                      $categoris = $stmt->fetchAll();
                      foreach ($categoris as $category) {
                        $rannum = rand(0, 10000);
                        echo 
                        '
                        <div class="container-lable">
                          <input type="radio" id="'.$rannum.'" name="typecourse" value="'.$category['C_UserID'].'">
                          <label for="'.$rannum.'">'.$category['category'].'</label>
                        </div>
                        ';
                      }
                      ?>
                      <div class="container-lable">
                        <input type="radio" id="alltypecourse" name="typecourse" value="all" checked>
                        <label for="alltypecourse"> الكل </label>
                      </div>
                    </div>
    
                    <div class="option option2 d-flex  block-mobile">
                      <div class="container-lable">
                        <input type="radio" id="status1" name="status" value="NotStart">
                        <label for="status1"> لم تبدأ </label>
                      </div>
                      <div class="container-lable">
                        <input type="radio" id="status2" name="status" value="Start">
                        <label  for="status2">  مستمر </label>
                      </div>
                      <div class="container-lable">
                        <input type="radio" id="status3" name="status" value="Finsh">
                        <label  for="status3">  انتهت </label>
                      </div>
                      <div class="container-lable">
                        <input type="radio" id="allstatus" name="status" value="all" checked>
                        <label for="allstatus"> الكل </label>
                      </div>
                    </div>
    
                    <div class="search-area p-20 mt-20 mb-20 bg-eee rad-10">
                      <div class="cont-search d-flex align-center block-mobile">
                          <span class="search-input p-relative block-mobile">
                            <input type="text" name="data" placeholder=" بحث عن دورة معينة من خلال " class="border-ccc">
                            <i class="fa-solid fa-magnifying-glass"></i>
                          </span>
                          <input type="submit" value="بحث" class="btn-shape bg-blue c-white block-mobile search-courses">
                      </div>
                    </div>
                  </form>
    
                  <div class="responsive-table mb-10 p-relative">
                    <table class="fs-15 w-full">
                      <thead>
                        <tr>
                          <td>العدد</td>
                          <td> الاسم </td>
                          <td> نوع الدورة </td>
                          <td> العنوان </td>
                          <td>السعر</td>
                          <td> الحالة </td>
                          <td>وقت البدء</td>
                          <td>وقت النهاية</td>
                          <td>تاريخ الإضافة</td>
                          <td> لوحة التحكم</td>
                        </tr>
                      </thead>
                      <tbody class="body-tabel-courses">
                        <?php
                          foreach ($rows as $row) {
                            echo '<tr class="p-relative">';
                              echo '<td class="nowrap"></td>';
                              echo '<td>'.$row['Name'].'</td>';
                              echo '<td>'.$row['category'].'</td>';
                              echo '<td>'.$row['Title'].'</td>';
                              echo '<td>'.$row['Price'].'</td>';
                              $date = date('Y-m-d');
                              echo '<td>'; if ($date < $row['Start']) { echo ' <span class="btn-shape bg-red c-white nowrap"> لم تبدأ </span> '; }elseif ($date >= $row['Start'] && $date <= $row['End']) {echo ' <span class="btn-shape bg-blue c-white nowrap"> مستمرة </span> ';}elseif($date > $row['End']) {echo '<span class="btn-shape bg-green c-white nowrap"> انتهت </span>';} echo'</td>';
                              echo '<td class="nowrap">'.$row['Start'].'</td>';
                              echo '<td class="nowrap">'.$row['End'].'</td>';
                              echo '<td class="nowrap">'.$row['Date'].'</td>';
                              echo '<td> 
                                <div>
                                  <button class="nowrap btn-shape bg-green m-5 c-white edite-course" data-ID="'.$row['UserID'].'"> تعديل </button>
                                  <button class="nowrap btn-shape bg-blue m-5 c-white view-course" data-ID="'.$row['UserID'].'"> عرض </button>
                                  <button class="nowrap btn-shape bg-blue m-5 c-white inable-course" data-ID="'.$row['UserID'].'">'; if ($row['Status'] == 1) {echo 'إخفاء';}else {echo 'إظهار';} echo '</button>
                                  <button class="nowrap btn-shape bg-red m-5 c-white delete-course" data-ID="'.$row['UserID'].'"> حذف </button>
                                </div>
                              </td>';
                            echo '</tr>';
                          }
                          if (getCount("courses", " WHERE TeacherID = ".$_SESSION['ID']) > $LIMIT) {
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
                            </tr> ';
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <button class="btn-shape bg-blue c-white button-popup">إضافة</button>
    
                  <div class="popup-add-course center-flex">
                    <div class="parent-popup border-ccc rad-10">
                      <div class="head-popup p-15 between-flex">
                        <span>أضف دورتك الجديدة الآن ...</span>
                        <i class="fa-solid fa-xmark"></i>
                      </div>
                      <div class="content-popup p-15">
                        <div class="parent-content-popup">
    
                          <div class="error c-red mb-15"></div>
                          <form action="" class="add-new-course-form">
                            <input type="hidden" name="action" value="addNewCourse">
                            <input type="hidden" name="userid">
                            <input type="hidden" name="teacherid" value="<?php echo $_SESSION['ID'];?>">
                            <div class="course txt-c bg-white rad-6 p-relative">
                              <div class="img-course">
                                <label for="imgCourse" class="p-relative"> 
                                  <span>صورة الدورة</span>
                                  <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <input type="file" id="imgCourse" name="imgcourse">
                                </label>
                                <?php
                                  if ($_SESSION['Avatar'] == '') {
                                    echo '<img src="'.$upload.'imags/Avatar/defaultImg.png" alt="" class="instructor">';
                                  }else {
                                    echo '<img src="'.$upload.'imags/Avatar/'.$_SESSION['Avatar'].'" alt="" class="instructor">';
                                  }
                                ?>
                              </div>
    
                              <div class="p-20">
                                <input type="text" maxlength="30" name="title" placeholder="اكتب العنوان هنا ...">
                                <div class="p-relative cont-textarea">
                                  <textarea name="describtion" maxlength="250" placeholder="اكتب الوصف هنا ..."></textarea>
                                  <span class="progress"></span>
                                  <span class="spanLength"></span>
                                </div>
                              </div>
                              <div class="info p-15 p-relative between-flex">
                                <span class="c-grey">
                                    <input type="number" name="price" placeholder="السعر">
                                    <i class="fa-solid fa-dollar-sign"></i>
                                </span>
                                <!-- <a href="" class="btn-shape bg-green c-white box"> اشترك الآن </a> -->
                                <span class="c-grey">
                                  عدد المشتركين
                                  <i class="fa-regular fa-user"></i>
                                </span>
                              </div>
    
                            </div>
                            <div class="more-details">
                              <h3 class="m-0 mb-10">المزيد من المعلومات</h3>
                                <input type="text" maxlength="30" name="name" placeholder="الاسم ...">
                                <label for="typeCourse">نوع الدورة</label>
                                <select id="typeCourse" name="typecourse">
                                  <?php 
                                  $stmt = $con->prepare("SELECT * FROM category");
                                  $stmt->execute();
                                  $categoris = $stmt->fetchAll();
                                  foreach($categoris as $category) {echo '<option value="'.$category['C_UserID'].'">'.$category['category'].'</option>';}
                                  ?>
                                </select>
                                <label for="start">يوم بداية الدورة</label>
                                <input type="date" id="start" name="start">
                                <label for="End">يوم نهاية الدورة</label>
                                <input type="date" id="End" name="end">
                              </div>
    
                            </div>
                          </form>
                          <div class="moredetails"></div>
    
                      </div>
    
                      <div class="buttons-popup p-15 pt-0">
                        <button class="action-course btn-shape bg-blue c-white d-block w-full">إضافة</button>
                      </div>
                    </div>
                  </div>
    
    
                </div>
            </div>
            <!-- End courses -->
    
            <script>
              let teacherid = '<?php echo $_SESSION['ID']; ?>';
            </script>
          <?php
          include $tpl . "footer.php"; 
        }
      }
    }
ob_end_flush();

?>