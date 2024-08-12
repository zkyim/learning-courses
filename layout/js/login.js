let emailInput = document.querySelector('.form input[type="email"]');
let passInput = document.querySelector('.form input[type="password"]');
let emailError = document.querySelector('.form .email-error');
let passError = document.querySelector('.form .pass-error');
let passIcon = document.querySelector('.form .pass-icon');

passIcon.addEventListener('click', e => {
    if (passInput.attributes.type.nodeValue == 'text') {
        passInput.attributes.type.nodeValue = 'password';
        passIcon.classList.add('fa-eye-slash');
        passIcon.classList.remove('fa-eye');
    }else {
        passInput.attributes.type.nodeValue = 'text';
        passIcon.classList.add('fa-eye');
        passIcon.classList.remove('fa-eye-slash');
    }
});

document.forms[0].onsubmit = (e) => {
    emailError.innerHTML = '';
    passError.innerHTML = '';

    if (emailInput.value == '') {
        emailError.innerHTML = 'يجب ملئ حقل البريد الإلكتروني';
    }
    if (passInput.value == '') {
        passError.innerHTML = 'يجب ملئ حقل كلمة السر';
    }

    
    if (emailInput.value == '' || passInput.value == '') {
        e.preventDefault();
    }
}
