// إزالة التعليق عن التحقق من الإنترنت

let dataUpdateCourse = '';
// ===================================== Start Mxlength Textarea =====================================
let textarea = document.querySelector('.popup-add-course textarea[name="describtion"]');
let length = textarea.getAttribute('maxlength');
let spanLength = document.querySelector('.popup-add-course .spanLength');
spanLength.innerHTML = length;

textarea.oninput = function () {
    let progres = document.querySelector('.popup-add-course .progress');
    spanLength.innerHTML = length - textarea.value.length;
    spanLength.innerHTML == 0 ? spanLength.classList.add('zero') : spanLength.classList.remove('zero');
    progres.style.width = `${100 - (textarea.value.length / length) * 100}%`;
}

// ===================================== End Mxlength Textarea =====================================

let responsiveTable = document.querySelector('.responsive-table');
let bodyTabelCourses = document.querySelector(".body-tabel-courses");
let parentTabelCourses = document.querySelector('.responsive-table');
let modepopupAddCourse = 'add';

// ===================================== Start Popup Add Course =====================================
let popupAddCourse = document.querySelector('.popup-add-course');
let headpopup = document.querySelector('.popup-add-course .head-popup > span');
let footerpopup = document.querySelector('.popup-add-course .buttons-popup');
let viewAddNewCourseForm = document.querySelector('.add-new-course-form');
let viewMoreDetailss = document.querySelector('.popup-add-course .moredetails');
let buttonpopup = document.querySelector('.popup-add-course .action-course');

document.querySelector("button.button-popup").addEventListener('click', (e) => {
    popupAddCourse.classList.add('open');
    modepopupAddCourse = 'add';
    headpopup.innerHTML = 'أضف دورتك الجديدة الآن ...';
    buttonpopup.innerHTML = 'إضافة';
});

popupAddCourse.children[0].addEventListener('click', (e) => {
    e.stopPropagation();
});

popupAddCourse.addEventListener('click', (e) => {
    popupAddCourse.classList.remove('open');
    emptyinput ();
    footerpopup.style.display = 'block';
    viewMoreDetailss.classList.remove('open');
    viewAddNewCourseForm.classList.remove('close');
});

document.querySelector('.popup-add-course .head-popup i').addEventListener('click', (e) => {
    popupAddCourse.classList.remove('open');
    emptyinput ();
    footerpopup.style.display = 'block';
    viewMoreDetailss.classList.remove('open');
    viewAddNewCourseForm.classList.remove('close');
});

// ===================================== End Popup Add Course ==================================

// ===================================== Start Search Form =====================================
let offset = 1;
let modeScroll = true;
let where = '';
let searchForm = document.querySelector('.search-courses-form');
searchForm.addEventListener('submit', (e) => {
    console.log(e)
    e.preventDefault();
    let loading = document.createElement('div');
    loading.className = 'loading';
    parentTabelCourses.appendChild(loading);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'action_courses.php');
    xhr.onload = () => {
        if (xhr.status === 200 && xhr.readyState === 4) {
            let response = xhr.responseText;
            console.log(response);
            loading.remove();
            if (response.indexOf('success') > -1) {
                response = response.split('||');
                bodyTabelCourses.innerHTML = response[0].replace('success', '');
                updateButtons ();
                offset = 1;
                modeScroll = true;
                where = response[1];
            }else if (response.indexOf('There is no data') > -1) {
                bodyTabelCourses.innerHTML = '<h3 class="c-red nowrap">لا يوجد أي من هذه البيانات</h3>';
            }
        }
    }
    let formData = new FormData(searchForm);
    xhr.send(formData);
});

// ===================================== End Search Form =====================================

// ===================================== Start Add New Course =====================================

let uploadImg = document.querySelector(".parent-content-popup .course input[type='file']");
let lable = document.querySelector(".parent-content-popup .course .img-course label");
let containerImg = document.querySelector(".parent-content-popup .course .img-course");

let action = document.querySelector('.popup-add-course input[name="action"]');
let title = document.querySelector('.popup-add-course input[name="title"]');
let Name = document.querySelector('.popup-add-course input[name="name"]');
let description = document.querySelector('.popup-add-course textarea[name="describtion"]');
let price = document.querySelector('.popup-add-course input[type=number]');
let typeCourse = document.querySelector('.popup-add-course select[name="typeCourse"]');
let start = document.querySelector('.popup-add-course input[name="start"]');
let end = document.querySelector('.popup-add-course input[name="end"]');

let error = document.querySelector('.popup-add-course .error');

function emptyinput () {
    if (containerImg.children[2]) {
        containerImg.children[2].remove();
    }
    uploadImg.value = '';
    title.value = '';
    Name.value = '';
    description.value = '';
    price.value = '';
    start.value = '';
    end.value = '';
    error.innerHTML = '';
}

document.querySelector('.action-course').addEventListener('click', e => {
    error.innerHTML = '';
    if (title.value === '' || Name.value === '' || description.value === '' || price.value === '' || start.value === '' || end.value === '') {
        if (modepopupAddCourse == 'add' && uploadImg.value == '') {
            error.innerHTML = 'يجب ملئ جميع الحقول';
        }else if (modepopupAddCourse == 'update') {
            error.innerHTML = 'يجب ملئ جميع الحقول';
        }
    }else {
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            if (modepopupAddCourse == 'add') {
                InsertData('action_courses.php');
            }else if (modepopupAddCourse == 'edit') {
                updateData ();
                emptyinput();
                popupAddCourse.classList.remove('open');
            }
        // }
    }
});

uploadImg.onchange = () => {
    let file = new FileReader();
    file.readAsDataURL(uploadImg.files[0]);
    file.onload = () => {
        let img = document.createElement('img');
        img.src = file.result;
        containerImg.children[1].style.display = 'block';
        if (containerImg.children[2]) {
            containerImg.children[2].remove();
        }
        containerImg.appendChild(img);
        containerImg.style.border = "none";
        lable.classList.add('uploaded');
    }
}

function InsertData (sendTo) {
    action.value = 'addNewCourse';
    let loading = document.createElement('div');
    loading.className = 'loading';
    popupAddCourse.appendChild(loading);
    let form = document.querySelector('.add-new-course-form');
    let xhr = new XMLHttpRequest();
    xhr.open('POST', sendTo);
    xhr.onload = () => { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            loading.remove();
            let response = xhr.responseText;
            console.log(response);
            if (response.indexOf('success') > -1) {
                createToast('success', 'تم إضافة الدورة بنجاح');
                response = response.replace('success', '');
                console.log(response);
                let tr = document.createElement('tr');
                tr.innerHTML = response;
                bodyTabelCourses.appendChild(tr);
                updateButtons ();
                emptyinput();
                popupAddCourse.classList.remove('open');
            }else if  (response.indexOf('empty') > -1) {
                error.innerHTML = 'يجب ملئ جميع الحقول';
            }else if (response.indexOf('error') > -1) {
                createToast('error', 'هناك خطأ ما أعد المحاولة');
            }else if (response.indexOf('This is not a valid image file') > -1) {
                error = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
// ===================================== End Add New Course =====================================

// ===================================== Start Edite Course =====================================

function editeCourseButton () {
    let editeCourse = document.querySelectorAll('.edite-course');
    editeCourse.forEach( ele => {
        ele.addEventListener('click', (e) => {
            console.log('open');
            let id = e.target.dataset.id;
            let loading = document.createElement('div');
            loading.className = 'loading';
            ele.parentElement.parentElement.parentElement.appendChild(loading);
            modepopupAddCourse = 'edit';
            let xhr = new XMLHttpRequest();
            xhr.onload = () => {
                let response = xhr.responseText;
                loading.remove();
                if (response.indexOf('success') > -1) {
                    response = response.replace('success', '');
                    // console.log(response);
                    console.log(JSON.stringify(response));
                    dataUpdateCourse = JSON.parse(JSON.parse(JSON.stringify(response).replace(/\\r\\n/g, '')));
                    addValuesInInputs (dataUpdateCourse);
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة')
                }
            };
            xhr.open("POST", "action_courses.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=getdata&User_ID=${id}`);
            
        })
    });
}

editeCourseButton ();

function addValuesInInputs (data) {
    let img = document.createElement('img');
    img.src = upload + 'imags/imgcourses/' + data.Avatar;
    containerImg.children[1].style.display = 'block';
    containerImg.appendChild(img);
    containerImg.style.border = "none";
    lable.classList.add('uploaded');

    title.value = data.Title;
    Name.value = data.Name;
    description.value = data.Describtion;
    price.value = data.Price;
    start.value = data.Start;
    end.value = data.End;
    popupAddCourse.classList.add('open');
    headpopup.innerHTML = ' تعديل الدورة ';
    buttonpopup.innerHTML = 'تعديل';
}

function updateData () {
    let loading = document.createElement('div');
    loading.className = 'loading';
    popupAddCourse.appendChild(loading);
    document.querySelector('.popup-add-course input[name="userid"]').value = dataUpdateCourse.UserID;
    action.value = 'update';
    let form = document.querySelector('.add-new-course-form');
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'action_courses.php');
    xhr.onload = () => { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            loading.remove();
            console.log(response);
            if (response.indexOf('This is not a valid image file') > -1) {
                error = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
            }else if (response.indexOf('success') > -1) {
                createToast('success', 'تم التعديل بنجاح');
                response = response.replace('success', '');
                document.querySelector(`.edite-course[data-id="${dataUpdateCourse.UserID}"]`).parentElement.parentElement.parentElement.innerHTML = response;
                updateButtons();
            }else if (response.indexOf('There is no that id') > -1) {
                createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة');
            }else if (response.indexOf('empty') > -1) {
                error = 'يجب ملئ جميع الحقول';
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}

// ===================================== End Edite Course =====================================

// ===================================== Start Delete Course ==================================

function deleteCourseButton () {
    let deleteCourse = document.querySelectorAll('.delete-course');
    deleteCourse.forEach( ele => {
        ele.addEventListener('click', (e) => {
            let modeOnline = checkOnline();
            createToast('warning', 'هل تود حذف هذه الدورة فعلا <button class="btn-shape c-white bg-red delete-now"> حذف </button>');
            document.querySelector('.delete-now').addEventListener('click', (elebut) => {
                // if (modeOnline == 'offline') {
                    //     checkOnline('work');
                    // }else {
                    elebut.target.parentElement.parentElement.parentElement.style.display = 'none';
                    let id = e.target.dataset.id;
                    let loading = document.createElement('div');
                    loading.classList.add('loading');
                    ele.parentElement.parentElement.parentElement.appendChild(loading);
                    let xhr = new XMLHttpRequest();
                    xhr.onload = () => { 
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            let response = xhr.responseText;
                            console.log(response);
                            loading.remove();
                            if (response.indexOf('success') > -1) {
                                createToast('success', 'تم الحذف بنجاح');
                                ele.parentElement.parentElement.parentElement.remove();
                            }else if (response.indexOf('There is no that id') > -1) {
                                createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة');
                            }
                        }
                    }
                    xhr.open("POST", "action_courses.php", false);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send(`action=delete&ID=${id}&teacherid=${teacherid}`);
                // }
            });

        })
    });
}

deleteCourseButton ();

function updateButtons () {
    deleteCourseButton (); 
    editeCourseButton ();
    viewMoreDetails ();
    view();
}
// ===================================== End Delete Course ====================================

// ===================================== Start View More Details Course ==================================
function viewMoreDetails () {
    let viewMoreDetailsBut = document.querySelectorAll('.view-course');
    viewMoreDetailsBut.forEach( ele => {
        ele.addEventListener('click', e => {
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let id = e.target.dataset.id;
                let loading = document.createElement('div');
                loading.classList.add('loading');
                ele.parentElement.parentElement.parentElement.appendChild(loading);
                let xhr = new XMLHttpRequest();
                xhr.onload = () => { 
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        let response = xhr.responseText;
                        console.log(response);
                        loading.remove();
                        if (response.indexOf('success') > -1) {
                            viewMoreDetailss.innerHTML = response.replace('success', '');
                            viewMoreDetailss.classList.add('open');
                            viewAddNewCourseForm.classList.add('close');
                            popupAddCourse.classList.add('open');
                            footerpopup.style.display = 'none';
                            headpopup.innerHTML = 'معلومات أكثر';
                        }else if (response.indexOf('There is no that id') > -1) {
                            createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة');
                        }
                    }
                }

                xhr.open("POST", "action_courses.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=viewMoreDetailsBut&userid=${id}&teacherid=${teacherid}`);
            // }
        });
    });
}

viewMoreDetails ();
// ===================================== End View More Details Course ====================================


// ===================================== Start View Course ==================================

function view () {
    let inableButtons = document.querySelectorAll('.inable-course');
    inableButtons.forEach( ele => {
        ele.addEventListener('click', e => {
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let id = e.target.dataset.id;
                let loading = document.createElement('div');
                loading.classList.add('loading');
                ele.parentElement.parentElement.parentElement.appendChild(loading);
                let xhr = new XMLHttpRequest();
                xhr.onload = () => {
                    if (xhr.status == 200 && xhr.readyState == 4) {
                        let response = xhr.responseText;
                        console.log(response);
                        loading.remove();
                        if (response.indexOf('success') > -1) {
                            if (ele.innerHTML == 'إخفاء') {
                                ele.innerHTML = 'إظهار';
                                createToast('success', 'تم إخفاء الدورة بنجاح');
                            }else {
                                ele.innerHTML = 'إخفاء';
                                createToast('success', 'تم إظهار الدورة بنجاح');
                            }
                        }else if (response.indexOf('There is no that id') > -1) {
                            createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة');
                        }
                    }
                }
                xhr.open("POST", "action_courses.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=Status&userid=${id}&teacherid=${teacherid}`);
            // }
        });
    });
}
view ();

// ===================================== End View Course ====================================


// ===================================== Start Load More Info ==================================

responsiveTable.addEventListener('scroll', e => {
    let loadMoreSkeleton = document.querySelector('.responsive-table .load-more-skeleton');
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
                        bodyTabelCourses.innerHTML += response.replace('success', '');
                        updateButtons();
                        loadMoreSkeleton.remove();
                    }else if (response.indexOf('That is all information') > -1) {
                        modeScroll = false;
                    }
                }
                xhr.open("POST", "action_courses.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=loadmoreinfo&offset=${offset}&teacherid=${teacherid}&where=${where}`);
            // }
        }
    }else {
        if (loadMoreSkeleton) {
            loadMoreSkeleton.remove();
            bodyTabelCourses.innerHTML += '<h3 class="c-red nowrap"> هذه جميع دوراتك </h3>';
            updateButtons();
        }
    }
});

// ===================================== End Load More Info ====================================