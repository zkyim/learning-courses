let labelPersonalInfo = document.querySelector('label div.PersonalInfo');

labelPersonalInfo.addEventListener('click', (e) => {
    // let modeOnline = checkOnline();
    // if (modeOnline == 'offline') {
    //     checkOnline('work');
    // }else {
        let xhr = new XMLHttpRequest();
        xhr.onload = () => { 
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = xhr.responseText;
                console.log(response);
                if (response.indexOf('success') > -1) {

                }else if (response.indexOf('There is no that id') > -1) {
                    createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
                }
            }
        }
        xhr.open("POST", "action_myaccount.php", false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`action=PersonalInfo&userid=${studentid}`);
    // }
});

