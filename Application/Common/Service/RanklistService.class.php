<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/15
 * Time: 13:37
 */

namespace Common\Service;


class RanklistService{
    public static function getTodayRanklist(){
        $ranklist = self::getRedisTodayRanklist();
        if (!$ranklist) {
            $ranklist = self::getMysqlTodayRanklist();
            if (!$ranklist) {
                return null;
            }
            self::setRedisTodayRanklist($ranklist);
        }
        return $ranklist;
    }

    /**
     * 获取redis缓存的当日排行榜
     * @return bool|mixed
     */
    private static function getRedisTodayRanklist(){
        $key = "ranklist-".DateService::getStrDate();
        $ranklist = CacheService::get($key);
        if( $ranklist ){
            return $ranklist;
        }else{
            return false;
        }
    }

    /**
     * 从mysql中生成当日排行榜
     * @return mixed
     */
    private static function getMysqlTodayRanklist(){
        $todayDate = DateService::getStrDate();
        $userTable = C("DB_PREFIX")."user";
        $dayCountTable = C("DB_PREFIX")."day_count";
        $ranklist = M()->table("$userTable user, $dayCountTable count")->
                where("user.id = count.userid and count.num > '0' and  count.today_date='$todayDate'")->
                field('user.id as userid, user.showname as name, count.num as num')->
                order('count.num desc' )->select();
        return $ranklist;
    }

    private static function setRedisTodayRanklist($ranklist){
        $key = "ranklist-".DateService::getStrDate();
        CacheService::set($key,$ranklist,C("TODAY_RANKLIST_EXPIRE"));
    }

    public static function getTotalRanklist(){
        $ranklist = self::getRedisTotalRanklist();
        if( !$ranklist){
            $ranklist = self::getMysqlTotalRanklist();
            if( !$ranklist ){
                return null;
            }
            self::setRedisTotalRanklist($ranklist);
        }
        return $ranklist;
    }

    private static function getRedisTotalRanklist(){
        $key = "total-ranklist";
        return  CacheService::get($key);
    }

    private static function getMysqlTotalRanklist(){
        return M("user")->field("id as userid, showname as name, total as num")->where("total > 0")->order("total desc")->select();
    }

    private static function setRedisTotalRanklist($ranklist){
        $key = "total-ranklist";
        CacheService::set($key,$ranklist,C("TOTAL_RANKLIST_EXPIRE"));
    }


}