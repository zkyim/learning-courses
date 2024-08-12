<?php
    ob_start();
    session_start();
    session_regenerate_id();

    $linkCss = "quiz_app.css";
    $pageName = 'mytests';
    $linkjs = "quiz_app.js";
    $pageTitle = " اختبار ";
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
    
    if (isset($_GET['testID']) == false || empty($_GET['testID']) || isset($_GET['C']) == false || empty($_GET['C']) || $_GET['L'] == false || empty($_GET['L']) || $_GET['S'] == false || empty($_GET['S'])) {
      header('location: logout.php');
      exit();
    }else {
      ?>
        <!-- Start Quiz App -->
        <div class="pairent-container-test">
          <div class="container-test">
            <?php
              $stmt = $con->prepare("SELECT * FROM tests WHERE UserID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? LIMIT 1");
              $stmt->execute(array($_GET['testID'], $_GET['C'], $_GET['L'], $_GET['S']));
              $test = $stmt->fetch();
              if ($stmt->rowCount() == 0) {
                header('location: logout.php');
                exit();
              }else {
                ?>
                  <div class="countdown">
                    <div class="value-container"></div>
                    <svg>
                        <circle class="circle" cx="65" cy="65" r="55" strok-linecap="round" style="stroke-dashoffset: 0;"></circle>
                    </svg>
                  </div>
                  <ul>
                  </ul>
                  <div class="finish-test">
                    <button>إنهاء</button>
                  </div>
                  <script>
                    let fileNameJson = '<?php echo $upload.'json/'.$test['FileName'].'.json'; ?>';
                  </script>
                <?php
              }
              ?>
          </div>
        </div>
        <!-- End Quiz App -->
        <script src="<?php echo $Exitjs.'quiz_func.js'; ?>"></script>
        <script>
          let studentid = '<?php echo $_SESSION['ID']; ?>';
        </script>
      <?php
    }
    include $tpl . "footer.php"; 
ob_end_flush();
?>