<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 9:38
 */

namespace Home\Controller;

use Think\Controller;
use Common\Service\UserService;

class LoginController extends Controller{
    public function login(){
        $this->display();
    }

    public function loginHandler(){
        $phone = I("phone");
        if( !$phone ){
            $this->error("请填写手机号！");
        }
        $user = UserService::getUserByPhone($phone);
        if( !$user ){
            $this->error("无此手机号！");
        }
        if( $user['password'] == md5(I("password")) ){
            session("username", $phone);
            $this->success("登录成功！",U('Index/index'));
        }

    }

    /**
     * 查询当前手机号的用户是否存在
     */
    public function isPhoneExist(){
        $phone = I("phone");
        if( UserService::isExistUser($phone) ){
            $ret['regist_state'] = 1;
        }else{
            $ret['regist_state'] = 0;
        }
        echo json_encode($ret);
    }

    public function regist(){
        $this->display();
    }

    public function registHandler(){
        $user['phone'] = I("phone");
        $user['password'] = md5(I("password"));
        if( M("user")->add($user) ){
            $this->success("注册成功！", U('Index/index'));
        }else{
            $this->error("注册失败！");
        }
    }

}
