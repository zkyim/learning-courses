<?php 
    $HTTP = explode('/', $_SERVER['PHP_SELF']);
    $HTTP = end($HTTP);

    $css = 'layout/css/';
    function setActive ($name='home') {
      global $pageName;
      if (isset($pageName) && $pageName == $name) {echo 'active';}
    }
?>

<!DOCTYPE html>
    <?php 
    if (isset($_COOKIE['style']['maincolor']) && isset($_COOKIE['style']['maincoloralt'])) {
        echo '<html lang="en" style="--main-color:'.$_COOKIE['style']['maincolor'].';--main-color-alt:'.$_COOKIE['style']['maincoloralt'].';">';
    }else {
        echo '<html lang="en">';
    }
    ?>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title> <?php echo GetTitle(); ?> </title>

    <link rel="stylesheet" href="layout/css/all.min.css" />
    <link rel="stylesheet" href="layout/css/framework.css" />
    <link rel="stylesheet" href="layout/css/master.css" />
    <link rel="stylesheet" href="<?php echo $css; echo GetLinkCss();?>">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="page d-flex">
      <div class="sidebar bg-white p-20 p-relative <?php if (isset($_COOKIE['style']['designlinks'])) {if($_COOKIE['style']['designlinks']=='hidelinks'){echo'hide';}elseif($_COOKIE['style']['designlinks']!='sidelinks'){echo 'close';}} ?>">
            <div class="open-icon">
              <i class="fa-solid fa-bars fa-fw"></i>
            </div>
        <h3 class="p-relative txt-c mt-0">مستقبلك</h3>
        <ul>
          <a href="dashboard.php">
            <li class="<?php setActive ('dashboard') ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-chart-bar fa-fw"></i>
              <span>لوحة التحكم</span>
            </li>
          </a>
          <a href="myaccount.php">
            <li  class="<?php setActive ('myaccount') ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-user fa-fw"></i>
              <span>حسابي</span>
            </li>
          </a>
          <a href="mytests.php">
            <li  class="<?php setActive ('mytests') ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-rectangle-list fa-fw"></i>
              <span>إختباراتي</span>
            </li>
          </a>
          <a href="mynotes.php">
            <li  class="<?php setActive ('mynotes') ?> d-flex align-center fs-14 c-black rad-6 p-10">
            <i class="fa-regular fa-credit-card fa-fw"></i>
              <span>ملاحظاتي</span>
            </li>
          </a>
          <a href="challenge.php" >
            <li class="<?php setActive ('challenge') ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-diagram-project fa-fw"></i>
              <span>التحديات</span>
            </li>
          </a>
          <a href="courses.php" >
            <li class="<?php setActive ('courses') ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-graduation-cap fa-fw"></i>
              <span>الدورات</span>
            </li>
          </a>
          <a href="settings.php">
            <li class="<?php setActive ('settings') ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-gear fa-fw"></i>
              <span>الإعدادات</span>
            </li>
          </a>
          <a href="aboutus.php">
            <li class="<?php setActive () ?> d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-address-card fa-fw"></i>
              <span>لمحة عنا</span>
            </li>
          </a>

        </ul>
      </div>
      <div class="content w-full">
        <!-- Start Head -->
        <div class="head bg-white p-15 between-flex">
          <!-- if top-head colse add close class -->
          <div class="top-head <?php if (isset($_COOKIE['style']['designlinks'])){if($_COOKIE['style']['designlinks']!='toplinks'){echo'close';}}else{echo'close';} ?>">
            <h3 class="p-relative txt-c mt-0">مستقبلك</h3>
            <ul>
              <a href="dashboard.php">
                <li class="<?php setActive ('dashboard') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-regular fa-chart-bar fa-fw"></i>
                  <span>لوحة التحكم</span>
                </li>
              </a>
              <a href="myaccount.php">
                <li  class="<?php setActive ('myaccount') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-regular fa-user fa-fw"></i>
                  <span>حسابي</span>
                </li>
              </a>
              <a href="mytests.php">
                <li  class="<?php setActive ('mytests') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-regular fa-rectangle-list fa-fw"></i>
                  <span>إختباراتي</span>
                </li>
              </a>
              <a href="mynotes.php">
                <li  class="<?php setActive ('mynotes') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                <i class="fa-regular fa-credit-card fa-fw"></i>
                  <span>ملاحظاتي</span>
                </li>
              </a>
              <a href="challenge.php" >
                <li class="<?php setActive ('challenge') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-solid fa-diagram-project fa-fw"></i>
                  <span>التحديات</span>
                </li>
              </a>
              <a href="courses.php" >
                <li class="<?php setActive ('courses') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-solid fa-graduation-cap fa-fw"></i>
                  <span>الدورات</span>
                </li>
              </a>
              <a href="settings.php">
                <li class="<?php setActive ('settings') ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-solid fa-gear fa-fw"></i>
                  <span>الإعدادات</span>
                </li>
              </a>
              <a href="aboutus.php">
                <li class="<?php setActive () ?> d-flex align-center fs-14 c-black rad-6 p-10">
                  <i class="fa-regular fa-address-card fa-fw"></i>
                  <span>لمحة عنا</span>
                </li>
              </a>

            </ul>
          </div>
          <div class="icons d-flex align-center">
            <?php 
            if ($_SESSION['Avatar'] == '') {
                echo '<img src="'.$upload.'imags/Avatar/defaultImg.png" alt="">';
            }else {
                echo '<img src="'.$upload.'imags/Avatar/'.$_SESSION['Avatar'].'" alt="">';
            }
            ?>
          </div>

        </div>
        <!-- Start CheckOnline -->
        <div class="check-online"></div>
        <!-- End CheckOnline -->
        <!-- Start Notifications -->
        <ul class="notifications"></ul>
        <!-- End Notifications -->
        
        <!-- End Head -->

        <div class="container-content">