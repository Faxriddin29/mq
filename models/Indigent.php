<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "indigent".
 *
 * @property int $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $phone
 * @property string $address
 * @property string $support_type
 * @property string|null $support_regularity_type
 * @property string|null $support_days
 * @property string|null $verified
 *
 * @property Support[] $supports
 * @property SupportProduct[] $supportProducts
 */
class Indigent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indigent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'middle_name', 'last_name', 'phone', 'address', 'support_type'], 'required'],
            [['support_type', 'support_regularity_type', 'verified'], 'string'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 12],
            [['address'], 'string', 'max' => 255],
            [['support_days'], 'string', 'max' => 100],
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
            'verified' => Yii::t('app', 'Verified'),
        ];
    }

    /**
     * Gets query for [[Supports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupports()
    {
        return $this->hasMany(Support::className(), ['indigent_id' => 'id']);
    }

    /**
     * Gets query for [[SupportProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportProducts()
    {
        return $this->hasMany(SupportProduct::className(), ['indigent_id' => 'id']);
    }
}
