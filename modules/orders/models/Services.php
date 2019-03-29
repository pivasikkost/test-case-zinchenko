<?php

namespace app\modules\orders\models;

use Yii;
use \yii\db\Query;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends \yii\db\ActiveRecord
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

    public static function getServices()  {
        $query = new Query();
        $query->select(['count(*) as orders_count', 'services.*' ]);
        $query->from('services');
        $query->leftJoin('orders', 'orders.service_id = services.id');
        $query->groupBy('id');

        return $query->all();
    }

}
