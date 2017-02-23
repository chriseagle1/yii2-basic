<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ChatController extends Controller
{
    /**
     * 1  
     * (non-PHPdoc)
     * @see \yii\base\Object::init()
     */
    public function init() {
    }
    
    /**
     * 2
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => '\app\common\ErrorAction'
        ];
    }
    
    /**
     * 3
     * (non-PHPdoc)
     * @see \yii\web\Controller::beforeAction()
     */
    public function beforeAction($action) {
        return parent::beforeAction($action);
    }
    
    /**
     * 4
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * 6
     * (non-PHPdoc)
     * @see \yii\base\Controller::afterAction()
     */
    public function afterAction($action, $result)
    {
         $result = parent::afterAction($action, $result);
         // your custom code here
         return $result;
    }
    
    /**
     * 5
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
