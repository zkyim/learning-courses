let finishQuiz = document.querySelector('.container-test .finish-test button');
let countdownElement = document.querySelector(".countdown");
let containerTest = document.querySelector('.container-test');
let tmr;
function getQestions() {
    let myRequest = new XMLHttpRequest();

    myRequest.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let questionsObject = JSON.parse(this.responseText);
            let SectionsCount = questionsObject.length;
            console.log(questionsObject);
            let qcount = shuffle(questionsObject);
            let duration = 0;
            // console.log(questionsObject)
            addQuestions(questionsObject);
            if (qcount < 96) {
                countdowntime (60 * qcount);
                duration=60 * qcount;
            }else {
                countdowntime (60 * 100);
                duration=60 * 100;
            }
            counttimer (0);
            finishQuiz.onclick = () => {
                clearInterval(countdowntInterval);
                clearInterval(cntmr);
                finishedQuiz(questionsObject);
                // finishQuiz.remove();
            };
        }
    };
    myRequest.open("POST", fileNameJson, true);
    myRequest.send();
}
getQestions();

function shuffle (array) {
    let current = array.length,
    temp,
    random;
    let countQues = 0;
    while (current > 0) {
        random = Math.floor(Math.random() * current);
        current--;
        temp = array[current];
        array[current] = array[random];
        array[random] = temp;
        let index = array[current].length-1;
        while (index > 0) {
            random = Math.floor(Math.random() * index);
            index--;
            // if shuffle here
            temp = array[current][index];
            array[current][index] = array[current][random];
            array[current][random] = temp;
            countQues++;
        }
    }
    return countQues;
}

function addQuestions (obj) {
    let UlElement = document.querySelector('.container-test > ul');
    let LiNum = 0;
    let theTitle = '';
    for (let i = 0; i < obj.length; i++) {
        for (let j = 0; j < obj[i].length-1; j++) {
            theTitle='';
            if (obj[i][j].type_item == 'question') {
                LiNum++;
                let typeInp = 'radio';
                if (obj[i][j].multans == 'multans') {typeInp = 'checkbox';}
                let answers = `<div class="ans">`;
                let lopfor = obj[i][j].answeres.length;
                for (let k=0; k < lopfor; k++) {
                    let theAnswer = '';
                    if (obj[i][j].answeres[k] != undefined) {
                        theAnswer = obj[i][j].answeres[k];
                    }
                    if (obj[i][j].math == 'math') {theAnswer = transformData (theAnswer, 'all', 0, 0, false)}
                    answers += `
                        <div class="answer" id="answer_${LiNum}" style="order: 3;">
                            <div class="cont-img"></div>
                            <div>
                                <div>
                                    <input type="${typeInp}" name="ans-${LiNum}" id="ans-${k}_num-${LiNum}" data-answer="${theAnswer}">
                                    <label for="ans-${k}_num-${LiNum}">
                                        <div class="input-data" data-linum="${LiNum}"> ${theAnswer} </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    
                    `;
                }
                answers += `</div>`;
                theTitle = obj[i][j].title;
                if (obj[i][j].math == 'math') {theTitle = transformData (theTitle, 'all', 0, 0, false)}
                UlElement.innerHTML += `
                <li id="qwestoin_${LiNum}">
                    <div class="title"> <span class="nowrap number-ques"> ${LiNum} :  </span> ${theTitle} </div>
                    ${answers}
                </li>
                `;
                let ans = document.querySelectorAll(".ans");
                answers = Array.from(ans[LiNum-1].children);
                let orderRange = [...Array(answers.length).keys()];
                let current = orderRange.length,
                temp,
                random;
                while (current > 0) {
                    random = Math.floor(Math.random() * current);
                    current--;
                    temp = orderRange[current];
                    orderRange[current] = orderRange[random];
                    orderRange[random] = temp;
                }
                answers.forEach((answer, index) => {
                    answer.style.order = orderRange[index];
                })
            }else if (obj[i][j].type_item == 'pargraph') {

            }

        }
    }

    
}

function countdowntime (duration) {
    let timer = document.querySelector(".value-container");
    let circle = document.querySelector("svg .circle");
    theNum = 0;
    theDeg = 345 / duration;
    let minutes, seconds;

    countdowntInterval = setInterval (function () {
        minutes = parseInt(duration / 60);
        seconds = parseInt(duration % 60);
        minutes = minutes < 10 ? `0${minutes}` : minutes;
        seconds = seconds < 10 ? `0${seconds}` : seconds;
        timer.innerHTML = `${minutes}:${seconds}`;
        circle.style.strokeDashoffset = theNum;
        --duration;
        if (duration < 0) {
            clearInterval(countdowntInterval);
            finishQuiz.click();
        }
        theNum += theDeg;
    }, 1000)
}
function counttimer (dur) {
    let min, sec;
    tmr = 0;
    cntmr = setInterval( function () {
        min = parseInt(dur / 60)
        sec = parseInt(dur % 60)
        min = min < 10 ?`0${min}` : min
        sec = sec < 10 ?`0${sec}` : sec
        tmr = `${min}:${sec}`
        ++dur;
    }, 1000)
}

function finishedQuiz (obj) {
    let UlElement = document.querySelector('.container-test > ul');
    let LiNum = 0;
    let rightAnswers = 0;
    let wrongAnswers = 0;
    let rightIcon = '<i class="far fa-check-circle righticon"></i>';
    let wrongIcon = '<i class="far fa-times-circle wrongicon"></i>';
    let theChosAns;
    let rAnswer;
    let containerAnsChecked;
    let rightContAns;
    for (let i = 0; i < obj.length; i++) {
        for (let j = 0; j < obj[i].length-1; j++) {
            if (obj[i][j].type_item == 'question') {
                theChosAns = [];
                rAnswer = [];
                containerAnsChecked = [];
                rightContAns = [];
                LiNum++;
                let LiElement = UlElement.querySelector(`#qwestoin_${LiNum}`);
                let answers = Array.from(LiElement.querySelectorAll('input'));
                if (obj[i][j].multans == 'multans') {
                    answers.forEach( answer => {
                        
                    });
                }else {
                    containerAnsChecked = undefined;
                    rAnswer = obj[i][j].answeres[obj[i][j].right_answeres[0]];
                    answers.forEach( answer => {
                        if (answer.checked) {
                            theChosAns = answer.dataset.answer;
                            containerAnsChecked = answer.parentElement.parentElement;
                        }
                        if (answer.dataset.answer == rAnswer) {
                            rightContAns = answer.parentElement.parentElement;
                        }
                    });

                    if (rAnswer === theChosAns) {
                        rightContAns.insertAdjacentHTML('beforeend', rightIcon);
                        rightContAns.parentElement.classList.add('right-answer');
                        LiElement.dataset.status = 'right';
                        rightAnswers++;
                    }else if (containerAnsChecked == undefined) {
                        rightContAns.insertAdjacentHTML('beforeend', rightIcon);
                        rightContAns.parentElement.classList.add('right-answer');
                        wrongAnswers++;
                        LiElement.dataset.status = 'wrong';
                    }else if (rAnswer !== theChosAns) {
                        rightContAns.insertAdjacentHTML('beforeend', rightIcon);
                        rightContAns.parentElement.classList.add('right-answer');
                        containerAnsChecked.insertAdjacentHTML('beforeend', wrongIcon);
                        containerAnsChecked.parentElement.classList.add('wrong-answer');
                        wrongAnswers++;
                        LiElement.dataset.status = 'wrong';
                    }

                }
            }
        }
    }
    
    let percentage = Math.ceil((rightAnswers/LiNum)*100);
    let color = (percentage < 70) ? 'bad' : 'good' ;
    let excellent = (percentage < 70) ? '' : 'أحسنت لقد حصلت على قمة التميز.' ;
    let sign = (percentage < 70) ? 'راسب' : 'ناجح' ;
    containerTest.innerHTML = 
    `
    <div class="grade-test">
        <div class="container-grade">
            <div class="title"> درجات الاختبار </div>
            <div class="content">
                <div class="excellent c-green"> ${excellent} </div>
                <div class="duration-ans"> مدة الحل : <span> ${tmr} </span> </div>
                <div class="count-ans"> عدد الأسئلة : <span> ${LiNum} </span> </div>
                <div class="rihgt-ans"> عدد الأسئلة الصحيحة : <span> ${rightAnswers} </span> </div>
                <div class="wrong-ans"> عدد الأسئلة الخاطئة : <span> ${wrongAnswers} </span> </div>
                <div class="result ${color}">  النسبة المئوية : <span> ${percentage}% </span> </div>
                <div class="result ${color}"> العلامة : <span> ${sign} </span> </div>
            </div>
            <div class="footer">
                <div class="show-wrong-ans" >
                    <button onclick="openBox(this)"> عرض الأسئلة الخاطئة <i class="fa-solid fa-chevron-down"></i> </button>
                    <div class="w-ans"></div>
                </div>
                <div class="show-all-ans">
                    <button onclick="openBox(this)"> عرض الكل <i class="fa-solid fa-chevron-down"></i> </button>
                    <div class="all-ans"></div>
                </div>
            </div>
        </div>
    </div>
    `;
    document.querySelector('.grade-test .show-all-ans .all-ans').appendChild(UlElement.cloneNode(true));

    UlElement.querySelectorAll('li').forEach( li => {
        if (li.dataset.status != 'wrong') {
            li.remove();
        }
    });
    document.querySelector('.grade-test .show-wrong-ans .w-ans').appendChild(UlElement.cloneNode(true));
}
function openBox (ele) {
    let box = ele.parentElement.querySelector('div');
    if (ele.querySelector('i').classList.contains('rotate') == false) {
        ele.querySelector('i').classList.add('rotate');
        box.style.height = box.scrollHeight+'px';
    }else {
        ele.querySelector('i').classList.remove('rotate');
        box.style.height = '0px';
    }
}
function textClicked () {
}