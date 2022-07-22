<?php


namespace app\controllers;


use app\models\CertForm;
use app\models\Cert;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class LayoutsController extends Controller
{
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]   
        ];
    }
    
    public function actionMain()
    {

        $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        $current_date = date('Y-m-d', time());
        $certs = Cert::find()->all();
        // $certs = Cert::find()->andWhere(['>', 'ex_date', $current_date]);

        

        return $this->render('main', [
            'certs' => $certs,
        ]);
    }

}