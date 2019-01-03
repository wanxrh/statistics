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

    public static function hello($array){
        $res = array();
        $temp = $array[0];
        $is_chao_temp = 0;
        $res[$array[0]] = 1;
        foreach($array as $k=>$v){
            if($k>0){
                if($v==$temp){
                    if($is_chao_temp!=0&&$is_chao_temp<$res[$v]){
                        $is_chao_temp++;
                    }else{
                        $res[$v] +=1;
                        $is_chao_temp=0;
                    }

                }else{
                    $is_chao_temp = 0;
                    if(!empty($res[$v])){
                        $is_chao_temp++;

                    }else{
                        $res[$v] = 1;
                    }

                }
                $temp = $v;


            }
        }
        return $res;

    }

    /**
     * @param $a
     * @return bool true 顺子 false 非顺子
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public static function shunza($a){
        if ($a[0]+1==$a[1] && $a[1]+1==$a[2]) {
            $shunzi = true;
        } else {
            if ($a[0] - 1 == $a[1] && $a[1] - 1 == $a[2]) {
                $shunzi = true;
            }elseif($a[0] + 1 == $a[1] && $a[1] - 2 == $a[2]){
                $shunzi = true;
            }elseif($a[0] + 2 == $a[1] && $a[1] - 1 == $a[2]){
                $shunzi = true;
            }elseif($a[0] - 1 == $a[1] && $a[1] + 2 == $a[2]){
                $shunzi = true;
            }elseif($a[0] - 2 == $a[1] && $a[1] + 1 == $a[2]){
                $shunzi = true;
            } else {
                $shunzi = false;
            }
        }
        return $shunzi;
    }

    /**
     * 两码和尾
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public static function liangmahe($array){
        $arr = ['0','1','2','3','4','9'];
        $he = [$array[0]+$array[1],$array[1]+$array[2],$array[0]+$array[2]];
        //$tj = '';
        foreach($he as $value){
            if($value>9){
                $value = substr($value,1,1);
            }
            if(in_array($value,$arr)){
                //$tj = '';
                $hewei = true;
                return $hewei;
            }else{
                //$tj.= $value.',';
                $hewei = false;
            }
        }
        //$tj = substr($tj,0,-1);
        //$path=Yii::$app->basePath;
        //$content = $tj."\r\n";;  // 写入的内容
        //$file = $path."/test.txt";    // 写入的文件
        //file_put_contents($file,$content,FILE_APPEND);
        return $hewei;
    }
    /**
     * @param $a
     * @return 下山号 上山号
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public static function xingtai($a){
        if ($a[0]<$a[1] && $a[1]<$a[2]) {
            $shunzi = '上山号';
        } else {
            if ($a[0]>$a[1] && $a[1]>$a[2]) {
                $shunzi = '下山号';
            } else {
                $shunzi = '其他';
            }
        }
        return $shunzi;
    }

    /**
     * 杀012路
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public static function x012($str){
        $arr  = [
            '01 04 07',
            '01 04 07',
            '01 04 10',
            '01 07 04',
            '01 07 10',
            '01 10 04',
            '01 10 07',
            '02 05 08',
            '02 08 05',
            '03 06 09',
            '03 09 06',
            '04 01 07',
            '04 01 10',
            '04 07 01',
            '04 07 10',
            '04 10 01',
            '04 10 07',
            '05 02 08',
            '05 08 02',
            '06 03 09',
            '06 09 03',
            '07 01 04',
            '07 01 10',
            '07 04 01',
            '07 04 10',
            '07 10 01',
            '07 10 04',
            '08 02 05',
            '08 05 02',
            '09 03 06',
            '09 06 03',
            '10 01 04',
            '10 01 07',
            '10 04 01',
            '10 04 07',
            '10 07 01',
            //123跨度
            //'01 05 09',
            //'01 05 10',
            //'01 06 10',
            //'01 09 05',
            //'01 10 05',
            //'01 10 06',
            //'02 06 10',
            //'02 10 06',
            //'05 01 09',
            //'05 01 10',
            //'05 09 01',
            //'05 10 01',
            //'06 01 10',
            //'06 02 10',
            //'06 10 01',
            //'06 10 02',
            //'09 01 05',
            //'09 05 01',
            //'10 01 05',
            //'10 01 06',
            //'10 02 06',
            //'10 05 01',
            //'10 06 01',
            //'10 06 02',
        ];
        if(in_array($str,$arr)){
            return false;
        }else{
            return true;
        }
    }
    /**
     * @param $source
     * @return string
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
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