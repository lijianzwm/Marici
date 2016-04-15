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
        if( $ranklist ){
            return $ranklist;
        }else{
            $ranklist = self::getMysqlTodayRanklist();
            if( $ranklist ){
                self::setRedisTodayRanklist($ranklist);
                return $ranklist;
            }else{
                return null;
            }
        }
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
                where('user.id = count.userid')->
                field('user.id as userid, user.showname as name, count.num as num')->
                order('count.num desc' )->select();
        return $ranklist;
    }

    private static function setRedisTodayRanklist($ranklist){
        $key = "ranklist-".DateService::getStrDate();
        CacheService::set($key,$ranklist,C("TODAY_RANKLIST_EXPIRE"));
    }

}