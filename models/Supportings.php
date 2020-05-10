<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supportings".
 *
 * @property int $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone
 * @property string $address
 * @property string $support_type
 * @property string $support_regularity_type
 * @property string $support_days
 * @property string $status
 * @property int $support_id
 * @property string|null $date
 * @property string|null $created_at
 */
class Supportings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supportings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'support_id'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'phone', 'address', 'support_type', 'support_regularity_type', 'status'], 'required'],
            [['support_type', 'support_regularity_type', 'status', 'app_status'], 'string'],
            [['date', 'created_at'], 'safe'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 13],
            [['address', 'support_days'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'Ism'),
            'middle_name' => Yii::t('app', 'Otasining ismi'),
            'last_name' => Yii::t('app', 'Familiya'),
            'phone' => Yii::t('app', 'Telefon raqami'),
            'address' => Yii::t('app', 'Manzil'),
            'support_type' => Yii::t('app', 'Ta`minot turi'),
            'support_regularity_type' => Yii::t('app', 'Ta`minot davomiyligi turi'),
            'support_days' => Yii::t('app', 'Ta`minot kunlari'),
            'status' => Yii::t('app', 'Holat'),
            'support_id' => Yii::t('app', 'Ta`minot yozuvi IDsi'),
            'date' => Yii::t('app', 'Kun'),
            'created_at' => Yii::t('app', 'Ariza berilgan kun'),
            'app_status' => Yii::t('app', 'Akt holati'),
        ];
    }
}
