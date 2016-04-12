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
            $this->error("此手机号未被注册，正在跳转到注册页面！", U('Login/regist', array('phone'=>$phone)));
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
        $phone = I("phone");
        $this->assign("phone", $phone);
        $this->display();
    }

    public function registHandler(){
        $phone = I("phone");
        $password = I("password");
        $user['phone'] = $phone;
        $user['password'] = md5($password);

        if( !UserService::checkUserInfo($user) ){
            $this->error("请将信息填写完整！");
        }

        if( M("user")->add($user) ){
            $this->success("注册成功！", U('Index/index'));
        }else{
            $this->error("注册失败！");
        }
    }

    public function findPassword(){
        $this->display("modifyPassword");
    }

    public function modifyPasswordHandler(){
        $phone = I("phone");
        $password = I("password");
        $user['phone'] = $phone;
        $user['password'] = md5($password);
        if( !UserService::checkUserInfo($user) ){
            $this->error("请将信息填写完整！");
        }
        UserService::updateUserInfo($user);
        $this->success("修改成功！");
    }

}
