<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 10:49
 */

namespace Api\Controller;


use Think\Controller;
use Common\Service\UserService;

class UserController extends Controller{

    public function updateUserInfo(){
        $user['id'] = I("id");
        $user['phone'] = I("phone");
        if( I("realname") ){
            $user['realname'] = I("realname");
        }
        if( I("dharma")){
            $user['dharma'] = I("dharma");
        }
        if( UserService::updateUserInfo($user)){
            $ret['error_code'] = 0;
            $ret['msg'] = "更新用户信息成功！";
        }else{
            $ret['error_code'] = 1;
            $ret['msg'] = "更新用户信息失败！";
        }
        echo json_encode($ret);
    }

}