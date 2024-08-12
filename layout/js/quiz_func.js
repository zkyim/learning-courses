function transformData (da, type='all', start=0, locCursor = 0, cursor = true) {
    let newData = '';
    let theEnd = start;
    if (da.length == 0 && locCursor == 0 && type =='all' && cursor == true) {newData += '<span class="cursor-text"></span>';}
    for (let i=start; i<da.length; i++) {
        if (i == 0) {newData += '<span class="new-line">';}
        if (i == 0 && locCursor == 0 && type =='all' && cursor == true) {newData += '<span class="cursor-text"></span>';}
        let out=false;
        let strartOp;
        let endOp;
        if (da.slice(i, i+7) == '\\frac\\{' || da.slice(i, i+7) == '\\sqrt\\{' || da.slice(i, i+7) == '\\powe\\{' || da.slice(i, i+7) == '\\down\\{') {
            let theOp = da.slice(i, i+7);
            if (i!=0) {newData += `</span>`;}
            if (type=='some'){da.slice(i, i+2)}
            strartOp = i;
            i +=7;
            let countCirilyPracece = 0;
            let firstNum='';
            let secondNum='';
            let selecStartFirstNum;
            let selecStartSecondNum;
            let theReturnData = '';
            let classNameFirstNum = '';
            let classNameSecondNum = '';
            let theStart=i;
            for (let j=i; j<da.length; j++) {
                theReturnData = condMoreOp(da, j, locCursor);
                if (theReturnData !== '') {
                    theReturnData = theReturnData.split('||');
                    j=Number(theReturnData[1]);
                }
                if (da.slice(j, j+2) == '\\}') {
                    if (countCirilyPracece==0) {
                        selecStartFirstNum = i;
                        if (theReturnData!='') {firstNum += theReturnData[0];}
                        if (theStart == locCursor) {classNameFirstNum += 'cursor';}
                        countCirilyPracece++;
                        if (da.slice(j+2, j+4) == '\\{') {
                            theStart=j+2;
                            j+=4;
                            for (let f=j; f<da.length;  f++) {
                                theReturnData = condMoreOp(da, f, locCursor);
                                if (theReturnData !== '') {
                                    theReturnData = theReturnData.split('||');
                                    f=Number(theReturnData[1]);
                                }
                                if (da.slice(f, f+2) == '\\}') {
                                    if (countCirilyPracece==1) {
                                        selecStartSecondNum = j;
                                        if (theReturnData!='') {secondNum += theReturnData[0]}
                                        if (theStart == locCursor-2) {classNameSecondNum += 'cursor';}
                                        countCirilyPracece++;
                                        i = f+1;
                                        endOp = f+2;
                                        out=true;
                                        break;
                                    }
                                }else {
                                    if (f-2 == theStart) {
                                        secondNum += `<span class="" data-location="${f-1}" onclick="textClicked(event, this)">`;
                                        if (f == locCursor) {secondNum += '<span class="cursor-text"></span>';}
                                    }
                                    if (da[f] == ' ') {
                                        secondNum += '</span>';
                                        secondNum += `<span class="" data-location="${f-1}" onclick="textClicked(event, this)">&nbsp;`;
                                        if (f+1 == locCursor) {secondNum += '<span class="cursor-text"></span>';}
                                        secondNum += '</span>';
                                        secondNum += `<span class="" data-location="${f}" onclick="textClicked(event, this)">`;
                                    }else {
                                        secondNum += da[f];
                                        if (f+1 == locCursor) {secondNum += '<span class="cursor-text"></span>';}
                                    }
                                    if (f == secondNum.length-1) {
                                        secondNum += '</span>';
                                    }
                                }
                            }
                        }
                    }
                }else {
                    if (j == theStart) {
                        firstNum += `<span class="" data-location="${j-1}" onclick="textClicked(event, this)">`;
                        if (j == locCursor) {firstNum += '<span class="cursor-text"></span>';}
                    }
                    if (da[j] == ' ') {
                        firstNum += '</span>';
                        firstNum += `<span class="" data-location="${j-1}" onclick="textClicked(event, this)">&nbsp;`;
                        if (j+1 == locCursor) {firstNum += '<span class="cursor-text"></span>';}
                        firstNum += '</span>';
                        firstNum += `<span class="" data-location="${j}" onclick="textClicked(event, this)">`;
                    }else {
                        firstNum += da[j];
                        if (j+1 == locCursor) {firstNum += '<span class="cursor-text"></span>';}
                    }
                    if (j == firstNum.length-1) {
                        firstNum += '</span>';
                    }
                }
                if (out==true) {break;}
            }
            let valueOfFirstNum = '';
            let valueOfSecondNum = '';
            theBiludOp = '';
            if (firstNum=='') {classNameFirstNum += ' unknown';valueOfFirstNum=''}else {classNameFirstNum += ' ';valueOfFirstNum=firstNum}
            if (secondNum=='') {classNameSecondNum += ' unknown';valueOfSecondNum=''}else {classNameSecondNum += ' ';valueOfSecondNum=secondNum}
            switch (theOp) {
                case '\\frac\\{':
                    theBiludOp = `<span class="parent-op"><span class="fraction"><span class="numerator" data-location="${selecStartFirstNum-1}" onclick="textClicked(event, this, 'op')"><div class="num ${classNameFirstNum}">${valueOfFirstNum}</div></span><span class="the-line"></span><span class="denominator" data-location="${selecStartSecondNum-1}" onclick="textClicked(event, this, 'op')"><div class="num ${classNameSecondNum}">${valueOfSecondNum}</div></span></span>`;
                    break;
                case '\\sqrt\\{':
                    theBiludOp = `<span class="parent-op"><span class="root"><span class="first-num" data-location="${selecStartFirstNum-1}" onclick="textClicked(event, this, 'op')"><div class="exponent num ${classNameFirstNum}">${valueOfFirstNum}</div></span><span class="lines-root"><span class="line_1"><span class="line_2"></span></span></span><span class="second-num" data-location="${selecStartSecondNum-1}" onclick="textClicked(event, this, 'op')"><div class="num-root num ${classNameSecondNum}">${valueOfSecondNum}</div></span></span>`;
                    break;
                case '\\powe\\{':
                    theBiludOp = `<span class="parent-op"><span class="second-num" data-location="${selecStartFirstNum-1}" onclick="textClicked(event, this, 'op')"><div class="num-power num ${classNameFirstNum}">${valueOfFirstNum}<span class="first-num" data-location="${selecStartSecondNum-1}" onclick="textClicked(event, this, 'op')"><div class="the-power num ${classNameSecondNum}">${valueOfSecondNum}</div></span></div></span>`;
                    break;
                case '\\down\\{':
                    theBiludOp = `<span class="parent-op"><span class="second-num" data-location="${selecStartFirstNum-1}" onclick="textClicked(event, this, 'op')"><div class="num-down num ${classNameFirstNum}">${valueOfFirstNum}<span class="first-num" data-location="${selecStartSecondNum-1}" onclick="textClicked(event, this, 'op')"><div class="the-down-num num ${classNameSecondNum}">${valueOfSecondNum}</div></span></div></span>`;
                    break;
            }
            if (type=='all'){newData += theBiludOp;}else
            if (type=='some'){newData += theBiludOp;theEnd = endOp;}
            if (type=='some'){if (da.slice(i+1, i+3)!=='\\}'){out=false;}}
            if (i+1 == locCursor) {newData += '<span class="cursor-text"></span>';}
            newData += '</span>';
            newData += `<span class="" data-location="${i-1}" onclick="textClicked(event, this)">`;

        }else if (da.slice(i, i+7) == '\\equa\\{') {
            if (i!=0) {newData += `</span>`;}
            if (type=='some'){da.slice(i, i+2)}
            strartOp = i;
            i +=7;
            let firstNum='';
            let selecStartFirstNum;
            let theReturnData = '';
            let classNameFirstNum = '';
            let theStart=i;
            for (let j=i; j<da.length; j++) {
                theReturnData = condMoreOp(da, j, locCursor);
                if (theReturnData !== '') {
                    theReturnData = theReturnData.split('||');
                    j=Number(theReturnData[1]);
                }
                if (da.slice(j, j+2) == '\\}') {
                    selecStartFirstNum = i;
                    if (theReturnData!='') {firstNum += theReturnData[0];}
                    if (theStart == locCursor) {classNameFirstNum += 'cursor';}
                    i = j+1;
                    endOp = j+2;
                    out=true;
                    break;
                }else {
                    if (j == theStart) {
                        firstNum += `<span class="" data-location="${j-1}" onclick="textClicked(event, this)">`;
                        if (j == locCursor) {firstNum += '<span class="cursor-text"></span>';}
                    }
                    if (da[j] == ' ') {
                        firstNum += '</span>';
                        firstNum += `<span class="" data-location="${j-1}" onclick="textClicked(event, this)">&nbsp;`;
                        if (j+1 == locCursor) {firstNum += '<span class="cursor-text"></span>';}
                        firstNum += '</span>';
                        firstNum += `<span class="" data-location="${j}" onclick="textClicked(event, this)">`;
                    }else {
                        firstNum += da[j];
                        if (j+1 == locCursor) {firstNum += '<span class="cursor-text"></span>';}
                    }
                    if (j == firstNum.length-1) {
                        firstNum += '</span>';
                    }
                }
                if (out==true) {break;}
            }
            let valueOfFirstNum = '';
            theBiludOp = '';
            if (firstNum=='') {classNameFirstNum += ' unknown';valueOfFirstNum=''}else {classNameFirstNum += ' ';valueOfFirstNum=firstNum}
            theBiludOp  = `<span class="parent-op"><span class="equa"><span class="content" data-location="${selecStartFirstNum-1}" onclick="textClicked(event, this, 'op')"><div class="num ${classNameFirstNum}">${valueOfFirstNum}</div></span></span>`;
            if (type=='all'){newData += theBiludOp;}else
            if (type=='some'){newData += theBiludOp;theEnd = endOp;}
            if (type=='some'){if (da.slice(i+1, i+3)!=='\\}'){out=false;}}
            if (i+1 == locCursor) {newData += '<span class="cursor-text"></span>';}
            newData += '</span>';
            newData += `<span class="" data-location="${i-1}" onclick="textClicked(event, this)">`;
        }else if (da.slice(i, i+9) == '\\{Enter\\}') {
            i+=8;
            newData += '</span>';
            newData += '</span>';
            newData += '<span class="new-line">';
            newData += `<span class="" data-location="${i}" onclick="textClicked(event, this)">`;
        }else {
            if (i==0 ) {
                newData += `<span class="" data-location="${i-1}" onclick="textClicked(event, this)">`;
            }
            if (da[i] == ' ') {
                // add space span here
                newData += '</span>';
                newData += `<span class="" data-location="${i-1}" onclick="textClicked(event, this)">&nbsp;`;
                if (i+1 == locCursor) {newData += '<span class="cursor-text"></span>';}
                newData += '</span>';
                newData += `<span class="" data-location="${i}" onclick="textClicked(event, this)">`;
            }else {
                newData += da[i];
                if (i+1 == locCursor) {newData += '<span class="cursor-text"></span>';}
            }
            if (i == da.length-1) {
                newData += '</span>';
            }
            if (type=='some'){theEnd++; if (da.slice(i+1, i+3)=='\\}'){out=true;}}
        }
        if (type=='some'&&out==true) {break;}
    }
    if (newData == '') {
        return da;
    }else {
        if (type=='all') { return newData; }
        else if(type=='some') { return newData + '||' + theEnd}
    }
    function condMoreOp (da, i, locCursor) {
        let theData = '';
        if (da.slice(i, i+7) == '\\frac\\{' || da.slice(i, i+7) == '\\sqrt\\{' || da.slice(i, i+7) == '\\powe\\{' || da.slice(i, i+7) == '\\down\\{') {
            theData = transformData (da, 'some', i, locCursor);
        }
        return theData;
    }
    console.log(newData);
}