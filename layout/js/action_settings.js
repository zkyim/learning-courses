// ===================================== Start Edite Info =====================================
let form = document.querySelector('.info-user > form');
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
document.querySelector('.settings .update-pass-but').addEventListener('click', (e) => {
    popup.classList.add('open');
});
// ===================================== Start Change Password ==================================

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

