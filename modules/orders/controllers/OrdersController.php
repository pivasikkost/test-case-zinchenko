<?php

namespace orders\controllers;

use Yii;
use app\models\Orders;
use orders\models\search\OrdersSearch;
use app\models\Services;
use yii\web\Controller;
use yii\data\Pagination;

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
        $query = $searchModel->search($params);

        $services = Services::getServices();
        $services_new = array();
        foreach ($services as $service) {
            $services_new[$service['id']] = $service;
        }

        $pagination = new Pagination([
            'pageSize' => 100,
            'totalCount' => $query->count(),
        ]);

        $orders = $query->orderBy('id desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $this->layout = 'orders';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'orders' => $orders,

            'pagination' => $pagination,
            'modes' => Orders::getModes(),
            'statuses' => Orders::getStatuses(),
            'services' => $services_new,
            'params' => $params,
        ]);
    }

    /**
     * Export Orders to csv file.
     */
    public function actionExport() {
        $data = "ID;User;Link;Quantity;Service;Status;Mode;Created\r\n";

        $params = Yii::$app->request->get();
        $searchModel = new OrdersSearch();
        $query = $searchModel->search($params);

        $orders = $query->orderBy('id desc')
            ->all();
        foreach ($orders as $order) {
            $data .= $order->id.
                    ';' . $order->user .
                    ';' . $order->link .
                    ';' . $order->quantity .
                    ';' . $order->service->name .
                    ';' . $order->getStatusText() .
                    ';' . $order->getModeText() .
                    ';' . $order->getDateText() . ' ' . $order->getTimeText() .
                    "\r\n";
        }
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export_' . date('d.m.Y') . '.csv"');
        echo iconv('utf-8', 'windows-1251', $data); //fix for Windows
        exit;
    }

}
