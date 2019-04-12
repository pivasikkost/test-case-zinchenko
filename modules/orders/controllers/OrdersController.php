<?php

namespace orders\controllers;

use Yii;
use app\helpers\CustomFormatConverter;
use app\models\Orders;
use orders\models\search\OrdersSearch;
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
        $searchResult = (new OrdersSearch())->search($params);

        return $this->render(
            'index',
            array_merge($searchResult, [
                'title' => Yii::t('app', 'Orders'),
                'params' => $params,
            ])
        );
    }

    /**
     * Export Orders to csv file.
     */
    public function actionExport()
    {
        Yii::$app->response->sendContentAsFile(
            (new OrdersSearch())->searchAndExport(
                Yii::$app->request->get()
            ),
            'export_' . date('d.m.Y') . '.csv'
        )->send();
    }
}
