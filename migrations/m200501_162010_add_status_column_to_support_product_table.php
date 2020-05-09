<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%support_product}}`.
 */
class m200501_162010_add_status_column_to_support_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('support_product', "status", "ENUM('0', '1') DEFAULT '0'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('support_product', 'status');
    }
}
