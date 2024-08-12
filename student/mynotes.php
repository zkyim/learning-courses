<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>لوحة التحكم</title>

    <link rel="stylesheet" href="layout/css/all.min.css" />
    <link rel="stylesheet" href="layout/css/framework.css" />
    <link rel="stylesheet" href="layout/css/master.css" />
    <link rel="stylesheet" href="layout/css/mynotes.css" />

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="page d-flex">
      <div class="sidebar bg-white p-20 p-relative">
        <h3 class="p-relative txt-c mt-0">مستقبلك</h3>
        <ul>
          <li>
            <a href="dashbord.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-chart-bar fa-fw"></i>
              <span>لوحة التحكم</span>
            </a>
          </li>
          <li>
            <a href="myaccount.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-user fa-fw"></i>
              <span>حسابي</span>
            </a>
          </li>
          <li>
            <a href="mytests.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-rectangle-list fa-fw"></i>
              <span>إختباراتي</span>
            </a>
          </li>
          <li>
            <a href="mynotes.html" class="active d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-credit-card fa-fw"></i>
              <span>ملاحظاتي</span>
            </a>
          </li>
          <li>
            <a href="challenge.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-diagram-project fa-fw"></i>
              <span>التحديات</span>
            </a>
          </li>
          <li>
            <a href="courses.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-graduation-cap fa-fw"></i>
              <span>الدورات</span>
            </a>
          </li>
          <li>
            <a href="settings.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-gear fa-fw"></i>
              <span>الإعدادات</span>
            </a>
          </li>
          <li>
            <a href="aboutus.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-address-card fa-fw"></i>
              <span>لمحة عنا</span>
            </a>
          </li>

        </ul>
      </div>
      <div class="content w-full">
        <!-- Start Head -->
        <div class="head bg-white p-15 between-flex">

          <div class="icons d-flex align-center">
            <img src="upload/imags/Avatar/avatar.png" alt="" />
          </div>
        </div>
        <!-- End Head -->

        <div class="container-content">

        <!-- Start my-notes -->
        <div class="my-notes">
          <h1 class="p-relative">ملاحظاتي</h1>

          <div class="popup-box">
            <div class="popup">
              <div class="header-popup">
                <span class="title-header-popup"> إنشاء ملاحظة </span>
                <i class="fa-solid fa-xmark xmark"></i>
              </div>
              <div class="error"> error </div>
              <input type="text" class="title" name="title" placeholder="العنوان">
              <div class="cont-textarea">
              <textarea class="discreption" name="discreption" placeholder="الملاحظة" maxlength="250"></textarea>
              <span class="length"></span>
              <div class="border"></div>
              <div class="progres"></div>
            </div>
              <button class="send"> حفظ </button>
            </div>
          </div>
      
          <div class="succes-msg">
            <span class="text">  تم الحذف بنجاح </span>
            <i class="fa-solid fa-check"></i>
          </div>

          <div class="container-notes bg-white rad-10 p-20 m-20">
            <h2 class="mt-0 mb-10">الملاحظات</h2>
            <p class="c-grey mt-0"> يمكنك إضافة ملاحظات دروسك وغيرها في هذه الميزة ويمكن إضافة 100 ملاحظة فقط . </p>  

              <div class="pairent-notes">
                  <div class="the-note new-note">
                      <div class="icon">
                          <i class="fa-solid fa-plus"></i>
                      </div>
                      <span> أضف ملاحظة جديدة </span>
                  </div>

                  <div class="the-note">
                    <div class="title"> عنوان </div>
                      <div class="pairent-note">
                        <div class="discreption"> وصف الملاحظة </div>
                          <div class="footer">
                            <span class="pairent-menu">
                              <i class="fa-solid fa-ellipsis-vertical dots"></i>
                              <span class="menu" data-id="'.$row['UserID'].'">
                                <span class="edit" onclick="editbutton(this)">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                  <span> تعديل </span>
                                </span>
                                <span class="delete" onclick="deletebutton(this)">
                                  <i class="fa-solid fa-trash"></i>
                                  <span> احذف </span>
                                </span>
                              </span>
                            </span>
                            <span class="date"> 2022/8/17 </span>
                          </div>
                      </div>
                  </div>

                  <div class="pairent-new-note">
                  </div>
              </div>
          </div>

        </div>
        <!-- End my-notes -->

        </div>
      </div>
    </div>
    <script src="layout/js/dashboard.js"></script>
  </body>
</html>