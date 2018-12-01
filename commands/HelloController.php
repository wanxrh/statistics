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

    /**
     * 跑脚本统计数量
     * @author lvlinlin <lvlinlin@tdnnic.org>
     */
    public function actionSum(){

        $db = Yii::$app->db_analysis;
        $time = ['本月','半年','一年'];
        foreach($time as $value){
            switch($value){
                case '本月':
                    $query = new Query();
                    $start_date = date('Y-m-d',mktime(0, 0, 0, date('m'), 1, date('Y')));
                    $end_date = date('Y-m-d',mktime(23, 59, 59, date('m'), date('t'), date('Y')));
                    $query->select('`id`,`domain_name`,count(`id`) as num')->where("is_crawler=0")->from(AnalysisLog::tableName());


                    $query->andWhere("created_at >= '{$start_date} 00:00:00' and created_at <= '{$end_date} 23:59:59'");

                    $count = $query->count('id', $db);
                    $query->groupBy("domain_name");
                    $count2= $query->count('id',$db);
                    Yii::$app->db_analysis->createCommand()->update('sum_tmp', ['month_sum' => $count,'month_page_sum'=>$count2])->execute();
                    break;
                case '半年':
                    $query2 = new Query();
                    $start_date2 = date("Y-m-d", strtotime("-6 month"));
                    $end_date2 = date("Y-m-d",time());
                    $query2->select('`id`,`domain_name`,count(`id`) as num')->where("is_crawler=0")->from(AnalysisLog::tableName());


                    $query2->andWhere("created_at >= '{$start_date2} 00:00:00' and created_at <= '{$end_date2} 23:59:59'");

                    $count2 = $query2->count('id', $db);
                    $query2->groupBy("domain_name");
                    $count2_1= $query2->count('id',$db);
                    Yii::$app->db_analysis->createCommand()->update('sum_tmp', ['half_year_sum' => $count2,'half_year_page_sum'=>$count2_1])->execute();
                    break;
                case '一年':
                    $query3 = new Query();
                    $start_date3 = date("Y-m-d", strtotime("-1 year"));
                    $end_date3 = date("Y-m-d",time());
                    $query3->select('`id`,`domain_name`,count(`id`) as num')->where("is_crawler=0")->from(AnalysisLog::tableName());


                    $query3->andWhere("created_at >= '{$start_date3} 00:00:00' and created_at <= '{$end_date3} 23:59:59'");

                    $count3 = $query3->count('id', $db);
                    $query3->groupBy("domain_name");
                    $count3_1= $query3->count('id',$db);
                    Yii::$app->db_analysis->createCommand()->update('sum_tmp', ['year_sum' => $count3,'year_page_sum'=>$count3_1])->execute();
                    break;
                default:
                    $start_date = date("Y-m-d",time());
                    $end_date = date("Y-m-d",time());
                    break;
            }

        }
        echo 'success';



    }
}
