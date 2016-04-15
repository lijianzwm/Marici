<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 14:27
 */

namespace Home\Controller;


use Think\Controller;
use Common\Service\RanklistService;

class RanklistController extends Controller{
    public function index(){
        $this->display(Phpinfo());
    }

    public function todayRanklist(){
        $ranklist = RanklistService::getTodayRanklist();
        $this->assign("title", "今日排行");
        $this->assign("yourUserid", session("userid"));
        $this->assign("ranklist", $ranklist);
        $this->display("ranklist");
    }

}