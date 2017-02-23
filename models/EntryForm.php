<?php
namespace app\models;

use yii;
use yii\base\Model;

class EntryForm extends Model {
    public $name;
    public $email;
    
    public function rules() {
        return [
            [['name', 'email', 'password'], 'required', 'on' => 'register'],
            [['name', 'password'], 'required', 'on' => 'login'],
            ['password', 'password'],
            ['email', 'email']    
        ];
    }
    
    public function attributeLabels() {
        return [
            'name' => '姓名',
            'email' => '邮箱'
        ];
    }
}