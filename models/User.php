<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $phone
 * @property int|null $status
 *
 * @property Payments[] $payments
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['phone', 'status'], 'integer'],
            [['name','phone'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'status' => 'Status',
        ];
    }

    public function getBalance()
    {
        $res = $this->getPayments()->asArray()->all();
        $sum = 0;
        foreach($res as $item) {
            $sum += $item['value'];
        }
        return $sum;
    }

    public function changeStatus()
    {
        if($this->status == self::STATUS_ACTIVE) {
            $this->status = self::STATUS_INACTIVE;
        } else {
            $this->status = self::STATUS_ACTIVE;
        }
        $this->save();
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['user' => 'id']);
    }
}
