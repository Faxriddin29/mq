<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support_product".
 *
 * @property int $id
 * @property int $support_id
 * @property int $indigent_id
 * @property int $product_id
 * @property float $amount
 * @property string|null $created_at
 * @property string|null $status
 *
 * @property Indigent $support
 * @property Product $product
 * @property Support $support0
 */
class SupportProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['support_id', 'indigent_id', 'product_id', 'amount'], 'required'],
            [['support_id', 'indigent_id', 'product_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at'], 'safe'],
            [['status'], 'string'],
            [['support_id'], 'exist', 'skipOnError' => true, 'targetClass' => Indigent::class, 'targetAttribute' => ['support_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['support_id'], 'exist', 'skipOnError' => true, 'targetClass' => Support::class, 'targetAttribute' => ['support_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'support_id' => Yii::t('app', 'Support ID'),
            'indigent_id' => Yii::t('app', 'Indigent ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'amount' => Yii::t('app', 'Amount'),
            'created_at' => Yii::t('app', 'Created At'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Support]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIndigent()
    {
        return $this->hasOne(Indigent::class, ['id' => 'support_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Support0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupport()
    {
        return $this->hasOne(Support::class, ['id' => 'support_id']);
    }
}
