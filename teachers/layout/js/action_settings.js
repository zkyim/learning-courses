let uploadImg = document.querySelector(".settings .container-img .input-avatar");
let avatarImg = document.querySelector(".settings .container-img .avatar-img");
let errorInfoUser = document.querySelector(".settings .info-user .error-info-user");
let form = document.querySelector('.info-user > form');

uploadImg.onchange = () => {
    let file = new FileReader();
    file.readAsDataURL(uploadImg.files[0]);
    file.onload = () => {
        avatarImg.src = file.result;
    }
}
// ===================================== Start Popup Add Course =====================================
let popup = document.querySelector('.settings .popup');
let headPopup = document.querySelector('.settings .popup .head-popup > span');
let popupErrorPass = document.querySelector('.settings .popup .popup-error-pass');
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
// ===================================== Start Edite Info =====================================
form.addEventListener("submit", (e) => {
    e.preventDefault();
    errorInfoUser.innerHTML = '';
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'action_settings.php');
        xhr.onload = () => { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText;
                console.log(response);
                if (response.indexOf('success') > -1) {
                    createToast('success', 'تم تعديل البيانات بنجاح');
                }else if  (response.indexOf('empty') > -1) {
                    errorInfoUser.innerHTML = 'يجب ملئ جميع الحقول';
                }else if (response.indexOf('email is not valid') > -1) {
                    errorInfoUser.innerHTML = 'البريد الإلكتروني غير صحيح أعد المحاولة';
                }else if (response.indexOf('This is not a valid image file') > -1) {
                    errorInfoUser.innerHTML = 'إمتداد هذه الصورة غير مسموح به، استخدم صورة بهذه الإمتدادات jpg , png , jpeg , gif';
                }else if (response.indexOf('img is big') > -1) {
                    errorInfoUser.innerHTML = 'حجم الصورة أكبر من 30 ميجا';
                }else if (response.indexOf('phone number is not a valid number') > -1) {
                    errorInfoUser.innerHTML = 'رقم الجوال يجب أن يكون 10 أحرف';
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', 'هناك خطأ ما أعد المحاولة');
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    // }
});
// ===================================== End Edite Info =====================================
// ===================================== Start Update Social ==================================
let formSocial = document.querySelector('.social-boxes form');
formSocial.addEventListener ('submit', e => {
    e.preventDefault();
    let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'action_settings.php');
        xhr.onload = () => { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText;
                console.log(response);
                if (response.indexOf('success') > -1) {
                    createToast('success', ' تم التعديل بنجاح . ');
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
                }
            }
        }
        let formData = new FormData(formSocial);
        xhr.send(formData);
    // }
});
// ===================================== End Update Social ==================================
// ===================================== Start Change Password ==================================
document.querySelector('.settings .update-pass-but').addEventListener('click', (e) => {
    popup.classList.add('open');
});
function emptyInput () {
    let inputs = document.querySelectorAll('.settings .popup input.password');
    inputs.forEach( input => {
        input.value = '';
    });
    popupErrorPass.innerHTML = '';
};
document.querySelector('.settings .popup .change-pass-but').addEventListener('click', (e) => {
    let empty = true;
    let inputs = document.querySelectorAll('.settings .popup input.password');
    inputs.forEach( input => {
        if (input.value === '') {
            empty = false;
        }
    });
    if (empty === false) {
        popupErrorPass.innerHTML = 'يجب ملئ جميع الحقول.';
    }else {
        if (inputs[1].value !== inputs[2].value) {
            popupErrorPass.innerHTML = 'كلمتا السر الجديدتان غير متطابقتين الرجاء إعادة المحاولة.';
        }else {
            popupErrorPass.innerHTML = '';
            let modeOnline = checkOnline();
            // if (modeOnline == 'offline') {
                //     checkOnline('work');
                // }else {
                    let xhr = new XMLHttpRequest();
                    xhr.onload = () => { 
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            let response = xhr.responseText;
                            console.log(response);
                            if (response.indexOf('success') > -1) {
                                createToast('success', 'تم تغيير كلمة السر بنجاح.');
                                emptyInput();
                            popup.classList.remove('open');
                        }else if (response.indexOf('empty') > -1) {
                            popupErrorPass.innerHTML = 'يجب ملئ جميع الحقول.';
                        }else if (response.indexOf('newpass is not equal to confirmpass') > -1) {
                            popupErrorPass.innerHTML = 'كلمتا السر الجديدتان غير متطابقتين الرجاء إعادة المحاولة.';
                        }else if (response.indexOf('there is no that id') > -1) {
                            createToast('error', 'هناك خطأ ما أعد المحاولة.');
                        }else if (response.indexOf('oldpass is not equal to userpass') > -1) {
                            popupErrorPass.innerHTML = 'كلمة السر القديمة لا توافق التي في حسابك الرجاء إعادة المحاولة.';
                        }else if (response.indexOf('this pass is used') > -1) {
                            popupErrorPass.innerHTML = 'عذرا كلمة السر مستعملة أعد المحاولة.';
                            inputs[1].value = '';
                            inputs[2].value = '';
                        }
                    }
                }
                xhr.open("POST", "action_settings.php", false);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(`action=changepass&userid=${id}&oldpass=${inputs[0].value}&newpass=${inputs[1].value}&confirmpass=${inputs[2].value}`);
                // }
            }
        }
});
// ===================================== End Change Password ==================================
// ===================================== Start Chose Color ================================
let colors = document.querySelectorAll('.design-web .colors span.color');
colors.forEach( (ele) => {
    ele.addEventListener('click', (e) => {
        colors.forEach( (ele) => { ele.classList.remove('active');});
        ele.classList.add('active');
        let xhr = new XMLHttpRequest();
        xhr.onload = () => { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText;
                console.log(response);
                if (response.indexOf('success') > -1) {
                    document.documentElement.style.setProperty('--main-color', e.target.dataset.maincolor);
                    document.documentElement.style.setProperty('--main-color-alt',e.target.dataset.maincoloralt);
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
                }
            }
        }
        xhr.open("POST", "action_settings.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=stylecolor&maincolor=${e.target.dataset.maincolor}&maincoloralt=${e.target.dataset.maincoloralt}`);
    });
});
// ===================================== End Chose Color ==================================
// ===================================== Start Display Links ================================
document.querySelectorAll('.design-web .con-links label').forEach( ele => {
    ele.addEventListener('click', e => {
        let sidebar = document.querySelector('div.sidebar');
        let topHead = document.querySelector('.head div.top-head');
        let designLinks = ele.dataset.designlinks;
        let xhr = new XMLHttpRequest();
        xhr.onload = () => { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText;
                console.log(response);
                if (response.indexOf('success') > -1) {
                    if (designLinks == 'sidelinks') {
                        sidebar.classList.remove('hide');
                        sidebar.classList.remove('close');
                        topHead.classList.add('close');
                    }else if (designLinks == 'toplinks') {
                        sidebar.classList.add('close');
                        topHead.classList.remove('close');
                    }else if (designLinks == 'hidelinks') {
                        sidebar.classList.remove('close');
                        sidebar.classList.add('hide');
                        topHead.classList.add('close');
                    }
                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
                }
            }
        }
        xhr.open("POST", "action_settings.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=designlinks&designlinks=${designLinks}`)
    })
})
// ===================================== End Display Links ==================================