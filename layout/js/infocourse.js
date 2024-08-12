// ===================================== Start Popup Add Course =====================================
let popup = document.querySelector('.popup');
let headPopup = document.querySelector('.popup .head-popup > span');
let popupErrorPass = document.querySelector('.popup .popup-error-pass');
let contentPopup = document.querySelector('.popup .content-popup-child');
popup.children[0].addEventListener('click', (e) => {
    e.stopPropagation();
});
popup.addEventListener('click', (e) => {
    popup.classList.remove('open');
});
document.querySelector('.popup .head-popup i').addEventListener('click', (e) => {
    popup.classList.remove('open');
});
// ===================================== End Popup Add Course ==================================
function signUpNow () {
    popup.classList.add('open');
    headPopup.innerHTML =' أنشئ حسابك الآن ...';
    contentPopup.innerHTML = 
    `
    <h3> طريقة الإشتراك في الدورة </h3>
    <p> 1 - التواصل مع منشئ الدورة ودفع الثمن. </p>
    <p> 2 - عند إستلام منشئ الدورة الثمن سوف يتم تفعيل الدورة. </p>
    <h4 class="c-red m-5"> يجب عليك إنشاء حسابك أولا . </h4>
    <a href="../signup.php" class="btn-shape bg-green c-white box"> أنشئ حسابك الآن </a>
    <div class="m-10">
        <a href="courselevels.php?UserID=${CourseID}" class="btn-shape bg-green c-white box"> ألقي نظرة على الدورة </a>
    </div>
    `;
}
function subscribPopap () {
    popup.classList.add('open');
    headPopup.innerHTML =' رسالة ...';
    contentPopup.innerHTML = 
    `
    <h3> تم إرسال طلب الإشتراك </h3>
    <p> 1 - التواصل مع منشئ الدورة ودفع الثمن. </p>
    <p> 2 - عند إستلام منشئ الدورة الثمن سوف يتم تفعيل الدورة خلال 48 ساعة. </p>
    `;
    let btn = document.querySelector('.course .info button');
    btn.innerHTML = 'تحت الطلب';
    btn.style.background = 'red';
}
function subscribNow () {
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                if (response.indexOf('success') > -1) {
                    subscribPopap();
                }else if (response.indexOf('there is no that id') > -1) {
                    createToast('error', 'لا يوجد مثل هذه البيانات');
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_infocourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=addNewOrder&CourseID=${CourseID}&StudentID=${studentid}&TeacherID=${teacherid}`);
    // }
}
