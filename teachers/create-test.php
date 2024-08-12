<?php
  ob_start();
  session_start();
  session_regenerate_id();

  // $linkCss = ".css";
  $linkjs = "";
  $pageTitle = " إدارة الإختبار ";

  include "init.php";

  $stmt = $con->prepare("SELECT * FROM userss WHERE UserID = ? LIMIT 1");
  $stmt->execute(array($_SESSION['ID']));
  $infoUser = $stmt->fetch();
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
        if (isset($_GET['id']) && empty($_GET['id'])) {
          header('location: logout.php');
          exit();
        }else {
          $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
          $stmt = $con->prepare("SELECT * FROM tests WHERE UserID = ? AND TeacherID = ? LIMIT 1");
          $stmt->execute(array($id, $ID));
          $infoTest = $stmt->fetch();
          if ($stmt->rowCount() == 0) {
            header('location: logout.php');
            exit();
          }else {
            ?>
              <div class="create-test-page">
                <h1 class="p-relative">إدارة الإختبار</h1>
                <div class="container">
                <div class="container">
                    <div class="container-add-from">
                        <div class="title"> <h3> إختيار أسئلة من  </h3> <i class="fa-solid fa-chevron-down rotate"></i> </div>
                        <div class="chose" style="height: 0px;">
                            <input type="radio" name="" id="question-bank">
                            <label for="question-bank">بنك الأسئلة</label>
                        </div>
                    </div>
                    <div class="container-controls">
                        <div class="title"> <h3> أضف الأسئلة </h3> <i class="fa-solid fa-chevron-down rotate"></i> </div>
                        <div class="controls" style="height: 0px;">
                          <div class="c-red p-5 error-msg"></div>
                          <div>
                            <input type="text" name="numloop" id="countLop" class="rad-6 border-ccc p-10" placeholder="عدد التكرارات ..." maxlength="2">
                          </div>
    
                          <div>
                            <input type="radio" name="typeques" id="prag" value="prag" checked>
                            <label for="prag">نص</label>
                            <input type="radio" name="typeques" id="math" value="math">
                            <label for="math">ريضيات</label>
                          </div>

                          <div>
                            <input type="radio" name="shuffle" id="shuffle" value="shuffle" checked>
                            <label for="shuffle"> عشوائي </label>
      
                            <input type="radio" name="shuffle" id="noshuffle" value="noshuffle">
                            <label for="noshuffle"> منتظم </label>
                          </div>
    
                          <div>
                            <input type="radio" name="typeans" id="oneans" value="oneans" checked>
                            <label for="oneans">إجابة واحدة</label>
      
                            <input type="radio" name="typeans" id="multans" value="multans">
                            <label for="multans">متعدد الخيارات</label>
                          </div>
    
                          <div>
                            <input name="code" type="text" id="code" class="rad-6 border-ccc p-10" placeholder=" رمز الأسئلة ..." maxlength="10">
                          </div>
    
                          <div>
                            <select name="sec" id="">
                              <option value="newSec">قسم جديد</option>
                            </select>
                            <?php
                            $stmt = $con->prepare("SELECT * FROM section_question WHERE CetegoryID = ? AND CourseID = ? AND LevelID = ? AND SubjectID = ? AND TeacherID = ?");
                            $stmt->execute(array($infoTest['CetegoryID'], $infoTest['CourseID'], $infoTest['LevelID'], $infoTest['SubjectID'], $ID));
                            $infosSecQues = $stmt->fetchAll();
                            ?>
                            <select name="typeTest" id="">
                            <?php
                            foreach ($infosSecQues as $info) {
                              echo '<option value="'.$info['Title'].'"> '.$info['Title'].' </option>';
                            }
                            ?>
                              <option value="other"> أخرى </option>
                            </select>
                          </div>
    
                          <div>
                            <button class="do" onclick="createSecTest()"> تطبيق </button>
                          </div>
    
                        </div>
                    </div>
                    <div class="container-add-test">
                        <ul>
                        </ul>
                        <div class="controls-test">
                          <span class="add-new-section" onclick="addNewSectionBut(this)"> <i class="fa-regular fa-plus"></i> إضافة قسم </span>
                        </div>
                    </div>
                </div>
                <div class="save">
                  <button onclick="saveShanges()">حفظ التغييرات</button>
                </div>
              </div>
              <script src="<?php echo $Exitjs; ?>quiz_func.js"></script>
              <script>
                let teacherid = '<?php echo $_SESSION['ID']; ?>';
                let file = '<?php echo $upload.'json/'.$infoTest['FileName'].'.json'; ?>';
                let fileID = '<?php echo $infoTest['UserID']; ?>';
                let optionsSecQues = '<?php foreach ($infosSecQues as $info){echo $info['Title'].',';}?>';
              </script>
              <script src="<?php echo $js; ?>create-test.js"></script>
              <script src="<?php echo $js; ?>create-test-respons.js"></script>
              <script>getResponsFile();</script>
            <?php
            include $tpl . "footer.php"; 
          }
        }
      }
    }
  }
  ob_end_flush();
?>
