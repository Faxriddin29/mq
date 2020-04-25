<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m200419_112923_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name_uz' => $this->string(50)->notNull(),
            'name_ru' => $this->string(50),
            'amount' => $this->decimal(10, 3),
            'unit' => "ENUM('kg', 'liter', 'pieces', 'meter', 'bottle', 'pocket', 'jar')"
        ]);

        $this->insert('product', [
            'name_uz' => 'Yog`',
            'amount' => 100,
            'unit' => 'liter'
        ]);

        $this->insert('product', [
            'name_uz' => 'Kartoshka',
            'amount' => 100,
            'unit' => 'kg'
        ]);

        $this->insert('product', [
            'name_uz' => 'Sabzi',
            'amount' => 100,
            'unit' => 'kg'
        ]);

        $this->insert('product', [
            'name_uz' => 'Go`sht',
            'amount' => 100,
            'unit' => 'kg'
        ]);

        $this->insert('product', [
            'name_uz' => 'shakar',
            'amount' => 100,
            'unit' => 'kg'
        ]);

        $this->insert('product', [
            'name_uz' => 'piyoz',
            'amount' => 100,
            'unit' => 'kg'
        ]);

        $this->insert('product', [
            'name_uz' => 'tuz',
            'amount' => 100,
            'unit' => 'pocket'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('product', ['id' => 1]);
        $this->delete('product', ['id' => 2]);
        $this->delete('product', ['id' => 3]);
        $this->delete('product', ['id' => 4]);
        $this->delete('product', ['id' => 5]);
        $this->delete('product', ['id' => 6]);

        $this->dropTable('{{%product}}');
    }
}
