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
            if(empty($pid)){
                return false;
            }
            $time=time();
            $ip=$_SERVER["REMOTE_ADDR"];

            $now = date('Ymd',$time);
            $tmp = array();
            $sql_uv="select * from dym_activity_browse where type=2 and  model='".$model."' and pid=".$pid." and ip='".$ip."' and aid=".$aid." and createtime=".$now;
            $arr_uv = Mod::app()->db->createCommand($sql_uv)->queryRow();

            $sql_pv="select * from dym_activity_browse where type=1 and  model='".$model."' and aid= ".$aid." and pid=".$pid." and createtime=".$now;
            $arr_pv = Mod::app()->db->createCommand($sql_pv)->queryRow();

            if($arr_pv){
                $sql = "UPDATE dym_activity_browse SET count_num = count_num+1 WHERE id=".$arr_pv['id'].";";
            }else{
                $sql = "INSERT INTO dym_activity_browse (type, pid , aid  , model ,count_num,createtime) VALUES (1, $pid , $aid  ,'$model',1,$now);";
            }
            if(!$arr_uv){
                $sql.= "INSERT INTO dym_activity_browse (type, pid , aid ,ip ,model,createtime) VALUES (2, $pid , $aid , '$ip' ,'$model',$now)";
            }
            if($sql) {
                $res = Mod::app()->db->createCommand($sql)->execute();
            }
    }
}