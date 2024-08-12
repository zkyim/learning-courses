<?php
  ob_start();
  session_start();
  session_regenerate_id();

  // $linkCss = ".css";
  $linkjs = "action_myaccount.js";
  $pageName = 'myaccount';
  $pageTitle = " حسابي ";

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
        ?>
          <!-- Start my-account -->
          <div class="my-account">
              <h1 class="p-relative">حسابي</h1>
              <div class="profile-page m-20">
                <!-- Start Overview -->
                <div class="overview bg-white rad-10 d-flex align-center">
                  <div class="avatar-box txt-c p-20">
                    <!-- <img class="rad-half mb-10" src="../members/upload/imags/Avatar/avatar.png" alt="" /> -->
                    <?php 
                      if ($_SESSION['Avatar'] == '') {
                          echo '<img class="rad-half mb-10" src="'.$upload.'imags/Avatar/defaultImg.png" alt="">';
                      }else {
                          echo '<img class="rad-half mb-10" src="'.$upload.'imags/Avatar/'.$_SESSION['Avatar'].'" alt="">';
                      }
                    ?>
                    <h3 class="m-0"> <?php echo $infoUser['FName'] . ' ' . $infoUser['SName']; ?> </h3>
                    <!-- <p class="c-grey mt-10">Level 20</p> -->
                    <!-- <div class="level rad-6 bg-eee p-relative">
                      <span style="width: 70%"></span>
                    </div> -->
                    <div class="rating mt-10 mb-10">
                      <i class="fa-solid fa-star c-orange fs-13"></i>
                      <i class="fa-solid fa-star c-orange fs-13"></i>
                      <i class="fa-solid fa-star c-orange fs-13"></i>
                      <i class="fa-solid fa-star c-orange fs-13"></i>
                      <i class="fa-solid fa-star-half-stroke fa-flip-horizontal c-orange fs-13"></i>
                    </div>
                    <p class="c-grey m-0 fs-13">550 Rating</p>
                  </div>
                  <div class="info-box w-full txt-c-mobile">
                    <!-- Start Information Row -->
                    <div class="box p-20 d-flex align-center">
                      <h4 class="c-grey fs-15 m-0 w-full"> معلومات عامة </h4>
                      <div class="fs-14">
                        <span class="c-grey"> البريد الإلكتروني : </span>
                        <span> <?php echo $infoUser['Email']; ?> </span>
                      </div>
                      <div class="fs-14">
                        <span class="c-grey">الإسم : </span>
                        <span> <?php echo $infoUser['FName'] . ' ' . $infoUser['SName']; ?> </span>
                      </div>
                      <div class="fs-14">
                        <span class="c-grey">رقم الهاتف : </span>
                        <span> <?php echo $infoUser['PhoneNumber']; ?> </span>
                      </div>
                      <div class="fs-14">
                        <span class="c-grey"> الجنس :  </span>
                        <span> <?php if ($infoUser['Sex'] == 'man') {echo 'ذكر';}else {echo 'أنثى';} ?> </span>
                      </div>
                    </div>
                    <!-- End Information Row -->
                    <!-- Start Information Row -->
                    <div class="box p-20 d-flex align-center">
                      <h4 class="c-grey w-full fs-15 m-0"> مواقع التواصل الإجتماعي </h4>
                      <div class="fs-14">
                        <span class="c-grey"> تويتر : </span>
                        <span> <?php if (empty($infoUser['Twitter'])) {echo 'لا يوجد';}else {echo $infoUser['Twitter']; }?> </span>
                      </div>
                      <div class="fs-14">
                        <span class="c-grey"> فيس بوك : </span>
                        <span> <?php if (empty($infoUser['Facebook'])) {echo 'لا يوجد';}else {echo $infoUser['Facebook']; }?> </span>
                      </div>
                      <div class="fs-14">
                        <span class="c-grey"> ليكندإن : </span>
                        <span> <?php if (empty($infoUser['Linkedin'])) {echo 'لا يوجد';}else {echo $infoUser['Linkedin']; }?> </span>
                      </div>
                      <div class="fs-14">
                        <span class="c-grey"> يوتيوب : </span>
                        <span> <?php if (empty($infoUser['Youtube'])) {echo 'لا يوجد';}else {echo $infoUser['Youtube']; }?> </span>
                      </div>
                    </div>
                    <!-- End Information Row -->
                    <!-- Start Information Row -->
                    <div class="box p-20 d-flex align-center">
                        <h4 class="c-grey w-full fs-15 m-0"> معلومات شخصية </h4>
                      <div class="fs-14 d-flex align-center">
                        <span class="c-grey"> إظهار :  </span>
                        
                        <label class="small">
                          <input class="toggle-checkbox small" type="checkbox" <?php if ($infoUser['PersonalInfo'] == 1) {echo 'checked';} ?> />
                          <div class="toggle-switch PersonalInfo small"></div>
                        </label>
                      </div>
                    </div>
                    <!-- End Information Row -->
                  </div>
                </div>
                <!-- End Overview -->
              </div>
          </div>
          <!-- End my-account -->
          <script>
            let id = '<?php echo $ID; ?>';
          </script>
        <?php
        include $tpl . "footer.php";
      }
    }
  }
  ob_end_flush();

?>