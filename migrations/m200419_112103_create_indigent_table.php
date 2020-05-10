<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%indigent}}`.
 */
class m200419_112103_create_indigent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%indigent}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(50)->notNull(),
            'middle_name' => $this->string(50)->notNull(),
            'last_name' => $this->string(50)->notNull(),
            'phone' => $this->char(13)->notNull(),
            'address' => $this->string(255)->notNull(),
            'support_type' => "ENUM('regular', 'once') NOT NULL",
            'support_regularity_type' => "ENUM('week_days', 'dates_of_the_month') NOT NULL",
            'support_days' => $this->string(255)->defaultValue('0')->notNull(),
            'status' => "ENUM('0', '1', '2', '3', '4') NOT NULL",
            'created_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

//        $this->insert('indigent', [
//            'first_name' => 'Kamolov',
//            'middle_name' => 'Kamol',
//            'last_name' => 'Kamol o`g`li',
//            'phone' => '998999999999',
//            'address' => 'Toshkent, Yunusobod',
//            'support_type' => 'once',
//            'support_regularity_type' => 'week_days',
//            'support_days' => '1',
//            'status' => '0'
//        ]);
//
//        $this->insert('indigent', [
//            'first_name' => 'Salimov',
//            'middle_name' => 'Salim',
//            'last_name' => 'Salim o`g`li',
//            'phone' => '998911234563',
//            'address' => 'Toshkent, Yashnobod',
//            'support_type' => 'once',
//            'support_regularity_type' => 'week_days',
//            'support_days' => '1',
//            'status' => '0'
//        ]);
//
//        $this->insert('indigent', [
//            'first_name' => 'Halimov',
//            'middle_name' => 'Halim',
//            'last_name' => 'Halim o`g`li',
//            'phone' => '998936594587',
//            'address' => 'Toshkent, Sirg`ali',
//            'support_type' => 'regular',
//            'support_regularity_type' => 'dates_of_the_month',
//            'support_days' => '1,5,6'
//        ]);
//
//        $this->insert('indigent', [
//            'first_name' => 'Salomov',
//            'middle_name' => 'Salom',
//            'last_name' => 'Salom o`g`li',
//            'phone' => '998936594587',
//            'address' => 'Toshkent, Yashnobod',
//            'support_type' => 'regular',
//            'support_regularity_type' => 'dates_of_the_month',
//            'support_days' => '1,3,5,6'
//        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->delete('indigent', ['id' => 1]);
//        $this->delete('indigent', ['id' => 2]);
//        $this->delete('indigent', ['id' => 3]);

        $this->dropTable('{{%indigent}}');
    }
}
