<?php

namespace orders\models\search;

use app\helpers\CustomFormatConverter;
use yii\base\Model;
use yii\db\Query;
use app\models\Orders;
use app\models\Services;
use yii\data\Pagination;

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
     * Returns orders and needed data by search query applied
     *
     * @param array $params
     *
     * @return array
     */
    public function search($params)
    {
        $query = (new Query())
            ->select('o.*, s.name as service_name')
            ->from(['o' => Orders::tableName()])
            ->leftJoin(['s' => Services::tableName()], 's.id = o.service_id');

        $filter = [];
        if (isset($params['status']) && $params['status'] !== '') {
            $filter['o.status'] = $params['status'];
        }
        if (isset($params['mode']) && $params['mode'] !== '') {
            $filter['o.mode'] = $params['mode'];
        }
        if (!empty($params['search-type']) && isset($params['search'])) {
            $attr = Orders::$searchTypes[$params['search-type']];
            $filter['o.' . $attr] = $params['search'];
        }
        if (isset($params['service_id']) && $params['service_id'] !== '') {
            $filter['o.service_id'] = $params['service_id'];
        }

        $query->filterWhere($filter);
        $query->orderBy('o.id desc');

        $pagination = new Pagination([
            'pageSize' => 100,
            'totalCount' => $query->count(),
        ]);

        $orders = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        foreach ($orders as &$order) {
            $order['status'] = Orders::getStatusText($order['status']);
            $order['mode'] = Orders::getModeText($order['mode']);
        }
        unset($order);

        return [
            'orders' => $orders,
            'pagination' => $pagination,
            'modes' => parent::getModes(),
            'statuses' => parent::getStatuses(),
            'searchTypes' => parent::getSearchTypes(),
            'orderLabels' => $this->attributeLabels(),
            'services' => Services::getServices(),
        ];
    }

    /**
     * Returns orders as csv format text by search query applied
     *
     * @param array $params
     *
     * @return string
     */
    public function searchAndExport($params)
    {
        $data = "ID;User;Link;Quantity;Service;Status;Mode;Created\r\n";

        $searchResult = (new OrdersSearch())->search($params);

        foreach ($searchResult['orders'] as $order) {
            $data .= $order['id'].
                ';' . $order['user'] .
                ';' . $order['link'] .
                ';' . $order['quantity'] .
                ';' . $order['service_name'] .
                ';' . $order['status'] .
                ';' . $order['mode'] .
                ';' . CustomFormatConverter::getDateText($order['created_at']) .
                ' ' . CustomFormatConverter::getTimeText($order['created_at']) .
                "\r\n";
        }

        return $data;
    }
}
