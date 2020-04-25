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
            'date' => $this->date()
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

        $this->insert('support', [
            'indigent_id' => 1,
            'date' => date('Y-m-d', strtotime('2020-04-25'))
        ]);

        $this->insert('support', [
            'indigent_id' => 2,
            'date' => date('Y-m-d', strtotime('2020-05-01'))
        ]);

        $this->insert('support', [
            'indigent_id' => 3,
            'date' => date('Y-m-d', strtotime('2020-05-13'))
        ]);

        $this->insert('support', [
            'indigent_id' => 1,
            'date' => date('Y-m-d', strtotime('2020-05-05'))
        ]);

        $this->insert('support', [
            'indigent_id' => 2,
            'date' => date('Y-m-d', strtotime('2020-06-01'))
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('support', ['id' => 1]);
        $this->delete('support', ['id' => 2]);
        $this->delete('support', ['id' => 3]);
        $this->delete('support', ['id' => 4]);
        $this->delete('support', ['id' => 5]);

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
