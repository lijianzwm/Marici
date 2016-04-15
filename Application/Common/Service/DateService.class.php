<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/13
 * Time: 13:52
 */

namespace Common\Service;


class DateService{
    public static function getStrDate(){
        return date('y-m-d',time());
    }
}