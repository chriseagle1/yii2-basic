<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ChatController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'chat-main';
        \yii::$app->view->registerCssFile(\yii::getAlias('@web' . '/css/chat.css'), ['depends'=>  'app\assets\AppAsset']);
        \yii::$app->view->registerJsFile(\yii::getAlias('@web' . '/js/websocket.js'), ['depends'=>  'app\assets\AppAsset']);
        return $this->render('index');
    }

}
