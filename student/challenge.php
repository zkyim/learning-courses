<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'challenge';
    $linkjs = "";
    $pageTitle = " التحديات ";
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
      <!-- Start challenge -->
      <div class="chalenge">
        <h1 class="p-relative">التحديات</h1>
        <div class="bg-white p-20 m-20 rad-10">
          <a href="" class="between-flex rad-10">
            <div class="title"> التحدي الأول </div>
            <div class="icon">
              <span>
                <span class=""> 100 سؤال </span>
                <span class=""> 100 دقيقة </span>
              </span>
              <span>
                <span class="">  من الساعة 3 </span>
                <span class=""> إلى الساعة 4 </span>
              </span>
              <i class="fas fa-unlock fa-fw"></i>
            </div>
          </a>
          <a href="" class="between-flex rad-10">
            <div class="title"> التحدي الأول </div>
            <div class="icon">
              <span>
                <span class=""> 100 سؤال </span>
                <span class=""> 100 دقيقة </span>
              </span>
              <span>
                <span class="">  من الساعة 3 </span>
                <span class=""> إلى الساعة 4 </span>
              </span>
              <i class="fas fa-unlock fa-fw"></i>
            </div>
          </a>
        </div>

      </div>
      <!-- End challenge -->
      <script>
        let studentid = '<?php echo $_SESSION['ID']; ?>';
      </script>
    <?php
    include $tpl . "footer.php"; 
ob_end_flush();

?>