let uploadImg = document.querySelector(".settings .container-img .input-avatar");
let avatarImg = document.querySelector(".settings .container-img .avatar-img");
let errorInfoUser = document.querySelector(".settings .info-user .error-info-user");


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