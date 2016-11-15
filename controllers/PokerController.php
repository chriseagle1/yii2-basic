<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class PokerController extends Controller
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
        $this->layout = false;
        $pokerNum = [
        	'11', '21', '31', '41', '12', '22', '32', '42', '13', '23', '33', '43',
        	'14', '24', '34', '44', '15', '25', '35', '45', '16', '26', '36', '46',
        	'17', '27', '37', '47', '18', '28', '38', '48', '19', '29', '39', '49',
        	'10', '20', '30', '40', '1a', '2a', '3a', '4a', '1b', '2b', '3b', '4b',
        	'1c', '2c', '3c', '4c', 'Ki', 'Qu',
        ];
        return $this->render('index', ['all_poker' => $pokerNum]);
    }

}
