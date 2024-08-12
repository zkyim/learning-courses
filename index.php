<?php

    ob_start();
    session_start();
    session_regenerate_id();

    $linkCss = "login.css";
    $linkjs = "login.js";
    $pageTitle = "تسجيل الدخول";
    
    $src1 = "#login";
    $src2 = "signup.php";
    $namesrc1 = "تسجيل الدخول";
    $namesrc2 = "إنشاء حساب";
    
    if (isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == -98) {
        header('Location: superAdmin/dashboard.php');
        exit();
    }elseif (isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 126) {
        header('Location: admin/dashboard.php');
        exit();
    }elseif (isset($_SESSION['GroupID']) && $_SESSION['GroupID'] == 0 && isset($_SESSION['ID']) && $_SESSION['ID'] != 0) {
        header('Location: members/memberspage.php');
        exit();
    }

    include "init.php"; 

    if (isset($_SESSION['HTTP']) && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $_SESSION['HTTP']) {
        // echo '<h1 style="padding: 20px;width: 85%;margin-left: auto;margin-right: auto;border: 2px dashed #4caf50;border-radius: 6px;background-color: #e8f5e9;"> تم إنشاء الحساب </h1>';
        // $theNumber = explode(':', getDates ("UrlName", "url", ' WHERE UrlType = ?', 'whtsapp'));
        // $endnum = end($theNumber);
        // echo '<h1>';
        // echo 'الرجاء التواصل مع المشرف لتفعيل حسابك عن طريق الرقم <a href=tel:"'; echo getDates ("UrlName", "url", ' WHERE UrlType = ?', 'whtsapp');  echo'" class="a"> ';  echo $endnum;  echo ' </a>';
        // echo '</h1>';
    }

    $_SESSION['HTTP'] = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $email      = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password   = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

        $Emailcount = checkItem('Email', 'userss', $email);

        $passcount = passCount ($password);
        
        $thePass = findpass ($password);


        $stmt = $con->prepare("SELECT
                                    *
                                FROM
                                    userss
                                WHERE
                                    Email = ?
                                AND
                                    PassWord = ?
                                LIMIT 1");
        $stmt->execute(array($email, $thePass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();


                if ($count > 0) {
                    $_SESSION['Usename'] = $row['FName'] . $row['SName'];
                    $_SESSION['Avatar'] = $row['Avatar'];
                    $_SESSION['ID'] = $row['UserID'];
                    if ($row['TypeUser'] == 'SuperAdmin') {
                        header('Location: superAdmin/dashboard.php');
                        exit();
                    }elseif ($row['TypeUser'] == 'Admin') {
                        header('Location: admin/dashboard.php');
                        exit();
                    }elseif ($row['TypeUser'] == 'Teacher') {
                        header('Location: teachers/dashboard.php');
                        exit();
                    }elseif ($row['TypeUser'] == 'Student') {
                        header('Location: student/dashboard.php');
                        exit();
                    }
                }elseif ($count == 0) {

                    if ($Emailcount > 0 && $passcount == 0) { 
                        createFormlLogin ('', 'الرقم السري خاطئ أعد المحاولة', $email);
                    }elseif ($Emailcount == 0 && $passcount > 0) {
                        createFormlLogin('البريد الإلكتروني خاطئ أعد المحاولة','');
                    }elseif ($Emailcount == 0 && $passcount == 0) {
                        createFormlLogin('البريد الإلكتروني خاطئ أعد المحاولة','الرقم السري خاطئ أعد المحاولة');
                    }elseif ($Emailcount > 0 && $passcount > 0) {
                        createFormlLogin('البريد الإلكتروني خاطئ أعد المحاولة','الرقم السري خاطئ أعد المحاولة');
                    }

                }
    }else {
        createFormlLogin('','');
    }


    include $tpl . "footer.php"; 
    ob_end_flush();

    function createFormlLogin ($msgEmail, $msgPass, $valueEmail = '', $valuePass = '') {
        ?>
        <div class="section">
            <div class="sign-in">
                <div class="container">
                    <div class="form">
                        <h2> تسجيل الدخول </h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="email-error"> <?php echo $msgEmail; ?> </div>
                            <label for="email">                                
                                <div class="container-input">
                                    <input type="email" id="email" name="email" value="<?php echo $valueEmail; ?>">
                                    <label for="email">البريد الإلكتروني</label>
                                    <i class="fa-regular fa-envelope fa-lg"></i>
                                </div>
                            </label>
                            <div class="pass-error"> <?php echo $msgPass; ?> </div>
                            <label for="pass">
                                <div class="container-input">
                                    <input type="password" id="pass" name="password" value="<?php echo $valuePass; ?>">
                                    <label>كلمة السر</label>
                                    <i class="fa-solid fa-lock fa-lg"></i>
                                    <i class="pass-icon fa-regular fa-eye-slash fa-lg"></i>
                                </div>
                            </label>

                            <a href="">نسيت كلمة السر</a>
                            <div class="buttons">
                                <input type="submit" value="التالي">
                                <a href="signup.php">أنشئ حسابك</a>
                            </div>
                        </form>
    
                    </div>
    
                    <div class="text">
                        <h2>أهلا بعودتك !!</h2>
                        <p>إن كنت زائرا جديدا فعليك أولا إنشاء حسابك الجديد الآن ويمكنك زيارة المنصة </p>
                    </div>
                </div>
            </div>
        </div>

        <?php

            // echo '
            // <form class="form" action="index.php" method="POST" style="margin-bottom:150px;">
            //     <h2 id="login">تسجيل الدخول</h2>
            //     <div class="mailError">' . $msgemail . '</div>
            //         <input class="text" type="text" name="mail" placeholder="البريد الإلكتروني" value="'.$valueEmail.'">
            //     <div class="passError">' . $msgpass . '</div>
            //     <input class="pass" type="password" name="pass" placeholder="كلمة المرور" value="'.$valuePass.'">
            //     <a href="resetpass.php" class="a"> نسيت كلمة المرور </a>
            //     <div class="buttons">
            //         <button class="submit">التالي</button>
            //         <a href="logup.php">إنشاء حساب</a>
            //     </div>
            // </form>
            // ';
    }

?>