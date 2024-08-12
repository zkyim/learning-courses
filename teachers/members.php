<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $linkjs = "action_members.js";
    $pageName = 'members';
    $pageTitle = " الأعضاء ";

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
              $From_To = " AND O_Date <= '$date_to' AND Date >= '$date_from' ";
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
            <!-- Start Members -->
            <div class="members">
                <h1 class="p-relative">الأعضاء</h1>
    
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
                      <div class="content"><div class="c-grey">الأعضاء المفعلة : </div><div class="num"><?php echo getCount("orders", "WHERE O_TeacherID = ".$ID." AND O_RegStatus = 1 $From_To"); ?></div></div>
                      <div class="icon"><i class="fa-solid fa-users"></i></div>
                    </li>
                  </ul>
                </div>
    
                <div class="table p-20 m-20 rad-10 bg-white">
    
    
                  <form action="" class="search-members-form">
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="teacherid" value="<?php echo $ID;?>">
                    <input type="hidden" name="From_To" value="<?php echo $From_To; ?>">
                    <div class="option d-flex  block-mobile">
                      <?php
                      $date = date("Y-m-d");
                      $stmt = $con->prepare("SELECT * FROM courses WHERE TeacherID = ? AND End >= '$date' AND Start <= '$date'");
                      $stmt->execute(array($ID));
                      $courses = $stmt->fetchAll();
                      $contRowscourses = $stmt->rowCount();
                      foreach($courses as $course) {
                        $rand = rand(0, 10000);
                        echo '<div class="container-lable">';
                          echo '<input type="radio" id="'.$rand.'" name="courseid" value="'.$course['UserID'].'">';
                          echo '<label for="'.$rand.'"> '. $course['Name'] .' </label>';
                        echo '</div>';
                      }
                      if ($contRowscourses > 0) {
                      ?>
                      <div class="container-lable">
                        <input type="radio" id="allMembersCourse" name="courseid" value="all" checked>
                        <label for="allMembersCourse"> الكل </label>
                      </div>
                      <?php } ?>
                    </div>
                    <?php if ($contRowscourses > 0) { ?>
                    <div class="option option2 d-flex  block-mobile">
                      <div class="container-lable">
                        <input type="radio" id="pendingMember" name="membersstatus" value="pending" checked>
                        <label for="pendingMember"> الأعضاء الخاملة </label>
                      </div>
                      <div class="container-lable">
                        <input type="radio" id="activeMember" name="membersstatus" value="active">
                        <label for="activeMember"> الأعضاء المفعلة </label>
                      </div>
                      <div class="container-lable">
                        <input type="radio" id="allMember" name="membersstatus" value="all">
                        <label for="allMember"> الكل </label>
                      </div>
                    </div>
    
                    <div class="search-area p-20 mt-20 mb-20 bg-eee rad-10">
                      <div class="cont-search d-flex align-center block-mobile">
                          <span class="search-input p-relative block-mobile">
                            <input type="text" name="data" placeholder=" بحث عن طالب معين من خلال الاسم الأول أو الاسم الثاني أو البريد الالكتروني" class="border-ccc">
                            <i class="fa-solid fa-magnifying-glass"></i>
                          </span>
                          <input type="submit" value="بحث" class="btn-shape bg-blue c-white block-mobile search-courses">
                      </div>
                    </div>
                  </form>
    
                  <div class="responsive-table p-relative">
                    <?php
                    $stmt = $con->prepare("SELECT * FROM orders JOIN userss ON orders.O_StudentID = userss.UserID WHERE O_TeacherID = ? AND O_RegStatus = 0 $From_To ORDER BY `orders`.`O_UserID` ASC LIMIT $LIMIT");
                    $stmt->execute(array($ID));
                    $coulms = $stmt->fetchAll();
                    ?>
                    <table class="fs-15 w-full">
                      <thead>
                        <tr>
                          <td>العدد</td>
                          <td> الاسم الأول </td>
                          <td> الاسم الثاني </td>
                          <td> البريد الإلكتروني </td>
                          <td>الحالة</td>
                          <td> تاريخ الطلب </td>
                          <td> لوحة التحكم </td>
                        </tr>
                      </thead>
                      <tbody class="body-tabel-members">
                        <?php
                          if ($stmt->rowCount() > 0) {
                            foreach ($coulms as $coulm) {
                              echo '<tr class="p-relative">';
                                echo '<td class="nowrap"></td>';
                                echo '<td class="nowrap">'.$coulm['FName'].'</td>';
                                echo '<td class="nowrap">'.$coulm['SName'].'</td>';
                                echo '<td class="nowrap">'.$coulm['Email'].'</td>';
                                echo '<td class="nowrap">'; if ($coulm['O_RegStatus'] == 0) {echo'<span class="label btn-shape bg-red c-white status"> خامل </span>';}else {echo'<span class="label btn-shape bg-green c-white status"> فعال </span>';} echo '</td>';
                                echo '<td class="nowrap">'.$coulm['O_Date'].'</td>';
                                echo '<td>'; 
                                  echo '<div>'; 
                                  if ($coulm['O_RegStatus'] == 0) {
                                    echo '<button class="btn-shape c-white bg-green m-5 inable-member" data-id="'.$coulm['UserID'].'">تفعيل</button>';
                                  }
                                  if ($coulm['O_RegStatus'] == 1) {
                                    echo '<button class="btn-shape c-white bg-red m-5 inable-member" data-id="'.$coulm['UserID'].'">تعطيل</button>'; 
                                  }
                                    echo '<button class="btn-shape c-white bg-blue m-5 view-member" data-id="'.$coulm['UserID'].'">عرض</button>';  
                                  echo '</div>'; 
                                echo '</td>';
                              echo '</tr>';
                            }
                          }
                          if (getCount("courses", " WHERE TeacherID = ".$ID) > $LIMIT) {
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
                        ?>
                      </tbody>
                    </table>
                    <?php
                    if ($stmt->rowCount() == 0) {
                        echo '<h3 class="c-red nowrap"> لم يتم التقديم على أي طلب لدوراتك </h3>';
                    }
                    ?>
                  </div>
                  <?php } else {echo '<h2 class="c-rec"> يجب عرض دورة أولا . </h2>';} ?>
    
    
                  <div class="popup center-flex">
                    <div class="parent-popup border-ccc rad-10">
                      <div class="head-popup p-15 between-flex">
                        <span> معلومات أكثر عن العضو </span>
                        <i class="fa-solid fa-xmark"></i>
                      </div>
                      <div class="content-popup p-15">
    
                        <div class="active-member">
                          <div class="c-red p-10 text-c error">  </div>
                          <!-- <div class="txt-c p-20 img-box">
                            <img src=" < echo $upload; > imags/Avatar/defaultImg.png" alt="">
                          </div> -->
                          <form action="#" class="chainge-status-form">
                            <div class="p-15">
                              <input type="text" class="border-ccc p-10 rad-6 w-full mb-10" placeholder="الرقم التسلسلي ...">
                              <input type="number" class="border-ccc p-10 rad-6 w-full" placeholder="الملغ المدفوع">
                            </div>
                            <div class="buttons-popup p-15 pt-0">
                              <button class="btn-shape bg-blue c-white d-block w-full active-button"> تغيير </button>
                            </div>
                          </form>
                        </div>
                        <div class="moredetails">
                        </div>
    
                      </div>
                    </div>
                  </div>
    
    
    
    
                </div>
            </div>
            <!-- End Members -->
            <script> let teacherid = '<?php echo $ID; ?>'; </script>
          <?php
          include $tpl . "footer.php"; 
        }
      }
    }
  ob_end_flush();

?>