<?php


namespace app\controllers;


use app\models\Cert;
use app\models\Customers;
use app\models\User;
use app\models\Kbase;
use app\models\LogTicket;
use app\models\LogTicketEvent;
use app\models\LogTicketType;
use app\models\KbaseForm;
use app\models\LogTicketForm;
use app\models\LogTicketEventForm;
use phpDocumentor\Reflection\Types\Array_;
use yii\data\Pagination;
use yii\filters\AccessControl;
use Yii;

class LogticketController extends BaseController{


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

    public function actionIndex() {
        function build_sorter($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }
        $query = LogTicket::find()->orderBy('status, id DESC');
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 30]);
        $logticket = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', compact('logticket', 'pages'));
    }

    public function actionTmp(){

        $query = LogTicket::find()->all();
        foreach ($query as $log){
            if ($log->type == 1 or $log->type == 0){
            
                $log->type = 2;
                $log->save();
            }
            if ($log->priority == 0){
            
                $log->type = 1;
                $log->save();
            }
        }
        return 123;
    }

    public function actionSearchfull(){

        $search = Yii::$app->request->get('search');
        $search_range_num = strpos($search, '***');
        $search_check = substr($search, - (strlen($search) - $search_range_num - 3));
        $search = substr($search, 0, $search_range_num );

        $search1 = str_replace(' ','', $search);
        if ($search_check == "По умлочанию"){
            $querycustomer = Customers::find()->where(['like', 'replace(shortname, " ", "")', $search1])->one();
            $queryuser = User::find()->where(['like', 'replace(name, " ", "")', $search1])->one();

            $query = LogTicket::find()->orFilterwhere(['like', 'replace(topic, " ", "")', $search1])
                ->orFilterWhere(['id'=> $search1])
                ->orFilterWhere(['res_person'=> $queryuser->id])
                ->orderBy('status, id DESC');

        }
        elseif ($search_check == "Заказчик"){
            // return 1;
             $query = LogTicket::find()
             ->joinWith(['customer'] )
             ->andFilterWhere(['like', 'replace(shortname, " ", "")', $search1])
             ->orderBy('status, id DESC');          

        }
        elseif ($search_check == "Категория"){
            // return 2;
             $query = LogTicket::find()
             ->joinWith(['logTicketType'])
             ->andFilterWhere(['like', 'replace(name, " ", "")', $search1])
             ->orderBy('status, id DESC');          

        }
        elseif ($search_check == "Приоритет"){
             $query = LogTicket::find()
             ->joinWith(['logTicketPriority'])
             ->andFilterWhere(['like', 'replace(name, " ", "")', $search1])
             ->orderBy('status, id DESC');          

        }
        elseif ($search_check == "Последний ответ"){
             $query = LogTicket::find()
             ->joinWith(['logTicketEvent'])
             ->andFilterWhere(['like', 'replace(text_description, " ", "")', $search1])
             ->orderBy('status, id DESC');                  

        }
        else{
            $search_range_num = strpos($search_check, '***');
            $search_date = substr($search_check, - (strlen($search_check) - $search_range_num - 3));
            $search_check = substr($search_check, 0, $search_range_num );

            $search_range_num = strpos($search_date, '***');
            $search_date_end = substr($search_date, - (strlen($search_date) - $search_range_num - 3));
            $search_date_from = substr($search_date, 0, $search_range_num );
            
            $search_date_from = Yii::$app->formatter->asTime( $search_date_from, 'php:Y-m-d h:i:s');
            $search_date_end = Yii::$app->formatter->asTime( $search_date_end, 'php:Y-m-d h:i:s');

       

            $query = LogTicket::find()
                ->andWhere(['like', 'replace(topic, " ", "")', $search1])
                ->andWhere(['<', 'reg_date', $search_date_end])
                ->andWhere(['>', 'reg_date', $search_date_from])
                ->orderBy('status, id DESC');

            if ($search1 == ''){
                $search = 'date';
            }

        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 30]);
        $logticket = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'logticket' => $logticket,
            'pages' => $pages,
            'searchfull' => $search
        ]);

    
    }

    public function actionAdd($customer_id) 
    {
        $model = new LogTicketForm;

        if ($model->load(Yii::$app->request->post()) or $customer_id != 0) 
        {

            if ($model->topic == 'tmp' or ($customer_id != 0 && $model->topic === NULL))
            {

                Yii::$app->session->setFlash('ChooseUz');

                $query = Customers::find()->all();
                $customers = Array();
                foreach ($query as $value)
                {
                    array_push($customers, $value->id . ' - ' . $value->fullname);
                }
                $query = LogTicketType::find()->all();
                $logtickettype = Array();
                foreach ($query as $value)
                {
                    array_push($logtickettype, $value->name);
                }
                if ( $customer_id == 0)
                {
                    $customer_name = strstr($model->customer_id, ' - ');
                    $customer_name = substr($customer_name, 3);

                    $customer_name = str_replace(' ','', $customer_name);

                    $query = Customers::findOne($model->customer_id);
                    $customer_id = $model->customer_id;
                }
                else
                {
                    $query = Customers::findOne($customer_id);                    
                }

                $customer_uz = Array();
                $customer_uz_obj = $query->uzs;
                foreach ($customer_uz_obj as $value)
                {
                    if ($value->description != NULL)
                    {
                        $tmp = stristr($value->description, '047');
                        $pos = stripos($tmp, ' ');
                        $id_uz = mb_substr($tmp,0, $pos);
                        array_push($customer_uz, $value->id . ' - ' . $value->uztype->name . ' - ' . count($value->logTickets) . ' Обращений ' . $id_uz);                

                    }
                    else
                    {
                        array_push($customer_uz, $value->id . ' - ' . $value->uztype->name . ' - ' . count($value->logTickets) . ' Обращений');                
                    }
                }
                $customer_contact = Array();
                $customer_contact_obj = $query->contacts;
                foreach ($customer_contact_obj as $value)
                {
                    $tmp = $value->id . ' - ' . $value->contactPosition->name;
                    if ($value->name != NULL)
                    {
                        $tmp = $tmp . ' - ' . $value->name;
                    }
                    if ($value->m_tel != NULL)
                    {
                        $tmp = $tmp . ' - ' . $value->m_tel;
                    }
                    elseif ($value->w_tel != NULL)
                    {
                        $tmp = $tmp . ' - ' . $value->w_tel;
                    }
                    array_push($customer_contact, $tmp);
                }

                $model->topic = '';
                $model->customer_id = $customer_id;
                $customer_id = 0;
                return $this->render('add', [
                        'model' => $model,
                        'customer_id' => $model->customer_id,
                        'customers' => $customers,
                        'logtickettype' => $logtickettype,
                        'customer_uz' => $customer_uz,
                        'customer_contact' => $customer_contact,
                    ]);
            }  
            $logTicket = new LogTicket;
            $logTicket->type = $model->type + 2;
            $logTicket->priority = $model->priority + 1;
            $logTicket->topic = $model->topic;
            $logTicket->description = $model->description;
            $logTicket->customer_id = $model->customer_id;
            $logTicket->status = 1;
            $logTicket->solution_time = 0;
            $logTicket->res_person = strval(Yii::$app->user->identity->id);

            $logTicket->reg_date = Yii::$app->formatter->asTime( time(), 'php:Y-m-d h:i:s');

            $logTicket->uz_id = $model->uz_id;
            $logTicket->contact_id = $model->contact_id;
            $logTicket->save();
            return $this->redirect(array('logticket/index'));


        }

        $query = Customers::find()->all();
        $customers = Array();
        foreach ($query as $value)
        {
            array_push($customers, $value->id . ' - ' . $value->fullname);
        }
        $query = LogTicketType::find()->all();
        $logtickettype = Array();
        foreach ($query as $value)
        {
            array_push($logtickettype, $value->name);
        }
        return $this->render('add', [
            'model' => $model,
            'customers' => $customers,
            'logtickettype' => $logtickettype,
        ]);
    }

    public function actionView($logticket_id) 
    {

        $model = new LogTicketForm;
        $logticket = LogTicket::findOne($logticket_id);
        $modelevent = new LogTicketEventForm;
        if ($modelevent->load(Yii::$app->request->post())) 
        {
            $logticketevent = new LogTicketEvent;
            $logticketevent->text_description = $modelevent->text_description; 
            $logticketevent->next_date_description = $modelevent->next_date_description; 
            $logticketevent->next_date = $modelevent->next_date; 
            $logticketevent->ticket_id = $logticket->id; 
            $logticketevent->res_person = strval(Yii::$app->user->identity->id);
            $logticketevent->reg_date = Yii::$app->formatter->asTime( time(), 'php:Y-m-d h:i:s');
            $logticketevent->save();
        }

        if ($model->load(Yii::$app->request->post())) 
        {
            if ($model->description != NULL)
            {
                $logticket->description = $model->description;
                $logticket->save();
            }   
            elseif ($model->solution_time != NULL)
            {
                $logticket->solution_time = $model->solution_time;
                $logticket->status = 2;
                $logticket->save();
                return $this->redirect(array('logticket/index' ));
            }
        }

        $logticket = LogTicket::findOne($logticket_id);
        
        $text = preg_replace( "#\r?\n#", "<br />", $logticket->description );
        $logticket->description = $text;

        $model->topic = $logTicket->model;
        $model->priority = $logTicket->priority;
        $model->type = $logTicket->type;

        return $this->render('view', [
            'logticket' => $logticket,
            'model' => $model,
            'modelevent' => $modelevent,
            'modelkbase' => $modelkbase,
        ]);
    }
    public function actionKbaseconnect($logticket_id) {

        $logticket = LogTicket::findOne($logticket_id);

        $model = new KbaseForm;
        if ($model->load(Yii::$app->request->post())) {
            $logticket->kbase_link = $model->name;
            $logticket->save();

            return $this->redirect(array('logticket/view', 'logticket_id' => $logticket_id ));
        }
        $kbase = Kbase::find()->all();

        

        return $this->render('kbaseconnect', [
            'logticket' => $logticket,
            'model' => $model,
            'kbase' => $kbase
        ]);

        
    }


    public function actionSuccess($logticket_id) {

        $logticket = LogTicket::findOne($logticket_id);


        

        $logticket->status = 2;
        $logticket->save();
        return $this->redirect(array('logticket/view', 'logticket_id' => $logticket_id));

        
    }



    public function actionEditevent($logticketevent_id) {
        $logticketevent = LogTicketEvent::findOne($logticketevent_id);
        $modelevent = new LogTicketEventForm;
        if ($modelevent->load(Yii::$app->request->post())) {
            $logticketevent->text_description = $modelevent->text_description;
            $logticketevent->next_date = $modelevent->next_date;
            $logticketevent->next_date_description = $modelevent->next_date_description;
            $logticketevent->save();
            return $this->redirect(array('logticket/view', 'logticket_id' => $logticketevent->logTicket->id));
        }


        return $this->render('editevent', [
            'logticketevent' => $logticketevent,
            'modelevent' => $modelevent,
        ]);
    }

    public function actionDeleteevent($logticketevent_id) {
        $logticketevent = LogTicketEvent::findOne($logticketevent_id);
        $logticket_id = $logticketevent->logTicket->id;
        $logticketevent->delete();
        return $this->redirect(array('logticket/view', 'logticket_id' => $logticket_id));
        


    }

    public function actionEdit($logticket_id) {
        $logticket = LogTicket::findOne($logticket_id);
        $model = new LogTicketForm;
        if ($model->load(Yii::$app->request->post())) {
            $logticket->topic = $model->topic;
            $logticket->priority = $model->priority + 1;
            $logticket->type = $model->type;
            $logticket->uz_id = $model->uz_id;
            $logticket->contact_id = $model->contact_id;
            $logticket->save();
            return $this->redirect(array('logticket/view', 'logticket_id' => $logticket->id));
        }

        $query = LogTicketType::find()->all();
        $logtickettype = Array();
        foreach ($query as $value){
            array_push($logtickettype, $value->name);
        }
        $customer_uzs = $logticket->customer->uzs;
        $customer_contacts = $logticket->customer->contacts;

        if($logticket->uz_id != NULL)
        {
            $model->uz_id = $logticket->uz_id;
        }
        if($logticket->contact_id != NULL)
        {
            $model->contact_id = $logticket->contact_id;
        }
        return $this->render('edit', [
            'logticket' => $logticket,
            'model' => $model,
            'customer_uzs' => $customer_uzs,
            'customer_contacts' => $customer_contacts,
            'logtickettype' => $logtickettype
        ]);
    }

}