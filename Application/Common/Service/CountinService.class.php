<?php

/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 8:49
 */

namespace Common\Service;
use Common\Service\CacheService;
use Common\Service\DateService;

class CountinService{

    public static function addNum($id,$num){
        CountinService::addTodayNum($id,$num);
        return true;
    }

    public static function getTotalNumById($userid){
        $num = CountinService::getRedisTotalNumById($userid);
        if( !$num ){
            $num = CountinService::getMysqlTotalNumById($userid);
            if( $num != -1 ){
                //如果mysql中有数据，redis中没有，存到缓存中来
                $totalKey = CacheService::getTotalNumUserRedisKey($userid);
                CacheService::set($totalKey, $num, 0);//total做永久缓存
                return $num;
            }else{
                return -1;
            }
        }else{
            return $num;
        }
    }

    public static function getRedisTotalNumById($userid){
        $totalKey = CacheService::getTotalNumUserRedisKey($userid);
        return CacheService::get($totalKey);
    }

    public static function getMysqlTotalNumById($userid){
        $user = M("user")->where("id='$userid'")->find();
        if( $user ){
            return $user['total'];
        }else{
            return -1;
        }
    }

    public static function getTodayNumById($userid){
        $num = CountinService::getRedisTodayNumById($userid);
        if( !$num ){
            $num = CountinService::getMysqlTodayNumById($userid);
            if( $num ){
                $todayKey = CacheService::getTodayUserRedisKey($userid);
                CacheService::set($todayKey,$num,C("TODAY_KEY_EXPIRE"));
                return $num;
            }else{
                return false;
            }
        }else{
            return $num;
        }
    }

    public static function getRedisTodayNumById($userid){
        $todayKey = CacheService::getTodayUserRedisKey($userid);
        return CacheService::get($todayKey);
    }

    public static function getMysqlTodayNumById($userid){
        $todayDate = DateService::getStrDate();
        $count = M("day_count")->where("userid='$userid', today_date='$todayDate'")->find();
        if( $count ){
            return $count['num'];
        }else{
            return null;
        }
    }

    public static function addTodayNum($userid, $num ){
        if( CountinService::isTodayFirstCommit($userid)){
            CountinService::insertMysqlTodayNum($userid, $num);
        }else{
            CountinService::addMysqlTodayNum($userid, $num);
        }
        CountinService::addRedisTodayNum($userid, $num);
        CountinService::addRedisTotalNum($userid,$num);
        CountinService::addMysqlTotalNum($userid,$num);
    }

    public static function addRedisTodayNum( $userid, $num ){
        $todayKey = CacheService::getTodayUserRedisKey($userid);
        $currentNum = CountinService::getRedisTodayNumById($userid);
        $expire = C("TODAY_KEY_EXPIRE");
        if ($currentNum) {
            CacheService::set($todayKey,$currentNum+$num,$expire);
        }else{
            CacheService::set($todayKey,$num,$expire);
        }
    }

    public static function addMysqlTodayNum( $userid, $num ){
        $dao = M();
        $todayDate = DateService::getStrDate();
        $table = C("DB_PREFIX")."day_count";
        if( $dao->execute("update $table set num=num+$num where userid='$userid' AND today_date='$todayDate'") ){
            return true;
        }else{
            return false;
        }
    }

    public static function insertMysqlTodayNum( $userid, $num ){
        $count['userid'] = $userid;
        $count['num'] = $num;
        $count['today_date'] = DateService::getStrDate();
        if( M("day_count")->add($count) ){
            return true;
        }else{
            return false;
        }
    }

    public static function addRedisTotalNum( $userid, $num ){
        $totalKey = CacheService::getTotalNumUserRedisKey($userid);
        $currentNum = CountinService::getRedisTotalNumById($userid);
        CacheService::set($totalKey,$currentNum+$num, C("TODAY_KEY_EXPIRE"));
    }

    public static function addMysqlTotalNum( $userid, $num ){
        $dao = M();
        $table = C("DB_PREFIX")."user";
        if( $dao->execute("update $table set total=total+$num where id='$userid'") ){
            return true;
        }else{
            return false;
        }
    }

    public static function isTodayFirstCommit( $userid ){
        if( !CountinService::getRedisTodayNumById($userid)){
            return true;
        }else{
            return false;
        }
    }

}