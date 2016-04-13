<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 14:00
 */

namespace Common\Service;


class CacheService{

    public static function test(){
        S(array(
                'host'=>C("REDIS_HOST"),
                'port'=>C("REDIS_PORT"),
                'prefix'=>C("REIDS_PREFIX"),
                'expire'=>C("REDIS_EXPIRE"))
        );
//        S("test", "test", 15);
        dump(S("test"));
        die();
    }
}