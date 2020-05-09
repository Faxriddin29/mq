<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%support}}`.
 */
class m200419_113219_create_support_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%support}}', [
            'id' => $this->primaryKey(),
            'indigent_id' => $this->integer()->notNull(),
            'date' => $this->date(),
            'app_status' => "ENUM('0', '1') DEFAULT '0'"
        ]);

        $this->createIndex(
            'idx-support-indigent_id',
            'support',
            'indigent_id'
        );

        $this->addForeignKey(
            'fk-support-indigent_id',
            'support',
            'indigent_id',
            'indigent',
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
            'fk-support-indigent_id',
            'support'
        );

        $this->dropIndex(
            'idx-support-indigent_id',
            'support'
        );

        $this->dropTable('{{%support}}');
    }
}
