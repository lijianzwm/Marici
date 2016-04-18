<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/15
 * Time: 13:37
 */

namespace Common\Service;


class RanklistService{

    /**
     * 获取今日排行榜，如果今天没人报数，排行榜值为：array(0) {}
     * @return mixed|null
     */
    public static function getTodayRanklist(){
        $ranklist = RedisService::getRedisTodayRanklist();
        if ( $ranklist == false ) {
            $ranklist = RedisService::cachingTodayRanklist();
        }
        return $ranklist;
    }

    /**
     * 获取总排行榜，如果总排行榜为空，则返回array(0) {}
     * @return mixed
     */
    public static function getTotalRanklist(){
        $ranklist = RedisService::getRedisTotalRanklist();
        if( $ranklist == false ){
            $ranklist = RedisService::cachingTotalRanklist();
        }
        return $ranklist;
    }

    /**
     * 获取昨日排行榜
     * @return mixed
     */
    public static function getYesterdayRanklist(){
        $yesterday = DateService::getStrYesterdayDate();
        return self::getSomedayRanklist($yesterday);
    }

    /**
     * 获取某天的排行榜
     * @param $date
     * @return mixed
     */
    public static function getSomedayRanklist($date){
        $ranklist = RedisService::getRedisSomedayRanklist($date);
        if( $ranklist == false ){
            $ranklist = RedisService::cachingSomedayRanklist($date);
        }
        return $ranklist;
    }

    /**
     * 获取当月排行榜
     * @return mixed
     */
    public static function getCurMonthRanklist(){
        $ranklist = RedisService::getRedisCurMonthRanklist();
        if( $ranklist == false ){
            $ranklist = RedisService::cachingCurMonthRanklist();
        }
        return $ranklist;
    }

    /**
     * 获取某月排行
     * @param $yearMonth
     * @return mixed
     */
    public static function getMonthRanklist($yearMonth){
        $ranklist = RedisService::getRedisMonthRanklist($yearMonth);
        if( $ranklist == false ){
            $ranklist = RedisService::cachingMonthRanklist($yearMonth);
        }
        return $ranklist;
    }

}