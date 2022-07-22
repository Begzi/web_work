<?php


namespace app\controllers;


use app\models\Uz;
use app\models\Cert;
use app\models\Customers;
use app\models\Contact;
use app\models\LogTicket;
use phpDocumentor\Reflection\Types\Array_;
use yii\data\Pagination;
use yii\filters\AccessControl;
use Yii;

class AnalyzeController extends BaseController{


    public function behaviors()
    {
         
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index',],
                'rules' => [ 
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['scheme'],
                        'allow' => true,
                        'roles' => ['logList'],
                    ],
                ],
            ]   
        ];
    }


    public function actionIndex() {
        $query = Customers::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $customers = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', compact('customers', 'pages'));
    }
}