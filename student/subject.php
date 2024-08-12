<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'courses';
    $linkjs = "";
    $pageTitle = " الأقسام ";
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
    if (isset($_GET['CourseID']) == false || empty($_GET['CourseID']) || $_GET['CourselevelID'] == false || empty($_GET['CourselevelID'])) {
        header('location: logout.php');
        exit();
    }else {
        ?>
            <!-- Start courses -->
            <div class="courses">
            <h1 class="p-relative">الأقسام</h1>
            <div class="my-courses w-full m-20 gap-20 bg-white rad-10 p-20">
                <h2 class="mt-0 mb-10">الأقسام</h2>
                <p class="c-grey"> أقسام الدورة . </p> 

                <div class="search-area">
                </div>
                <div class="courses-page d-grid m-20 gap-20">
                <?php
                    $date = date("Y-m-d");
                    $stmt = $con->prepare("SELECT * FROM subjects WHERE CourseID = ? AND LevelID = ?");
                    $stmt->execute(array($_GET['CourseID'], $_GET['CourselevelID']));
                    $subjects = $stmt->fetchAll();
                    if ($stmt->rowCount() == 0) {
                      header('location: logout.php');
                      exit();
                    }else {
                        foreach ($subjects as $subject) {
                            ?>
                                <a href="coursecontent.php?CourseID=<?php echo $_GET['CourseID']; ?>&CourselevelID=<?php echo $_GET['CourselevelID'];?>&SubjectID=<?php echo $subject['UserID']; ?>">
                                    <div class="course txt-c bg-white rad-6 p-relative">
                                        <img class="cover" src="<?php echo $upload.'imags/imgcourses/'.$subject['ImgSubject']; ?>" alt="" />
                                        <div class="p-20 center-flex">
                                            <h4 class="m-0 c-black fill"> <?php echo $subject['Name']; ?> </h4>
                                        </div>
                                    </div>
                                </a>
                            <?php
                        
                        }
                    }
                ?>
                </div>
            </div>
            </div>
            <!-- End courses -->
            <script>
                let studentid = '<?php echo $_SESSION['ID']; ?>';
            </script>
        <?php
    }
    include $tpl . "footer.php"; 
ob_end_flush();
?>