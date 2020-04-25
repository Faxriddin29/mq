<?php

use yii\db\Migration;

/**
 * Class m200425_114239_create_indigent_support_view
 */
class m200425_114239_create_indigent_support_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE OR REPLACE VIEW supportings AS (SELECT 
                i.id,
                i.first_name,
                i.middle_name,
                i.last_name,
                i.phone,
                i.address,
                i.support_type,
                i.support_regularity_type,
                i.support_days,
                i.status,
                s.id as support_id,
                s.date,
                i.created_at
                FROM support s
                INNER JOIN indigent i ON s.indigent_id = i.id
WHERE i.status IN ('1','2','4'))");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200425_114239_create_indigent_support_view cannot be reverted.\n";

        return $this->execute("DROP VIEW IF EXISTS supportings");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200425_114239_create_indigent_support_view cannot be reverted.\n";

        return false;
    }
    */
}
