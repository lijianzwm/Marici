<?php

/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 8:49
 */

namespace Common\Service;

class CountinService{

    /**
     * 获取用户所有数目，若该用户不存在，返回null
     * @param $userid
     * @return mixed|null
     */
    public static function getUserTotalNumById($userid){
        $num = RedisService::getRedisTotalNumById($userid);
        if( $num == false ){//这里不用!$num，因为缓存的数据有可能是0
            $num = RedisService::cachingUserTotalNum($userid);
        }
        return $num;
    }

    /**
     * 获取用户当日的数目，若用户不存在，返回null
     * @param $userid
     * @return mixed
     */
    public static function getTodayNumById($userid){
        $num = RedisService::getRedisUserTodayNumById($userid);
        if( $num == false ){
            DebugService::displayLog("getTodayNumById : not cached");
            $num = RedisService::cachingUserTodayNum($userid);
        }
        return $num;
    }


    public static function addTodayNum($userid, $num ){
        //TODO 判断是否添加计数成功
        if ( !MysqlService::isUserExist($userid)) {
            return false;
        }
        if( CountinService::isTodayFirstCommit($userid)){//如果是当天第一次报数
            MysqlService::insertMysqlTodayNum($userid, $num);
            RedisService::cachingUserTodayNum($userid);
        }else{
            MysqlService::addMysqlTodayNum($userid, $num);
            RedisService::addRedisTodayNum($userid, $num);
        }
        RedisService::addRedisUserTotalNum($userid,$num);
        MysqlService::addMysqlTotalNum($userid,$num);
        return true;
    }


    /**
     * 获取某一天的共修总数（可以是今天），如果日期非法，返回null
     * @param $date : 2016-04-18
     * @return int|mixed|null
     */
    public static function getDayTotalNum($date){
        $today = DateService::getCurrentYearMonthDay();
        if( $date > $today ){
            return null;
        }
        $num = RedisService::getRedisDayTotalNum($date);
        if( $num == false ){
            DebugService::displayLog("total num $date: not cached");
            $num = RedisService::cachingDayTotalNum($date);
        }
        return $num;
    }

    public static function getMonthTotalNum($yearMonth){

    }

    /**
     *
     */
    public static function getAllUserTotalNum(){

    }

    public static function isTodayFirstCommit( $userid ){
        if( RedisService::getRedisUserTodayNumById($userid) == false){
            if( MysqlService::getMysqlTodayNumById($userid) == null){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}