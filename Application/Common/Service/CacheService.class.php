<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 14:00
 */

namespace Common\Service;
use Common\Service\DateService;
use Think\Cache;


class CacheService{

    public static function test(){
        S(array(
                'host'=>C("REDIS_HOST"),
                'port'=>C("REDIS_PORT"),
                'prefix'=>C("REIDS_PREFIX"),
                'expire'=>C("REDIS_EXPIRE"))
        );
        S("test", "test", 15);
        dump(S("test"));
        die();
    }

    public static function set($key,$value,$expire){
        S(array(
                'host'=>C("REDIS_HOST"),
                'port'=>C("REDIS_PORT"),
                'prefix'=>C("REIDS_PREFIX"),
                'expire'=>C("REDIS_EXPIRE"))
        );
        S($key, $value, $expire);
    }

    public static function get($key){
        S(array(
                'host'=>C("REDIS_HOST"),
                'port'=>C("REDIS_PORT"),
                'prefix'=>C("REIDS_PREFIX"),
                'expire'=>C("REDIS_EXPIRE"))
        );
        return S($key);
    }



    /**
     * 获取当日用户redis缓存数据的key，key由id_日期构成
     * @param $userid
     * @return string
     */
    public static function getTodayUserRedisKey( $userid ){
        return $userid."_".DateService::getDate();
    }

    /**
     * 获取该用户的总共计数
     * @param $userid
     * @return string
     */
    public static function getTotalNumUserRedisKey( $userid ){
        return "total_".$userid;
    }

}