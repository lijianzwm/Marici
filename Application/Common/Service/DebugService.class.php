<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/18
 * Time: 13:18
 */

namespace Common\Service;


class DebugService{
    public static function displayLog($str){
        if( C("DEBUG_SERVICE") == true ){
            dump($str);
        }
    }
}