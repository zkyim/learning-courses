let tabs = document.querySelectorAll(".tabs li")
let tabsArry = Array.from(tabs)
let divs = document.querySelectorAll(".my-courses .content > div")
let divsArry = Array.from(divs)

tabsArry.forEach((ele) => {
    ele.addEventListener("click", function (e) {
        tabsArry.forEach((ele) => {
            ele.classList.remove("active");
        });
        e.currentTarget.classList.add("active");
        divsArry.forEach((div) => {
            div.style.display = "none";
        });
        document.querySelector(e.currentTarget.dataset.cont).style.display = "block";
    });
});

let chiledul = document.querySelectorAll(".list ul li");
let chiledulArray = Array.from(chiledul);
let videoTitle = document.querySelector(".preview .info");
let theVideo = document.querySelector(".videos .preview .infovideo ");

let iframe = document.querySelector(".videos .preview iframe");


let videosPlayer = document.querySelectorAll('video');
let quiltySelector = document.querySelectorAll('.qulity-selector');
let quiltySelector2 = document.querySelector('.video .qulity-selector');
let iconQuiltySelector = document.querySelectorAll('.qulity-selector > i')
let menuSelector = document.querySelectorAll('.qulity-selector .menu-qulity');
let menuSelector2 = document.querySelector('.video .qulity-selector .menu-qulity');
let globalIndex = 0;

chiledulArray.forEach( (ele) => {
    ele.addEventListener('click', function (e) {
        chiledulArray.forEach( (ele) => {
            ele.classList.remove("active");
        });
        e.currentTarget.classList.add("active");
        e.currentTarget.innerText;
        videoTitle.innerText = e.currentTarget.innerText;
        if (e.currentTarget.dataset.type == 'video') {
            iframe.src = '';
            iframe.style.display = 'none';
            theVideo.style.display = 'block';
            // quiltySelector2.style.display = 'block';
            theVideo.src = e.currentTarget.dataset.src;
            // let qulities = e.currentTarget.dataset.qulity;
            // let newQulities = qulities.split(',');
            // let qulitiesInMenuSelector = Array.from(menuSelector2.children)
            // qulitiesInMenuSelector.forEach ( e => {
            //     e.remove();
            // });
            // for (let i = 0; i < newQulities.length; i++) {
            //     if (newQulities[i] !== '') {

            //         oldNameQulity = newQulities[i].split('-');
            //         nameQulity = oldNameQulity[1].split('.')
            //         theDivQulity = `<div onclick="deffrint_qulity (this)" data-src=" ${upload}video/video${sourceVideo}/${newQulities[i]}"`;
            //         if (nameQulity[0] == defultQulity) {
            //             theDivQulity += ' class="active" ';
            //         }
            //         theDivQulity += `>` 
            //         if (nameQulity[0] == '1080') {
            //             theDivQulity += '<sup style="color: red;"> HD </sup>';
            //             theDivQulity += '1080p';
            //         }else {
            //             theDivQulity += nameQulity[0];
            //             theDivQulity += 'p';
            //         }
            //         theDivQulity +=`</div>`;
            //         menuSelector2.innerHTML += theDivQulity;
            //     }
            // }
        }else if (e.currentTarget.dataset.type == 'link') {
            theVideo.src = '';
            theVideo.style.display = 'none';
            // quiltySelector2.style.display = 'none';
            iframe.style.display = 'block';
            iframe.src = e.currentTarget.dataset.src;
        }else if (e.currentTarget.dataset.type == 'singup') {
            createToast('warning', '<div> <a href="../signup.php"> أنشئ حسابك الآن  </a> واستمتع بالدورة كاملة . </div>');
        }else if (e.currentTarget.dataset.type == 'subscribe') {
            createToast('info', '<div> <a href="infocourse.php?UserID='+ele.dataset.courseid+'">  اشترك في الدورة  </a> واستمتع بها كاملة . </div>');
        }else if (e.currentTarget.dataset.type == 'wait') {
            createToast('info', '<div> سوف يتم قبولك خلال 48 ساعة. </div>');
        }
    });
});

for (let i = 0; i < quiltySelector.length; i++) {
    iconQuiltySelector[i].addEventListener('click', ele => {
        menuSelector[i].classList.toggle('open');
        globalIndex = i;
    });

    quiltySelector.forEach(e => {
        e.addEventListener('click', ele => {
            ele.stopPropagation();
        })
    })

    document.addEventListener ('click', e => {
        if (e.target !== iconQuiltySelector[i] || e.target !== menuSelector[i]) {
            menuSelector[i].classList.remove('open');
        }
    })

}

function deffrint_qulity (element) {
    let qulitiesInMenuSelector = Array.from(menuSelector[globalIndex].children);
    let currentTime = videosPlayer[globalIndex].currentTime;

        qulitiesInMenuSelector.forEach ( e => {
            e.classList.remove('active');
        });
        element.classList.add('active');
        // add the source video
        videosPlayer[globalIndex].src = element.dataset.src;
        videosPlayer[globalIndex].currentTime = currentTime;
}

let dots = Array.from(document.querySelectorAll('.dots'));
let container_notes = Array.from(document.querySelectorAll('.container-notes'));
let xmark = Array.from(document.querySelectorAll('.xmark'));
let button = Array.from(document.querySelectorAll('.container-notes button'));
let button_i = Array.from(document.querySelectorAll('.container-notes button i'));
let thenotes = Array.from(document.querySelectorAll('.the-notes'));
let msg = document.querySelectorAll('.container-notes .msg');
let globalIndexCont = 0;

xmark.forEach( (e, index) => {
    e.addEventListener('click', ele => {
        container_notes.forEach ( e => {e.classList.remove('open');});
    });
});

dots.forEach( (e, index) => {
    e.addEventListener('click', ele => {
        container_notes.forEach ( e => {e.classList.remove('open');});
        thenotes.forEach ( e => {e.classList.remove('open');});
        container_notes[index].classList.toggle('open');
        globalIndexCont = index;
        msg[index].innerHTML = '';
    });
});

button.forEach( (e, index) => {
    e.addEventListener('click', ele => {
        button_i[index].classList.toggle('rotate');
        thenotes[index].classList.toggle('open');
    })
});

dots.forEach ( e => {
    e.addEventListener('click', ele => {
        ele.stopPropagation();
    })
});

container_notes.forEach ( e => {
    e.addEventListener('click', ele => {
        ele.stopPropagation();
    })
});

document.addEventListener("click", e => {
    if (e.target !== container_notes[globalIndexCont] && e.target !== dots[globalIndexCont]) {
        // container_notes[globalIndexCont].classList.remove("open");
    }
});


let textAreaNotes = document.querySelectorAll('.container-notes textarea');
let progres = document.querySelectorAll('.container-notes .progres');
let spanLength = document.querySelectorAll('.container-notes .length');
let input_stid = document.querySelectorAll('.container-notes .studentID');
let input_vid = document.querySelectorAll('.container-notes .videoid');
let input_vty = document.querySelectorAll('.container-notes .videotype');

Array.from(spanLength).forEach( (e, index) => {
    let length = textAreaNotes[index].getAttribute('maxlength');
    e.innerHTML = length;
});

Array.from(textAreaNotes).forEach( (e, index) => {
    e.oninput = function () {
        let length = textAreaNotes[index].getAttribute('maxlength');
        spanLength[index].innerHTML = length - e.value.length;
        spanLength[index].innerHTML == 0 ? spanLength[index].classList.add('zero') : spanLength[index].classList.remove('zero');
        progres[index].style.width = `${100 - (e.value.length / length) * 100}%`;
    }
});

Array.from(document.forms).forEach ( (e, index) => {
    e.onsubmit = (ele) => {
        ele.preventDefault();
        if (textAreaNotes[index].value != '') {
            // send the note to database
            let sendData = new XMLHttpRequest();
            sendData.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // console.log(this.responseText);
                }
            };

            sendData.open("POST", "server_send_note.php", false);
            sendData.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            sendData.send(`studentID=${input_stid[index].value}&videoID=${input_vid[index].value}&videotype=${input_vty[index].value}&thenote=${textAreaNotes[index].value}`);


            thenotes[index].innerHTML += `<div> ${textAreaNotes[index].value} </div>`;
            msg[index].innerHTML = `<div class="succes"> تم حفظ الملاحظة </div>`;
            textAreaNotes[index].value = '';
        }else {
            msg[index].innerHTML = `<div class="error"> الحقل فارغ </div>`;
        }
    }
});

let tests = document.querySelectorAll('.two .continaer > a');
tests.forEach( (ele) => {
    ele.addEventListener('click', e => {
        if (ele.dataset.type == 'singup') {
            e.preventDefault();
            createToast('success', '<div> <a href="../signup.php"> أنشئ حسابك الآن  </a> واستمتع بالدورة كاملة . </div>');
        }else if (e.currentTarget.dataset.type == 'subscribe') {
            e.preventDefault();
            createToast('info', '<div> <a href="infocourse.php?UserID='+ele.dataset.courseid+'">  اشترك في الدورة  </a> واستمتع بها كاملة . </div>');
        }else if (e.currentTarget.dataset.type == 'wait') {
            e.preventDefault();
            createToast('info', '<div> سوف يتم قبولك خلال 48 ساعة. </div>');
        }
    })
});
let files = document.querySelectorAll('.three .file-info > div > a');
files.forEach( (ele) => {
    ele.addEventListener('click', e => {
        if (ele.dataset.type == 'singup') {
            e.preventDefault();
            createToast('success', '<div> <a href="../signup.php"> أنشئ حسابك الآن  </a> واستمتع بالدورة كاملة . </div>');
        }else if (e.currentTarget.dataset.type == 'subscribe') {
            e.preventDefault();
            createToast('info', '<div> <a href="infocourse.php?UserID='+ele.dataset.courseid+'">  اشترك في الدورة  </a> واستمتع بها كاملة . </div>');
        }else if (e.currentTarget.dataset.type == 'wait') {
            e.preventDefault();
            createToast('info', '<div> سوف يتم قبولك خلال 48 ساعة. </div>');
        }
    })
});
// e.preventDefault();