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

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="page d-flex">
      <div class="sidebar bg-white p-20 p-relative">
        <h3 class="p-relative txt-c mt-0">مستقبلك</h3>
        <ul>
          <a href="dashboard.html">
            <li class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-chart-bar fa-fw"></i>
              <span>لوحة التحكم</span>
            </li>
          </a>
          <a href="members.html">
            <li  class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-users"></i>
              <span>الأعضاء</span>
            </li>
          </a>
          <a href="courses.html">
            <li  class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-graduation-cap fa-fw"></i>
              <span>الدورات</span>
            </li>
          </a>
            <li class="menu">
              <div class="between-flex fs-14 c-black rad-6 p-10">
                <div>
                  <i class="fa-regular fa-pen-to-square fa-fw"></i>
                  <span>إدارة</span>
                </div>
                <i class="fa-solid fa-sort-down"></i>
              </div>
              <div class="menu">
                <a href="mangecourse.html">قدرات</a>
                <a href="mangecourse.html">تحصيلي</a>
              </div>
            </li>
          <a href="myaccount.html" >
            <li class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-user fa-fw"></i>
              <span>حسابي</span>
            </li>
          </a>
          <a href="settings.html">
            <li class="d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-solid fa-gear fa-fw"></i>
              <span>الإعدادات</span>
            </li>
          </a>
          <a href="aboutus.html">
            <li class="d-flex align-center fs-14 c-black rad-6 p-10 active">
              <i class="fa-regular fa-address-card fa-fw"></i>
              <span>لمحة عنا</span>
            </li>
          </a>

        </ul>
      </div>
      <div class="content w-full">
        <!-- Start Head -->
        <div class="head bg-white p-15 between-flex">

          <div class="icons d-flex align-center">
            <img src="../members/upload/imags/Avatar/avatar.png" alt="" />
          </div>
        </div>
        <!-- End Head -->

        <div class="container-content">


        <!-- Start about-us -->
        <div class="about-us">
          <h1 class="p-relative">لمحة عنا</h1>
        </div>
        <!-- End about-us -->

        </div>
      </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="layout/js/my_chart.js"></script>
    <script src="layout/js/master.js"></script>
  </body>
</html>