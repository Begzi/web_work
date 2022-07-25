<?php


namespace app\controllers;


use app\models\Cert;
use app\models\CertUz;
use app\models\UzForm;
use app\models\UzNet;
use app\models\Uz;
use app\models\UzType;
use yii\filters\AccessControl;
use Yii;

class UzController extends BaseController
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

    public function actionAdd($customer_id)
    {
        $model = new UzForm();
        if ($model->load(Yii::$app->request->post())) 
        {

            for ($i = 0; $i < $model->number_for_add; $i++)
            {
                $uz = new Uz();
                $uz->customer_id = $customer_id;
                $uz->type_id = $model->type_id;
                $uz->net_id = $model->net_id;
                if ($model->supply_time == NULL)
                {
                    $uz->supply_time = date('Y-m-d h:i', time());
                }
                else
                {
                    $uz->supply_time = strval($model->supply_time);
                }
                $uz->supply_ex_time = date('Y-m-d', strtotime(''.$uz->supply_time.'+1 year'));
                $uz->save();
            }



            return $this->redirect(array('customers/view', 'id'=>$customer_id));
        }
        $query = UzType::find()->all();
        $type=Array();
        for ($i=0; $i < count($query); $i++)
        {
            array_push($type,$query[$i]->name);
        }
        $query = UzNet::find()->all();
        $net=Array();
        for ($i=0; $i < count($query); $i++)
        {
            array_push($net,$query[$i]->num . ' - ' . $query[$i]->name);
        }
        return $this->render('add', [
            'model' => $model,
            'type' => $type,
            'net' => $net,
            'customer_id' => $customer_id
        ]);
    }
    public function actionEdit($id)
    {
//        if (Yii::$app->user->identity->username != 'admin') {
//            return $this->actionError();
//        }
        $model = new UzForm();

        $uz = Uz::findOne($id);
        $query = $uz->customer->address;
        $address[0]=' ';
        $selected_address = 0;
        for ($i=0; $i < count($query); $i++)
        {
            array_push($address, $query[$i]->branch . ' - ' . $query[$i]->city . ' ' . $query[$i]->street . ' ' . $query[$i]->num);
            if ($uz->address_id == $query[$i]->id){
                $selected_address = $i + 1 ;
            }
        }

        if ($model->load(Yii::$app->request->post())) 
        {

            Yii::$app->session->setFlash('uzlistFormSubmitted');
            $uz->type_id = $model->type_id;
            $uz->net_id = $model->net_id;
            $uz->supply_time = strval($model->supply_time);
            if (date('m-d', strtotime(strval($model->supply_time))) == '01-01')
            {
                $uz->supply_ex_time = date('Y-m-d', strtotime(''.strval($model->supply_time).'+1 year - 1 day'));
            }
            else 
            {
                $uz->supply_ex_time = date('Y-m-d', strtotime(''.strval($model->supply_time).'+1 year'));
            }
            $uz->description = $model->description;
            if ($model->address_id != 0){
                $uz->address_id = $query[$model->address_id - 1]->id;
            }
            $uz->save();



            return $this->redirect(array('customers/view', 'id'=>$uz->customer->id));
        }
        $query = UzType::find()->all();
        $type=Array();
        for ($i=0; $i < count($query); $i++)
        {
            array_push($type, $query[$i]->name);
        }
        $query = UzNet::find()->all();
        $net=Array();
        for ($i=0; $i < count($query); $i++)
        {
            array_push($net, $query[$i]->num . ' - ' .  $query[$i]->name);
        }
       
        return $this->render('edit', [
            'model' => $model,
            'type' => $type,
            'net' => $net,
            'uz' => $uz,
            'address' => $address,
            'selected_address' => $selected_address
        ]);
    }
    public function actionDelete($id)
    {
        $uz = Uz::findOne($id);
        $id = $uz->customer->id;

        for ($i = 0; $i < count($uz->logTickets); $i++)
        {
            $query = LogTicket::findOne($uz->logTickets[$i]->id);
            $query->uz_id = NULL;
            $query->save();
        }
        
        for ($i = 0; $i < count($uz->certuzs); $i++)
        {
            $query = CertUz::findOne($uz->certuzs[$i]->id);
            $query->uz_id = 0;
            $query->save();
        }

        $uz->delete();
        return $this->redirect(array('customers/view', 'id'=> $id));
    }

    public function actionView($id)
    {
        $uz = Uz::findOne($id);
        $model = new UzForm();
        if ($model->load(Yii::$app->request->post())) 
        {

            $uz->description = $model->description;

            $uz->save();

        }
        $text = preg_replace( "#\r?\n#", "<br />", $uz->description );
        $uz->description = $text;
        return $this->render('view', [
            'uz' => $uz,
            'model' => $model
        ]);
    }
}