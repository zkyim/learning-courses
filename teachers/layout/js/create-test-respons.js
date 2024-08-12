function getResponsFile() {
    if (file) {
        let myRequest = new XMLHttpRequest();
        myRequest.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let Object = JSON.parse(this.responseText);
                let scount = Object.length;
                showQuestion (Object);
            }
            // else if (this.readyState !== 4 && this.status !== 200) {
            //     document.body.innerHTML = '<div class="c-red p-20"> الملف المطلوب غير موجود الرجاء مراجة بياناتك ... </div>';
            // }
        };
        myRequest.open("POST", file, true);
        myRequest.send();
    }
}
function showQuestion (obj) {
    for (let i=0; i<obj.length; i++) {
        let id = 'newSec';
        let j;
        for (j=0; j<obj[i].length-1; j++) {
            // console.log(obj[i][j]);
            if (j == 1) {id = document.querySelector('.container-add-test .cont-section:last-child').id;}
            if (obj[i][j].type_item == 'question') {
                addNewQuestion ('newQuestion', 1, obj[i][j].the_code, [obj[i][j].math, obj[i][j].suffling, obj[i][j].multans], id, obj[i][j].the_section, obj[i][j].title, obj[i][j].answeres, obj[i][j].right_answeres, obj[i][j].explain)
            }else if (obj[i][j].type_item == 'pargraph') {
                addNewParagraph(id, obj[i][j].pargraph, obj[i][j].the_code);
            }
        }
        document.querySelector('.container-add-test .cont-section:last-child .header-sec input').value = obj[i][j].title_section;
    }
}
function saveShanges (typeAction = 'writeInTheFile', user_id = 0) {
    let contentJsonFile = `[`;
    let sectiones = document.querySelectorAll('.container-add-test .cont-section');
    let questionCount = 0;
    if (typeAction == 'writeInTheFile') {
        sectiones.forEach( (sec, index) => {
            if (index > 0) {contentJsonFile += `,`;}
            contentJsonFile += `[`;
            let children = Array.from(sec.children[1].children);
            let paragraphCount = 0;
            let theCodesOfQuestion = [];
            let theCodesOfPargraph = [];
            let theReturn = getChildren(children);
            paragraphCount += theReturn.paragraphCount;
            theCodesOfQuestion += theReturn.theCodesOfQuestion;
            theCodesOfPargraph += theReturn.theCodesOfPargraph;
            let titleSection = sec.querySelector('.header-sec input[type="text"]').value;
            if (titleSection.length === 0) {
                let num = sec.querySelector('.header-sec span').innerHTML;
                createToast('error', `الرجاء كتابة العنوان في القسم رقم ${num}`);
            }
            contentJsonFile += `,{"title_section": "${titleSection}","paragraph_count": ${paragraphCount},"the_codes_of_question": ${JSON.stringify(theCodesOfQuestion)},"the_codes_of_pargraph": ${JSON.stringify(theCodesOfPargraph)}}`;
            for (let i=0; i<theCodesOfPargraph.length; i++) {
                if (theCodesOfQuestion.indexOf(theCodesOfPargraph[i]) == -1) {
                    createToast('error', `يجب إختيار رمز في الأسئلة للقطعة ذات الرقم ${i+1}`);
                }
            }
            contentJsonFile += `]`;
        });
    }else if (typeAction == 'addNewQuestiones' || typeAction == 'updatequestion') {
        let children = Array.from(document.querySelector('.container-add-test ul').children);
        getChildren (children);
    }
    contentJsonFile += `]`;
    contentJsonFile = JSON.stringify(contentJsonFile).replace(/\\n/g, '').replace(/\\r/g, '')
    contentJsonFile = JSON.parse(contentJsonFile)
    console.log(JSON.parse(contentJsonFile));
    let xhr = new XMLHttpRequest();
    xhr.onload = () => { 
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log(response);
            if (response.indexOf('success') > -1) {
                if (typeAction == 'updatequestion') {
                    window.location = 'question_bank.php';
                }else {
                    createToast('success', 'تم حفظ التغيرات .')
                }
            }else if (response.indexOf('There is no that id') > -1) {
                createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
            }
        }
    }
    xhr.open("POST", "action_create-test-respons.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    if (typeAction == 'writeInTheFile') {
        console.log(contentJsonFile)
        xhr.send(`action=writeInTheFile&file_id=${fileID}&file_name=${file}&contentJsonFile=${contentJsonFile}&questionCount=${questionCount}`);
    }else if (typeAction == 'addNewQuestiones') {
        xhr.send(`action=addnewquestiones&contentJsonFile=${contentJsonFile}&teacher_id=${teacherid}`);
    }else if (typeAction == 'updatequestion') {
        xhr.send(`action=updatequestion&contentJsonFile=${contentJsonFile}&user_id=${user_id}&teacher_id=${teacherid}`);
    }
    function getChildren (children) {
        let paragraphCount = 0;
        let theCodesOfPargraph = [];
        let theCodesOfQuestion = [];
        children.forEach ( (ele, index) => {
            if (index > 0) {contentJsonFile += ',';}
            if (ele.dataset.typeitem == 'question') {
                questionCount++;
                // let theSection = ele.querySelector('select[name="typeques"] option:checked').value;
                let theCode = ele.querySelector('input[type="text"]#code').value;
                if (theCode.length > 0) {theCodesOfQuestion.push(theCode)}
                let suffling = ele.querySelector('input[type="checkbox"]#shuffle');
                if (suffling.checked) {suffling = 'shuffle';}else {suffling = 'no-shuffle';}
                let math = ele.querySelector('input[type="checkbox"]#math');
                if (math.checked) {math = 'math';}else {math = 'no-math';}
                let multipleAnswer = ele.querySelector('input[type="checkbox"]#multiple-answer');
                if (multipleAnswer.checked) {multipleAnswer = 'multans';}else {multipleAnswer = 'no-multans';}
                let title = '';
                let imgTilte = ele.querySelector('.info-ques input[type="file"]').files[0];
                if (imgTilte == undefined) {
                    imgTilte = '';
                }else {
                    imgTilte = imgTilte.name;
                }
                let answeres = [];
                let imgAnswersArr = [];
                let imgAnswers = ele.querySelectorAll('.answers input[type="file"]');
                for (let i = 0; i < imgAnswers.length; i++) {
                    if (imgAnswers[i].files[0] == undefined) {
                        imgAnswersArr.push('');
                    }else {
                        imgAnswersArr.push(imgTilte.name);
                    }
                }
                let rightAnsweres = [];
                let explain = '';
                if (math == 'math') {
                    title = ele.querySelector('.info-ques input[type="text"]').value;
                    answeres = ele.querySelectorAll('.container-more-detail-ques .container-answer-info input[type="text"]');
                    explain = ele.querySelector('.container-explain-info input[type="text"]').value;
                }else {
                    title = ele.querySelector('.info-ques textarea').value;
                    answeres = ele.querySelectorAll('.container-more-detail-ques .container-answer-info textarea');
                    explain = ele.querySelector('.container-explain-info textarea').value;
                }
                if (title.length === 0) {
                    let num = ele.querySelector('.number-ques').innerHTML;
                    createToast('error', `الرجاء كتابة السؤال في السؤال رقم ${num}`);
                }else {
                    title = title.replace(/"/g,'\'');
                }
                if (answeres.length == 0) {
                    let num = ele.querySelector('.number-ques').innerHTML;
                    createToast('error', `الرجاء وضع إجابات للسؤال رقم ${num}`);
                }
                if (answeres.length > 0) {
                    let emptyAnswers = true;
                    answeres.forEach( (answer,index) => {
                        if (index == 0) {answeres = [];}
                        answeres.push(JSON.parse(JSON.stringify(answer.value).replace(/\\n/g, '').replace(/\\r/g, '')))
                        // answeres.push(answer.value);
                        if (answer.value.length > 0) {emptyAnswers = false;}
                    })
                    if (emptyAnswers == true) {
                        let num = ele.querySelector('.number-ques').innerHTML;
                        createToast('error', `الرجاء وضع ملئ إجابات للسؤال رقم ${num}`);
                    }
                }
                if (multipleAnswer === 'multans') {
                    rightAnsweres = ele.querySelectorAll('.container-more-detail-ques .container-answer-info input[type="checkbox"]');
                }else {
                    rightAnsweres = ele.querySelectorAll('.container-more-detail-ques .container-answer-info input[type="radio"]');
    
                }
                if (rightAnsweres.length > 0) {
                    let emptyRightAnswers = true;
                    rightAnsweres.forEach( (rightAnswer, index) => {
                        if (index == 0) {rightAnsweres = [];}
                        if (rightAnswer.checked) {emptyRightAnswers = false;rightAnsweres.push(index);}
                    })
                    if (emptyRightAnswers == true) {
                        let num = ele.querySelector('.number-ques').innerHTML;
                        createToast('error', `الرجاء إختيار إجابة واحدة صحيحة على الأقل للسؤال رقم ${num}`);
                    } 
                }
                // if (explain.length === 0) {
                //     let num = ele.querySelector('.number-ques').innerHTML;
                //     createToast('error', `الرجاء كتابة الشرح في السؤال رقم ${num}`);
                // }
                explain = explain.replace(/"/g,'\'');
                contentJsonFile += `{"type_item": "question","the_section": "${theSection}",`;
                    if (typeAction == 'addNewQuestiones' || typeAction == 'updatequestion') {
                        let secQuestion = ele.querySelector('select[name="sectionQues"] option:checked').value;
                        contentJsonFile += `"sec_question": "${secQuestion}",`;
                    }
                    contentJsonFile +=`"math": "${math}","suffling": "${suffling}","multans": "${multipleAnswer}","title": "${dubbleBackSlashes(title)}","img-title": "${imgTilte}","answeres": ${JSON.stringify(answeres)},"img-answers": ${JSON.stringify(imgAnswersArr)},"right_answeres" : ${JSON.stringify(rightAnsweres)},"explain": "${dubbleBackSlashes(explain)}","the_code": ${JSON.stringify(theCode)}}`;
                // contentJsonFile += `{
                //     "type_item": "question",
                //     "the_section": "${theSection}",`;
                //     if (typeAction == 'addNewQuestiones' || typeAction == 'updatequestion') {
                //         let secQuestion = ele.querySelector('select[name="sectionQues"] option:checked').value;
                //         contentJsonFile += `"sec_question": "${secQuestion}",`;
                //     }
                //     contentJsonFile +=`"math": "${math}",
                //     "suffling": "${suffling}",
                //     "multans": "${multipleAnswer}",
                //     "title": "${dubbleBackSlashes(title)}",
                //     "img-title": "${imgTilte}",
                //     "answeres": ${JSON.stringify(answeres)},
                //     "img-answers": ${JSON.stringify(imgAnswersArr)},
                //     "right_answeres" : ${JSON.stringify(rightAnsweres)},
                //     "explain": "${dubbleBackSlashes(explain)}",
                //     "the_code": ${JSON.stringify(theCode)}
                // }`;
            }else if (ele.dataset.typeitem == 'pargraph') {
                paragraphCount++;
                let paragraph = ele.querySelector('textarea').value;
                if (paragraph.length === 0) {
                    createToast('error', `يجب ملئ القطعة رقم ${index+1}`);
                }
                let theCode = ele.querySelector('input[type="text"]').value;
                if (theCode.length > 0) {theCodesOfPargraph.push(theCode)}
                if (theCode.length === 0) {
                    createToast('error', `يجب ملئ الرمز للقطعة رقم ${index+1}`);
                }
                contentJsonFile += `{
                    "type_item": "pargraph",
                    "pargraph": "${dubbleBackSlashes(paragraph)}",
                    "the_code": "${theCode}"
                }`;
            }
        })
        return { "paragraphCount": paragraphCount, "theCodesOfPargraph": theCodesOfPargraph, "theCodesOfQuestion": theCodesOfQuestion};
    }
    if (typeAction == 'addNewQuestiones') {
        document.querySelector('.container-add-test ul').innerHTML = '';
    }
}
function dubbleBackSlashes (data) {
    return data.replace(/\\/g, '\\\\');
}
// ================================= Add Questiones ================================
let offset = 1;
function addNewQuestiones () {
    let questiones = document.querySelector('.container-add-test ul').children;
    if (questiones.length != 0) {
        saveShanges ('addNewQuestiones');
    }
}
function getDataQuestion (user_id) {
    let xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log(response);

            if (response.indexOf('This is not for you') > -1) {
                createToast('error', ' لم تضع هذا السؤال حاول مرة أخرى . ');
            }else if (response.indexOf('There is no that id') > -1) {
                createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
            }else {
                let obj = JSON.parse(response);
                for (let j = 0; j < obj.length; j++) {
                    if (obj[j].type_item == 'question') {
                        addNewQuestion ('newQuestion', 1, obj[j].the_code, [obj[j].math, obj[j].suffling, obj[j].multans], 0, obj[j].the_section, obj[j].title, obj[j].answeres, obj[j].right_answeres, obj[j].explain, obj[j].sec_question, obj[j].id, obj[j].teacherID, 'question_bank', 'No')
                    }else if (obj[j].type_item == 'pargraph') {
                        addNewParagraph('newParagraph', obj[j].pargraph, obj[j].the_code, obj[j].teacherID, obj[j].id, 'question_bank', 'No');
                    }
                }
            }
        }
    }
    xhr.open("POST", "action_create-test-respons.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`action=getdataquestion&user_id=${user_id}&teacher_id=${teacherid}`);
}
function updateQuestion (ele) {
    saveShanges('updatequestion', `${ele.dataset.userid}`);
}
function deleteQuestion (ele) {
    let xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log(response);
            if (response.indexOf('success') > -1) {
                if (ele.dataset.typeitem == 'question') {
                    document.querySelector(`.container-add-test ul li#li_${ele.dataset.linum}`).remove();
                }else if (ele.dataset.typeitem == 'pargraph') {
                    document.querySelector(`.container-add-test ul div.pargraph#ques_${ele.dataset.linum}`).remove();
                }
                createToast('success', 'تم الحذف بنجاح .');
            }else if (response.indexOf('This is not for you') > -1) {
                createToast('error', ' لم تضع هذا السؤال حاول مرة أخرى . ');
            }else if (response.indexOf('There is no that id') > -1) {
                createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
            }
        }
    }
    xhr.open("POST", "action_create-test-respons.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`action=deletequestion&user_id=${ele.dataset.userid}&teacher_id=${teacherid}`);
}
function loadmoreQuestion (ele) {
    let xhr = new XMLHttpRequest();
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = xhr.responseText;
            console.log(response);
            if (response.indexOf('This is all questions') > -1) {
                document.querySelector('.container-add-test .more-questiones').style.display = 'none';
                containerSec.innerHTML += '<h2 class="c-red p-20"> لا يوجد المزيد من الأسئلة  </h2>';
            }else if (response.indexOf('empty') > -1) {
            }else if (response.indexOf('There is no that id') > -1) {
                createToast('error', ' هناك خطأ ما أعد المحاولة في وقت لاحق. ');
            }else {
                offset++;
                let obj = JSON.parse(response);
                for (let j = 0; j < obj.length; j++) {
                    if (obj[j].type_item == 'question') {
                        addNewQuestion ('newQuestion', 1, obj[j].the_code, [obj[j].math, obj[j].suffling, obj[j].multans], 0, obj[j].the_section, obj[j].title, obj[j].answeres, obj[j].right_answeres, obj[j].explain, obj[j].sec_question, obj[j].id, obj[j].teacherID, 'question_bank')
                    }else if (obj[j].type_item == 'pargraph') {
                        addNewParagraph('newParagraph', obj[j].pargraph, obj[j].the_code, obj[j].teacherID, obj[j].id, 'question_bank');
                    }
                }
            }
        }
    }
    xhr.open("POST", "action_create-test-respons.php", false);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`action=loadmorequestiones&offset=${offset}&the_section=${theSection}&sec_question=${secQuestion}`);
}
