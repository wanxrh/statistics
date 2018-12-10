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
    public static function xml_to_json($source) {
        if(is_file($source)){ //传的是文件，还是xml的string的判断
            $xml_array=simplexml_load_file($source);
        }else{
            $xml_array=simplexml_load_string($source);
        }
        $json = json_encode($xml_array); //php5，以及以上，如果是更早版本，请查看JSON.php
        return $json;
    }
    public static function xmlToArray($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }
}