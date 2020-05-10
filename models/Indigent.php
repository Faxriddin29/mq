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
 * @property string|null $status
 *
 * @property Support[] $supports
 * @property SupportProduct[] $supportProducts
 */
class Indigent extends \yii\db\ActiveRecord
{
    const NOT_CONFIRMED = '0';
    const ON_PROCESS = '1';
    const DELIVERED = '2';
    const REJECTED = '3';
    const CONFIRMED = '4';
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
            [['support_type', 'support_regularity_type', 'status'], 'string'],
            [['first_name', 'middle_name', 'last_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 13],
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
            'first_name' => Yii::t('app', 'Ism'),
            'middle_name' => Yii::t('app', 'Otasining ismi'),
            'last_name' => Yii::t('app', 'Familiya'),
            'phone' => Yii::t('app', 'Telefon raqami'),
            'address' => Yii::t('app', 'Manzil'),
            'support_type' => Yii::t('app', 'Taminlash turi'),
            'support_regularity_type' => Yii::t('app', 'Ta`minlash davomiyligi turi'),
            'support_days' => Yii::t('app', 'Ta`minlash kunlari'),
            'status' => Yii::t('app', 'Holati'),
        ];
    }

    /**
     * Gets query for [[Supports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupports()
    {
        return $this->hasMany(Support::class, ['indigent_id' => 'id']);
    }

    /**
     * Gets query for [[SupportProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportProducts()
    {
        return $this->hasMany(SupportProduct::class, ['indigent_id' => 'id']);
    }

    public static function status()
    {
        return [
            '' => 'Tanlang',
            self::NOT_CONFIRMED => 'Tasdiqlanmagan',
            self::ON_PROCESS => 'Yuborish jarayonida',
            self::DELIVERED => 'Yuborilgan',
            self::REJECTED => 'Rad etilgan',
            self::CONFIRMED => 'Tasdiqlangan',
        ];
    }
}
