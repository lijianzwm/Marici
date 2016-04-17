<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/17
 * Time: 11:38
 */

namespace Common\Service;

/**
 * 获取redis的key
 * Class RedisKeyService
 * @package Common\Service
 */
class RedisKeyService{

    public static function getUserTodayNumKey($userid ){
        return "num-".DateService::getStrMonthDay()."-".$userid;
    }

    public static function getUserTotalNumKey($userid ){
        return "total-".$userid;
    }

    public static function getTodayRanklistKey(){
        return "ranklist-today-".DateService::getStrMonthDay();
    }

    public static function getTotalRanklistKey(){
        return "ranklist-total";
    }

    public static function getSomedayRanklistKey($date){
        return "ranklist-".$date;
    }

    public static function getCurMonthRanklistKey($yearMonth){
        return "ranklist-".$yearMonth;
    }

}