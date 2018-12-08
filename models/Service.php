<?php
/**
 * Created by PhpStorm.
 * User: lvlinlin
 * Date: 2018/11/15
 * Time: 10:18
 */

namespace app\models;

use Yii;
use yii\db\Query;
use yii\web\Cookie;
class Service
{
    /*
        function:二维数组按指定的键值排序
        author:www.111cn.net
        */
    public static function array_sort($array,$keys,$type='asc')
    {
        if(!isset($array) || !is_array($array) || empty($array) || !isset($keys) || trim($keys)==''){
            return $array;
        }
        if(!in_array(strtolower($type),array('asc','desc'))){
            $type='asc';
        }
        $keysvalue=array();
        foreach($array as $key=>$val){
            $val[$keys] = str_replace('-','',$val[$keys]);
            $val[$keys] = str_replace(' ','',$val[$keys]);
            $val[$keys] = str_replace(':','',$val[$keys]);
            $keysvalue[] =$val[$keys];
        }
        asort($keysvalue); //key值排序
        reset($keysvalue); //指针重新指向数组第一个
        foreach($keysvalue as $key=>$vals) {
            $keysort[] = $key;
        }
        $keysvalue = array();
        $count=count($keysort);
        if(strtolower($type) != 'asc'){
            for($i=$count-1; $i>=0; $i--) {
                $keysvalue[] = $array[$keysort[$i]];
            }
        }else{
            for($i=0; $i<$count; $i++){
                $keysvalue[] = $array[$keysort[$i]];
            }
        }
        return $keysvalue;
    }
    /**
     * @param $up
     * @param 每个位置出现的14710次数
     * @param $current
     */
    public static function Kill_number($current){
        //号码
        $kj = ['01', '04', '07', '10'];
        if(array_intersect($current,$kj)){
            return true;
        }else{
            return false;
        }



    }
}