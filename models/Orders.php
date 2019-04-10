<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $user
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */
class Orders extends \yii\db\ActiveRecord
{
    protected  static $statuses = [
        0 => 'Pending',
        1 => 'In progress',
        2 => 'Completed',
        3 => 'Canceled',
        4 => 'Error'
    ];

    protected static $modes = [
        0 => 'Manual',
        1 => 'Auto',
    ];
    
    protected static $search_types = [
        1 => 'orders.id',
        2 => 'link',
        3 => 'user'
    ];

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return self::$statuses;
    }

    /**
     * @return array
     */
    public static function getModes()
    {
        return self::$modes;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['user', 'link'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', 'User'),
            'link' => Yii::t('app', 'Link'),
            'quantity' => Yii::t('app', 'Quantity'),
            'service_id' => Yii::t('app', 'Service ID'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'mode' => Yii::t('app', 'Mode'),
        ];
    }

    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    public function getStatusText()
    {
        return self::$statuses[(int)$this->status];
    }

    public function getModeText()
    {
        return self::$modes[(int)$this->mode];
    }

    public function getDateText()
    {
        return gmdate("Y-m-d", $this->created_at);
    }

    public function getTimeText()
    {
        return gmdate("H:i:s", $this->created_at);
    }

}
