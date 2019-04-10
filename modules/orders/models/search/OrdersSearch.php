<?php

namespace orders\models\search;

use yii\base\Model;
use yii\db\Query;
use app\models\Orders;
use app\models\Services;

/**
 * OrdersSearch represents the model behind the search form of `app\modules\orders\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['user', 'link'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return Query instance.
     */
    public function search($params)
    {
        $query = (new Query())
            ->select('o.*, s.name as service_name')
            ->from(['o' => Orders::tableName()])
            ->leftJoin(['s' => Services::tableName()], 's.id = o.service_id');

        $filter = [];
        if (isset($params['status']) && $params['status'] !== '') {
            $filter['status'] = $params['status'];
        }
        if (isset($params['mode']) && $params['mode'] !== '') {
            $filter['mode'] = $params['mode'];
        }
        if (!empty($params['search-type']) && isset($params['search'])) {
            $attr = Orders::$searchTypes[$params['search-type']];
            $filter[$attr] = $params['search'];
        }
        if (isset($params['service_id']) && $params['service_id'] !== '') {
            $filter['service_id'] = $params['service_id'];
        }

        $query->filterWhere($filter);
        $query->orderBy('o.id desc');

        return $query;
    }
}
