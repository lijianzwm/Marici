<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 15:12
 */

namespace Home\Controller;

use Common\Service\CountinService;

class CountinController extends CommonController{

    public function addNum(){
        $userid = session("userid");
        $todayNum = CountinService::getTodayNumById($userid);
        $total = CountinService::getUserTotalNumById($userid);
        if( $total == null ){
            $total = "用户不存在！";
            $todayNum = "用户不存在！";
        }else{
            if( $todayNum == null ){
                $todayNum = 0;
            }
        }
        $this->assign("todayNum", $todayNum);
        $this->assign("total", $total);
        $this->display();
    }

    public function addNumHandler(){
        $num = I("num");
        $id = session("userid");
        if( CountinService::addTodayNum($id,$num) ){
            $this->success("报数成功！", U('Ranklist/todayRanklist'));
        }else{
            $this->error("报数失败！");
        }
    }

    public function counter(){
        $total = CountinService::getUserTotalNumById(session("userid"));
        $todayNum = CountinService::getTodayNumById(session("userid"));
        $this->assign("total", $total);
        $this->assign("todayNum", $todayNum);
        $this->display();
    }

}