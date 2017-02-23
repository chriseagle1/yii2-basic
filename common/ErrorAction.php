<?php
namespace app\common;

use yii\base\Action;

class ErrorAction extends Action {
    public function run() {
        return 'hello world';
    }
}