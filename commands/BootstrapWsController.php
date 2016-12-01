<?php

namespace app\commands;

use yii\console\Controller;
use app\common\Websocket;

/**
 * 启动websocket服务器端监听
 */
class BootstrapWsController extends Controller
{
    
    public function actionRun($host = '127.0.0.1', $port = '8888')
    {
        try {

        } catch(\Exception $e) {
        	Yii::error($e->getMessage());
        	return false;
        }
    }
}
