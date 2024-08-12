let FirstName = document.querySelector('[name=FirstName]');
let SecondName = document.querySelector('[name=SecondName]');
let mail = document.querySelector('[name=mail]');
let pass1 = document.querySelector('[name=Password1]');
let pass2 = document.querySelector('[name=Password2]');
let number = document.querySelector('[name=number]');
let FirstNameError = document.querySelector('.FirstNameError');
let SecondNameError = document.querySelector('.SecondNameError');
let SecondNameError2 = document.querySelector('.SecondNameError2');
let EmailError = document.querySelector('.mail');
let Password1Error = document.querySelector('.Password1Error');
let Password2Error = document.querySelector('.Password2Error');
let Password2Error2 = document.querySelector('.Password2Error2');
let numberError = document.querySelector('.Number');
let noteq = document.querySelector('.noteq');




document.forms[0].onsubmit = (e) => {

    FirstNameError.innerHTML = '';
    SecondNameError.innerHTML = '';
    SecondNameError2.innerHTML = '';
    EmailError.innerHTML = '';
    Password1Error.innerHTML = '';
    Password2Error.innerHTML = '';
    Password2Error2.innerHTML = '';
    numberError.innerHTML = '';
    noteq.innerHTML = '';

    let fnError = [];
    let snError = [];
    let mailError = [];
    let pass1Error = [];
    let pass2Error = [];
    let noteqpass = [];
    let nuError = [];

    if (FirstName.value == '') {
        fnError.push('يجب ملئ حقل الإسم الأول');
    }
    if (FirstName.value.length > 20) {
        fnError.push('يجب ألا يتجاوز عدد المدخلات 20 مدخل');
    }
    fnError.forEach( error => {
        FirstNameError.innerHTML = error;
    });

    if (SecondName.value == '') {
        snError.push('يجب ملئ حقل إسم الأب');
    }
    if (SecondName.value.length > 20) {
        snError.push('يجب ألا يتجاوز عدد المدخلات 20 مدخل');
    }
    snError.forEach( error => {
        SecondNameError.innerHTML = error;
        SecondNameError2.innerHTML = error;
    });

    if (mail.value == '') {
        mailError.push('يجب ملئ حقل البريد الإمكتروني ');
    }
    if (mail.value.length > 30) {
        mailError.push('يجب ألا يتجاوز عدد المدخلات 30 مدخل');
    }
    mailError.forEach( error => {
        EmailError.innerHTML = error;
    });

    if (pass1.value != pass2.value) {
        noteqpass.push('كلمتا المرور غير متساوة الرجاء التأكد منها');
    }
    noteqpass.forEach( error => {
        noteq.innerHTML = error;
    })

    if (pass1.value == '') {
        pass1Error.push('يجب ملئ حقل كلمة المرور ');
    }
    if (pass1.value.length > 20) {
        pass1Error.push('يجب ألا يتجاوز عدد المدخلات 20 مدخل');
    }
    pass1Error.forEach( error => {
        Password1Error.innerHTML = error;
    });

    if (pass2.value == '') {
        pass2Error.push('يجب ملئ حقل كلمة المرور ');
    }
    if (pass2.value.length > 20) {
        pass2Error.push('يجب ألا يتجاوز عدد المدخلات 20 مدخل');
    }
    pass2Error.forEach( error => {
        Password2Error.innerHTML = error;
        Password2Error2.innerHTML = error;
    });

    if (number.value.length != 10 && number.value != '') {
        nuError.push('يجب أن يكون عدد الأرقام 10 أرقام')
    }
    if (number.value == '') {
        nuError.push('يجب ملئ حقل رقم الهاتف')
    }
    nuError.forEach( error => {
        numberError.innerHTML = error;
    })


    if (fnError != '' || snError != '' || mailError != '' || pass1Error != '' || pass2Error != '' || noteqpass != '' || nuError != '') {
        e.preventDefault();
    }
}


let buttonspan = document.querySelector('.buttons span');
let gallary = document.querySelector('.gallary');

buttonspan.onclick = () => {
    gallary.classList.toggle('open');
}


// ================================= selector =====================================

let selector = Array.from(document.querySelectorAll('.container-selector'));
let titleSelector = Array.from(document.querySelectorAll('.container-selector .title-selector > span'));
let iconTitleSelector = Array.from(document.querySelectorAll('.container-selector .title-selector > i'));
let options = Array.from(document.querySelectorAll('.container-selector .options'));
let label = Array.from(document.querySelectorAll('.container-selector label'));
let learnMore = Array.from(document.querySelectorAll('.container-selector .learn-more'));
let disPlayLearnMore = Array.from(document.querySelectorAll('.container-selector .pairent-show-info'))
let display = Array.from(document.querySelectorAll('.container-selector .display'))
let closeDisPlay = Array.from(document.querySelectorAll('.container-selector .pairent-show-info i'));
let globalIndexSelector = 0;

for (let i = 0; i < learnMore.length; i++) {
    display[i].addEventListener('click', e => {
        e.stopPropagation();
    })
    closeDisPlay[i].addEventListener('click', e => {
        disPlayLearnMore[i].classList.remove('open');
    })
    disPlayLearnMore[i].addEventListener('click', e => {
        disPlayLearnMore[i].classList.remove('open')
    })
}

for (let i = 0; i < selector.length; i++) {
    selector[i].addEventListener('click', e => {
        e.stopPropagation();
        if (options[i].classList.contains('open') === false) {
            options.forEach ( e => {
                e.classList.remove('open');
            });
            iconTitleSelector.forEach ( e => {
                e.style.transform = 'rotate(0deg)';
            })
        }
        options[i].classList.toggle('open');
        iconTitleSelector[i].style.transform = 'rotate(180deg)';
        globalIndexSelector = i;
    })
    options[i].addEventListener('click', e => {
        e.stopPropagation();
    })

    document.addEventListener("click", e => {
        if (e.target !== options[i] && e.target !== selector[i]) {
            if (options[i].classList.contains("open")) {
                options[i].classList.toggle("open");
                iconTitleSelector[i].style.transform = 'rotate(0deg)';
            }
        }
    })
}

label.forEach ( e => {
    e.addEventListener('click', ele => {
        ele.stopPropagation();
        titleSelector[globalIndexSelector].innerText = e.firstChild.firstChild.textContent;
        if (ele.target !== e.lastChild) {
            options[globalIndexSelector].classList.remove('open');
            iconTitleSelector[globalIndexSelector].style.transform = 'rotate(0deg)';
        }
    });
});

learnMore.forEach ( (e, index) => {
    e.addEventListener('click', ele => {
        disPlayLearnMore[index].classList.add('open');
    });
});

