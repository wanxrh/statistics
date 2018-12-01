<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "analysis_log".
 *
 * @property int $id
 * @property string $domain_name
 * @property string $ip
 * @property int $is_crawler 是否属于爬虫数据0否1是
 * @property string $useragent 浏览器来源
 * @property string $created_at
 */
class AnalysisLog extends \yii\db\ActiveRecord
{
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_analysis');
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'analysis_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['domain_name'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 20],
            [['is_crawler'], 'string', 'max' => 4],
            [['useragent'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain_name' => 'Domain Name',
            'ip' => 'Ip',
            'is_crawler' => 'Is Crawler',
            'useragent' => 'Useragent',
            'created_at' => 'Created At',
        ];
    }
}
