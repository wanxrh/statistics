<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xy_data".
 *
 * @property int $id
 * @property string $type 时时彩种类，对应ssc_type.id
 * @property string $time 开奖时间
 * @property string $number 期号(场次)
 * @property string $data 开奖号码，半角逗号分开
 */
class XyData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xy_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'time', 'number', 'data'], 'required'],
            [['type'], 'integer'],
            [['time'], 'safe'],
            [['number'], 'string', 'max' => 32],
            [['data'], 'string', 'max' => 80],
            [['type', 'number'], 'unique', 'targetAttribute' => ['type', 'number']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'time' => 'Time',
            'number' => 'Number',
            'data' => 'Data',
        ];
    }
}
