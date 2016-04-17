<?php
/**
 * Created by PhpStorm.
 * User: lijian
 * Date: 2016/4/17
 * Time: 11:42
 */

namespace Common\Service;


class MysqlService{

    /**
     * 获取某日排行榜，若没有排行榜，返回array(0) {}
     * @param $date
     * @return mixed
     */
    public static function getMysqlSomeDayRanklist($date){
        $userTable = C("DB_PREFIX")."user";
        $dayCountTable = C("DB_PREFIX")."day_count";
        $ranklist = M()->table("$userTable user, $dayCountTable count")->
        where("user.id = count.userid and count.num > '0' and  count.today_date='$date'")->
        field('user.id as userid, user.showname as name, count.num as num')->
        order('count.num desc' )->select();
        return $ranklist;
    }

    /**
     * 获取总排行，如果没有，返回array(0) {}
     * @return mixed
     */
    public static function getMysqlTotalRanklist(){
        return M("user")->field("id as userid, showname as name, total as num")->where("total > 0")->order("total desc")->select();
    }

    /**
     * 获取当日排行榜，如果没有，返回array(0) {}
     * @return mixed
     */
    public static function getMysqlTodayRanklist(){
        $todayDate = DateService::getStrDate();
        return self::getMysqlSomeDayRanklist($todayDate);
    }

    /**
     * 获取用户所有数目，如果用户不存在，返回null
     * @param $userid
     * @return null
     */
    public static function getMysqlTotalNumById($userid){
        $user = M("user")->where("id='$userid'")->find();
        if( $user ){
            return $user['total'];
        }else{
            return null;
        }
    }

    /**
     * 获取mysql中用户当日数目，如果用户不存在或当日没有进行报数，返回null
     * @param $userid
     * @return null
     */
    public static function getMysqlTodayNumById($userid){
        $todayDate = DateService::getStrDate();
        $count = M("day_count")->where("userid='$userid' and today_date='$todayDate'")->find();
        if( $count ){
            return $count['num'];
        }else{
            return null;
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

    public static function isUserExist($userid){
        if( M("user")->where("id=$userid")->find() ){
            return true;
        }else{
            return false;
        }
    }

    public static function initMysqlUserTodayNum($userid){
        self::insertMysqlTodayNum($userid, 0);
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

    public static function addMysqlTotalNum( $userid, $num ){
        $dao = M();
        $table = C("DB_PREFIX")."user";
        if( $dao->execute("update $table set total=total+$num where id='$userid'") ){
            return true;
        }else{
            return false;
        }
    }

}