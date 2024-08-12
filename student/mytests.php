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
            <a href="mytests.html" class="active d-flex align-center fs-14 c-black rad-6 p-10">
              <i class="fa-regular fa-rectangle-list fa-fw"></i>
              <span>إختباراتي</span>
            </a>
          </li>
          <li>
            <a href="mynotes.html" class="d-flex align-center fs-14 c-black rad-6 p-10">
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

        <!-- Start my-test -->
        <div class="my-test">
          <h1 class="p-relative">إختباراتي</h1>
          <div class="p-20 bg-white rad-10 m-20">
            <div class="qus d-flex between-flex p-10 mb-10">
              <span class="btn-shape bg-green c-white"> الأسئلة المميزة </span>
              <span class="btn-shape bg-red c-white"> الأسئلة الخاطئة </span>
              <!-- Start Popap -->
              <div class="container-popap">
                <i class="fa-solid fa-xmark xmark"></i>
                <div class="pairent-popap">
                  <a href="" class="edit">
                    <span> التعديل على الأسئلة </span>
                  </a>
                  <form action="wrongquestest.php" method="post">
                    <input type="hidden" name="typeTest" value="">
                    <select name="option">
                      <option value="tl" > تأسيس لفظي  </option>
                      <option value="tk" selected > تأسيس كمي </option>
                      <option value="ml" > محوسب لفظي </option>
                      <option value="mk" > محوسب كمي </option>
                    </select>
                    <div class="buttons">
                      <input type="submit" value="التالي">
                      <span class="xmark"> إلغاء </span>
                    </div>
                  </form>
                </div>
              </div>
              <!-- End Popap -->
            </div>

            <div class="responsive-table">
              <table class="fs-15 w-full">
                <thead>
                  <tr>
                    <td>العدد</td>
                    <td>نوع الإختبار</td>
                    <td>الدرجة</td>
                    <td>الحالة</td>
                    <td>الوقت</td>
                    <td>التاريخ</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td>تأسيس كمي</td>
                    <td>100%</td>
                    <td><span class="label btn-shape bg-green c-white">ناجح</span></td>
                    <td>3:49</td>
                    <td>2022/8/17</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>تأسيس كمي</td>
                    <td>100%</td>
                    <td><span class="label btn-shape bg-green c-white">ناجح</span></td>
                    <td>3:49</td>
                    <td>2022/8/17</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>تأسيس كمي</td>
                    <td>100%</td>
                    <td><span class="label btn-shape bg-green c-white">ناجح</span></td>
                    <td>3:49</td>
                    <td>2022/8/17</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <span class="c-grey d-block mt-15"> مجموع النقاط : 133 </span>
          </div>
        </div>
        <!-- End my-test -->

        </div>
      </div>
    </div>
    <script src="layout/js/dashboard.js"></script>
  </body>
</html>