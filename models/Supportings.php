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
            [['support_type', 'support_regularity_type', 'status'], 'string'],
            [['date', 'created_at'], 'safe'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 12],
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
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'support_type' => Yii::t('app', 'Support Type'),
            'support_regularity_type' => Yii::t('app', 'Support Regularity Type'),
            'support_days' => Yii::t('app', 'Support Days'),
            'status' => Yii::t('app', 'Status'),
            'support_id' => Yii::t('app', 'Support ID'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
