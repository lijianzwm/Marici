<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 13:52
 */

namespace Common\Service;


use Org\Util\Date;

class DateService{
    public static function getStrDate(){
        return strval(date('y-m-d',time()));
    }

    public static function getCrrentTimeHis(){
        return date('H:i:s', time());
    }

    public static function getCurrentTime(){
        return date('y-m-d H:i:s', time());
    }

    public static function timeDistance($time1, $time2){
        $date1 = strtotime($time1);
        $date2 = strtotime($time2);
        return $date1-$date2;
    }

}