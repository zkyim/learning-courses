// إزالة التعليق عن التحقق من الإنترنت

let responsiveTable = document.querySelector('.responsive-table');
let bodyTabelMembers = document.querySelector(".body-tabel-members");

// ===================================== Start Popup Add Course =====================================
let popup = document.querySelector('.popup');
let headPopup = document.querySelector('.popup .head-popup > span');
let moreDetailsContent = document.querySelector('.popup .moredetails');
let activeMemberContent = document.querySelector('.popup .active-member');


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

// ===================================== End Popup Add Course ==================================

// ===================================== Start Search Form =====================================
let offset = 1;
let modeScroll = true;
let where = ' AND O_RegStatus = 0 '; 
let searchForm = document.querySelector('.search-members-form');
searchForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let loading = document.createElement('div');
    loading.className = 'loading';
    responsiveTable.appendChild(loading);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'action_members.php');
    xhr.onload = () => {
        if (xhr.status === 200 && xhr.readyState === 4) {
            let response = xhr.responseText;
            console.log(response);
            loading.remove();
            if (response.indexOf('success') > -1) {
                response = response.split('||');
                bodyTabelMembers.innerHTML = response[0].replace('success', '');
                updateButtons ();
                offset = 1;
                modeScroll = true;
                where = response[1];
            }else if (response.indexOf('There is no data') > -1) {
                bodyTabelMembers.innerHTML = '<h3 class="c-red nowrap">لا يوجد أي من هذه البيانات</h3>';
            }
        }
    }
    let formData = new FormData(searchForm);
    xhr.send(formData);
});

// ===================================== End Search Form =====================================

let inputs = document.querySelectorAll('.popup input');
let error = document.querySelector('.popup .error');
let inableMemberButton;
let studentid; 
let indexele;


document.querySelector('.popup .chainge-status-form').addEventListener('submit', e => {
    e.preventDefault();
    if (inputs[0].value === '' || inputs[1].value === '') { 
        error.innerHTML = ' يجب ملئ جميع الحقول ';
    }else {
        let modeOnline = checkOnline();
        // if (modeOnline == 'offline') {
        //     checkOnline('work');
        // }else {
            let loading = document.createElement('div');
            loading.classList.add('loading');
            popup.appendChild(loading);
            let xhr = new XMLHttpRequest();
            xhr.onload = () => { 
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = xhr.responseText;
                    console.log(response);
                    loading.remove();
                    if (response.indexOf('success') > -1) {
                        createToast('success', 'تم التفعيل بنجاح');
                        popup.classList.remove('open');
                        console.log(where);
                        if (where.indexOf('O_RegStatus = 0') > -1 || where.indexOf('O_RegStatus = 1') > -1) {
                            inableMemberButton.parentElement.parentElement.parentElement.remove();
                        }else if (where === '') {
                            if (inableMemberButton.innerHTML === 'تعطيل') {
                                inableMemberButton.innerHTML = 'تفعيل'
                                inableMemberButton.classList.remove('bg-red');
                                inableMemberButton.classList.add('bg-green');
                                lableStatus[indexele].innerHTML = 'خامل';
                                lableStatus[indexele].classList.add('bg-red');
                                lableStatus[indexele].classList.remove('bg-green');
                            }else if (inableMemberButton.innerHTML === 'تفعيل') { 
                                inableMemberButton.innerHTML = 'تعطيل'
                                inableMemberButton.classList.remove('bg-green');
                                inableMemberButton.classList.add('bg-red');
                                lableStatus[indexele].innerHTML = 'فعال';
                                lableStatus[indexele].classList.remove('bg-red');
                                lableStatus[indexele].classList.add('bg-green');
                            }
                        }
                        emptyInput ();
                    }else if (response.indexOf('There is no that id') > -1) {
                        createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة');
                    }
                }
            }
            xhr.open("POST", "action_members.php", false);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`action=statusmember&studentid=${inableMemberButton.dataset.id}&teacherid=${teacherid}`);
        // }
    }
});

function emptyInput () {
    inputs.forEach( e => {
        e.value = '';
    });
    error.innerHTML = '';
}

function activeMember () {
    lableStatus = document.querySelectorAll('.responsive-table .label.btn-shape');
    let inableMember = document.querySelectorAll('.responsive-table .inable-member');
    headPopup.innerHTML = 'تغيير حالة العضو ';
    inableMember.forEach( (ele, index) => {
        ele.addEventListener('click', (e) => {
            indexele = index;
            inableMemberButton = e.target;
            popup.classList.add('open');
        })
    });
}
activeMember ();

function updateButtons () {
    activeMember (); 
    viewMoreDetails ();
    view();
}
// ===================================== End Delete Course ====================================

// ===================================== Start View More Details ==================================
function viewMoreDetails () {
    let viewMoreDetailsBut = document.querySelectorAll('table button.view-member');
    viewMoreDetailsBut.forEach( ele => {
        ele.addEventListener('click', e => {
            headPopup.innerHTML = ' معلومات أكثر عن العضو ';
            activeMemberContent.style.display = 'none';
            moreDetailsContent.style.display = 'block';
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
                            popup.classList.add('open');
                            moreDetailsContent.innerHTML = response.replace('success', '');
                        }else if (response.indexOf('There is no that id') > -1) {
                            createToast('error', 'لا يوجد مثل هذه البيانات أعد المحاولة');
                        }
                    }
                }
                xhr.open("POST", "action_members.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=viewMoreDetailsBut&studentid=${id}&teacherid=${teacherid}`);
            // }
        });
    });
}

viewMoreDetails ();
// ===================================== End View More Details ====================================


// ===================================== Start View ==================================

function view () {
    let inableButtons = document.querySelectorAll('table button.inable-member');
    inableButtons.forEach( ele => {
        ele.addEventListener('click', e => {
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
            //     checkOnline('work');
            // }else {
                let id = e.target.dataset.id;
                let loading = document.createElement('div');
                loading.classList.add('loading');
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
                xhr.open("POST", "action_members.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=Status&userid=${id}&teacherid=${teacherid}`);
            // }
        });
    });
}
view ();

// ===================================== End View ====================================


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
                        bodyTabelMembers.innerHTML += response.replace('success', '');
                        updateButtons();
                    }else if (response.indexOf('That is all information') > -1) {
                        modeScroll = false;
                    }
                }
                xhr.open("POST", "action_members.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=loadmoreinfo&offset=${offset}&teacherid=${teacherid}&where=${where}`);
            // }
        }
    }else {
        if (loadMoreSkeleton) {
            loadMoreSkeleton.remove();
            bodyTabelMembers.innerHTML += '<h3 class="c-red nowrap"> هذه جميع دوراتك </h3>';
            updateButtons();
        }
    }
});
// ===================================== End Load More Info ====================================