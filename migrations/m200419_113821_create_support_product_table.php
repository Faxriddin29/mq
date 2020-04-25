<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%support_product}}`.
 */
class m200419_113821_create_support_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%support_product}}', [
            'id' => $this->primaryKey(),
            'support_id' => $this->integer()->notNull(),
            'indigent_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10, 0)->notNull(),
            'created_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            'idx-support_product-support_id',
            'support_product',
            'support_id'
        );

        $this->addForeignKey(
            'fk-support_product-support_id',
            'support_product',
            'support_id',
            'support',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-support_product-indigent_id',
            'support_product',
            'indigent_id'
        );

        $this->addForeignKey(
            'fk-support_product-indigent_id',
            'support_product',
            'support_id',
            'indigent',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-support_product-product_id',
            'support_product',
            'product_id'
        );

        $this->addForeignKey(
            'fk-support_product-product_id',
            'support_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-support_product-support_id',
            'support_product'
        );

        $this->dropIndex(
            'idx-support_product-support_id',
            'support_product'
        );

        $this->dropForeignKey(
            'fk-support_product-indigent_id',
            'support_product'
        );

        $this->dropIndex(
            'idx-support_product-indigent_id',
            'support_product'
        );

        $this->dropForeignKey(
            'fk-support_product-product_id',
            'support_product'
        );

        $this->dropIndex(
            'idx-support_product-product_id',
            'support_product'
        );

        $this->dropTable('{{%support_product}}');
    }
}
