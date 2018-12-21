<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\AnalysisLog;
use app\models\Service;
use Yii;
use yii\db\Query;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
    public function actionGetApi(){
        //$src = 'http://f.apiplus.net/bjpk10.json';
        //$src = 'https://kj.13322.com/trend/pk10.findIssueInfo.do';
        $src = 'http://e.apiplus.net/newly.do?token=t687d5a65d3b303c3k&code=bjpk10&format=json';
        $src .= '?_='.time();
        $json = file_get_contents(urldecode($src));
        //$json = json_decode($json);

        $json_data = Service::xmlToArray($json);
        //print_r($json_data['row'][0]);exit;
        if(!empty($json_data['row'])){
            foreach($json_data['row'] as $k=>$item){
                //echo 54545;exit;
                //先查询数据库有没有
                $kj_one = Yii::$app->db->createCommand("SELECT * FROM xy_data WHERE `number`='{$item['@attributes']['expect']}'")->queryOne();
                //print_r($kj_one);exit;
                if(empty($kj_one)){
                    //当前数据库连接
                    $db = Yii::$app->db;
                    //生成命令查询器 这里其实可以直接根据 sql 进行构造
                    $command = $db->createCommand();
                    //单条插入
                    $command->insert('xy_data', [
                        'type'=>'1',
                        'time'=>$item['@attributes']['opentime'],
                        'number'=>$item['@attributes']['expect'],
                        'data'=>$item['@attributes']['opencode'],
                    ]);
                    $result_insert = $command->execute();
                    if($result_insert){
                        echo "插入成功".PHP_EOL;
                    }

                    //$result = Yii::$app->db->createCommand()->insert("xy_data",array(
                    //    'type'=>'1',
                    //    'time'=>$item->opentime,
                    //    'number'=>$item->expect,
                    //    'data'=>$item->opencode,
                    //))->execute();
                    //if($result){
                    //    echo "插入成功".PHP_EOL;
                    //}
                }
            }
        }


    }
    public function actionGetkj(){
        //$src = 'http://f.apiplus.net/bjpk10.json';
        $src = 'https://kj.13322.com/trend/pk10.findIssueInfo.do';
        //$src = 'http://e.apiplus.net/newly.do?token=t687d5a65d3b303c3k&code=bjpk10&format=json';
        $src .= '?_='.time();
        $json = file_get_contents(urldecode($src));
        $data = json_decode($json,true);
        if(!empty($data)){
            //foreach($data as $k=>$item){
                //先查询数据库有没有
                $kj_one = Yii::$app->db->createCommand("SELECT * FROM xy_data2 WHERE `number`='{$data['preissue']}'")->queryOne();
                if(empty($kj_one)){
                    //当前数据库连接
                    $db = Yii::$app->db;
                    //生成命令查询器 这里其实可以直接根据 sql 进行构造
                    $command = $db->createCommand();
                    //单条插入
                    $command->insert('xy_data2', [
                        'type'=>'1',
                        'time'=>$data['predrawtime'],
                        'number'=>$data['preissue'],
                        'data'=>$data['predrawcode'],
                    ]);
                    $result_insert = $command->execute();
                    if($result_insert){
                        echo "插入成功".PHP_EOL;
                    }

                }
            //}
        }


    }
}
