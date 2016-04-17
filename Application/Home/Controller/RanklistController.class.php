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
        $this->assign("title", "今日排行榜");
        $this->assign("yourUserid", session("userid"));
        $this->assign("refreshTime", C("TODAY_RANKLIST_EXPIRE"));
        $this->assign("ranklist", $ranklist);
        $this->display("ranklist");
    }

    public function totalRanklist(){
        $ranklist = RanklistService::getTotalRanklist();
        $this->assign("title","总排行榜");
        $this->assign("refreshTime", C("TOTAL_RANKLIST_EXPIRE"));
        $this->assign("yourUserid", session("userid"));
        $this->assign("ranklist", $ranklist);
        $this->display("ranklist");
    }

    public function yesterdayRanklist(){
        $ranklist = RanklistService::getYesterdayRanklist();
        $this->assign("title","昨日排行榜");
        $this->assign("refreshTime", C("SOMEDAY_RANKLIST_EXPIRE"));
        $this->assign("yourUserid", session("userid"));
        $this->assign("ranklist", $ranklist);
        $this->display("ranklist");
    }

    public function curMonthRanklist(){
        $ranklist = RanklistService::getCurMonthRanklist();
        $this->assign("title","本月排行榜");
        $this->assign("refreshTime", C("CUR_MONTH_RANKLIST_EXPIRE"));
        $this->assign("yourUserid", session("userid"));
        $this->assign("ranklist", $ranklist);
        $this->display("ranklist");
    }

}