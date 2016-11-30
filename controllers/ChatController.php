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
        $this->view->registerCssFile('/css/chat.css', ['depends'=>  'app\assets\AppAsset']);
        $this->view->registerJsFile('/js/template.js', ['depends'=>  'app\assets\AppAsset']);
        $this->view->registerJsFile('/js/websocket.js', ['depends'=>  'app\assets\AppAsset']);
        
        return $this->render('index');
    }

}
