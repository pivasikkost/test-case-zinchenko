<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

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
class Orders extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED = 3;
    const STATUS_FAIL = 4;

    const MODE_MANUAL = 0;
    const MODE_AUTO = 1;

    const SEARCH_TYPE_ID = 1;
    const SEARCH_TYPE_LINK = 2;
    const SEARCH_TYPE_USER = 3;


    protected static $statuses = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_IN_PROGRESS => 'In progress',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELED => 'Canceled',
        self::STATUS_FAIL => 'Error'
    ];

    protected static $modes = [
        self::MODE_MANUAL => 'Manual',
        self::MODE_AUTO => 'Auto',
    ];
    
    protected static $searchTypes = [
        self::SEARCH_TYPE_ID => 'id',
        self::SEARCH_TYPE_LINK => 'link',
        self::SEARCH_TYPE_USER => 'user'
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
     * @return array
     */
    public static function getSearchTypes()
    {
        return self::$searchTypes;
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

    /**
     * @param int $status
     * @return string
     */
    public static function getStatusText($status)
    {
        return self::$statuses[(int)$status];
    }

    /**
     * @param int $mode
     * @return string
     */
    public static function getModeText($mode)
    {
        return self::$modes[(int)$mode];
    }

}
