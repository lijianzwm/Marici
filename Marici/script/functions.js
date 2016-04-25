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
    api.getPhoneNumber(
        function(ret, err){
            if(ret){
                phone= ret.value;
                if( phone[0] == '+'){
                    phone = phone.substr(3);
                }
                domPhone.val(phone);
            }
        }
    );
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