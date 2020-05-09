<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property int $id
 * @property int $indigent_id
 * @property string $date
 *
 * @property Indigent $indigent
 * @property SupportProduct[] $supportProducts
 */
class Support extends \yii\db\ActiveRecord
{
    const SUPPORT_ONCE = 'once';
    const SUPPORT_REGULAR = 'regular';

    /**
     * Invoice status
     */
    const STATUS_NOT_GENERATED = '0';
    const STATUS_GENERATED = '1';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['indigent_id', 'date'], 'required'],
            [['indigent_id'], 'integer', 'unique'],
            [['app_status', 'string']],
            [['date'], 'safe'],
            [['indigent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Indigent::class, 'targetAttribute' => ['indigent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'indigent_id' => Yii::t('app', 'Indigent ID'),
            'date' => Yii::t('app', 'Date'),
            'app_status' => Yii::t('app', 'Application status')
        ];
    }

    /**
     * Gets query for [[Indigent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIndigent()
    {
        return $this->hasOne(Indigent::class, ['id' => 'indigent_id']);
    }

    /**
     * Gets query for [[SupportProducts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupportProducts()
    {
        return $this->hasMany(SupportProduct::class, ['support_id' => 'id']);
    }
}
