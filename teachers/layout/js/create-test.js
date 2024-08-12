let inpNum = document.querySelector('.controls input[name="numloop"]');
if (inpNum) {
    inpNum.addEventListener('keydown', e => {
        if (e.keyCode<48||e.keyCode>57) {
            if (e.keyCode != 8) {e.preventDefault();}
        }
    });
}

let containerSec = document.querySelector('.create-test-page .container-add-test > ul'),
liNumber = 1
secNum = 1,
pargraphNum = 0;
let sectionDelete;
let keyboard =
`
<div class="math-keyboard" id="keyboard_${liNumber}">
    <div class="head">
        <span class="active">الجبر</span>
        <span> رموز </span>
        <span>حساب المثلثات</span>
        <span> إحصاء </span>
        <span>التفاضل والتكامل</span>
        <span> المصفوفات </span>
    </div>
    <div class="container-math-op">
        <div class="row">
            <span onclick="typeKeyBoard(this)" data-key="Backspace" data-linum="${liNumber}" class="key"><i class="fa-solid fa-delete-left"></i></span>
            <span onclick="typeKeyBoard(this)" data-key="٠" data-linum="${liNumber}" class="key">٠</span>
            <span onclick="typeKeyBoard(this)" data-key="١" data-linum="${liNumber}" class="key">١</span>
            <span onclick="typeKeyBoard(this)" data-key="٢" data-linum="${liNumber}" class="key">٢</span>
            <span onclick="typeKeyBoard(this)" data-key="٣" data-linum="${liNumber}" class="key">٣</span>
            <span onclick="typeKeyBoard(this)" data-key="٤" data-linum="${liNumber}" class="key">٤</span>
            <span onclick="typeKeyBoard(this)" data-key="٥" data-linum="${liNumber}" class="key">٥</span>
            <span onclick="typeKeyBoard(this)" data-key="٦" data-linum="${liNumber}" class="key">٦</span>
            <span onclick="typeKeyBoard(this)" data-key="٧" data-linum="${liNumber}" class="key">٧</span>
            <span onclick="typeKeyBoard(this)" data-key="٨" data-linum="${liNumber}" class="key">٨</span>
            <span onclick="typeKeyBoard(this)" data-key="٩" data-linum="${liNumber}" class="key">٩</span>
            <span onclick="typeKeyBoard(this)" data-key="AC" data-linum="${liNumber}" class="key">AC</span>
        </div>
        <div class="row">
            <span onclick="typeKeyBoard(this)" data-key=">" data-linum="${liNumber}" class="key">></span>
            <span onclick="typeKeyBoard(this)" data-key="<" data-linum="${liNumber}" class="key"><</span>
            <span onclick="typeKeyBoard(this)" data-key="≥" data-linum="${liNumber}" class="key">≥</span>
            <span onclick="typeKeyBoard(this)" data-key="≤" data-linum="${liNumber}" class="key">≤</span>
            <span onclick="typeKeyBoard(this)" data-key="=" data-linum="${liNumber}" class="key">=</span>
            <span onclick="typeKeyBoard(this)" data-key="+" data-linum="${liNumber}" class="key">+</span>
            <span onclick="typeKeyBoard(this)" data-key="-" data-linum="${liNumber}" class="key">-</span>
            <span onclick="typeKeyBoard(this)" data-key="×" data-linum="${liNumber}" class="key">×</span>
            <span onclick="typeKeyBoard(this)" data-key="÷" data-linum="${liNumber}" class="key">÷</span>
            <span onclick="typeKeyBoard(this)" data-key="(" data-linum="${liNumber}" class="key">(</span>
            <span onclick="typeKeyBoard(this)" data-key=")" data-linum="${liNumber}" class="key">)</span>
            <span onclick="typeKeyBoard(this)" data-key="∞" data-linum="${liNumber}" class="key">∞</span>
        </div>
        <div class="row">
            <span onclick="typeKeyBoard(this)" data-key="°" data-linum="${liNumber}" class="key">°</span>
            <span onclick="typeKeyBoard(this)" data-key="π" data-linum="${liNumber}" class="key">π</span>
            <span onclick="typeKeyBoard(this)" data-key="%" data-linum="${liNumber}" class="key">%</span>
            <span onclick="typeKeyBoard(this)" data-key="." data-linum="${liNumber}" class="key">.</span>
            <span onclick="typeKeyBoard(this)" data-key="," data-linum="${liNumber}" class="key">,</span>
            <span onclick="typeKeyBoard(this)" data-key="θ" data-linum="${liNumber}" class="key">θ</span>
            <span onclick="typeKeyBoard(this)" data-key="!" data-linum="${liNumber}" class="key">!</span>
            <span onclick="typeKeyBoard(this)" data-key="±" data-linum="${liNumber}" class="key">±</span>
            <span onclick="typeKeyBoard(this)" data-key="→" data-linum="${liNumber}" class="key">→</span>
            <span onclick="typeKeyBoard(this)" data-key="←" data-linum="${liNumber}" class="key">←</span>
            <span onclick="typeKeyBoard(this)" data-key="≠" data-linum="${liNumber}" class="key">≠</span>
            <span onclick="typeKeyBoard(this)" data-key="" data-linum="${liNumber}" class="key"></span>
        </div>
        <div class="content-key-row">
            <div class="row">
                <span data-key="fraction" onclick="typeKeyBoard(this, 'no')" data-linum="${liNumber}" class="key">
                    <span class="parent-op">
                        <span class="fraction">
                            <span class="numerator"><span class="num unknown"></span></span>
                            <span class="the-line"></span>
                            <span class="denominator"><span class="num unknown"></span></span>
                        </span>
                    </span>
                </span>
                <span data-key="root" onclick="typeKeyBoard(this, 'no')" data-linum="${liNumber}" class="key">
                    <span class="parent-op">
                        <span class="root">
                            <span class="exponent unknown"></span>
                            <span class="lines-root">
                                <span class="line_1">
                                    <span class="line_2">
                                    </span>
                                </span>
                            </span>
                            <span class="num-root unknown"></span>
                        </span>
                    </span>
                </span>
                <span data-key="power" onclick="typeKeyBoard(this, 'no')" data-linum="${liNumber}" class="key">
                    <span class="parent-op">
                        <span class="num-power unknown">
                            <span class="the-power unknown">
                            </span>
                        </span>
                    </span>
                </span>
                <span data-key="down" onclick="typeKeyBoard(this, 'no')" data-linum="${liNumber}" class="key">
                    <span class="parent-op">
                        <span class="num-down unknown">
                            <span class="the-down-num unknown">
                            </span>
                        </span>
                    </span>
                </span>
                <span data-key="equation" onclick="typeKeyBoard(this, 'no')" data-linum="${liNumber}" class="key">معادلة</span>
                <!-- <span class="key"></span> -->
            </div>
        </div>
    </div>
</div>
`;

let theSection = 'الكل';
let secQuestion = 'الكل';
function quessec (ele) {
    let options = '';
    theSection = ele.value;
    if (ele.value == 'كمي') {
        options = kammey;
    }else if (ele.value == 'لفظي') {
        options = laphzy;
    }
    let content = '';
    options = options.split(',');
    for (let i=0; i<options.length-1; i++) {
        content += `
        <input type="radio" name="typequestion" id="${options[i]+'_1'}" value="${options[i]}" onclick="typequestion(this)">
        <label for="${options[i]+'_1'}"> ${options[i]} </label>`;
    }
    let box = document.querySelector('.container-controls .controls .typequestion');
    box.innerHTML = content;
    let heightBox = box.parentElement.scrollHeight;
    if (heightBox < 115) {
        box.parentElement.style.height = heightBox + 25 + 'px';
    }
    document.querySelector('.container-controls .controls .submit-button').style.display = 'none';
    if (ele.value == 'الكل') {
        typequestion(ele);
    }
}
function typequestion (ele) {
    secQuestion = ele.value;
    document.querySelector('.container-controls .controls .submit-button').style.display = 'block';
    let box = document.querySelector('.container-controls .controls');
    let heightBox = box.scrollHeight;
    if (heightBox < 170) {
        box.style.height = heightBox + 35 + 'px';
    }
}
function filterQuestion () {
    let xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log(response);
            if (response.indexOf('empty') > -1) {
                createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
            }else if (response.indexOf('There is no that id') > -1) {
                createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
            }else {
                let moreQuestions = document.querySelector('.container-add-test .more-questiones');
                containerSec.innerHTML = '';
                liNumber = 1;
                secNum = 1;
                pargraphNum = 0;
                let obj = JSON.parse(response);
                for (let j = 0; j < obj.length; j++) {
                    if (obj[j].type_item == 'question') {
                        addNewQuestion ('newQuestion', 1, obj[j].the_code, [obj[j].math, obj[j].suffling, obj[j].multans], 0, obj[j].the_section, obj[j].title, obj[j].answeres, obj[j].right_answeres, obj[j].explain, obj[j].sec_question, obj[j].id, obj[j].teacherID, 'question_bank')
                    }else if (obj[j].type_item == 'pargraph') {
                        addNewParagraph('newParagraph', obj[j].pargraph, obj[j].the_code, obj[j].teacherID, obj[j].id, 'question_bank');
                    }
                }
                moreQuestions.style.display = 'block';
                if (response == '[]') {
                    moreQuestions.style.display = 'none';
                    containerSec.innerHTML = '<h2 class="c-red p-20"> لا يوجد أسئلة من هذا القسم </h2>';
                }
            }
        }
    }
    xhr.open("POST", "action_create-test-respons.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`action=showquestiones&the_section=${theSection}&sec_question=${secQuestion}`)
}

let selectSec = document.querySelector('select[name=sec]');
let countSec = 0;
let countQues = 0;

let ErrorMsgNewQues = document.querySelector('.container-controls .error-msg');
function createSecTest () {
    let numloop = document.querySelector('.container-controls input[name="numloop"]').value;
    let theCode = document.querySelector('.container-controls input[name="code"]').value;
    let inputChecked = document.querySelectorAll('.container-controls input[type="radio"]:checked');
    let selectSecChecked = document.querySelector('.container-controls select[name="sec"] option:checked').value;
    let checkSelect = document.querySelector('.container-controls select[name="typeTest"] option:checked').value;
    addNewQuestion ('section',numloop, theCode, inputChecked, selectSecChecked, checkSelect);
}
function addNewQuestion (type, numloop, theCode, inputChecked, selectSecChecked, checkSelect, title = '', textanswers = '', rightAnswers = '', explain = '', secQuestion = '', UserID = 0, teacherID = 0, page = 'create-new-test', MoreToll = 'yes') {
    let style = 'none';
    let show = 'open';
    let typeInp = 'radio';
    let checkbox = '';
    let checkmath = '';
    let checkshuffle = '';
    inputChecked = Array.from(inputChecked);
    if (type == 'section') {
        inputChecked[0] = inputChecked[0].value;
        inputChecked[1] = inputChecked[1].value;
        inputChecked[2] = inputChecked[2].value;
    }

    if (inputChecked[0] == 'math') {
        style = 'flex';
        show = '';
        checkmath = 'checked';
    }
    if (inputChecked[1] == 'shuffle') {
        checkshuffle = 'checked';
    }
    if (inputChecked[2] == 'multans') {
        typeInp = 'checkbox';
        checkbox = 'checked';
    }
    let options = optionsSecQues.split(',');
    let optionsSelect = '';
    let numSelect = 0;
    for (let i=0; i<options.length-1; i++) {
        let selected = '';
        if (options[i] === checkSelect) {selected = 'selected'; numSelect++;} 
        optionsSelect += `<option value="${options[i]}"  ${selected}>${options[i]}</option>`;
        selected = '';
        if (i == options.length-2 && page != 'question_bank') {
            if (numSelect == 0) {selected = 'selected';}
            optionsSelect += `<option value="أخرى" ${selected}>أخرى</option>`;
        }
        
    }

    let onchangeSeclet = '';
    let incressSelect = '';
    if (page == 'question_bank') {
        let options = '';
        if (checkSelect == 'كمي') {
            options = kammey;
        }else if (checkSelect == 'لفظي') {
            options = laphzy;
        }

        incressSelect = `<div class="incress-select"> <select name="sectionQues" id="">`;
        options = options.split(',');
        for (let i = 0; i < options.length-1; i++) {
            if (options[i] != 'الكل') {
                let selected = '';
                if (options[i] === secQuestion) {selected = 'selected'; numSelect++;} 
                incressSelect += `<option value="${options[i]}" ${selected}> ${options[i]}</option>`;
            }
        }
        incressSelect += `</select> </div>`;
        onchangeSeclet += `onchange="sectionsQue(this)"`;
    }

    let bodySection;
    if (numloop != 0) {
        if (ErrorMsgNewQues) {ErrorMsgNewQues.innerHTML = '';}
        if (page == 'create-new-test') {
            if (selectSecChecked == 'newSec') {
                document.querySelector('.container-add-test .controls-test .add-new-section').click();
                bodySection = document.querySelector('.create-test-page .container-add-test ul .cont-section:last-child .body-sec');
            }else {
                bodySection = document.querySelector(`.create-test-page .container-add-test ul .cont-section#${selectSecChecked} .body-sec`);
            }
        }else if (page == 'question_bank') {
            bodySection = document.querySelector(`.create-test-page .container-add-test ul`);
        }

        for (let i = 1; i <= Number(numloop); i++) {
            countQues++;
            let answers = `<div class="answers" id="answers_${liNumber}">`;
            let lopfor = 0;
            if (type == 'section') {
                lopfor = 4;
            }else if (type == 'newQuestion') {
                lopfor = textanswers.length;
            }
            for (let i=0; i < lopfor; i++) {
                let theAnswer = '';
                let checkbox = '';
                if (textanswers[i] != undefined) {
                    theAnswer = textanswers[i];
                }
                for (let j=0; j<rightAnswers.length; j++) {
                    if (rightAnswers[j] == i) {checkbox = 'checked';}
                }
                answers += `
                    <div class="answer" id="answer_${liNumber}">
                        <div class="cont-img"></div>
                        <div class="container-answer-info">
                            <input type="${typeInp}" name="answer_${liNumber}" ${checkbox}>
                            <div class="input-data" data-linum="${liNumber}" style="display:${style};" onclick="keyInputDiv (this)" data-placeholder="الإجابة">الإجابة</div>
                            <textarea placeholder="الإجابة" class="${show}">${theAnswer}</textarea>
                            <input type="text" value="${theAnswer}"/>
                            <span class="keyboard-icon">
                                <i class="fa-regular fa-keyboard" style="display:${style};" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
                            </span>
                            <label for="img-ans${i}_${liNumber}"><i class="fa-regular fa-images"></i></label>
                            <input type="file" name="img" id="img-ans${i}_${liNumber}" onchange="uplaodImg(this)"/>
                            <i class="fa-regular fa-trash-can" onclick="deleteAnswerButton(this)"></i>
                        </div>
                        ${keyboard}
                    </div>
                
                `;
            }
            answers += `</div>`;
            let moreTools = ``;
            if (page == 'question_bank') {
                if (teacherid == teacherID && MoreToll == 'yes') {
                    moreTools = 
                    `
                        <div class="between-flex more-tools mt-10">
                            <div>
                                <a href="question_bank.php?action=UpdateQuestion&UserID=${UserID}"> <button class="btn pr-10 pl-10 p-5 rad-6 c-white bg-blue update-btn"  data-userid="${UserID}" data-linum="${liNumber}"> تعديل </button></a>
                            </div>
                            <div>
                                <button class="btn pr-10 pl-10 p-5 rad-6 c-white bg-red delete-btn" onclick="deleteQuestion(this)" data-userid="${UserID}" data-linum="${liNumber}" data-typeItem="question"> حذف </button>
                            </div>
                        </div>
                    `;
                }
            }
            let content = 
            `
            <li id="li_${liNumber}" data-linum="${liNumber}" data-typeques="math" data-typeitem="question">
                <div class="question" id="question_${liNumber}">
                    <div class="cont-img"></div>
                    <div class="info-ques">
                        <span class="nowrap number-ques"> ${countQues} : </span>
                        <div class="input-data" data-linum="${liNumber}" onclick="keyInputDiv (this)" style="display:${style};" data-placeholder="السؤال">السؤال</div>
                        <textarea placeholder="السؤال" class="${show}">${title}</textarea>
                        <input type="text" value="${title}"/>
                        <span class="keyboard-icon">
                            <i class="fa-regular fa-keyboard" style="display:${style};" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
                        </span>
                        <label for="img-ques_${liNumber}"><i class="fa-regular fa-images"></i></label>
                        <input type="file" name="img" id="img-ques_${liNumber}" onchange="uplaodImg(this)"/>
                    </div>
                    ${keyboard}
                </div>
                <div class="container-more-detail-ques">

                    ${answers}

                    <div class="add-new-answer">
                        <span data-typeInp="${typeInp}" data-style="${style}" data-show="${show}" onclick="addNweAnswerButton(this)"><i class="fa-regular fa-plus"></i> إضافة إجابة </span>
                        <span onclick="addNwePragraphButton(this)"  data-linum="${liNumber}"><i class="fa-regular fa-plus"></i> إضافة قطعة </span>
                    </div>

                    <div class="answer">
                        <div class="cont-img"></div>
                        <div class="container-explain-info">
                            <span></span>
                            <div class="input-data" data-linum="${liNumber}" style="display:${style};" onclick="keyInputDiv (this)" data-placeholder="الشرح">الشرح</div>
                            <textarea placeholder="الشرح" class="${show}">${explain}</textarea>
                            <input type="text" value="${explain}"/>
                            <span class="keyboard-icon">
                                <i class="fa-regular fa-keyboard" style="display:${style};" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
                            </span>
                            <label for="img-explain_${liNumber}"><i class="fa-regular fa-images"></i></label>
                            <input type="file" name="img" id="img-explain_${liNumber}" onchange="uplaodImg(this)"/>
                        </div>
                        ${keyboard}
                    </div>

                    <div class="tools">
                        <div>
                            <div>
                                <label for="multiple-answer">متعدد الخيارات</label>
                                <label class="small">
                                    <input class="toggle-checkbox small" type="checkbox" id="multiple-answer" data-linum="${liNumber}" onclick="transformAnswers(this)" ${checkbox}>
                                    <div class="toggle-switch small"></div>
                                </label>
                            </div>
                            <div>
                                <label for="math">ريضيات</label>
                                <label class="small">
                                    <input class="toggle-checkbox small" type="checkbox" id="math" data-linum="${liNumber}" onclick="transformMath(this)" ${checkmath}>
                                    <div class="toggle-switch small"></div>
                                </label>
                            </div>
                            <div>
                                <label for="shuffle">عشوائي</label>
                                <label class="small">
                                    <input class="toggle-checkbox small" type="checkbox" id="shuffle" data-linum="${liNumber}" ${checkshuffle}>
                                    <div class="toggle-switch small"></div>
                                </label>
                            </div>
                            <div>
                                <label for="code">رمز للسؤال</label>
                                <input type="text" id="code" value="${theCode}" maxlength="10" />
                            </div>
                            <div>
                                <select name="typeques" id="" ${onchangeSeclet}>
                                    ${optionsSelect}
                                </select>
                            </div>
                            ${incressSelect}
                        </div>
                        <div>
                            <i class="fa-regular fa-copy" data-linum="${liNumber}" onclick="copyQues(this)"></i>
                            <i class="fa-regular fa-trash-can" data-linum="${liNumber}" onclick="deleteContQuesButton(this)"></i>
                        </div>
                    </div>
                    ${moreTools}
                </div>
        
            </li>
            `;
            bodySection.insertAdjacentHTML('beforeend', content);
            if (type != 'section') {
                let valueInpQues = bodySection.children[bodySection.children.length-1].querySelector('.question .info-ques input[type="text"]').value;
                let displayInpQues = bodySection.children[bodySection.children.length-1].querySelector('.question .info-ques .input-data');
                displayInpQues.innerHTML = transformData(valueInpQues, 'all', 0, 0, false);
                let valueInpAns = bodySection.children[bodySection.children.length-1].querySelectorAll('.container-more-detail-ques .answers input[type="text"]');
                let displaiesAns = bodySection.children[bodySection.children.length-1].querySelectorAll('.container-more-detail-ques .answers .input-data');
                displaiesAns.forEach( (ele, index) => {ele.innerHTML = transformData(valueInpAns[index].value, 'all', 0, 0, false)});
                let valueInpExplain = bodySection.children[bodySection.children.length-1].querySelector('.container-explain-info input[type="text"]').value;
                let displayInpExplain = bodySection.children[bodySection.children.length-1].querySelector('.container-explain-info .input-data');
                displayInpExplain.innerHTML = transformData(valueInpExplain, 'all', 0, 0, false);
            }
            liNumber++;
        }
    }else {
        ErrorMsgNewQues.innerHTML = 'يجب تحديد عدد التكرارات ...';
    }
}
function addNewParagraph (type = 'newSec', paragraph = '', theCode = '', teacherID = 0, UserID = 0, page = 'create-new-test', MoreToll = 'yes') {
    pargraphNum++;
    let moreTools = '';
    if (page == 'question_bank') {
        if (teacherid == teacherID) {
            if (MoreToll == 'yes') {
                moreTools = 
                `
                    <div class="between-flex more-tools p-20">
                        <div>
                            <a href="question_bank.php?action=UpdateQuestion&UserID=${UserID}"> <button class="btn pr-10 pl-10 p-5 rad-6 c-white bg-blue update-btn"  data-userid="${UserID}" data-linum="${liNumber}"> تعديل </button></a>
                        </div>
                        <div>
                            <button class="btn pr-10 pl-10 p-5 rad-6 c-white bg-red delete-btn" onclick="deleteQuestion(this)" data-userid="${UserID}" data-linum="${liNumber}" data-typeItem="pargraph"> حذف </button>
                        </div>
                    </div>
                `;
            }
        }
    }
    let content =
    `
    <div class="pargraph" data-typeitem="pargraph"  id="ques_${liNumber}">
        <div class="w-full title">  القطعة رقم : <span class="number-pargraph"> ${pargraphNum} </span></div>
        <div>
            <div class="w-full">
                <textarea placeholder="القطعة">${paragraph}</textarea> <input type="text" name="code" placeholder="الرمز" value="${theCode}" class="w-full rad-6 border-ccc">
            </div>
            <i class="fa-regular fa-trash-can" onclick="deletePragraphButton(this, 'create-new-test')"></i>
        </div>
        ${moreTools}
    </div>
    `;
    let bodySection = '';
    if (page == 'create-new-test') {
        if (type == 'newSec') {
            document.querySelector('.container-add-test .controls-test .add-new-section').click();
            bodySection = document.querySelector('.create-test-page .container-add-test ul .cont-section:last-child .body-sec');
        }else {
            bodySection = document.querySelector(`.create-test-page .container-add-test ul .cont-section:last-child .body-sec`);
        }
    }else if (page == 'question_bank') {
        bodySection = document.querySelector(`.create-test-page .container-add-test ul`);
    }
    bodySection.innerHTML += content;
}
function addNewSectionBut (ele) {
    countSec++;
    let content = 
    `
    <div class="cont-section" id="sec_${secNum}" data-secnum="${secNum}">
    <div class="header-sec">
      <span class=""> ${countSec} : </span>
      <input type="text" class="border-ccc rad-6 p-10" placeholder=" عنوان القسم"/>
    </div>
    <div class="body-sec">
      </div>
      <div class="footer-sec">
        <span class="add-new-question" onclick="addNewQuestionBut(this)"><i class="fa-regular fa-plus"></i>إضافة سؤال</span>
        <span class="delete-section" onclick="deleteSection(this)"><i class="fa-regular fa-trash-can"></i> حذف القسم</span>
      </div>
    </div>
    `;
    containerSec.insertAdjacentHTML('beforeend', content);
    selectSec.insertAdjacentHTML('beforeend', `<option value="sec_${secNum}"> القسم ${countSec} </option>`);
    secNum++;
}
function addNewQuestionBut (ele, page = 'create-new-test') {
    let style = 'none';
    let show = 'open';
    let typeInp = 'radio';
    let options = optionsSecQues.split(',');
    let optionsSelect = '';
    for (let i=0; i<options.length-1; i++) {
        optionsSelect += `<option value="${options[i]}" >${options[i]}</option>`;
        if (page != 'question-bank') {
            optionsSelect += '<option value="أخرى">أخرى</option>';
        }
    }
    countQues++;
    let answers = '<div class="answers" id="answers_${liNumber}">'; 
        for (let i=0; i<4; i++) {
            answers +=
            `
            <div class="answer" id="answer_${liNumber}">
                <div class="cont-img"></div>
                <div class="container-answer-info">
                    <input type="radio" name="answer_${liNumber}">
                    <div class="input-data" data-linum="${liNumber}" style="display:none;" onclick="keyInputDiv (this)" data-placeholder="الإجابة">الإجابة</div>
                    <textarea placeholder="الإجابة" class="open"></textarea>
                    <input type="text" />
                    <span class="keyboard-icon">
                        <i class="fa-regular fa-keyboard" style="display:none;" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
                    </span>
                    <label for="img-ans${i}_${liNumber}"><i class="fa-regular fa-images"></i></label>
                    <input type="file" name="img" id="img-ans${i}_${liNumber}" onchange="uplaodImg(this)"/>
                    <i class="fa-regular fa-trash-can" onclick="deleteAnswerButton(this)"></i>
                </div>
                ${keyboard}
            </div>
            `;
        }
    answers += `</div>`;
    let incressSelect = '';
    let onchangeSeclet = '';
    if (page == 'question-bank') {
        incressSelect = `<div class="incress-select">
        <select name="sectionQues" id=""><option value="تناظر لفظي">تناظر لفظي</option><option value="الخطأ السياقي">الخطأ السياقي</option><option value="إكمال الجمل">إكمال الجمل</option><option value="إستيعاب المقروء">إستيعاب المقروء</option><option value="المفردة الشاذة">المفردة الشاذة</option><option value="أخرى">أخرى</option></select>
        </div>`;
        onchangeSeclet += `onchange="sectionsQue(this)"`;
    }
    let content = 
    `
    <li id="li_${liNumber}" data-linum="${liNumber}" data-typeques="math" data-typeitem="question">
        <div class="question" id="question_${liNumber}">
            <div class="cont-img"></div>
            <div class="info-ques">
                <span class="nowrap number-ques"> ${countQues} : </span>
                <div class="input-data" data-linum="${liNumber}" onclick="keyInputDiv (this)" style="display:none;" data-placeholder="السؤال">السؤال</div>
                <textarea placeholder="السؤال" class="open"></textarea>
                <input type="text" />
                <span class="keyboard-icon">
                    <i class="fa-regular fa-keyboard" style="display:none;" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
                </span>
                <label for="img-ques_${liNumber}"><i class="fa-regular fa-images"></i></label>
                <input type="file" name="img" id="img-ques_${liNumber}" onchange="uplaodImg(this)"/>
            </div>
            ${keyboard}
        </div>
        <div class="container-more-detail-ques">

            ${answers}

            <div class="add-new-answer">
            <span data-typeInp="${typeInp}" data-style="${style}" data-show="${show}" onclick="addNweAnswerButton(this)"><i class="fa-regular fa-plus"></i> إضافة إجابة </span>
                <span onclick="addNwePragraphButton(this, '${page}')"  data-linum="${liNumber}"><i class="fa-regular fa-plus"></i> إضافة قطعة </span>
            </div>
            <div class="answer">
                <div class="cont-img"></div>
                <div class="container-explain-info">
                    <span></span>
                    <div class="input-data" data-linum="${liNumber}" style="display:none;" onclick="keyInputDiv (this)" data-placeholder="الشرح">الشرح</div>
                    <textarea placeholder="الشرح" class="open"></textarea>
                    <input type="text" />
                    <span class="keyboard-icon">
                        <i class="fa-regular fa-keyboard" style="display:none;" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
                    </span>
                    <label for="img-explain_${liNumber}"><i class="fa-regular fa-images"></i></label>
                    <input type="file" name="img" id="img-explain_${liNumber}" onchange="uplaodImg(this)"/>
                </div>
                ${keyboard}
            </div>
            <div class="tools">
                <div>
                    <div>
                        <label for="multiple-answer">متعدد الخيارات</label>
                        <label class="small">
                            <input class="toggle-checkbox small" type="checkbox" id="multiple-answer" data-linum="${liNumber}" onclick="transformAnswers(this)">
                            <div class="toggle-switch small"></div>
                        </label>
                    </div>
                    <div>
                        <label for="math">ريضيات</label>
                        <label class="small">
                            <input class="toggle-checkbox small" type="checkbox" id="math" data-linum="${liNumber}" onclick="transformMath(this)">
                            <div class="toggle-switch small"></div>
                        </label>
                    </div>
                    <div>
                        <label for="shuffle">عشوائي</label>
                        <label class="small">
                            <input class="toggle-checkbox small" type="checkbox" id="shuffle" data-linum="${liNumber}" checked>
                            <div class="toggle-switch small"></div>
                        </label>
                    </div>
                    <div>
                        <label for="code">رمز للسؤال</label>
                        <input type="text" id="code" />
                    </div>
                    <div>
                        <select name="typeques" id="" ${onchangeSeclet}>
                            ${optionsSelect}
                        </select>
                    </div>
                    ${incressSelect}
                </div>
                <div>
                    <i class="fa-regular fa-copy" data-linum="${liNumber}" onclick="copyQues(this)"></i>
                    <i class="fa-regular fa-trash-can" data-linum="${liNumber}" onclick="deleteContQuesButton(this, '${page}')"></i>
                </div>
            </div>
        </div>

    </li>
    `;
    let theBody = '';
    if (page === 'question-bank') {
        theBody = document.querySelector('.container-add-test > ul');
    }else {
        theBody = ele.parentElement.parentElement.querySelector('.body-sec');
    }
    theBody.insertAdjacentHTML('beforeend', content);
    liNumber++;
}
function deleteSection (ele) {
    sectionDelete = ele.parentElement.parentElement;
    createToast('error', `هل أنت متأكد من حذفك للقسم كامل ؟ <button class="bg-red c-white btn-shape" onclick="confirmDeleteSec()">تأكيد الحذف</button>`);
}
function confirmDeleteSec () {
    document.querySelector('ul.notifications li').remove();
    sectionDelete.remove();
    countSec--;

    let numSpan = document.querySelectorAll('.header-sec > span');
    numSpan.forEach( (ele, index) => {ele.innerHTML = index+1 + ' : ';});

    selectSec.querySelector(`option[value="sec_${sectionDelete.dataset.secnum}"]`).remove();

    let optionsSelectSec = selectSec.querySelectorAll('option');
    optionsSelectSec.forEach( (ele, index) => { if (index != 0) {ele.innerHTML = 'القسم '+index;}})
}
function deleteAnswerButton (ele) {
    ele.parentElement.parentElement.remove();
}
let newIdInpFile = 0;
function addNweAnswerButton (ele) {
    let typeInp = ele.dataset.typeinp;
    let show = ele.dataset.show;
    let style = ele.dataset.style;
    let answers = ele.parentElement.parentElement.querySelector('.answers');
    let liNumber = answers.id.split('_')[1];
    newIdInpFile++;
    let newAnswer = 
    `
    <div class="answer" id="answer_${liNumber}">
        <div class="cont-img"></div>
        <div class="container-answer-info">
            <input type="${typeInp}" name="answer_${liNumber}">
            <div class="input-data" data-linum="${liNumber}" style="display:${style};" onclick="keyInputDiv (this)" data-placeholder="الإجابة">الإجابة</div>
            <textarea placeholder="الإجابة" class="${show}"></textarea>
            <input type="text" />
            <span class="keyboard-icon">
                <i class="fa-regular fa-keyboard" style="display:${style};" data-linum="${liNumber}" onclick="showKeyboardButton(this)"></i>
            </span>
            <label for="img-ans_${liNumber+newIdInpFile}"><i class="fa-regular fa-images"></i></label>
            <input type="file" name="img" id="img-ans_${liNumber+newIdInpFile}" onchange="uplaodImg(this)"/>
            <i class="fa-regular fa-trash-can" onclick="deleteAnswerButton(this)"></i>
        </div>
        ${keyboard}
    </div>
    `;
    answers.insertAdjacentHTML('beforeend', newAnswer);
}
function addNwePragraphButton (ele, page = 'create-new-test') {
    pargraphNum++;
    let Li = document.querySelector(`li#li_${ele.dataset.linum}`);
    Li.insertAdjacentHTML('beforebegin', `<div class="pargraph" data-typeitem="pargraph" id="ques_${ele.dataset.linum}"> <div class="w-full title">  القطعة رقم : <span class="number-pargraph"> ${pargraphNum} </span> </div> <div> <div class="w-full"> <textarea placeholder="القطعة"></textarea> <input type="text" name="code" placeholder="الرمز" class="w-full rad-6 border-ccc" /> </div><i class="fa-regular fa-trash-can" onclick="deletePragraphButton(this, '${page}')"></i></div></div>`);
    // let textareas = document.querySelector()
    // resizeTextarea();
}
function deleteContQuesButton (ele, page = 'create-new-test') {
    let Li = document.querySelector(`li#li_${ele.dataset.linum}`)
    Li.remove();
    countQues--;
    let numQuestions = '';
    if (page == 'question-bank') {
        numQuestions = document.querySelectorAll('.container-add-test > ul > li .number-ques');
    }else {
        numQuestions = document.querySelectorAll('.body-sec > li .number-ques');
    }
    numQuestions.forEach( (ele, index) => {ele.innerHTML = index+1 + ' : ';});
}
function deletePragraphButton (ele, page = 'create-new-test') {
    pargraphNum--;
    ele.parentElement.parentElement.remove();
    let numPargraph = '';
    if (page == 'question-bank') {
        numPargraph = document.querySelectorAll('.container-add-test > ul > div.pargraph .number-pargraph');
    }else {
        numPargraph = document.querySelectorAll('.body-sec > div.pargraph .number-pargraph');
    }
    numPargraph.forEach( (ele, index) => {ele.innerHTML = index+1;});
}
function copyQues (ele) {
    // let liEle = document.querySelector(`#li_${ele.dataset.linum}`);
    // liEle.insertAdjacentHTML('afterend', liEle);
}
function showKeyboardButton (ele) {
    let question = document.getElementById(`question_${ele.dataset.linum}`),
    answers = document.querySelectorAll(`#answer_${ele.dataset.linum}`);
    answers.forEach(ele => { ele.children[2].classList.remove('open')});
    question.children[2].classList.remove('open');
    ele.parentElement.parentElement.parentElement.children[2].classList.add('open');
    document.addEventListener('click', eled => {
        if (eled.target !== ele.parentElement.parentElement.parentElement.children[2] &&eled.target !== ele.parentElement.parentElement.parentElement.children[1] && eled.target !== ele) {
            ele.parentElement.parentElement.parentElement.children[2].classList.remove('open');
        }
    });
}
function uplaodImg(ele) {
    let containerImg = ele.parentElement.parentElement.children[0];
    console.log(containerImg)
    let file = new FileReader();
    if (ele.files[0].type.split('/')[0] == 'image'){
        file.readAsDataURL(ele.files[0]);
        file.onload = () => {
            let img = document.createAttribute('img');
            img.src = file.result;
            containerImg.innerHTML = `<img src="${file.result}" width="100%"></img>`;
        }
    }else {
        createToast('error', 'لا يمكن رفع غير الصور');
    }
}
let allDisplaiesClicked = [];
let inputClicked = [];
let focusInput;
function keyInputDiv (ele) {
    let typeques = document.querySelector(`li#li_${ele.dataset.linum}`).dataset.typeques;
    let displaies = document.querySelectorAll('li div.input-data');
    displaies.forEach( ele => { ele.innerHTML = ele.innerHTML.replace(/<span class="cursor-text"><\/span>/g, ''); if (ele.innerHTML == '') {ele.innerHTML = ele.dataset.placeholder;} });
    let placeholder = ele.dataset.placeholder;
    let mainInput = ele.parentElement.querySelector('input[type="text"]');
    if (ele.innerHTML == placeholder) {ele.innerHTML = '';}
    ele.innerHTML = transformData(mainInput.value, 'all', 0, mainInput.value.length);
    mainInput.selectionStart = mainInput.value.length;
    mainInput.selectionEnd = mainInput.value.length;
    mainInput.focus();
    if (inputClicked.indexOf(mainInput) == -1) {
        mainInput.addEventListener('keydown', e => {
            if (typeques == 'math') {
                theKey = e.key;
                switch (theKey) {
                    case 'Backspace':
                        backSpace (mainInput);
                        e.preventDefault();
                        break;
                    case 'ArrowRight':
                    case 'ArrowUp':
                        ele.innerHTML = arrowRight(mainInput);
                        e.preventDefault();
                        break;
                    case 'ArrowLeft':
                    case 'ArrowDown':
                        ele.innerHTML = arrowLeft(mainInput);
                        e.preventDefault();
                        break;
                }
            }
        })
        mainInput.addEventListener('keyup', e => {
            if (typeques == 'math') {
                theKey = e.key;
                switch(theKey){
                    // Enter
                    case 'Enter':
                        let item = '\\{Enter\\}';
                        mainInput.value = insertInText(mainInput.value, mainInput.selectionStart, item);
                        transformData (mainInput.value, 'all', 0, mainInput.selectionStart+item.length)
                        break;
                    default: ele.innerHTML = transformData(mainInput.value, 'all', 0, mainInput.selectionStart);
                }
                if (ele.innerHTML == '') {ele.innerHTML = placeholder}
            }
        });
        mainInput.addEventListener('focus', e => {
            if (typeques == 'math') {
                focusInput = mainInput;
            }
        });

        if (typeques == 'math') {
            focusInput = mainInput;
            inputClicked.push(mainInput)
        }
    }
    if (allDisplaiesClicked.indexOf(ele) == -1) {
        ele.parentElement.parentElement.children[1].addEventListener('click', e => {
            e.stopPropagation();
            if (typeques == 'math') {
                mainInput.focus();
            }
        })
        ele.parentElement.parentElement.children[2].addEventListener('click', e => {
            e.stopPropagation();
            if (typeques == 'math') {
                mainInput.focus();
            }
        });
        document.addEventListener('click', e => {
            typeques = document.querySelector(`li#li_${ele.dataset.linum}`).dataset.typeques;
            if (e.target !== ele && typeques == 'math') {
                ele.innerHTML = ele.innerHTML.replace(/<span class="cursor-text"><\/span>/g, '');
                if (ele.innerHTML == '') {ele.innerHTML = placeholder;}
            }
        });
        allDisplaiesClicked.push(ele);
    }
}
function typeKeyBoard (ele, type='normal') {
    let input = (type == 'normal') ? ele.parentElement.parentElement.parentElement.parentElement.children[1].children[3] : ele.parentElement.parentElement.parentElement.parentElement.parentElement.children[1].children[3];
    let display = (type == 'normal') ? ele.parentElement.parentElement.parentElement.parentElement.children[1].children[1] : ele.parentElement.parentElement.parentElement.parentElement.parentElement.children[1].children[1];
    let theKey = ele.dataset.key;
    let selecStart = input.selectionStart;
    let item = '';
    switch (theKey) {
        case 'Backspace':
            // backSpace(input);
            break;

        case 'AC':
            input.value = '';
            break;

        case 'fraction':
            item = '\\frac\\{\\}\\{\\}';
            input.value = insertInText(input.value, input.selectionStart, item);
            // '\frac{}{}' microsoft
            // '\frac\{\}\{\}'me
            break;

        case 'root':
            item = '\\sqrt\\{\\}\\{\\}';
            input.value = insertInText(input.value, input.selectionStart, '\\sqrt\\{\\}\\{\\}');
            // '\sqrt[]{}' microsoft
            // '\sqrt\{\}\{\}' me
            break;

        case 'power':
            item = '\\powe\\{\\}\\{\\}';
            input.value = insertInText(input.value, input.selectionStart, '\\powe\\{\\}\\{\\}');
            // '^{}' microsoft
            // '\powe\{\}\{\}' me
            break;

        case 'down':
            item = '\\down\\{\\}\\{\\}';
            input.value = insertInText(input.value, input.selectionStart, '\\down\\{\\}\\{\\}');
            // '\down\{\}\{\}' me
            break;

        case 'equation':
            item = '\\equa\\{\\}';
            input.value = insertInText(input.value, input.selectionStart, '\\equa\\{\\}');
            // '\equa{}' me
            break;
        default:
            item = theKey;
            input.value = insertInText(input.value, input.selectionStart, theKey);
    }
    display.click();
    input.selectionStart = selecStart+item.length;
    input.selectionEnd = selecStart+item.length;
    display.innerHTML = transformData (input.value, 'all', 0, selecStart+item.length);
}
function textClicked (event, ele, type) {
    event.stopPropagation();
    let locationCursor = 0;
    if (type == 'op') {
        locationCursor = Number(ele.dataset.location) + ele.firstChild.innerText.length;
        if(ele.innerHTML.indexOf('class="parent-op"') && ele.firstChild.innerText.length >= 1) {locationCursor= locationCursor - ele.firstChild.innerText.length;}
    }else {
        locationCursor = Number(ele.dataset.location) + ele.innerText.length;
    }
    focusInput.selectionEnd = locationCursor+1;
    focusInput.selectionStart = locationCursor+1;
    focusInput.focus();
    let display = focusInput.parentElement.querySelector('.input-data');
    display.innerHTML = transformData (focusInput.value, 'all', 0, locationCursor+1);
}
function arrowRight (inp) {
    let da = inp.value;
    let selecStart = inp.selectionStart;
    let newSelecStart=0;
    if (da.slice(selecStart-9, selecStart) == '\\{Enter\\}') {
        inp.selectionEnd = selecStart-9;
        inp.selectionStart = selecStart-9;
        newSelecStart = selecStart-9;
    }else if (da.slice(selecStart-7, selecStart) == '\\frac\\{' || da.slice(selecStart-7, selecStart) == '\\sqrt\\{' || da.slice(selecStart-7, selecStart) == '\\powe\\{' || da.slice(selecStart-7, selecStart) == '\\down\\{') {
        inp.selectionEnd = selecStart-7;
        inp.selectionStart = selecStart-7;
        newSelecStart = selecStart-7;
    }else if (da.slice(selecStart-4, selecStart) == '\\}\\{') {
        inp.selectionEnd = selecStart-4;
        inp.selectionStart = selecStart-4;
        newSelecStart = selecStart-4;
    }else if (da.slice(selecStart-2, selecStart) == '\\}' || (selecStart-2, selecStart) == '\\{') {
        inp.selectionEnd = selecStart-2;
        inp.selectionStart = selecStart-2;
        newSelecStart = selecStart-2;
    }else {
        if (selecStart != 0) {
            inp.selectionEnd = selecStart-1;
            inp.selectionStart = selecStart-1;
            newSelecStart = selecStart-1;
        }
    }
    return transformData (inp.value, 'all', 0, newSelecStart);
}
function arrowLeft (inp) {
    let da = inp.value;
    let selecStart = inp.selectionStart;
    let newSelecStart=0;
    if (da.slice(selecStart, selecStart+9) == '\\{Enter\\}') {
        inp.selectionEnd = selecStart+9;
        inp.selectionStart = selecStart+9;
        newSelecStart = selecStart+9;
    }else if (da.slice(selecStart, selecStart+7) == '\\frac\\{' || da.slice(selecStart, selecStart+7) == '\\sqrt\\{' || da.slice(selecStart, selecStart+7) == '\\powe\\{' || da.slice(selecStart, selecStart+7) == '\\down\\{') {
        inp.selectionEnd = selecStart+7;
        inp.selectionStart = selecStart+7;
        newSelecStart = selecStart+7;
    }else if (da.slice(selecStart, selecStart+4) == '\\}\\{') {
        inp.selectionEnd = selecStart+4;
        inp.selectionStart = selecStart+4;
        newSelecStart = selecStart+4;
    }else if (da.slice(selecStart, selecStart+2) == '\\}' || da.slice(selecStart, selecStart+2) == '\\{') {
        inp.selectionEnd = selecStart+2;
        inp.selectionStart = selecStart+2;
        newSelecStart = selecStart+2;
    }else {
        inp.selectionEnd = selecStart+1;
        inp.selectionStart = selecStart+1;
        newSelecStart = selecStart+1;
    }
    return transformData (inp.value, 'all', 0, newSelecStart);
}
function backSpace (inp) {
    let da = inp.value;
    let selecStart = inp.selectionStart;
    let newSelecStart=0;
    if (da.slice(selecStart-9, selecStart) == '\\{Enter\\}') {
        inp.value = inp.value.slice(0, selecStart-9) + inp.value.slice(selecStart+8);
        inp.selectionEnd = selecStart-9;
        inp.selectionStart = selecStart-9;
        newSelecStart = selecStart-9;
    }else if (da.slice(selecStart-7, selecStart) == '\\frac\\{' || da.slice(selecStart-7, selecStart) == '\\sqrt\\{' || da.slice(selecStart-7, selecStart) == '\\powe\\{' || da.slice(selecStart-7, selecStart) == '\\down\\{') {
        inp.value = inp.value.slice(0, selecStart-7) + inp.value.slice(selecStart+6);
        inp.selectionEnd = selecStart-7;
        inp.selectionStart = selecStart-7;
        newSelecStart = selecStart-7;
    }else if (da.slice(selecStart-4, selecStart) == '\\}\\{') {
        inp.selectionEnd = selecStart-4;
        inp.selectionStart = selecStart-4;
        newSelecStart = selecStart-4;
    }else if (da.slice(selecStart-2, selecStart) == '\\}' || (selecStart-2, selecStart) == '\\{') {
        inp.selectionEnd = selecStart-2;
        inp.selectionStart = selecStart-2;
        newSelecStart = selecStart-2;
    }else {
        newSelecStart = selecStart-1;
        if (selecStart != 0) {
            inp.value = inp.value.slice(0, selecStart-1) + inp.value.slice(selecStart);
            inp.selectionStart = newSelecStart;
            inp.selectionEnd = newSelecStart;
        }
    }
}
function insertInText(text, index, item) {
    return text.slice(0, index) + item + text.slice(index);
}
function transformAnswers (ele) {
    let inputs;
    let typeInp = '';
    if (ele.checked) {
        inputs = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('.answers .answer input[type="radio"]');
        typeInp = 'checkbox';
    }else {
        inputs = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('.answers .answer input[type="checkbox"]');
        typeInp = 'radio';
    }
    inputs.forEach( input => {input.type = typeInp;})
    let addNewAnSBut = document.querySelector(`#li_${ele.dataset.linum} .add-new-answer > span`);
    addNewAnSBut.dataset.typeinp = typeInp;
}
function transformMath (ele) {
    let Li = document.querySelector(`li#li_${ele.dataset.linum}`),
    keyboardIcons = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('span.keyboard-icon > i'),
    keyboards = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('div.math-keyboard'),
    displaiesMathKeyb = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('div.input-data'),
    inputsText = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('div.input-data ~ input[type="text"]'),
    textareas = document.querySelector(`li#li_${ele.dataset.linum}`).querySelectorAll('div.input-data + textarea');
    let style = '',
    show = '';
    if (ele.checked) {
        Li.dataset.typeques = 'math';
        style = 'open';
        show = '';
        for (let i=0; i<keyboardIcons.length; i++) {
            keyboardIcons[i].style.display = 'flex';
            displaiesMathKeyb[i].style.display = 'flex';
            textareas[i].classList.remove('open');
        }
    }else {
        Li.dataset.typeques = 'prag';
        style = 'none';
        show = 'open';
        for (let i=0; i<keyboardIcons.length; i++) {
            keyboardIcons[i].style.display = 'none';
            keyboards[i].classList.remove('open');
            displaiesMathKeyb[i].style.display = 'none';
            textareas[i].classList.add('open');
        }
        resizeTextarea(textareas);
        textareas.forEach( (ele, index) => {
            ele.addEventListener('keyup', e => {inputsText[index].value = ele.value;})
        });
    }
    let addNewAnSBut = document.querySelector(`#li_${ele.dataset.linum} .add-new-answer > span`);
    addNewAnSBut.dataset.style = style;
    addNewAnSBut.dataset.show = show;
}
function showBox (but, box) {
    if (but) {
        but.addEventListener('click', e => {
            but.classList.toggle('rotate');
            if (but.classList.contains('rotate')) {
                box.style.height = '0px';
                box.style.padding = '0px';
            }else {
                box.style.height = box.scrollHeight + 25 + 'px';
                box.style.padding = '10px 21px 15px';
            }
        })
    }
}
function sectionsQue (ele) {
    let options = '';
    if (ele.value == 'كمي') {
        options = kammey;
    }else if (ele.value == 'لفظي') {
        options = laphzy;
    }
    let content = '<select name="sectionQues" id="">';
    options = options.split(',');
    for (let i=0; i<options.length-1; i++) {
        if (options[i] != 'الكل') {
            content += `<option value="${options[i]}">${options[i]}</option>`;
        }
    }
    content += '</select>';
    ele.parentElement.parentElement.querySelector('.incress-select').innerHTML = content;
}
showBox (document.querySelector('.container-add-from .title i'), document.querySelector('.container-add-from .chose'))
showBox (document.querySelector('.container-controls .title i'), document.querySelector('.container-controls .controls'))