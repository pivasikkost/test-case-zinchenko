<?php

namespace orders\controllers;

use Yii;
use app\helpers\CustomFormatConverter;
use app\models\Orders;
use orders\models\search\OrdersSearch;
use app\models\Services;
use yii\web\Controller;

/**
 * OrdersController implements actions for Orders model.
 */
class OrdersController extends Controller
{

    /**
     * Displays Orders.
     * @return string the rendering result.
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->get();
        $searchModel = new OrdersSearch();
        $searchResult = $searchModel->search($params);

        $this->layout = 'orders';

        return $this->render('index', [
            'orders' => $searchResult['orders'],
            'pagination' => $searchResult['pagination'],
            'modes' => Orders::getModes(),
            'statuses' => Orders::getStatuses(),
            'searchTypes' => Orders::getSearchTypes(),
            'orderLabels' => $searchModel->attributeLabels(),
            'services' => Services::getServices(),
            'params' => $params,
        ]);
    }

    /**
     * Export Orders to csv file.
     */
    public function actionExport()
    {
        $data = "ID;User;Link;Quantity;Service;Status;Mode;Created\r\n";

        $params = Yii::$app->request->get();
        $searchModel = new OrdersSearch();
        $searchResult = $searchModel->search($params);

        foreach ($searchResult['orders'] as $order) {
            $data .= $order['id'].
                    ';' . $order['user'] .
                    ';' . $order['link'] .
                    ';' . $order['quantity'] .
                    ';' . $order['service_name'] .
                    ';' . Orders::getStatusText($order['status']) .
                    ';' . Orders::getModeText($order['mode']) .
                    ';' . CustomFormatConverter::getDateText($order['created_at']) .
                    ' ' . CustomFormatConverter::getTimeText($order['created_at']) .
                    "\r\n";
        }

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export_' . date('d.m.Y') . '.csv"');
        echo iconv('utf-8', 'windows-1251', $data); //fix for Windows
        exit;
    }

}
