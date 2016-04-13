<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if( session("userid")){
            $this->assign("isLogin", 1);
        }else{
            $this->assign("isLogin", 0);
        }
        $this->display();
    }
}