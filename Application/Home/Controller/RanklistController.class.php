<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 14:27
 */

namespace Home\Controller;


use Think\Controller;
use Common\Service\CacheService;

class RanklistController extends Controller{
    public function index(){
        $this->display(Phpinfo());
    }

    public function todayRanklist(){

    }

}