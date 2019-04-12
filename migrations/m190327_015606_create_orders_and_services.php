<?php

use app\helpers\DbHelper;
use yii\db\Migration;
use yii\db\Query;

/**
 * Class m190327_015606_create_orders_and_services
 */
class m190327_015606_create_orders_and_services extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute(file_get_contents(__DIR__ . '/../db/db_initial.sql'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $dbName = DbHelper::getDsnAttribute('dbname', $this->db->dsn);

        $tables = (new Query())
            ->select('table_name')
            ->from('information_schema.tables')
            ->where(['table_schema' => $dbName])
            ->column();

        foreach ($tables as $table) {
            if ($table !== 'migration') {
                $this->dropTable($table);
            }
        }
    }
}
