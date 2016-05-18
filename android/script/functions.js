function getCountNum(){
    user = getUserInfo();
    num = $api.getStorage('counter_num_id'+user.id);
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
        user = getUserInfo();
        $api.setStorage('counter_num_id'+user.id, parseInt(num));
    }
}

function addOneCountNum(){
    num = getCountNum()+1;
    setCountNum(num);
    return num;
}

function resetCountNum(){
    user = getUserInfo();
    $api.setStorage('counter_num_id'+user.id, 0);
}

// function getUserInfo(){
    // userInfo = null;
    // api.getPrefs({
    //     key: 'user'
    // }, function( ret, err ){
    //     if( ret ){
    //         userInfo = $.parseJSON(ret.value);
    //     }else{
    //         alert(JSON.stringify(err))
    //     }
    // });
    // return userInfo;
// }

function setUserInfo(user){
    $api.setStorage("user", user);
}

function getUserInfo(){
    user = $api.getStorage("user");
    if( user ){
        return user;
    }else{
        api.openWin({
            name: 'login',
            url: './html/login.html',
            pageParam: {
                vScrollBarEnabled: false
            }
        });
    }
}

function sendCode(code, phone, domSendCodeButton,jsSendMessageWait){
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
            alert(JSON.stringify(err));
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