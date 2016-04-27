function getCountNum(){
    num = $api.getStorage('counter_num');
    if( num ){
        return parseInt(num);
    }else{//如果没有counter_num这个key,返回0
        return 0;
    }
}

function setCountNum(num){
    if( isNaN(num) ){
        alert("setCountNum传的值不是数字!");
    }else{
        $api.setStorage('counter_num', parseInt(num));
    }
}

function addOneCountNum(){
    num = getCountNum()+1;
    setCountNum(num);
    return num;
}

function resetCountNum(){
    $api.setStorage('counter_num', 0);
}

function getUserInfo(){
    userInfo = null;
    api.getPrefs({
        key: 'user'
    }, function( ret, err ){
        if( ret ){
            userInfo = $.parseJSON(ret.value);
        }else{
            alert(JSON.stringify(err))
        }
    });
    return userInfo;
}

function setUserInfo(user){
    api.setPrefs({
        key: 'user',
        value: user
    });
}

function autoFillPhone(domPhone){
    // api.getPhoneNumber(
    //     function(ret, err){
    //         if(ret){
    //             phone= ret.value;
    //             if( phone[0] == '+'){
    //                 phone = phone.substr(3);
    //             }
    //             domPhone.val(phone);
    //         }
    //     }
    // );
}

function sendCode(code, domSendCodeButton,jsSendMessageWait){
    api.ajax({
        url : apiHost+'/Api/Message/sendVerifyCode',
        method : 'post',
        dataType:'json',
        data : {
            values : {
                apikey : apiKey,
                phone : phone,
                code : code
            }
        }
    }, function(ret, err){
        if( ret ){
            //TODO 发送成功！
        }else{
            alert(JSON.stringify(err))
        }
    });
    time(domSendCodeButton,jsSendMessageWait);
}

function time(obj,jsSendMessageWait){
    if( jsSendMessageWait == 0 ){
        obj.html("发送");
        isEnableClick = true;
    }else{
        isEnableClick = false;
        jsSendMessageWait -= 1;
        obj.html(jsSendMessageWait);
        setTimeout(function(){
            time(obj,jsSendMessageWait-1);
        },1000);
    }
}