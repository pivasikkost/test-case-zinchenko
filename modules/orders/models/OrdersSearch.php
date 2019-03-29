<?php

namespace app\modules\orders\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\orders\models\Orders;

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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();

        $filter = [];
        if (isset($params['status']) && $params['status']!== '') {
            $filter['status'] = $params['status'];
        }
        if (isset($params['mode']) && $params['mode']!== '') {
            $filter['mode'] = $params['mode'];
        }
        if (!empty($params['search-type']) && isset($params['search'])) {
            $attr = Orders::$search_types[$params['search-type']];
            $filter[$attr] = $params['search'];
        }
        if (isset($params['service_id']) && $params['service_id']!== '') {
            $filter['service_id'] = $params['service_id'];
        }

        $query->joinWith('service');
        $query->filterWhere($filter);

        return $query;
    }
}
