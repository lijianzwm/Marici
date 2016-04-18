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
//        if( !is_numeric($num) ){
//            $ret['error_code'] = 1;
//            $ret['msg'] = "请输入正确的数字！";
//        }else{
//            $num = intval($num);
//            if(  $num > 0 ){
                if( CountinService::addTodayNum($id,$num) ){
                    $ret['error_code'] = 0;
                }else{
                    $ret['error_code'] = 1;
                    $ret['msg'] = "用户不存在！";
                }
//            }else{
//                $ret['error_code'] = 1;
//                $ret['msg'] = "请输入大于0的整数！";
//            }
//        }
        echo json_encode($ret);
    }

    public function getTotalNum(){
        $id = I("userid");
        $total = CountinService::getUserTotalNumById($id);
        if( $total != null ){
            $ret['error_code'] = 0;
            $ret['num'] = $total;
        }else{
            $ret['error_code'] = 1;
            $ret['num'] = $total;
        }
        echo json_encode($ret);
    }

}