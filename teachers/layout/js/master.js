let upload = '../student/upload/';
// ====================================== Start Hide Sidebar =========================================
let sidebar = document.querySelector('.sidebar');
let openIconSidebar = document.querySelector('.sidebar .open-icon');
sidebar.addEventListener('click', e => {
    e.stopPropagation();
});
openIconSidebar.addEventListener('click', e => {
    sidebar.classList.toggle('open');
});
document.addEventListener('click', e => {
    if (e.target !== sidebar || e.target !== openIconSidebar) {sidebar.classList.remove('open');}
})
// ====================================== End Hide Sidebar ===========================================
// ====================================== Start Toast =========================================
// paramiter1 of type 1-success or 2-error or 3-warning or 4-info
// paramiter2 of text
let notifications = document.querySelector(".notifications");
function removeToast (toast) {
    toast.classList.add('hide');
    setTimeout(() => {toast.remove()}, 500);
}
function createToast (type, text) {
    let toastDetails = {
        timer : 4000,
        success: {
            icon : "fa-circle-check"
        },
        error: {
            icon : "fa-circle-xmark"
        },
        warning: {
            icon : "fa-triangle-exclamation"
        },
        info: {
            icon : "fa-circle-info"
        }
    };
    let {icon} = toastDetails[type];
    let toast = document.createElement('li');
    toast.className = `toast ${type}`;
    toast.innerHTML = 
    `
    <div class="column">
        <i class="fa-solid ${icon}"></i>
        <span>${text}</span>
    </div>
    <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>
    `;
    notifications.appendChild(toast);
    setTimeout(() => removeToast(toast), toastDetails.timer)
}
// ====================================== End Toast =========================================
// ====================================== Start Check Online ================================
let checkOnlineCont = document.querySelector('.check-online');
function removeCheckOnline () {
    checkOnlineCont.classList.add('hide');
    setTimeout(() => {checkOnlineCont.innerHTML = ''}, 500);
}
function checkOnline (work = 'nowork') {
    let text;
    let mode;
    if (window.navigator.onLine) {
        checkOnlineCont.classList.remove('offline');
        text = 'أنت متصل بالإنترنت';
        mode = 'online';
    }else {
        checkOnlineCont.classList.add('offline');
        text = 'أنت غير متصل بالإنترنت';
        mode = 'offline';
    }
    if (work != 'nowork') {
        checkOnlineCont.innerHTML =
        `
        <div class="content between-flex p-relative">
            <div class="column">
                <i class="fa-solid fa-wifi p-relative"></i>
                <span class="mr-10"> ${text} </span>
            </div>
            <i class="fa-solid fa-xmark" onclick="removeCheckOnline ()"></i>
        </div>
        `;
    }

    setTimeout(() => removeCheckOnline(), 5000);
    return mode;
}
// ====================================== End Check Online =========================================
let textareas = document.querySelectorAll("textarea");
resizeTextarea(textareas);
function resizeTextarea (textareas) {
    textareas.forEach( element => {
        element.addEventListener('keyup', (e) => {
            // element.style.height = '42px';
            element.style.height = (e.target.scrollHeight) + 'px';
        });
    });
}