<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'settings';
    $linkjs = "";
    $pageTitle = "الإعدادات";
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
    function setColorActive ($color='#2196f3') {
      if (isset($_COOKIE['style']['maincolor']) && $color == $_COOKIE['style']['maincolor']) {
        echo 'active';
      }elseif (isset($_COOKIE['style']['maincolor']) == false && $color == '#2196f3') {echo 'active';}
    }
    ?>
        <!-- Start settings -->
        <div class="settings">
          <h1 class="p-relative">الإعدادات</h1>
          <div class="settings-page m-20 d-grid gap-20">
            <!-- Start Settings Box -->
            <div class="p-20 bg-white rad-10 info-user">
              <form action="#">
                <h2 class="mt-0 mb-10">معلومات عامة</h2>
                <p class="mt-0 mb-20 c-grey fs-15"> معلومات عامة عن حسابك . </p>
                <div class="error-info-user" style="color: var(--red-color);"></div>
                <div class="container-img w-full mb-20" >
                  <div class="pairent-img w-fit p-relative">
                    <input type="hidden" name="action" value="updateInfoUser">
                    <input type="hidden" name="idUser" value="<?php echo $_SESSION['ID']; ?>">
                    <?php
                      if ($_SESSION['Avatar'] == '') {
                        echo '<img src="'.$upload.'imags/Avatar/defaultImg.png" alt="" class="rad-half avatar-img">';
                      }else {
                          echo '<img src="'.$upload.'imags/Avatar/'.$_SESSION['Avatar'].'" alt="" class="rad-half avatar-img">';
                      }
                    ?>
                    <label class="upload-img bg-blue center-flex" for="avatar">
                      <i class="fa-solid fa-upload fa-fw c-white"></i>
                    </label>
                    <input type="file" name="avatar" id="avatar" style="display: none;" class="input-avatar">
                  </div>
                </div>
                <div class="d-flex block-mobile gap-20">
                  <div class="mb-15 w-full">
                    <input class="b-none border-ccc p-10 rad-6 d-block w-full" type="text" name="FName" placeholder="الاسم الأول" value="<?php if ($infoUser == '') {echo 'الاسم الأول ...';}else {echo $infoUser['FName'];} ?>"/>
                  </div>
                  <div class="mb-15 w-full">
                    <input class="b-none border-ccc p-10 rad-6 d-block w-full" type="text" name="SName" placeholder="إسم الأب" value="<?php if ($infoUser == '') {echo 'الاسم الثاني ...';}else {echo $infoUser['SName'];} ?>"/>
                  </div>
                </div>
                <div class="mb-15">
                  <input class="b-none border-ccc p-10 rad-6 d-block w-full" type="email" name="Email" placeholder="البريد الإلكتروني" value="<?php if ($infoUser == '') {echo 'example@gmail.com';}else {echo $infoUser['Email'];} ?>"/>
                </div>
                <div class="mb-15">
                  <input class="b-none border-ccc p-10 rad-6 d-block w-full" type="number" name="phoneNumber" placeholder="رقم الهاتف" value="<?php if ($infoUser == '') {echo '0500000000';}else {echo $infoUser['PhoneNumber'];} ?>"/>
                </div>
                <button class="btn-shape bg-blue c-white update-date">تعديل</button>
              </form>
            </div>
            <!-- End Settings Box -->
            <!-- Start Settings Box -->
            <div class="social-boxes p-20 bg-white rad-10">
              <h2 class="mt-0 mb-10"> مواقع التواصل الإجتماعي </h2>
              <p class="mt-0 mb-20 c-grey fs-15"> مواقع التواصل الإجتماعي الخاصة بك . </p>
              <form>
                <input type="hidden" name="action" value="updateSocial">
                <input type="hidden" name="idUser" value="<?php echo $ID; ?>">
                <div class="d-flex align-center mb-15">
                  <i class="fa-brands fa-twitter center-flex c-grey"></i>
                  <input class="w-full" name="twitter" type="url" placeholder="رابط تويتر" value="<?php if ($infoUser == '') {echo 'رابط تويتر ...';}else {echo $infoUser['Twitter'];} ?>"/>
                </div>
                <div class="d-flex align-center mb-15">
                  <i class="fa-brands fa-facebook-f center-flex c-grey"></i>
                  <input class="w-full" name="facebook" type="url" placeholder="رابط فيس بوك" value="<?php if ($infoUser == '') {echo 'رابط فيس بوك ...';}else {echo $infoUser['Facebook'];} ?>" />
                </div>
                <div class="d-flex align-center mb-15">
                  <i class="fa-brands fa-linkedin center-flex c-grey"></i>
                  <input class="w-full" name="linkedin" type="url" placeholder="رابط لينكد إن" value="<?php if ($infoUser == '') {echo 'رابط لينكد إن ...';}else {echo $infoUser['Linkedin'];} ?>" />
                </div>
                <div class="d-flex align-center mb-15">
                  <i class="fa-brands fa-youtube center-flex c-grey"></i>
                  <input class="w-full" name="youtube" type="url" placeholder="رابط اليوتيوب" value="<?php if ($infoUser == '') {echo 'رابط اليوتيوب ...';}else {echo $infoUser['Youtube'];} ?>" />
                </div>
                <button class="btn-shape bg-blue c-white update-social">تعديل</button>
              </form>
            </div>
            <!-- End Settings Box -->
            <!-- Start Settings Box -->
            <div class="p-20 bg-white rad-10">
              <h2 class="mt-0 mb-10">معلومات الأمان</h2>
              <p class="mt-0 mb-20 c-grey fs-15"> معلومات الأمان الخاصة بحسابك . </p>
              <div class="sec-box mb-15 between-flex">
                  <div>
                      <span>كلمة السر</span>
                      <p class="c-grey mt-5 mb-0 fs-13"> <?php if ($infoUser == '') {echo 'تاريخ تعديل كلمة السر ...';} else {if ($infoUser['LastChahgePassDate'] == '0000-00-00') {echo 'لم تقم بتعديل كلمة السر منذ إنشاء الحساب.';}else {echo 'آخر تعديل كان في '.$infoUser['LastChahgePassDate'].'';}} ?></p>
                    </div>
                    <button class="button bg-blue c-white btn-shape update-pass-but">تعديل</button>
                </div>
            </div>

            <div class="popup center-flex">
              <div class="parent-popup border-ccc rad-10">
                <div class="head-popup p-15 between-flex">
                  <span> تغيير كلمة السر </span>
                  <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="content-popup p-15">
                  <div class="mb-10 popup-error-pass" style="color: var(--red-color);"></div>
                  <input class="b-none border-ccc p-10 mb-10 rad-6 d-block w-full password" type="password" name="oldpass" placeholder="كلمة السر القديمة">
                  <input class="b-none border-ccc p-10 mb-10 rad-6 d-block w-full password" type="text" name="newpass" placeholder="كلمة السر الجديدة">
                  <input class="b-none border-ccc p-10 rad-6 d-block w-full password" type="password" name="confirmpass" placeholder="تأكيد كلمة السر الجديدة">
                      
                  <div class="buttons-popup p-15 pt-0">
                    <button class="btn-shape bg-blue c-white d-block w-full change-pass-but"> تغيير </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Settings Box -->

            <!-- Start Settings Box -->
            <div class="p-20 bg-white rad-10 design-web">
              <h2 class="mt-0 mb-5"> أشكال الموقع </h2>
              <p class="mt-0 mb-20 c-grey fs-15">  أشكال متعددة للموقع تتيح لك إستخدام أفضل ومريح . </p>
              <div class="sec-box lightAdark mb-15 between-flex m-5">
                <div>
                  <span> مضيء | معتم </span>
                  <label class="small">
                    <input class="toggle-checkbox small" type="checkbox">
                    <div class="toggle-switch PersonalInfo small"></div>
                  </label>
                </div>
              </div>
              <div class="sec-box colors mb-15 between-flex m-5">
                <div>
                  <div> الألوان </div>
                  <div class="m-5 mt-10">
                    <span class="color <?php setColorActive('#2196f3');?>" style="background-color: #2196f3;" data-maincolor="#2196f3" data-maincoloralt="#cbe8ffeb"></span>
                    <span class="color <?php setColorActive('#22c55e');?>" style="background-color: #22c55e;" data-maincolor="#22c55e" data-maincoloralt="#91ffba82"></span>
                    <span class="color <?php setColorActive('#f44336');?>" style="background-color: #f44336;" data-maincolor="#f44336" data-maincoloralt="#fb594d69"></span>
                    <span class="color <?php setColorActive('#f59e0b');?>" style="background-color: #f59e0b;" data-maincolor="#f59e0b" data-maincoloralt="#f5af355e"></span>
                    <span class="color <?php setColorActive('#f94180');?>" style="background-color: #f94180;" data-maincolor="#f94180" data-maincoloralt="#ff669aa3"></span>
                  </div>
                </div>
              </div>
              <div class="sec-box links mb-15 m-5">
                <div>
                  <div> شكل الروابط </div>
                  <div class="m-5 mt-10 between-flex con-links">
                    <input id="link1" name="links" type="radio" value="sidebar" <?php if(isset($_COOKIE['style']['designlinks'])&&$_COOKIE['style']['designlinks']=='sidelinks'){echo'checked';}elseif(isset($_COOKIE['style']['designlinks'])==false){echo'checked';} ?>>
                    <label for="link1" data-designlinks="sidelinks">
                      <i class="fa-regular fa-chart-bar fa-fw mb-10"></i>
                      <span> روابط جانبية </span>
                    </label>
                    <input id="link2" name="links" type="radio" value="sidebar-top" <?php if(isset($_COOKIE['style']['designlinks'])&&$_COOKIE['style']['designlinks']=='toplinks'){echo'checked';}?>>
                    <label for="link2" data-designlinks="toplinks">
                      <i class="fa-regular fa-chart-bar fa-fw mb-10"></i>
                      <span> روابط علوية </span>
                    </label>
                    <input id="link3" name="links" type="radio" value="sidebar-hide" <?php if(isset($_COOKIE['style']['designlinks'])&&$_COOKIE['style']['designlinks']=='hidelinks'){echo'checked';}?>>
                    <label for="link3" data-designlinks="hidelinks">
                      <i class="fa-regular fa-chart-bar fa-fw mb-10"></i>
                      <span> روابط مخفية </span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <!-- End Settings Box -->

          </div>
          
        </div>
        <!-- End settings -->
        <?php if (!empty($infoUser)) { ?>
          <script src="<?php echo $js; ?>action_settings.js"></script>
        <?php } ?>
        <script src="<?php echo $js; ?>settings.js"></script>
        <script>
         let studentid = '<?php echo $_SESSION['ID']; ?>';
        </script>
    <?php
    include $tpl . "footer.php"; 
  ob_end_flush();
?>