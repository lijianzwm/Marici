<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/12
 * Time: 13:39
 */

namespace Common\Service;


class UserService{

    /**
     * 通过手机号来获取用户信息
     * @param $phone
     * @return mixed
     */
    public static function getUserByPhone($phone){
        return M("user")->where("phone=$phone")->find();
    }

    /**
     * 判断手机号为$phone的用户是否存在
     * @param $phone
     * @return bool
     */
    public static function isExistUser($phone){
        $user = UserService::getUserByPhone($phone);
        if( $user ){
            return true;
        }else{
            return false;
        }
    }

}