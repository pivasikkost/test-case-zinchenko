<?php

namespace app\modules\orders\controllers;

use Yii;
use app\modules\orders\models\Orders;
use app\modules\orders\models\OrdersSearch;
use app\modules\orders\models\Services;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * OrdersController implements actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
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

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
