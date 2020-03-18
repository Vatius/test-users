<?php

namespace app\models;

use yii\base\Model;

class PayForm extends Model
{
    public $user;
    public $value;

    public function rules()
    {
        return [
            [['user', 'value'], 'required'],
            ['user', 'integer'],
            ['value', 'number'],
        ];
    }

}