<?php

/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 8:49
 */

namespace Common\Service;

class CountinService{

    public static function addNum($id,$num){
        $dao = M();
        $table = C("DB_PREFIX")."user";
        if( $dao->execute("update $table set total=total+$num where id=$id") ){
            return true;
        }else{
            return false;
        }
    }

    public static function getNumById($id){
        $user = M("user")->where("id='$id'")->find();
        if( $user ){
            return $user['total'];
        }else{
            return -1;
        }
    }

}