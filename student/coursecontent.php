<?php
    ob_start();
    session_start();
    session_regenerate_id();

    $linkCss = "coursecontent.css";
    $pageName = 'courses';
    $linkjs = "coursecontent.js";
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
    if (isset($_GET['CourseID']) == false || empty($_GET['CourseID']) || $_GET['CourselevelID'] == false || empty($_GET['CourselevelID']) || $_GET['SubjectID'] == false || empty($_GET['SubjectID'])) {
        header('location: logout.php');
        exit();
    }else {
        ?>
            <!-- Start courses -->
            <div class="courses">
              <h1 class="p-relative"> المحتوى </h1>
              <div class="my-courses w-full m-20 gap-20 bg-white rad-10 p-20">
                  <h2 class="mt-0 mb-10">المحتوى</h2>
                  <p class="c-grey">  محتوى الدورة من هذا القسم . </p> 
                  <?php
                    function createLTFNU () {
                        global $con;
                        global $upload;
                        // $defultQulity = '360';
                        // echo '<div class="mainvideo" dir="ltr">';
                        //   echo '<h3> مقدمة محوسب</h3>';
                        //   echo '<div class="introvideo" style="position: relative;">';
                        //     echo '<video class="infovideo" controlslist="nodownload" controls preload="metadata">';
                        //       echo ' <source src="">';
                        //     echo ' </video>';
                        //     echo '<div class="qulity-selector">';
                        //       echo '<i class="fa-solid fa-gear"></i>';
                        //       echo '<div class="menu-qulity">';
                        //         echo '<div onclick="deffrint_qulity (this)" data-src="">';
                        //           echo '<sup style="color:red;"> HD </sup>1080pp';
                        //         echo '</div>';
                        //       echo '</div>';
                        //     echo '</div>';
                        //   echo '</div>';
                        //   echo '<iframe width="100%" height="100%" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        // echo '</div>';

                        // echo '<div class="cont-buy"> <a href=tel:"" class="a"> <span class="buy"> اشترك الآن </span> </a> واحصل على مميزات الدورة  <i class="fa-solid fa-cart-shopping"></i> </div>';
                        if ($_SESSION['ID'] != 'vistor') {
                          $stmt = $con->prepare("SELECT O_CourseID, O_RegStatus FROM orders WHERE O_StudentID = ? AND O_CourseID = ? LIMIT 1");
                          $stmt->execute(array($_SESSION['ID'], $_GET['CourseID']));
                          $Order = $stmt->fetch();
                        }
                        
                        echo '<div class="containertabs">';

                          echo '<ul class="tabs">';
                            echo '<li class="active" data-cont=".one" id="thelesones">الدروس</li>';
                            echo '<li data-cont=".two" id="thetestes">الإختبارات</li>';
                            echo '<li data-cont=".three">الملفات</li>';
                            echo '<li data-cont=".four">الملاحظات</li>';
                            echo '<li data-cont=".five"> الجدول </li>';
                          echo '</ul>';

                          echo '<div class="content">';


                            echo '<div class="one">';
                              $stmt = $con->prepare("SELECT * FROM lessons WHERE CourseID = ? AND LevelID = ? AND SubjectID = ?");
                              $stmt->execute(array($_GET['CourseID'], $_GET['CourselevelID'], $_GET['SubjectID']));
                              $lessons = $stmt->fetchAll();
                              if ($stmt->rowCount() == 0) {
                                echo '<h2> لم يتم رفع أي درس الرجاء الإنتظار قليلا </h2>';
                              }else {
                                if ($_SESSION['ID'] == 'vistor') {
                                  echo '<h4> متاح لك أول ثلاث دروس مجانا . </h4>';
                                  echo '<div> <a href="../signup.php"> أنشئ حسابك الآن  </a> واستمتع بالدورة كاملة . </div>';
                                }
                                echo '<div class="videos">';
                                  echo '<div class="container">';
                                    echo '<div class="holder">';
                                      echo '<div class="preview">';
                                        echo '<div class="info"> '.$lessons[0]['Title'].' </div>';
                                        echo '<div class="video" dir="ltr">';
                                          if ($lessons[0]['TypeLesson'] == 'link') {
                                            echo '<iframe width="100%" height="100%" src="'.$lessons[0]['Url'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            echo '<video class="infovideo" style="display: none;" controlslist="nodownload" controls preload="metadata">';
                                              echo '<source src=""video/video/"">';
                                            echo '</video>';
                                          }else {
                                            echo '<video class="infovideo" controlslist="nodownload" controls preload="metadata">';
                                              echo '<source src=""video/video/"">';
                                            echo '</video>';
                                            echo '<iframe width="100%" height="100%"  src="'.$lessons[0]['Url'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                          }
                                            // echo '<div class="qulity-selector">';
                                            //   echo '<i class="fa-solid fa-gear"></i>';
                                            //   echo '<div class="menu-qulity">';
                                            //       echo '<div onclick="deffrint_qulity(this)" data-src="">';
                                            //         echo '<sup style="color: red;"> HD </sup>1080p';
                                            //       echo '</div>';
                                            //     echo '</div>';
                                            // echo '</div>';
                                        echo '</div>';
                                      echo '</div>';
                                      echo '<div class="list">';
                                        echo '<div class="name"> قائمة الدروس </div>';
                                        echo '<ul>'; 
                                          // echo '<script> let upload = ""; let sourceVideo =""; let defultQulity = ""; </script>';
                                          $index = 0;
                                          foreach ($lessons as $lesson) {
                                            $src = '';
                                            $active = '';
                                            if ($_SESSION['ID'] == 'vistor' && $index > 2) {
                                              echo '<li data-type="singup"> '.$lesson['Title'].' </li>';
                                            }elseif ($_SESSION['ID'] != 'vistor' && empty($Order) && $index > 2) {
                                              echo '<li data-courseid="'.$_GET['CourseID'].'" data-type="subscribe"> '.$lesson['Title'].' </li>';
                                            }elseif ($_SESSION['ID'] != 'vistor' && !empty($Order) && $index > 2) {
                                              if ($Order['O_RegStatus'] == 0) {
                                                echo '<li data-type="wait"> '.$lesson['Title'].' </li>';
                                              }
                                            }else {
                                              if ($lesson['TypeLesson'] == 'video') {
                                                $src = $upload.'files/videos/'.$lesson['FileName'];
                                              }elseif ($lesson['TypeLesson'] == 'link') {$src = $lesson['Url']; }
                                              if ($index == 0) {$active = ' class=" active " ';}
                                              echo '<li '.$active.' data-type="'.$lesson['TypeLesson'].'" data-src="'.$src.'"> '.$lesson['Title'].' </li>';
                                            }
                                            $index++;
                                          }
                                          // echo '<li data-type="" data-src="" data-qulity="" > الدرس الأول </li>';
                                        echo '</ul>';
                                      echo '</div>';
                                  echo '</div>';
                                echo '</div>';
                              }
                            echo '</div>';
                            echo '</div>';

                            echo '<div class="two">';
                                $stmt = $con->prepare("SELECT * FROM tests WHERE CourseID = ? AND LevelID = ? AND SubjectID = ?");
                                $stmt->execute(array($_GET['CourseID'], $_GET['CourselevelID'], $_GET['SubjectID']));
                                $tests = $stmt->fetchAll();
                                if ($stmt->rowCount() == 0) {
                                  echo '<h2> لم يتم رفع أي إختبار </h2>';
                                }else {
                                  if ($_SESSION['ID'] == 'vistor') {
                                    echo '<h4> متاح لك أول ثلاث اختبارات مجانا. </h4>';
                                    echo '<div> <a href="../signup.php"> أنشئ حسابك الآن  </a> واستمتع بالدورة كاملة . </div>';
                                  }
                                  echo '<div class="continaer">';
                                    $index = 0;
                                    foreach ($tests as $test) {
                                      $type = '';
                                      $courseid = '';
                                      if ($_SESSION['ID'] == 'vistor' && $index > 2) {
                                        $type = 'singup';
                                      }elseif ($_SESSION['ID'] != 'vistor' && empty($Order) && $index > 2) {
                                        $type = 'subscribe';
                                        $courseid = 'data-courseid="'.$_GET['CourseID'].'"';
                                      }elseif ($_SESSION['ID'] != 'vistor' && !empty($Order) && $Order['O_RegStatus'] == 0 && $index > 2) {
                                        $type = 'wait';
                                      }else {
                                        $type = 'test';
                                      }
                                      echo '<a data-type="'.$type.$courseid.'" href="quiz_app.php?testID='. $test['UserID'] .'&T='.$test['Title'].'&C='.$test['CourseID'].'&L='.$test['LevelID'].'&S='.$test['SubjectID'].'">';
                                        echo '<div class="title"> ' . $test['Title'] . ' </div>';
                                            echo '<div class="icon">';
                                            echo '<span> ' . $test['CountQues'] . ' سؤال </span>';
                                            echo '<span> ';
                                              if ($test['CountQues'] >= 96) {
                                                  echo '100';
                                              }else {
                                                  echo $test['CountQues'];
                                              }
                                            echo ' دقيقة </span>';
                                            echo '<i class="fas fa-unlock"></i>';
                                        echo '</div>';
                                      echo '</a>'; 
                                      $index++;
                                    }
                                  echo '</div>';
                                }
                            echo '</div>';

                            echo '<div class="three">';
                              $stmt = $con->prepare("SELECT * FROM files WHERE CourseID = ? AND LevelID = ? AND SubjectID = ?");
                              $stmt->execute(array($_GET['CourseID'], $_GET['CourselevelID'], $_GET['SubjectID']));
                              $files = $stmt->fetchAll();
                              if ($stmt->rowCount() == 0) {
                                echo '<h2> لم يتم رفع أي ملف  </h2>';
                              }else {
                                $index = 0;
                                foreach ($files as $file) {
                                  echo '<div class="continaer">';
                                    echo '<div class="file-info">';
                                      echo '<div class="title"> ' . $file['Title'] . ' </div>';
                                      echo '<div>';
                                      $type = '';
                                      $courseid = '';
                                      if ($_SESSION['ID'] == 'vistor' && $index > 2) {
                                        $type = 'singup';
                                      }elseif ($_SESSION['ID'] != 'vistor' && empty($Order) && $index > 2) {
                                        $type = 'subscribe';
                                        $courseid = 'data-courseid="'.$_GET['CourseID'].'"';
                                      }elseif ($_SESSION['ID'] != 'vistor' && !empty($Order) && $Order['O_RegStatus'] == 0 && $index > 2) {
                                        $type = 'wait';
                                      }else {
                                        $type = 'test';
                                      }
                                        echo '<a data-type="'.$type.$courseid.'" href="'.$upload.'files/files/'.$file['FileName'] .'" download class="btn-shape bg-blue c-white nowrap"> تحميل </a>';
                                      echo '</div>';
                                      // echo '<div class="icon">';
                                      //   echo '<i class="fa-solid fa-file-arrow-down"></i>';
                                      // echo '</div>';
                                    echo '</div>';
                                  echo '</div>';
                                  $index++;
                                }
                              }
                            echo '</div>';
                  
                            echo '<div class="four">';
                              echo '<h2> لم يتم رفع أي ملاحظة </h2>';
                              echo '<div class="container">';
                                // foreach($rows3 as $row) {
                                //     if ($row['TypeNote'] == 'text') {
                                //         echo '<div class="thenote"> ' . $row['TheNote'] . ' </div>';
                                //     }elseif ($row['TypeNote'] == 'img') {
                                //         echo '<div class="thenoteimg"> <img src="'.$upload.'imgnote/'.$row['ImageName'].'" alt=""> </div>';
                                //     }
                                // }
                              echo '</div>';
                            echo '</div>';
                  
                            echo '<div class="five">';
                              echo '<h2>  قريباً ... </h2>';
                              echo '<div class="container">';
                              echo '</div>';
                            echo '</div>';


                          echo '</div>';

                          
                        echo '</div>';
                    }
                    createLTFNU();
                  ?>
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