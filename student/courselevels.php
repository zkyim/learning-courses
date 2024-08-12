<?php
    ob_start();
    session_start();
    session_regenerate_id();

    // $linkCss = ".css";
    $pageName = 'courses';
    $linkjs = "";
    $pageTitle = " المستويات ";
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
    if (isset($_GET['UserID']) == false && empty($_GET['UserID'])) {
        header('location: logout.php');
        exit();
    }else {
        ?>
            <!-- Start courses -->
            <div class="courses">
            <h1 class="p-relative">المستويات</h1>
            <div class="my-courses w-full m-20 gap-20 bg-white rad-10 p-20">
                <h2 class="mt-0 mb-10">المستويات</h2>
                <p class="c-grey"> مستويات الدورة . </p> 

                <div class="search-area">
                </div>
                <div class="courses-page d-grid m-20 gap-20">
                <?php
                    $date = date("Y-m-d");
                    $stmt = $con->prepare("SELECT * FROM courselevels WHERE CourseID = ?");
                    $stmt->execute(array($_GET['UserID']));
                    $courselevels = $stmt->fetchAll();
                    $stmt = $con->prepare("SELECT * FROM courses WHERE UserID = ?");
                    $stmt->execute(array($_GET['UserID']));
                    $cours = $stmt->fetchAll();
                    if ($stmt->rowCount() == 0) {
                        header('location: logout.php');
                        exit();
                    }else {
                        foreach ($courselevels as $courselevel) {
                            ?>
                                <a href="subject.php?CourseID=<?php echo $_GET['UserID']; ?>&CourselevelID=<?php echo $courselevel['UserID'];?>">
                                    <div class="course txt-c bg-white rad-6 p-relative">
                                        <img class="cover" src="<?php echo $upload.'imags/imgcourses/'.$courselevel['ImgLevel']; ?>" alt="" />
                                        <div class="p-20 center-flex">
                                            <h4 class="m-0 c-black fill"> <?php echo $courselevel['Name']; ?> </h4>
                                        </div>
                                        <!-- <div class="info p-15 p-relative between-flex">
                                            <span class="c-grey">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                            <?php echo $course['Price']; ?>
                                            </span>
                                            <?php
                                            if ($inActiveOrder == true) {
                                                echo '<button class="btn-shape bg-red c-white box"> تحت الطلب </button>';
                                            }elseif ($activeOrder == true) {
                                                echo '<button class="btn-shape bg-blue c-white box"> تم الإشتراك </button>';
                                            }else {
                                                echo '<a href="infocourse.php?UserID='.$course['UserID_Course'].'" class="btn-shape bg-green c-white box"> اشترك الآن </a>';
                                            } 
                                            ?>
                                            <span class="c-grey">
                                            <i class="fa-regular fa-user"></i>
                                            <?php echo $total_subscirberes; ?>
                                            </span>
                                        </div> -->
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