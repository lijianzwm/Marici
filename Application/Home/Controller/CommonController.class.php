<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 15:12
 */

namespace Home\Controller;


use Think\Controller;

class CommonController extends Controller{
    public function _initialize(){
        if( !session("userid") ){
            $this->redirect("Login/login");
        }
    }
}