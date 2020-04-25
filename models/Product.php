<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name_uz
 * @property string $name_ru
 * @property string $unit
 *
 * @property SupportProduct[] $supportProducts
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_uz', 'amount'], 'required'],
            [['unit'], 'string'],
            [['amount'], 'double', 'min' => 1, 'max' => 10000],
            [['name_uz', 'name_ru'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_uz' => Yii::t('app', 'Name Uz'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'unit' => Yii::t('app', 'Unit'),
        ];
    }

    /**
     * Gets query for [[SupportProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportProducts()
    {
        return $this->hasMany(SupportProduct::className(), ['product_id' => 'id']);
    }
}
