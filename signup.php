<?php
    ob_start();
    session_start();
    session_regenerate_id();

    $linkCss = "logup.css";
    $linkjs = "logup.js";

    $pageTitle = "إنشاء حساب";

    $src1 = "#login";
    $src2 = "index.php";
    $namesrc1 = "إنشاء حساب";
    $namesrc2 = "تسجيل الدخول";

    include "init.php";
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['thepass'])) {
        $thepass = filter_var($_POST['thepass'], FILTER_SANITIZE_NUMBER_INT);

        if (!empty($thepass)) {
            if ($_SESSION['checkpassword'] == $thepass) {

                $stmt = $con->prepare("INSERT INTO 
                                            userss(FName, SName, Email, PassWord, PhoneNumber, Sex, TypeUser, Date)
                                            VALUES(:FName, :SName, :Email, :PassWord, :PhoneNumber, :Sex, :TypeUser, now())");
                $stmt->execute(array(
                    'FName' => $_SESSION['Fname'],
                    'SName' => $_SESSION['Sname'],
                    'Email' => $_SESSION['mail'],
                    'PassWord' => $_SESSION['hashedpass'],
                    'PhoneNumber' => $_SESSION['number'],
                    'Sex' => $_SESSION['sex'],
                    'TypeUser' => 'Student'
                ));
                $_SESSION['HTTP'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
                header('location: index.php');
                exit();

            }else {
                $theMsg = 'تأكيد كلمة المرور غير صحيحة الرجاء إعادة المحاولة';
                redirectHome($theMsg);
            }
        }else {
            echo '
            <section>
                <form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form">
                    <h2> التأكد من الحساب </h2>
                    <h3 style="color: #ff0000d9;"> تم إرسال رمز التحقق إلى بريدك الإلكتروني </h3>
                    <h3 style="color: #ff0000d9;"> يجب ملئ الحقل </h3>
                    <input type="text" placeholder="رمز التحقق" name="thepass" autocomplete="off">
                    <div class="buttons">
                        <button type="submit"> إرسال </button>
                    </div>
                </form>
            </section>
            ';
        }


        
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mail'])) {

        $Fname      = filter_var($_POST['FirstName']    , FILTER_SANITIZE_STRING);
        $Sname      = filter_var($_POST['SecondName']   , FILTER_SANITIZE_STRING);
        $email       = filter_var($_POST['mail']        , FILTER_SANITIZE_EMAIL);
        $number     = filter_var($_POST['number']       , FILTER_SANITIZE_NUMBER_INT);
        $sex        = filter_var($_POST['sex']          , FILTER_SANITIZE_STRING);
        $Pass1      = filter_var($_POST['Password1']    , FILTER_SANITIZE_STRING);
        $Pass2      = filter_var($_POST['Password2']    , FILTER_SANITIZE_STRING);

        $hashedpass = password_hash($Pass1, PASSWORD_DEFAULT);

        $formError = array();

        if (empty($Fname)) {
            $formError[] = 'يجب ملئ حقل الإسم الأول';
        }
        if (strlen($Fname) > 20) {
            $formError[] = 'يجب ألا يتجاوز عدد المدخلات 20 مدخل للإسم الأول';
        }
        if (empty($Sname)) {
            $formError[] = 'يجب ملئ حقل إسم الأب';
        }
        if (strlen($Sname) > 20) {
            $formError[] = 'يجب ألا يتجاوز عدد المدخلات 20 مدخل إسم الأب';
        }
        if (empty($email)) {
            $formError[] = 'يجب ملئ حقل البريد الإمكتروني ';
        }
        if (strlen($email) > 30) {
            $formError[] = 'يجب ألا يتجاوز عدد المدخلات 30 مدخل للبريد الإلكتروني';
        }
        if (empty($Pass1)) {
            $formError[] = ' يجب ملئ حقل كلمة المرور الألى';
        }
        if (strlen($Pass1) > 20) {
            $formError[] = ' يجب ألا يتجاوز عدد المدخلات 20 مدخل لكلمة المرور';
        }
        if (empty($Pass2)) {
            $formError[] = ' يجب ملئ حقل كلمة المرور الثانية';
        }
        if (!empty($Pass1) && $Pass1 !== $Pass2) {
            $formError[] = 'كلمتا المرور غير متساوة الرجاء التأكد منها';
        }
        if (empty($number)) {
            $formError[] = 'يجب ملئ حقل رقم هاتفك';
        }
        if (strlen($number) != 10) {
            $formError[] = 'يجب أن تكون عدد الأرقام 10 أرقام';
        }
        // if (filter_var($number, FILTER_VALIDATE_INT) === FALSE) {
        //     $formError[] = 'الرقم الذي أدخلته غير مدعوم قد تتواجد به بعض العمليات الحسابية';
        // }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            $formError[] = 'البريد الإلكتروني الذي أدخلته غير مدعوم الرجاء التأكد منه';
        }
        if (!empty($formError)) {
            foreach($formError as $error) {
                echo $error . '<br>';
            }
            createForm ('','', $Fname, $Sname, $mail, $Pass1, $Pass2, $number, $sex);
        }
        if (empty($formError)) {

            $_SESSION['Fname']       = $Fname;
            $_SESSION['Sname']       = $Sname;
            $_SESSION['mail']        = $email;
            $_SESSION['hashedpass']  = $hashedpass;
            $_SESSION['number']      = $number;
            $_SESSION['sex']         = $sex;

            $Emailcount = checkItem('Email', 'userss', $email);

            if ($Emailcount > 0) {
                createForm ('عذرا : لقد استعملت هذا البريد الإلكتروني حاول مرة أخرى','', $Fname, $Sname, '', $Pass1, $Pass2, $number, $sex); 
    
            }else{

                $_SESSION['checkpassword'] = '';
                
                $randomNumber = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                for ($i = 0; $i < 6; $i++) {
                    $Random = rand(0, 9);
                    $_SESSION['checkpassword'] .= $randomNumber[$Random];
                }
                // sending a pass for theuser
                echo $_SESSION['checkpassword'] . "<br>";

                // require_once 'mail.php';
                // $mail->setFrom('zkim15121@gmail.com', 'قدرات');
                // $mail->addAddress($email);
                // $mail->Subject = 'تأكيد كلمة المرور';
                // $mail->Body    = '
                // <h3 style="direction: rtl;"> تأكيد كلمة المرور لإتمام عملية الحساب </h3>
                // <h2> ' . $_SESSION['checkpassword'] . '  كلمة المرور </h2>
                // <h3> شكرا لإختيارك موقع القدرات </h3>
                // <h3> وفقك الله </h3>
                // ';
                // $mail->send();
        
                // if ($mail->send()) {
                    

                    echo $_SESSION['checkpassword'].'<br>';
                    echo '
                    <section>
                        <form action="'.$_SERVER['PHP_SELF'].'" method="POST" class="form">
                            <h2> التأكد من الحساب </h2>
                            <h3 style="color: #ff0000d9;"> تم إرسال رمز التحقق إلى بريدك الإلكتروني </h3>
                            <input type="text" placeholder="رمز التحقق" name="thepass" autocomplete="off">
                            <div class="buttons">
                                <button type="submit"> إرسال </button>
                            </div>
                        </form>
                    </section>
                    ';


                // }else {
                    // echo '<h1> البريد الإلكتروني غير صحيح أعد المحاولة </h1>';
                    // createForm ('البريد الإلكتروني غير صحيح أعد المحاولة','', $Fname, $Sname, '', $Pass1, $Pass2);
                // }

            }
        }
        
    }
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        createForm ('','');
    }
    include $tpl . "footer.php"; 
ob_end_flush();

function createForm ($msgemail, $msgpass, $VFName = '', $VSName = '', $email = '', $pass1 = '', $pass2 = '', $number = '', $sex = '') {
    global $con;
    ?>
    <div class="section">
        <div class="sign-in">
            <div class="container">
                <section>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <h2 id="login">أنشئ حسابك الآن ...</h2>
                        <div class="name"><span class="FirstNameError"></span> <span class="SecondNameError"></span> </div>
                        <div class="coontainer">
                            <div class="inputcont">
                                <input type="text" class="text1" placeholder="الاسم الأول" name="FirstName" autocomplete="off" value="<?php echo $VFName; ?>">
                            </div>
                            <div class="inputcont">
                                <span class="SecondNameError2"></span>
                                <input type="text" class="text2" placeholder="اسم الأب"   name="SecondName" autocomplete="off" value="<?php echo $VSName; ?>">
                            </div>
                        </div>
                        <div class="mail"> <?php echo $msgemail; ?> </div>
                        <input type="text" class="text3" placeholder="البريد الإلكتروني" name="mail" autocomplete="off" value="<?php echo $email; ?>">
                        <div> <span class="Number">  </span> </div>
                        <div class="coontainer">
                            <div class="inputcont">
                                <input type="text" class="text3" placeholder="رقم هاتفك" name="number" autocomplete="off" value="<?php echo $number; ?>">
                            </div>
                            <div class="inputcont">
                                <div class="container-selector">
                                    <div class="title-selector"><span> <?php if ($sex == 'man') {echo'ذكر';}elseif ($sex == 'woman') {echo'أنثى';}else{echo 'ذكر';} ?> </span><i class="fa-solid fa-caret-down"></i></div>
                                    <div class="menu-selector">
                                        <div class="options">
                                            <input type="radio" name="sex" value="man" id="man" <?php if ($sex == 'man') {echo'checked';}else {echo'checked';} ?>><label for="man"><span>ذكر</span></label>
                                            <input type="radio" name="sex" value="woman" id="woman" <?php if ($sex == 'woman') {echo'checked';} ?> ><label for="woman"><span>أنثى</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="noteq"> <?php echo $msgpass; ?> </div>
                        <div class="name"><span class="Password1Error"></span> <span class="Password2Error"></span> </div>
                        <div class="coontainer">
                            <div class="inputcont">
                                <input type="text" class="pass1" placeholder="كلمة المرور" name="Password1" autocomplete="new-password" value="<?php echo $pass1; ?>">
                            </div>
                            <div class="inputcont">
                                <span class="Password2Error2"> </span>
                                <input type="password" class="pass2" placeholder="تأكيد كلمة المرور" name="Password2" autocomplete="new-password"value="<?php echo $pass2; ?>">
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="submit">التالي</button>
                            <span>شروط إنشاء حساب</span>
                        </div>
                    </form>

                    <div class="gallary">
                        <div class="containet">
                            <div class="ad">1 - يجب ملئ جميع الحقول</div>
                            <div class="ad"> 2 - إستخدم كلمة مرور صعبة للأمان  </div>
                            <div class="ad">3 - تأكد من إستخدام بريد مستعمل لأنه سيتم إرسال رمز تحقق إليه</div>
                            <div class="ad">وفقك الله</div>
                        <div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php
}
?>