<?php

namespace app\models;

use Yii;
use \yii\db\Query;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public static function getServices()
    {
        $query = (new Query())
            ->select(['count(*) as orders_count', 'services.*' ])
            ->from('services')
            ->leftJoin('orders', 'orders.service_id = services.id')
            ->groupBy('id')
            ->orderBy('orders_count DESC')
            ->all();

        $services = array();
        foreach ($query as $service) {
            $services[$service['id']] = $service;
        }

        return $services;
    }

}
