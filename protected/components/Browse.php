<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/20
 * Time: 14:33
 */
class Browse
{

    /* 增加浏览数量 */
    public static  function add_browsenum($pid='0')
    {

        if(empty($pid)){
            return false;
        }
        $time=time();
        $now = date('Ym',$time);
        $sql="select * from dym_browse_num where pid=".$pid." and datetime=".$now;
        $arr = Mod::app()->db->createCommand($sql)->queryRow();
        if($arr){
            $sql = " UPDATE dym_browse_num SET count_num = count_num+1 WHERE pid = $pid and datetime= ".$now;
        }else{
            $sql = "INSERT INTO dym_browse_num (count_num, pid,datetime) VALUES (1, $pid, $now)";
        }
        $res = Mod::app()->db->createCommand($sql)->execute();

    }

    /* 增加独立访问数量 */
    public static  function add_usernum($pid='0')
    {
        if(empty($pid)){
            return false;
        }
        $ip=$_SERVER["REMOTE_ADDR"];
        $time=time();
        $now = date('Ymd',$time);
        $name= "userbrowse.txt";

        if(is_file($name)) {
            $arr = json_decode(file_get_contents($name), true);
        }

        $temp['pid']=$pid;
        $temp['ip']=$ip;
        $temp['c_time']=$time;
        $str=$now.$pid.$ip;
        $temp['str']=$str;

        if(empty($arr)){
            $arr=array();
            $arr[]=$temp;
        }else {
            if(!Browse::deep_in_array($str,$arr)){
                $arr[]=$temp;
            }
        }


        $fp = fopen($name, "w+");
        fwrite($fp,  json_encode($arr));
        fclose($fp);
    }



    public  static function deep_in_array($value, $array) {
        foreach($array as $item) {
            if(!is_array($item)) {
                if ($item == $value) {
                    return true;
                } else {
                    continue;
                }
            }

            if(in_array($value, $item)) {
                return true;
            } else if(Browse::deep_in_array($value, $item)) {
                return true;
            }
        }
        return false;
    }


    /*
     *  增加活动浏览量独立访问量
     */

    public static function  add_activity_browse($pid=0,$aid=0,$model=''){
            if(empty($pid) && empty($mid)){
                return false;
            }
            $time=time();
            $ip=$_SERVER["REMOTE_ADDR"];

            $now = date('Ymd',$time);
            $sql="select * from dym_activity_browse where model='".$model."'and pid=".$pid." and ip='".$mid."' and aid=".$aid." and create_time=".$now;
            $arr = Mod::app()->db->createCommand($sql)->queryRow();
            $sql="INSERT INTO dym_activity_browse (type, pid , aid  , model ,create_time) VALUES (1, $pid , $aid  ,'$model',$now);";
            if(!$arr){
                $sql.= "INSERT INTO dym_activity_browse (type, pid , aid ,ip ,model,create_time) VALUES (2, $pid , $aid , '$ip' ,'$model',$now)";
            }
            $res = Mod::app()->db->createCommand($sql)->execute();
    }
}