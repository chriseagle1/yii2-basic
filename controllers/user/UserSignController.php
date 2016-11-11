<?php
namespace app\controllers\user;

use Yii;
use yii\web\Controller;

class UserSignController extends Controller {
    public function actionIndex() {
        $this->layout = false;
        return $this->render('index');
    }
}