<?php
  ob_start();
  session_start();
  session_regenerate_id();
  // disabled
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
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage' ;
            ?>
              <div class="create-test-page">
                <?php if ($action == 'Manage') { ?>
                  <h1 class="p-relative">إدارة بنك الأسئلة</h1>
                <?php }else if ($action == 'AddQuestions') { ?>
                  <h1 class="p-relative"> إضافة الأسئلة لبنك الأسئلة</h1>
                  <?php }else if ($action == 'UpdateQuestion') { ?>
                    <h1 class="p-relative"> تعديل السؤال </h1>
                <?php } ?>
                <div class="container">

                    <?php if ($action == 'Manage') { ?>
                        <div class="container-controls">
                            <div class="title"> <h3> فلترة </h3> <i class="fa-solid fa-chevron-down rotate"></i> </div>
                            <div class="controls" style="height: 0px;">
                                <div class="quessec">
                                    <input type="radio" name="quessec" id="لفظي" value="لفظي" onclick="quessec(this)">
                                    <label for="لفظي"> لفظي </label>

                                    <input type="radio" name="quessec" id="كمي" value="كمي" onclick="quessec(this)">
                                    <label for="كمي">كمي</label>

                                    <input type="radio" name="quessec" id="الكل" value="الكل" onclick="quessec(this)">
                                    <label for="الكل">الكل</label>
                                </div>
                                <div class="typequestion">

                                </div>
                                <div class="submit-button" style="display: none;">
                                    <button class="p-10 w-full rad-6 c-white bg-green" onclick="filterQuestion()">فلترة</button>
                                </div>
                            </div>
                        </div>
                    <?php }else if ($action == 'AddQuestiones') { ?>
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

                                <select name="typeTest" id="">
                                <option value="كمي"> كمي </option>
                                <option value="لفظي"> لفظي </option>
                                <option value="other"> أخرى </option>
                                </select>
                            </div>
        
                            <div>
                                <button class="do" onclick="createSecTest()"> تطبيق </button>
                            </div>
        
                            </div>
                        </div>
                    <?php } ?>

                    <div class="container-add-test">
                        <ul <?php if ($action == 'Manage') {echo 'class="disabled"';}else if ($action == 'UpdateQuestion') {echo 'class="trash"';} ?>>
                            
                        </ul>
                        <?php if ($action == 'Manage') { ?>
                          <div class="save">
                            <a href="<?php echo $_SERVER['PHP_SELF'].'?action=AddQuestions'; ?>"><button onclick="saveShanges()"> <span class="add-new-question">إضافة الأسئلة</span> </button></a>
                          </div>
                          <div class="controls-test">
                            <span class="add-new-question more-questiones" onclick="loadmoreQuestion(this)"><i class="fa-regular fa-plus"></i> المزيد من الأسئلة </span>
                          </div>
                        <?php }else if ($action == 'AddQuestions') { ?>
                            <div class="controls-test">
                                <span class="add-new-question" onclick="addNewQuestionBut(this, 'question-bank')"><i class="fa-regular fa-plus"></i>إضافة سؤال</span>
                            </div>
                            <div class="save">
                              <button onclick="addNewQuestiones()"> إضافة جميع الأسئلة </button>
                            </div>
                        <?php }else if ($action == 'UpdateQuestion') { ?>
                          <div class="save">
                            <button data-UserID="<?php echo $_GET['UserID']; ?>" onclick="updateQuestion(this)"> تعديل السؤال </button>
                          </div>
                        <?php } ?>
                    </div>
                </div>
              </div>
              <script src="<?php echo $Exitjs; ?>quiz_func.js"></script>
              <script>
                let teacherid = '<?php echo $_SESSION['ID']; ?>';
                let optionsSecQues = 'لفظي,كمي,';
                let kammey = 'مقارنة,إحصاء,الكل,أخرى,';
                let laphzy = 'تناظر لفظي,الخطأ السياقي,إكمال الجمل,إستيعاب المقروء,المفردة الشاذة,الكل,أخرى,'
              </script>
              <script src="<?php echo $js; ?>create-test.js"></script>
              <script src="<?php echo $js; ?>create-test-respons.js"></script>
              <?php if ($action == 'Manage') { ?>
                <script> filterQuestion(); </script>
              <?php }elseif ($action == 'UpdateQuestion' && isset($_GET['UserID']) && !empty($_GET['UserID'])) { ?>
                <script> getDataQuestion(<?php echo '"'.$_GET['UserID'].'"'; ?>); </script>
              <?php } ?>
            <?php
            include $tpl . "footer.php"; 
      }
    }
  }
  ob_end_flush();
?>
