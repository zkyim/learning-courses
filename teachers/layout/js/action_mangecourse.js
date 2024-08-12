// ===================================== Start Popup Add Course =====================================
let popup = document.querySelector('.popup');
let headPopup = document.querySelector('.popup .head-popup > span');
let popupError = document.querySelector('.popup .popup-error');
let contentPopup = document.querySelector('.popup .content-popup-child');
popup.children[0].addEventListener('click', (e) => {
    e.stopPropagation();
});
popup.addEventListener('click', (e) => {
    popup.classList.remove('open');
    emptyInput ();
});
document.querySelector('.popup .head-popup i').addEventListener('click', (e) => {
    popup.classList.remove('open');
    emptyInput ();
});
function emptyInput () {
    let inputs = document.querySelectorAll('.popup input');
    inputs.forEach( input => {
        input.value = '';
    });
    popupError.innerHTML = '';
};
// ===================================== End Popup Add Course ==================================
let option1 = document.querySelectorAll('.mange-cours div.table .option1 input');
let option2 = document.querySelector('.mange-cours div.table .option2');
let option3 = document.querySelector('.mange-cours div.table .option3');
let option4 = document.querySelector('.mange-cours div.table .option4');
let option5 = document.querySelector('.mange-cours div.table .option5');
let searchArea = document.querySelector('.mange-cours div.table .search-area');
let InputSearchArea = document.querySelector('.mange-cours div.table .search-area input[type="text"]');
let responsiveTable = document.querySelector('.mange-cours div.table .responsive-table');
let table = document.querySelector('.mange-cours div.table table');
let addClass = document.querySelector('.mange-cours div.table .addClass');
let cetegoryID;
let CourseID;
let levelID;
let subjectID;
let classes;

let offset = 1;
let modeScroll = true;

option1.forEach( ele => {
    ele.addEventListener('click', e => {
        cetegoryID  = e.target.value;
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            option2.style.visibility = 'visible';
            option2.style.height = '100px';
            let loading = document.createElement('div');
            loading.classList.add('loading');
            option2.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        option2.innerHTML = response[0];
                        option2.innerHTML += `<a href="courses.php"><div class="add-lable"><label> <i class="fa-regular fa-square-plus"></i> </label></div></a>`;
                    }else if (response.indexOf('there is no data to display') > -1) {
                        option2.innerHTML = 'لم يتم رفع أي دورة بهذا النوع.';
                        option2.innerHTML += `<a href="courses.php"><div class="add-lable"><label> <i class="fa-regular fa-square-plus"></i> </label></div></a>`;
                        option3.style.visibility = 'hidden';
                        option4.style.visibility = 'hidden';
                        option5.style.visibility = 'hidden';
                        searchArea.style.visibility = 'hidden';
                    }else if (response.indexOf('There is no that id') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=nameCourses&typecourse=${e.target.value}&teacherid=${teacherid}`);
            option2.style.height = 'fit-content';
        // }
    });
});

function courseNameClick (ele) {
    CourseID = ele.value;
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        option3.style.visibility = 'visible';
        option3.style.height = '100px';
        let loading = document.createElement('div');
        loading.classList.add('loading');
        option3.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    option3.innerHTML = response[0];
                    option3.innerHTML += `<div class="add-lable"><label onclick="openPopupOption3()"><i class="fa-regular fa-square-plus"></i></label></div>`;
                }else if (response.indexOf('there is no data to display') > -1) {
                    option3.innerHTML = 'لم يتم إضافة أي مستويات لهذه الدورة .';
                    option3.innerHTML += `<div class="add-lable"><label onclick="openPopupOption3()"><i class="fa-regular fa-square-plus"></i></label></div>`;
                    option4.style.visibility = 'hidden';
                    option5.style.visibility = 'hidden';
                    searchArea.style.visibility = 'hidden';
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=courselevels&cetegoryID=${cetegoryID}&courseID=${ele.value}&teacherid=${teacherid}`);
        option3.style.height = 'fit-content';
    // }
}
// ==================================== Start actions on levels course =========================

function openPopupOption3 () {
    popup.classList.add('open');
    headPopup.innerHTML = 'أضف المستوى الجديد لهذه الدورة ...';
    contentPopup.innerHTML = `
    <form action="#">
        <input type="hidden" name="action" value="addCourseLevel">
        <input type="hidden" name="cetegoryID" value="${cetegoryID}">
        <input type="hidden" name="courseID" value="${CourseID}">
        <input type="hidden" name="teacherid" value="${teacherid}">
        <div class="course">
            <div class="img-course">
                <label for="imglevel" class="p-relative"> 
                <span>صورة المستوى</span>
                <i class="fa-solid fa-cloud-arrow-up"></i>
                    <input type="file" id="imglevel" name="imglevel" onchange="uploadimg(this)">
                </label>
            </div>
        </div>
        <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20" type="text" name="name" placeholder="اسم المستوى" />
        <div class="buttons-popup p-15 pt-0">
            <button class="action-course btn-shape bg-blue c-white d-block w-full">إضافة</button>
        </div>
    </form>`;
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        addCourseLevel (e);
    });
}

function addCourseLevel (ele) {
    popupError.innerHTML = '';
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'action_mangecourse.php');
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    option3.innerHTML = response[0];
                    createToast('success', 'تمت الإضافة بنجاح.');
                    option3.innerHTML += `<div class="add-lable"><label onclick="openPopupOption3()"><i class="fa-regular fa-square-plus"></i></label></div>`;
                    popup.classList.remove('open');
                }else if (response.indexOf('empty') > -1) {
                    popupError.innerHTML = 'يجب ملئ جميع الحقول';
                }else if (response.indexOf('This is not a valid image file') > -1) {
                    popupError.innerHTML = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
                }else if (response.indexOf('There is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    createToast('error', 'لا يوجد مثل هذه البيانات');
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        let formData = new FormData(ele.target);
        xhr.send(formData);
    // }
}

function uploadimg (ele) {
    let lable = document.querySelector(".course .img-course label");
    let containerImg = document.querySelector(".course .img-course");
    console.log(containerImg);
    console.log(containerImg.children[0]);
    let file = new FileReader();
    file.readAsDataURL(ele.files[0]);
    file.onload = () => {
        let img = document.createElement('img');
        img.src = file.result;
        if (containerImg.children[1]) {
            containerImg.children[1].remove();
        }
        containerImg.appendChild(img);
        containerImg.style.border = "none";
        lable.classList.add('uploaded');
    }
}

function openmenulevel (ele) {
    ele.parentElement.children[1].classList.add('open');
    ele.parentElement.children[1].addEventListener('click', e => {
        e.stopPropagation();
    });
    document.addEventListener('click', eled => {
        if (eled.target !== ele.parentElement.children[1] && eled.target !== ele) {
            ele.parentElement.children[1].classList.remove('open');
        }
    });
}
let labelcont;
function updatelevel (ele) {
    let data = getdataforeditelevel (ele.dataset.userid);
    labelcont = ele.parentElement.parentElement.parentElement.children[1];
    ele.parentElement.classList.remove('open');
    popup.classList.add('open');
    headPopup.innerHTML = 'عدل هذا المستوى ...';
    contentPopup.innerHTML = data;
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        editeCourseLevel (e);
    });
    function getdataforeditelevel (userid) {
        let responsereturn;
        // let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            option3.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        responsereturn = response[0];
                    }else if (response.indexOf('there is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=getdatacourseLevel&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&teacherid=${teacherid}`);
        // }
        return responsereturn;
    }
    function editeCourseLevel (ele) {
        popupError.innerHTML = '';
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            popup.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'action_mangecourse.php');
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        labelcont.innerHTML = response[0];
                        popup.classList.remove('open');
                        createToast('success', 'تم التعديل بنجاح.');
                    }else if (response.indexOf('empty') > -1) {
                        popupError.innerHTML = 'يجب ملئ جميع الحقول';
                    }else if (response.indexOf('This is not a valid image file') > -1) {
                        popupError.innerHTML = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
                    }else if (response.indexOf('There is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                        createToast('error', 'لا يوجد مثل هذه البيانات');
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            let formData = new FormData(ele.target);
            xhr.send(formData);
        // }
    }
}
let deletebut;
function deletelevel (ele) {
    deletebut = ele;
    ele.parentElement.classList.remove('open');
    popup.classList.add('open');
    headPopup.innerHTML = ' تأكيد الحذف  ...';
    contentPopup.innerHTML = ` <div class="c-red"> هل أنت متأكد من حذفك للمستوى </div>  
    <div>    لديك 0 مواد و 0 دروس 0 اختبارات   </div>  
    <div class="buttons-popup p-15 pt-0">
        <button class="action-course btn-shape bg-red c-white d-block w-full">تأكيد</button>
    </div>`;
    document.querySelector('.popup .content-popup-child .action-course').addEventListener('click', e => {
        createToast('error', ` هل أنت متأك من حذف هذا المستوى <button class="bg-red c-white btn-shape" onclick="confirmdeletelevel()"> تأكيد </button> `);
    });
}
function confirmdeletelevel () {
    document.querySelector('ul.notifications li').remove();
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم الحذف بنجاح.');
                    popup.classList.remove('open');
                    deletebut.parentElement.parentElement.parentElement.parentElement.remove();
                    option4.style.visibility = 'hidden';
                    option5.style.visibility = 'hidden';
                    searchArea.style.visibility = 'hidden';
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deleteLevel&userid=${deletebut.dataset.userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&teacherid=${teacherid}`);
    // }
}

// ==================================== End actions on levels course =========================


// ==================================== Start actions on subject course =========================
function courseLeveleClick (ele) {
    levelID = ele.value;
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        option4.style.visibility = 'visible';
        option4.style.height = '100px';
        let loading = document.createElement('div');
        loading.classList.add('loading');
        option4.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    option4.innerHTML = response[0];
                    option4.innerHTML += `<div class="add-lable"><label onclick="openPopupOption4()"><i class="fa-regular fa-square-plus"></i></label></div>`;
                }else if (response.indexOf('there is no data to display') > -1) {
                    option4.innerHTML = 'لم يتم إضافة أي مستويات لهذه الدورة .';
                    option4.innerHTML += `<div class="add-lable"><label onclick="openPopupOption4()"><i class="fa-regular fa-square-plus"></i></label></div>`;
                    option5.style.visibility = 'hidden';
                    searchArea.style.visibility = 'hidden';
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=subjects&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&teacherid=${teacherid}`);
        option4.style.height = 'fit-content';
    // }
}
function openPopupOption4 () {
    popup.classList.add('open');
    headPopup.innerHTML = 'أضف المواد الجديدة لهذا المستوى  ...';
    contentPopup.innerHTML = `
    <form action="#">
        <input type="hidden" name="action" value="addsubject">
        <input type="hidden" name="cetegoryID" value="${cetegoryID}">
        <input type="hidden" name="courseID" value="${CourseID}">
        <input type="hidden" name="levelID" value="${levelID}">
        <input type="hidden" name="teacherid" value="${teacherid}">
        <div class="course">
            <div class="img-course">
                <label for="imglevel" class="p-relative"> 
                <span>صورة للمادة</span>
                <i class="fa-solid fa-cloud-arrow-up"></i>
                    <input type="file" id="imglevel" name="imglevel" onchange="uploadimg(this)">
                </label>
            </div>
        </div>
        <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20" type="text" name="name" placeholder="اسم المادة" />
        <div class="buttons-popup p-15 pt-0">
            <button class="action-course btn-shape bg-blue c-white d-block w-full">إضافة</button>
        </div>
    </form>`;
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        addsubject (e);
    });
}
function addsubject (ele) {
    popupError.innerHTML = '';
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'action_mangecourse.php');
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    option4.innerHTML = response[0];
                    createToast('success', 'تمت الإضافة بنجاح.');
                    option4.innerHTML += `<div class="add-lable"><label onclick="openPopupOption4()"><i class="fa-regular fa-square-plus"></i></label></div>`;
                    popup.classList.remove('open');
                }else if (response.indexOf('empty') > -1) {
                    popupError.innerHTML = 'يجب ملئ جميع الحقول';
                }else if (response.indexOf('This is not a valid image file') > -1) {
                    popupError.innerHTML = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
                }else if (response.indexOf('There is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    createToast('error', 'لا يوجد مثل هذه البيانات');
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        let formData = new FormData(ele.target);
        xhr.send(formData);
    // }
}
function updateSubject (ele) {
    let data = getdataforeditesubject (ele.dataset.userid);
    labelcont = ele.parentElement.parentElement.parentElement.children[1];
    ele.parentElement.classList.remove('open');
    popup.classList.add('open');
    headPopup.innerHTML = 'عدل هذه المادة ...';
    contentPopup.innerHTML = data;
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        editeSubject (e);
    });
    function getdataforeditesubject (userid) {
        let responsereturn;
        // let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            option4.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        responsereturn = response[0];
                    }else if (response.indexOf('there is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=getdatasubject&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&teacherid=${teacherid}`);
        // }
        return responsereturn;
    }
    function editeSubject (ele) {
        popupError.innerHTML = '';
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            popup.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'action_mangecourse.php');
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        labelcont.innerHTML = response[0];
                        popup.classList.remove('open');
                        createToast('success', 'تم التعديل بنجاح.');
                    }else if (response.indexOf('empty') > -1) {
                        popupError.innerHTML = 'يجب ملئ جميع الحقول';
                    }else if (response.indexOf('This is not a valid image file') > -1) {
                        popupError.innerHTML = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
                    }else if (response.indexOf('There is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                        createToast('error', 'لا يوجد مثل هذه البيانات');
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            let formData = new FormData(ele.target);
            xhr.send(formData);
        // }
    }
}
function deleteSubject (ele) {
    deletebut = ele;
    ele.parentElement.classList.remove('open');
    popup.classList.add('open');
    headPopup.innerHTML = ' تأكيد الحذف  ...';
    contentPopup.innerHTML = ` <div class="c-red"> هل أنت متأكد من حذفك للمادة </div>  
    <div>    لديك 0 مواد و 0 دروس 0 اختبارات   </div>  
    <div class="buttons-popup p-15 pt-0">
        <button class="action-course btn-shape bg-red c-white d-block w-full">تأكيد</button>
    </div>`;
    document.querySelector('.popup .content-popup-child .action-course').addEventListener('click', e => {
        createToast('error', ` هل أنت متأك من حذف هذا المستوى <button class="bg-red c-white btn-shape" onclick="confirmdeletesubject()"> تأكيد </button> `);
    });
}
function confirmdeletesubject () {
    document.querySelector('ul.notifications li').remove();
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم الحذف بنجاح.');
                    popup.classList.remove('open');
                    deletebut.parentElement.parentElement.parentElement.parentElement.remove();
                    option5.style.visibility = 'hidden';
                    searchArea.style.visibility = 'hidden';
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deletesubject&userid=${deletebut.dataset.userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&teacherid=${teacherid}`);
    // }
}

// ==================================== End actions on subject course =========================
function subjectClick (ele) {
    subjectID = ele.value;
    option5.style.visibility = 'visible';
}
function viweInputSearch (ele) {
    classes = ele.value;
    searchArea.style.visibility = 'visible';
}
function search () {
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        addClass.innerHTML = '';
        option2.style.visibility = 'visible';
        option2.style.height = '100px';
        let loading = document.createElement('div');
        loading.classList.add('loading');
        option2.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    responsiveTable.innerHTML = response[0];
                    if (classes === 'lessons' || classes === 'files') {
                        addClass.innerHTML = '<button class="btn-shape bg-blue c-white" onclick="addFiles()">إضافة</button> <button class="btn-shape bg-red c-white" onclick="deleteAllFiles()">حذف الكل</button>';
                    }else if (classes === 'tests') {
                        addClass.innerHTML = '<button class="btn-shape bg-blue c-white" onclick="addTest()">إضافة</button> <button class="btn-shape bg-red c-white" onclick="deleteAllTests()">حذف الكل</button>';
                    }else if (classes === 'schedule') {createDateSchedule();}
                    offset = 1;
                    modeScroll = true;
                }else if (response.indexOf('there is no data to display') > -1) {
                    response = response.split('||');
                    responsiveTable.innerHTML = '<div class="c-red"> لم يتم رفع أي بينات لهذا القسم . </div>';
                    if (classes === 'lessons' || classes === 'files') {
                        addClass.innerHTML = '<button class="btn-shape bg-blue c-white" onclick="addFiles()">إضافة</button> <button class="btn-shape bg-red c-white" onclick="deleteAllFiles()">حذف الكل</button>';
                    }else if (classes === 'tests') {
                        addClass.innerHTML = '<button class="btn-shape bg-blue c-white" onclick="addTest()">إضافة</button> <button class="btn-shape bg-red c-white" onclick="deleteAllTests()">حذف الكل</button>';
                    }else if (classes === 'schedule') {createDateSchedule();}
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=search&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&teacherID=${teacherid}&class=${classes}&data=${InputSearchArea.value}`);
        option2.style.height = 'fit-content';
    // }
}

// ==================================== Start actions On LoadMoreInfo =======================
responsiveTable.addEventListener('scroll', e => {
    let loadMoreSkeleton = document.querySelector('.responsive-table .load-more-skeleton');
    let tableBody = document.querySelector('.mange-cours div.table table .body-search');
    if (modeScroll == true) {
        if ((responsiveTable.scrollHeight - responsiveTable.scrollTop) < (responsiveTable.clientHeight + 40)) {
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let xhr = new XMLHttpRequest();
                xhr.onload = () => {
                    let response = xhr.responseText;
                    console.log(response);
                    if (response.indexOf('success') > -1) {
                        offset++;
                        if (loadMoreSkeleton) {
                            loadMoreSkeleton.remove();
                        }
                        tableBody.innerHTML += response.replace('success', '');
                        loadMoreSkeleton.remove();
                    }else if (response.indexOf('That is all information') > -1) {
                        modeScroll = false;
                    }
                }
                xhr.open("POST", "action_mangecourse.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=loadmoreinfo&offset=${offset}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&teacherID=${teacherid}&class=${classes}`);
            // }
        }
    }else {
        if (loadMoreSkeleton) {
            loadMoreSkeleton.remove();
            tableBody.innerHTML += '<h3 class="c-red nowrap"> هذه جميع معلوماتك الواردة </h3>';
        }
    }
});
// ==================================== End actions On LoadMoreInfo =========================

// ==================================== Start actions On Files ========================
function showVL(ele) {
    let type = ele.dataset.type;
    let url = popup.querySelector('input[type=url]');
    let imgcont = popup.querySelector('.img-course');
    if (type === 'video') {
        url.style.display = 'none';
        imgcont.style.display = 'block';
    }else if (type === 'link') {
        url.style.display = 'block';
        imgcont.style.display = 'none';
    }
}
function addFiles () {
    popup.classList.add('open');
    let nameFile = '';
    let optionvideo = '';
    if (classes === 'lessons') {
        headPopup.innerHTML = ' أضف درسا جديدا ...';
        nameFile = 'الدرس';
        optionvideo = '<div class="d-flex align-center b-none mb-20 option">  <input type="radio" name="typevideo" id="video" value="video" checked/> <label for="video" data-type="video" onclick="showVL(this)">فيديو</label>  <input type="radio" name="typevideo" id="link" value="link"/> <label for="link" data-type="link" onclick="showVL(this)">رابط</label>  </div>';
    }else if (classes === 'files') {
        headPopup.innerHTML = ' أضف ملفا جديدا ...';
        nameFile = 'الملف';
        optionvideo = '';
    }
    popupError.innerHTML = '';
    contentPopup.innerHTML = `
        <form action="#">
            ${optionvideo}
            <div class="course">
                <div class="img-course">
                    <span></span>
                    <label for="file" class="p-relative"> 
                    <span> ${nameFile} </span>
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                        <input type="file" name="file" id="file">
                    </label>
                </div>
                <div class="progress-Area"></div>
                <input type="hidden" name="action" value="insertfile">
                <input type="hidden" name="cetegoryID" value="${cetegoryID}">
                <input type="hidden" name="courseID" value="${CourseID}">
                <input type="hidden" name="levelID" value="${levelID}">
                <input type="hidden" name="subjectID" value="${subjectID}">
                <input type="hidden" name="class" value="${classes}">
                <input type="hidden" name="teacherid" value="${teacherid}">
            </div>
            <input class="b-none border-ccc p-10 rad-6 d-block w-full mb-20 mt-20" type="text" name="title" placeholder="العنوان">
            <input class="b-none border-ccc p-10 rad-6 d-block w-full mb-20 mt-20" type="url" name="link" placeholder="الرابط" style="display: none;">
            <div class="buttons-popup p-15 pt-0"><button class="btn-shape bg-blue c-white d-block w-full submit">إضافة</button></div>
        </form>
    `;
    let form = document.querySelector('.popup .content-popup-child form');
    let button = document.querySelector('.popup .content-popup-child button.submit');
    let progressArea = document.querySelector('.popup .content-popup-child .course .progress-Area');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        insertFiles (e);
    });
    function insertFiles (ele) {
        let tableBody = document.querySelector('.mange-cours div.table table .body-search');
        let file;  
        if (classes == 'lessons') {
            file = ele.target[2].files[0];
        }else {
            file = ele.target[0].files[0];
        }
        popupError.innerHTML = '';
        if (file) {
            let fileName = file.name;
            let inputs = document.querySelectorAll('.popup .content-popup-child input[type="hidden"]');
            let input = document.querySelector('.popup .content-popup-child input[type="text"]');
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let empty = false;
                inputs.forEach( ele => {if (ele.value.length === 0) {empty = true;}});
                if (input.value.length === 0 || empty === true) {
                    popupError.innerHTML = 'يجب ملئ جميع الحقول';
                }else {
                    let fileAllowedExte;
                    if (classes === 'lessons') {
                        fileAllowedExte = ['mp4'];
                    }else if (classes === 'files') {
                        fileAllowedExte = ['docx', 'pdf', 'pptx'];
                    }
                    let fileAllowed = false;
                    let file_E = fileName.split('.');
                    fileAllowedExte.forEach ( ele => {if (file_E.at(-1) === ele) {fileAllowed = true;}});
                    if (fileAllowed === false) {
                        if (classes === 'lessons') {
                            popupError.innerHTML = 'إمتداد هذا الفيديو غير مسموح به، استخدم فيديو بهذه الإمتدادات mp4';
                        }else if (classes === 'files') {
                            popupError.innerHTML = 'إمتداد هذا الملف غير مسموح به، استخدم ملف بهذه الإمتدادات docx, pdf, pptx';
                        }
                    }else {
                        popupError.innerHTML = 'جار التحميل ... الرجاء الانتظار قليلا.';
                        button.remove();
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', 'action_mangecourse.php');
                        xhr.upload.addEventListener('progress', ({loaded, total}) => {
                            let fileLoaded = Math.floor((loaded / total) * 100);
                            let fileTotal = Math.floor(total / 1024);
                            let fileSize;
                            if (fileName.length >= 12) {
                                let spiltName = fileName.split('.');
                                fileName = spiltName[0].substring(0, 12) + ' ... .' + spiltName[1];
                            }
                            (fileTotal < 1024) ? fileSize = fileTotal + ' KB' : fileSize = (fileTotal / (1024)).toFixed(2) + ' MB';
                            progressArea.innerHTML = `
                            <div class="row">
                                <div class="content">
                                    <div class="details">
                                        <span class="parcent"> ${fileLoaded}% </span>
                                        <span class="name"> جار التحميل ... # ${fileName} </span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: ${fileLoaded}%;"></div>
                                    </div>
                                    <div class="size"> الحجم : ${fileSize} </div>
                                </div>
                                <i class="fas fa-file-alt"></i>
                            </div>
                            `;
                        });
                        xhr.onload = () => {
                            if (xhr.status == 200 && xhr.readyState == 4) {
                                let response = xhr.responseText;
                                console.log(response)
                                tableBody.innerHTML += response;
                                popup.classList.remove('open');
                                createToast('success', 'تمت الإضافة بنجاح.');
                            }
                        }
                        let formData = new FormData(ele.target);
                        xhr.send(formData);
                    }
                }
            // }
        }else {
            if (popup.querySelectorAll('input[type=radio]')[1] && popup.querySelectorAll('input[type=radio]')[1].checked && classes == 'lessons') {
                let title = popup.querySelector('input[name="title"]').value;
                let url = popup.querySelector('input[name="link"]').value;
                // let modeOnline = checkOnline();
                // if (modeOnline == 'offline') {
                //     checkOnline('work');
                // }else {
                    let loading = document.createElement('div');
                    loading.classList.add('loading');
                    popup.append(loading);
                    let xhr = new XMLHttpRequest();
                    xhr.onload = () => {
                        if (xhr.status == 200 && xhr.readyState == 4) {
                            let response = xhr.responseText;
                            console.log(response);
                            loading.remove();
                            if (response.indexOf('success') > -1) {
                                createToast('success', 'تمت الإضافة بنجاح .');
                                popup.classList.remove('open');
                                document.querySelector('.sec-ques ul').insertAdjacentHTML('beforeend', response.split('||')[0]);
                            }else if (response.indexOf('there is no that id') > -1) {
                                popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                            }else if (response.indexOf('error') > -1) {
                                createToast('error', 'هناك خطأ ما أعد المحاولة.');
                            }
                        }
                    }
                    xhr.open("POST", "action_mangecourse.php", false);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send(`action=insertfile&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}&typevideo=link&title=${title}&url=${url}`);
                // }
            }else {
                popupError.innerHTML = 'يجب إضافة ملف.';
            }
        }
    }
}
function editFiles (ele) {
    let userid = ele.dataset.userid;
    let data = getDataFiles(userid);
    popup.classList.add('open');
    if (classes === 'lessons') {
        headPopup.innerHTML = 'تعديل الدرس  ...';
    }else {
        headPopup.innerHTML = 'تعديل الملف  ...';
    }
    contentPopup.innerHTML = data;
    let trelement = ele.parentElement.parentElement.parentElement;
    function getDataFiles (userid) {
        let responsereturn;
        // let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            ele.parentElement.parentElement.parentElement.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        responsereturn = response[0];
                    }else if (response.indexOf('there is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=getdatafile&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
        // }
        return responsereturn;
    }
    let form = document.querySelector('.popup .content-popup-child form');
    let button = document.querySelector('.popup .content-popup-child button.submit');
    let progressArea = document.querySelector('.popup .content-popup-child .course .progress-Area');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        updateFile (e);
    });
    function updateFile (ele) {
        let file;  
        if (classes == 'lessons') {
            file = ele.target[2].files[0];
        }else {
            file = ele.target[0].files[0];
        }
        popupError.innerHTML = '';
        if (file) {
            let fileName = file.name;
            let inputs = document.querySelectorAll('.popup .content-popup-child input[type="hidden"]');
            let input = document.querySelector('.popup .content-popup-child input[type="text"]');
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let empty = false;
                if (input.value.length === 0 || empty === true) {
                    popupError.innerHTML = 'يجب ملئ جميع الحقول';
                }else {
                    let fileAllowedExte;
                    if (classes === 'lessons') {
                        fileAllowedExte = ['mp4'];
                    }else if (classes === 'files') {
                        fileAllowedExte = ['docx', 'pdf', 'pptx'];
                    }
                    let fileAllowed = false;
                    let file_E = fileName.split('.');
                    fileAllowedExte.forEach ( ele => {if (file_E.at(-1) === ele) {fileAllowed = true;}});
                    if (fileAllowed === false) {
                        if (classes === 'lessons') {
                            popupError.innerHTML = 'إمتداد هذا الفيديو غير مسموح به، استخدم فيديو بهذه الإمتدادات mp4';
                        }else if (classes === 'files') {
                            popupError.innerHTML = 'إمتداد هذا الملف غير مسموح به، استخدم ملف بهذه الإمتدادات docx, pdf, pptx';
                        }
                    }else {
                        popupError.innerHTML = 'جار التحميل ... الرجاء الانتظار قليلا.';
                        button.remove();
                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', 'action_mangecourse.php');
                        xhr.upload.addEventListener('progress', ({loaded, total}) => {
                            let fileLoaded = Math.floor((loaded / total) * 100);
                            let fileTotal = Math.floor(total / 1024);
                            let fileSize;
                            if (fileName.length >= 12) {
                                let spiltName = fileName.split('.');
                                fileName = spiltName[0].substring(0, 12) + ' ... .' + spiltName[1];
                            }
                            (fileTotal < 1024) ? fileSize = fileTotal + ' KB' : fileSize = (fileTotal / (1024)).toFixed(2) + ' MB';
                            progressArea.innerHTML = `
                            <div class="row">
                                <div class="content">
                                    <div class="details">
                                        <span class="parcent"> ${fileLoaded}% </span>
                                        <span class="name"> جار التحميل ... # ${fileName} </span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress" style="width: ${fileLoaded}%;"></div>
                                    </div>
                                    <div class="size"> الحجم : ${fileSize} </div>
                                </div>
                                <i class="fas fa-file-alt"></i>
                            </div>
                            `;
                        });
                        xhr.onload = () => {
                            if (xhr.status == 200 && xhr.readyState == 4) {
                                let response = xhr.responseText;
                                console.log(response)
                                response = response.split('||');
                                trelement.innerHTML = response[0];
                                popup.classList.remove('open');
                                createToast('success', 'تم التعديل بنجاح .');
                            }
                        }
                        let formData = new FormData(ele.target);
                        xhr.send(formData);
                    }
                }
            // }
        }else {
            let inputs = document.querySelectorAll('.popup .content-popup-child input[type="hidden"]');
            let input = document.querySelector('.popup .content-popup-child input[type="text"]');
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let empty = false;
                inputs.forEach( ele => {if (ele.value.length === 0) {empty = true;}});
                console.log(empty);
                if (input.value.length === 0 || empty === true) {
                    popupError.innerHTML = 'يجب ملئ جميع الحقول';
                }else {
                    popupError.innerHTML = 'جار التحميل ... الرجاء الانتظار قليلا.';
                    button.remove();
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', 'action_mangecourse.php');
                    xhr.onload = () => {
                        if (xhr.status == 200 && xhr.readyState == 4) {
                            let response = xhr.responseText;
                            console.log(response);
                            if (response.indexOf('success') > -1) {
                                response = response.split('||');
                                popup.classList.remove('open');
                                trelement.innerHTML = response[0];
                                createToast('success', 'تم التعديل بنجاح.');
                            }else if (response.indexOf('empty') > -1) {
                                popupError.innerHTML = 'يجب ملئ جميع الحقول';
                            }else if (response.indexOf('This is not a valid image file') > -1) {
                                popupError.innerHTML = 'إمتداد هذا الفيديو غير مسموح به، استخدم فيديو بهذه الإمتدادات mp4';
                            }else if (response.indexOf('There is no that id') > -1) {
                                popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                                createToast('error', 'لا يوجد مثل هذه البيانات');
                            }else if (response.indexOf('error') > -1) {
                                createToast('error', 'هناك خطأ ما أعد المحاولة.');
                            }
                        }
                    }
                    let formData = new FormData(ele.target);
                    xhr.send(formData);
                }
            // }
        }
    }
}
function viweFiles (ele) {
    let userid = ele.dataset.userid;
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        console.log(ele.parentElement.parentElement.parentElement)
        ele.parentElement.parentElement.parentElement.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    headPopup.innerHTML = ' معلومات أكثر عن الملف ...';
                    popupError.innerHTML = '';
                    popup.classList.add('open');
                    contentPopup.innerHTML = response[0];
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=moreinfofile&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
    // }
}
function deleteFiles (ele) {
    trelement = ele.parentElement.parentElement.parentElement
    let userid = ele.dataset.userid;
    popup.classList.add('open');
    headPopup.innerHTML = ' تأكيد الحذف  ...';
    contentPopup.innerHTML = ` <div class="c-red"> هل أنت متأكد من حذفك للدرس </div>  
    <div class="buttons-popup p-15 pt-0">
        <button class="btn-shape bg-red c-white d-block w-full confirm">تأكيد</button>
    </div>`;
    document.querySelector('.popup .content-popup-child .confirm').addEventListener('click', e => {
        createToast('error', ` هل أنت متأك من حذف هذا للدرس <button class="bg-red c-white btn-shape" onclick="confirmdeletefile('${userid}')"> تأكيد </button> `);
    });
}
function confirmdeletefile (userid) {
    document.querySelector('ul.notifications li').remove();
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم الحذف بنجاح.');
                    popup.classList.remove('open');
                    trelement.remove();
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deletefile&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
    // }
}
function deleteAllFiles () {
    popup.classList.add('open');
    headPopup.innerHTML = ' تأكيد الحذف  ...';
    contentPopup.innerHTML = ` <div class="c-red"> هل أنت متأكد من حذفك لجمع الدروس </div>  
    <div class="buttons-popup p-15 pt-0">
        <button class="btn-shape bg-red c-white d-block w-full confirm">تأكيد</button>
    </div>`;
    document.querySelector('.popup .content-popup-child .confirm').addEventListener('click', e => {
        createToast('error', ` هل أنت متأك من حذف هذا لجميع الدروس <button class="bg-red c-white btn-shape" onclick="confirmdeleteallfile()"> تأكيد </button> `);
    });
}
function confirmdeleteallfile () {
    document.querySelector('ul.notifications li').remove();
    createToast('error', ` هل أنت متأك من حذف هذا لجميع الدروس للمرة الأخيرة !!! <button class="bg-red c-white btn-shape" onclick="confirmtheconfirmdeleteallfile()"> تأكيد الحذف للمرة الأخيرة </button> `);
}
function confirmtheconfirmdeleteallfile () {
    let tableBody = document.querySelector('.mange-cours div.table table .body-search');
    document.querySelector('ul.notifications li').remove();
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم حذف جميع الدروس بنجاح.');
                    popup.classList.remove('open');
                    tableBody.innerHTML = '<div class="c-green"> تم حذف جميع البيانات بنجاح </div>';
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deleteallfile&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
    // }
}
// ==================================== End Actions On Files =========================

// ==================================== Start Actions Test =========================
let trelement;
function addTest () {
    popup.classList.add('open');
    headPopup.innerHTML = ' أضف إختبارا جديدا ...';
    popupError.innerHTML = '';
    contentPopup.innerHTML = `
        <form>
            <input type="hidden" name="action" value="addTest">
            <input type="hidden" name="cetegoryID" value="${cetegoryID}">
            <input type="hidden" name="courseID" value="${CourseID}">
            <input type="hidden" name="levelID" value="${levelID}">
            <input type="hidden" name="subjectID" value="${subjectID}">
            <input type="hidden" name="class" value="${classes}">
            <input type="hidden" name="teacherid" value="${teacherid}">
            <input class="border-ccc p-10 rad-6 d-block w-full" type="text" name="title" placeholder="العنوان">
            <label for="duration" class="mt-15"> الوقت </label>
            <select class="border-ccc p-10 rad-6 d-block w-full" name="duration" id="duration">
                <option value="one"> دقيقة لكل سؤال </option>
                <option value="tow"> دقيقتين لكل سؤال </option>
                <option value="infinity"> مفتوح </option>
            </select>
            <label for="countattempts" class="mt-15"> عدد المحاولات </label>
            <select class="border-ccc p-10 rad-6 d-block w-full" name="countattempts" id="countattempts">
                <option value="infinity">لا نهائي</option>
                <option value="oneattempt">محاولة واحدة</option>
            </select>
            <div class="buttons-popup p-15 pt-0"><button class="btn-shape bg-blue c-white d-block w-full submit">إضافة</button></div>
        </form>
    `;
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        insertTest (e);
    });
    function insertTest (ele) {
        let inputText = document.querySelector('.popup .content-popup-child input[type="text"]');
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let empty = false;
            if (inputText.value.length === 0) {
                popupError.innerHTML = 'يجب ملئ جميع الحقول';
            }else {
                let tableBody = document.querySelector('.mange-cours div.table table .body-search');
                popupError.innerHTML = '';
                let loading = document.createElement('div');
                loading.classList.add('loading');
                popup.append(loading);
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'action_mangecourse.php');
                xhr.onload = () => {
                    if (xhr.status == 200 && xhr.readyState == 4) {
                        let response = xhr.responseText;
                        loading.remove();
                        console.log(response);
                        if (response.indexOf('success') > -1) {
                            popup.classList.remove('open');
                            response = response.split('||');
                            tableBody.innerHTML += response[0];
                            createToast('success', 'تمت الإضافة بنجاح ...');
                        }else if (response.indexOf('empty') > -1) {
                            createToast('error', 'يجب ملئ جميع الحقول .');
                        }else if (response.indexOf('There is no that id') > -1) {
                            createToast('error', 'يجب ملئ جميع الحقول .');
                        }else if (response.indexOf('There is no that id') > -1) {
                            createToast('error', 'هناك خطأ ما أعد المحاولة.');
                        }
                    }
                }
                let formData = new FormData(ele.target);
                xhr.send(formData);
            }
        // }
    }
}
function editTest (ele) {
    let userid = ele.dataset.userid;
    let data = getDataTest(userid);
    popup.classList.add('open');
    headPopup.innerHTML = 'تعديل الإختبار  ...';
    contentPopup.innerHTML = data;
    let trelement = ele.parentElement.parentElement.parentElement;
    function getDataTest (userid) {
        let responsereturn;
        // let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            ele.parentElement.parentElement.parentElement.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        responsereturn = response[0];
                    }else if (response.indexOf('there is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=getdatatest&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
        // }
        return responsereturn;
    }
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        updateTest (e);
    });
    function updateTest (ele) {
        popupError.innerHTML = '';
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            popup.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'action_mangecourse.php');
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        loading.remove();
                        trelement.innerHTML = response[0];
                        popup.classList.remove('open');
                        createToast('success', 'تم التعديل بنجاح.');
                    }else if (response.indexOf('empty') > -1) {
                        popupError.innerHTML = 'يجب ملئ جميع الحقول';
                    }else if (response.indexOf('There is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                        createToast('error', 'لا يوجد مثل هذه البيانات');
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            let formData = new FormData(ele.target);
            xhr.send(formData);
    }
}
function viweTest (ele) {
    let userid = ele.dataset.userid;
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        ele.parentElement.parentElement.parentElement.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.split('||');
                    headPopup.innerHTML = ' معلومات أكثر عن الإختبار ...';
                    popupError.innerHTML = '';
                    popup.classList.add('open');
                    contentPopup.innerHTML = response[0];
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=moreinfotest&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
    // }
}
function deleteTest (ele) {
    let userid = ele.dataset.userid;
    trelement = ele.parentElement.parentElement.parentElement;
    createToast('error', ` هل أنت متأك من حذف هذا للدرس <button class="bg-red c-white btn-shape" onclick="confirmdeletetest('${userid}','${trelement}')"> تأكيد </button> `);
}
function confirmdeletetest (userid) {
    document.querySelector('ul.notifications li').remove();
        // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم الحذف بنجاح.');
                    trelement.remove();
                }else if (response.indexOf('there is no that id') > -1) {
                    createToast('لا يوجد مثل هذه البيانات');
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deletetest&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
    // }
}
function deleteAllTests () {
    popup.classList.add('open');
    headPopup.innerHTML = ' تأكيد الحذف  ...';
    contentPopup.innerHTML = ` <div class="c-red"> هل أنت متأكد من حذفك لجمع الإختبارات </div>  
    <div class="buttons-popup p-15 pt-0">
        <button class="btn-shape bg-red c-white d-block w-full confirm">تأكيد</button>
    </div>`;
    document.querySelector('.popup .content-popup-child .confirm').addEventListener('click', e => {
        createToast('error', ` هل أنت متأك من حذف هذا لجميع الإختبارات <button class="bg-red c-white btn-shape" onclick="confirmdeletealltest()"> تأكيد </button> `);
    });
}
function confirmdeletealltest () {
    let tableBody = document.querySelector('.mange-cours div.table table .body-search');
    document.querySelector('ul.notifications li').remove();
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم حذف جميع الدروس بنجاح.');
                    popup.classList.remove('open');
                    tableBody.innerHTML = '<div class="c-green nowrap"> تم حذف جميع البيانات بنجاح </div>';
                }else if (response.indexOf('there is no that id') > -1) {
                    popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deletealltest&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}`);
    // }
}
// ==================================== End Actions Test =========================

function openPopupsecques (ele) {
    popup.classList.add('open');
    headPopup.innerHTML = 'أضف قسم للأسئلة ...';
    let content = `
        <input class="b-none border-ccc p-10 rad-6 d-block w-full mt-20 mb-20" type="text" name="title" placeholder="القسم">
        <button class="btn-shape bg-blue c-white d-block w-full" onclick="addsec()">إضافة</button>
    `;
    contentPopup.innerHTML = content;
}
function addsec () {
    let input = popup.querySelector('input');
    if (input.value.length == 0) {
        popupError.innerHTML = 'يجب ملئ جميع الحقول ...';
    }else {
        // let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            popup.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        createToast('success', 'تم إضافة القسم بنجاح .');
                        popup.classList.remove('open');
                        document.querySelector('.sec-ques ul').insertAdjacentHTML('beforeend', response.split('||')[0]);
                    }else if (response.indexOf('there is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=addsecques&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&class=${classes}&teacherid=${teacherid}&title=${input.value}`);
        // }
    }
}
function updatesecques (ele) {
    let data = getdataforeditesecques (ele.dataset.userid);
    labelcont = ele.parentElement.parentElement.parentElement.children[0];
    ele.parentElement.classList.remove('open');
    popup.classList.add('open');
    headPopup.innerHTML = 'عدل هذا القسم ...';
    contentPopup.innerHTML = data;
    let form = document.querySelector('.popup .content-popup-child form');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        editesecques (e);
    });
    function getdataforeditesecques (userid) {
        let responsereturn;
        // let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            option4.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        responsereturn = response[0];
                    }else if (response.indexOf('there is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            xhr.open("POST", "action_mangecourse.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=getdatasecques&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&teacherid=${teacherid}`);
        // }
        return responsereturn;
    }
    function editesecques (ele) {
        popupError.innerHTML = '';
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            popup.append(loading);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'action_mangecourse.php');
            xhr.onload = () => {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        response = response.split('||');
                        labelcont.innerHTML = response[0];
                        popup.classList.remove('open');
                        createToast('success', 'تم التعديل بنجاح.');
                    }else if (response.indexOf('empty') > -1) {
                        popupError.innerHTML = 'يجب ملئ جميع الحقول';
                    }else if (response.indexOf('This is not a valid image file') > -1) {
                        popupError.innerHTML = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
                    }else if (response.indexOf('There is no that id') > -1) {
                        popupError.innerHTML = 'لا يوجد مثل هذه البيانات';
                        createToast('error', 'لا يوجد مثل هذه البيانات');
                    }else if (response.indexOf('error') > -1) {
                        createToast('error', 'هناك خطأ ما أعد المحاولة.');
                    }
                }
            }
            let formData = new FormData(ele.target);
            xhr.send(formData);
        // }
    }
}
function deletesecques (ele) {
    let userid = ele.dataset.userid;
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let loading = document.createElement('div');
        loading.classList.add('loading');
        popup.append(loading);
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if (xhr.status == 200 && xhr.readyState == 4) {
                let response = xhr.responseText;
                console.log(response);
                loading.remove();
                if (response.indexOf('success') > -1) {
                    ele.parentElement.parentElement.parentElement.remove();
                    createToast('success', 'تم الحذف بنجاح.');
                }else if (response.indexOf('there is no that id') > -1) {
                    createToast('error','لا يوجد مثل هذه البيانات');
                }else if (response.indexOf('error') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة.');
                }
            }
        }
        xhr.open("POST", "action_mangecourse.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=deletesecques&userid=${userid}&cetegoryID=${cetegoryID}&courseID=${CourseID}&levelID=${levelID}&subjectID=${subjectID}&teacherid=${teacherid}`);
    // }
}
// ==================================== Start Schedule =========================
function createDateSchedule () {
    let dateCurrent = document.querySelectorAll('table.schedule thead td div span');
    let ToDay = new Date();
    let date = new Date();
    function getWeeklyDate () {
        let dateToDay = date.getDate();
        let currDay = date.getDay();
        let currYear = date.getFullYear();
        let currMonth = date.getMonth();
        for (let i = 1; i < 8; i++) {
            dateCurrent[i-1].parentElement.classList.remove('c-blue');
            let customDate = new Date(currYear, currMonth, dateToDay - currDay + i-1).getDate();
            let newMonth = new Date(currYear, currMonth, dateToDay - currDay + i-1).getMonth();
            let newYear = new Date(currYear, currMonth, dateToDay - currDay + i-1).getFullYear();
            if (ToDay.getFullYear() === newYear && ToDay.getMonth() === newMonth && ToDay.getDate() === customDate) {
                dateCurrent[i-1].parentElement.classList.add('c-blue');
            }
            if (newMonth+1 < 10) {newMonth = `0${newMonth+1}`; }else {newMonth = `${newMonth+1}`;}
            if (customDate < 10) {customDate = `0${customDate}`; }else {customDate = `${customDate}`;}
            dateCurrent[i-1].innerHTML = `${newYear}/${newMonth}/${customDate}`;

        }
    }
    getWeeklyDate ();
    document.querySelectorAll('.responsive-table > div.buttons-next-prev > span').forEach( ele => {
        ele.addEventListener('click', e => {
            if (ele.className === 'next') {
                let dateSpilt = dateCurrent[6].innerHTML.split('/');
                plusDay = Number(dateSpilt[2])+1;
                if (plusDay === 32) {
                    date.setDate(plusDay);
                }else {
                    date = new Date(`${dateSpilt[0]}/${dateSpilt[1]}/${plusDay}`);
                }
            }else {
                let dateSpilt = dateCurrent[0].innerHTML.split('/');
                minusDay = Number(dateSpilt[2])-1;
                if (minusDay == 0) {
                    date.setDate(minusDay);
                }else {
                    date = new Date(`${dateSpilt[0]}/${dateSpilt[1]}/${minusDay}`);
                }
            }
            getWeeklyDate ();
        })
    });
}
// ==================================== End Schedule =========================