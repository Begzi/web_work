<?php
namespace app\controllers;


use app\models\Cert;
use app\models\Customers;

class TicketController extends BaseController
{
    public function actionIndex($customer_id)
    {
        $query = Customers::find()->all();
        $k=1;
        foreach ($query as $value){
            $value->doc_type_id = $k;
            $value->save();
        }
    }
}