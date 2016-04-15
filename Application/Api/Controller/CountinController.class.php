<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 19:42
 */

namespace Api\Controller;


use Think\Controller;
use Common\Service\CountinService;

class CountinController extends Controller{
    public function addNum(){
        $num = I("num");
        $id = I("userid");
        if( CountinService::addNum($id,$num) ){
            $ret['error_code'] = 0;
        }else{
            $ret['error_code'] = 1;
        }
        echo json_encode($ret);
    }

    public function getTotalNum(){
        $id = I("userid");
        $total = CountinService::getTotalNumById($id);
        if( $total != -1 ){
            $ret['error_code'] = 0;
            $ret['num'] = $total;
        }else{
            $ret['error_code'] = 1;
            $ret['num'] = $total;
        }
        echo json_encode($ret);
    }

}