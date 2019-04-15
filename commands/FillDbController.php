<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Orders;

/**
 * This command fills the database with test data for 500 thousand records, based on the first 500 existing ones.
 *
 * @author Konstantin Zosimenko <pivasikkost@gmail.com>
 * @since 2.0
 */
class FillDbController extends Controller
{
    const EXISTING_RECORDS = 500;
    const NEW_RECORDS = 500000;

    /**
     * {@inheritdoc}
     */
    public $defaultAction = 'up';

    /**
     * This command fills the database with test data for 500 thousand records, based on the first 500 existing ones.
     * @return int Exit code
     */
    public function actionUp()
    {
        $existingOrders = Orders::find()->limit(static::EXISTING_RECORDS)->all();
        $orderAttributes = (new Orders())->getAttributes();
        unset($orderAttributes['id']);

        for ($i = 0; $i < (static::NEW_RECORDS / static::EXISTING_RECORDS) ; $i++) {
            for ($j = 0; $j < static::EXISTING_RECORDS; $j++) {
                $order = new Orders();
                foreach ($orderAttributes as $field => $value) {
                    $order->$field = $existingOrders[$j]->$field;
                }
                $order->save();
            }
        }

        echo static::NEW_RECORDS . " records added succesfully\n";
        return ExitCode::OK;
    }

    /**
     * This command deletes the last 500 thousand records added.
     * @return int Exit code
     */
    public function actionDown()
    {
        $existingOrders = Orders::find()
            ->orderBy('id DESC')
            ->limit(static::NEW_RECORDS);

        foreach ($existingOrders->each() as $order) {
            $order->delete();
        }

        echo static::NEW_RECORDS . " records deleted succesfully\n";
        return ExitCode::OK;
    }
}
