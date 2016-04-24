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