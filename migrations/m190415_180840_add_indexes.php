<?php

use yii\db\Migration;

/**
 * Class m190415_180840_add_indexes
 */
class m190415_180840_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('link', 'orders', 'link');
        $this->createIndex('user', 'orders', 'user');
        $this->createIndex('service_id', 'orders', 'service_id');
        $this->createIndex('status', 'orders', 'status');
        $this->createIndex('mode', 'orders', 'mode');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('mode', 'orders');
        $this->dropIndex('status', 'orders');
        $this->dropIndex('service_id', 'orders');
        $this->dropIndex('user', 'orders');
        $this->dropIndex('link', 'orders');
    }
}
