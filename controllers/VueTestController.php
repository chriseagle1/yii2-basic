<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class VueTestController extends Controller
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
        return $this->render('index');
    }
    
    public function actionUploadExcel() {
        $type = 'xlsx';
        $file_path = '';
        
        if ($type == 'xlsx' || $type == 'xls') {
            $reader = \PHPExcel_IOFactory::createReader('Excel2007'); // 读取 excel 文档
        } else if ($type == 'csv') {
            $reader = \PHPExcel_IOFactory::createReader('CSV'); // 读取 CSV 文档
        } else {
            die('Not supported file types!');
        }
        
        $phpExcel = $reader->load($file_path);
        $objWorksheet = $phpExcel->getActiveSheet();
        
    }

}
