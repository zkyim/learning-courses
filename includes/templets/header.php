<?php
$css = 'layout/css/';
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">

        <link rel="stylesheet" href="layout/css/all.min.css">
        <link rel="stylesheet" href="layout/css/normalize.css">
        <link rel="stylesheet" href="layout/css/master.css">
        <link rel="stylesheet" href="<?php echo $css; echo GetLinkCss();?>">

        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
        
        <title> <?php GetTitle() ?> </title>
    </head>
    <body>

        <header>
            <div class="container">
                <div class="logo">مشروع</div>
                <div class="dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="links">
                    <ul>
                        <li><a href="<?php Getsrc1 () ?>"> <?php Getnamesrc1 () ?> </a></li>
                        <li><a href="<?php Getsrc2 () ?>"> <?php Getnamesrc2 () ?> </a></li>
                        <li><a href="">لمحة عنا</a></li>
                        <li><a href="logout.php">خروج</a></li>
                    </ul>
                </div>
            </div>
        </header>
