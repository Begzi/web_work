<?php


namespace app\controllers;


// use app\models\User;
use app\models\Uz;
use app\models\Mail;
use app\models\Cert;
use app\models\CertUz;
use app\models\Region;
use app\models\Customers;
use app\models\CustomerGroupName;
use app\models\Contact;
use app\models\Scheme;
use app\models\Address;
use app\models\LogTicket;
use app\models\CustomersForm;
use phpDocumentor\Reflection\Types\Array_;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use Yii;
class CustomersController extends BaseController{


    public function behaviors()
    {
         
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['edit', 'scheme', 'index', 'role', 'view', 'add', 'searchfull', 'association'],
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
    public function actionRole() {

        // // Создание РОЛЕЙ!
        // $admin = Yii::$app->authManager->createRole('admin');
        // $admin->description = 'Администратор';
        // Yii::$app->authManager->add($admin);

        // $TZI = Yii::$app->authManager->createRole('TZI');
        // $TZI->description = 'Техподдержка';
        // Yii::$app->authManager->add($TZI);

        // $manager = Yii::$app->authManager->createRole('manager');
        // $manager->description = 'Менеджер';
        // Yii::$app->authManager->add($manager);

        // // //Создание ПРАВ
        // $permit = Yii::$app->authManager->createPermission('logList');
        // $permit->description = 'Право на просмотр Журнала обращения';
        // Yii::$app->authManager->add($permit);

        // // //Наследование ОТ ролей ПРАВ. По факту что могут делать 2 роля одновременно. 
        // $role_a = Yii::$app->authManager->getRole('admin');
        // $role_t = Yii::$app->authManager->getRole('TZI');
        // $permit = Yii::$app->authManager->getPermission('logList');
        // $permit = Yii::$app->authManager->getRole('manager');
        // Yii::$app->authManager->addChild($role_a, $permit);
        // Yii::$app->authManager->addChild($role_t, $permit);

        // // //Привязка РОЛЕЙ к учёткам
        // $userRole = Yii::$app->authManager->getRole('admin');
        // Yii::$app->authManager->assign($userRole, 11);  
        // Yii::$app->authManager->assign($userRole, 2);  
        // Yii::$app->authManager->assign($userRole, 4);  
        // Yii::$app->authManager->assign($userRole, 8);  
        // $userRole = Yii::$app->authManager->getRole('TZI');
        // Yii::$app->authManager->assign($userRole, 11);  
        // Yii::$app->authManager->assign($userRole, 8);  
        // Yii::$app->authManager->assign($userRole, 9);  
        // $userRole = Yii::$app->authManager->getRole('manager');
        // Yii::$app->authManager->assign($userRole, 10);   

        // // Обычные пароль пользователей в хеш
        // $users = User::find()->all();
        // foreach ($users as $user){
        //     $user->hash = Yii::$app->getSecurity()->generatePasswordHash($user->password);
        //     $user->save();
        // }



        // Yii::$app->mailer->compose()
        //     ->setFrom(['support@pik-b.ru'])
        //     ->setTo('begzi@pik-b.ru')
        //     ->setSubject('Тема сообщения')
        //     ->setTextBody('Текст сообщения')
        //     ->setHtmlBody('Женя женьямин ЖЕНЕВИЧ <br> Большой')
        //     ->send();

        // $query = Customers::find()->all(); В ОСНОВНОМ САЙТЕ ТОЖЕ ДЕЛАТЬ!
        // foreach ($query as $value)
        // {
        //     $value->doc_type_id = $value->doc_type_id + 1;
        //     $value->save();
        // }


        return 123456;
    }
    

    /**
     * @return string|\yii\web\Response
     */
    public function actionView($id)
    {
        function build_sorter($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }

        $customer = Customers::find()->with('contacts')->with('uzs')->with('doctype')->with('address')->where(['id'=>$id])->one();
        
        $model = new CustomersForm();
    // Изменение описания и тип обмена документооборота
        if ($model->load(Yii::$app->request->post())) {
            if ($model->doc_type_id == NULL) {
                $customer->description = $model->description;
                $customer->save();
            } elseif ($model->description == NULL) {
                $customer->doc_type_id = $model->doc_type_id;
                $customer->save();
            }
        }

        $customer = Customers::find()->with('contacts')->with('uzs')->with('doctype')->with('address')->where(['id'=>$id])->one();

        $text = preg_replace( "#\r?\n#", "<br />", $customer->description );
        $customer->description = $text;
        // при вывводе примечания выводились и знак следующей строки! нужно оставить это после проверки на ввод не кода


        $uzs = $customer->uzs;
        usort($uzs, build_sorter('type_id'));
        $tmp= [];
        $realuzs= [];
        $k=0;
        // делёшься узлов по типу
        for ($i=0; $i < count($uzs); $i++)
        {
            if (empty($tmp))
            {
                array_push($tmp,$uzs[$i]);
            }
            else
            {
                if ($uzs[$i]->type_id == $tmp[$k]->type_id)
                {
                    array_push($tmp,$uzs[$i]);
                    $k++; #Первый элемент повторяющихся узлов. Узлы отсартированные по типу
                }
                else
                {
                    array_push($realuzs,$tmp);
                    $tmp=[];
                    $k=0;
                    array_push($tmp,$uzs[$i]);
                }

            }
        }
        array_push($realuzs,$tmp);

        $date = Yii::$app->formatter->asDate( time());
        $date_check=[];
        for ($i = 0; $i < count($realuzs); $i++) 
        {
            $date_k = 0;
            $date_l = 0;

            for ($j = 0; $j < count($realuzs[$i]); $j++) 
            {
                $check_tmp =  Yii::$app->formatter->asDate( $realuzs[$i][$j]->actualcert->ex_date);
                if ($check_tmp) //на случай если нет сертификата. Проверка
                {
                    if (strtotime($date) < strtotime( $check_tmp)) 
                    {
                        $date_k++;
                    }
                }
            }
            if (($date_k < count($realuzs[$i])) && ($realuzs[$i][0]->uztype->type == 1))
            {

                for ($j = 0; $j < count($realuzs[$i]); $j++) 
                {
                    $check_tmp =  Yii::$app->formatter->asDate( $realuzs[$i][$j]->supply_ex_time);

                    
                    if ($check_tmp) //на случай если нет supply_ex_time. Проверка
                    {
                        if ( strtotime($date) < strtotime($check_tmp) )
                        {
                            $date_l++;
                        }
                    }
                }
            }
            if ($date_k == count($realuzs[$i])) 
            {
                array_push( $date_check, 'У всех действующие сертификаты');
            } 
            elseif ($date_k == 0) 
            {
                if ($date_l > 0)
                {
                    array_push( $date_check,  'У всех нет действующих сертификатов, но есть на базовой гарантии' . $check_tmp);
                }
                else
                {
                    array_push( $date_check,  'У всех нет действующих сертификатов');
                }
            } 
            else 
            {
                if ($date_l > 0)
                {
                    array_push( $date_check, 'У некоторых нет действующих сертификатов, и есть на базовой гарантии');
                }
                else
                {
                    array_push( $date_check, 'У некоторых узлов нет действующих сертификатов');
                }
            }

            usort($realuzs[$i], build_sorter('id'));


        }

        return $this->render('view', [
            'customer' => $customer,
            'realuzs' => $realuzs,
            'date' => $date,
            'model' => $model,
            'date_check' => $date_check
            ]);
    }

    public function actionAdd() 
    {
//        if (Yii::$app->user->identity->username != 'admin') {
//            return $this->actionError();
//        }
        $model = new CustomersForm();
        if ($model->load(Yii::$app->request->post())) {

            if (strlen(strval($model->CPP)) != 9 or !is_numeric(strval($model->CPP))){
                Yii::$app->session->setFlash('WrongCPPFormSubmitted');

                return $this->render('add', [
                    'model' => $model,
                    'customer' => $customer
                ]);

            }
            if (strlen(strval($model->UHH))!= 10 or !is_numeric(strval($model->UHH))){
                Yii::$app->session->setFlash('WrongUHHFormSubmitted');
                return $this->render('add', [
                    'model' => $model,
                ]);

            }
            $query = Customers::find()->where(['UHH' => $model->UHH])->all();
            if ($query != NULL ){
                Yii::$app->session->setFlash('HaveUHHFormSubmitted');
                return $this->render('add', [
                    'model' => $model,
                ]);

            }
//            $customers = Customers::find()->all();
            $customer = new Customers();
            $customer->fullname = $model->fullname;
            $customer->shortname = $model->shortname;
            $customer->leg_address = $model->leg_address;
            $customer->description = $model->description;
            $customer->UHH = $model->UHH;
            $customer->CPP = $model->CPP;
            $customer->doc_type_id = $model->doc_type_id;
            $customer->customer_group_name_id = $model->customer_group_name_id + 1;
            $customer->save();

            $query = Customers::find()->where(['fullname' => $model->fullname])->all();

            return $this->redirect(array('customers/view', 'id'=>$query[0]->id));
        }
        $query = CustomerGroupName::find()->all();
        $customer_group_name = Array();
        foreach ($query as $group_name){
            array_push($customer_group_name, $group_name->name);
        }
        return $this->render('add', [
            'model' => $model,
            'customer_group_name' => $customer_group_name,
        ]);

    }

    public function actionEdit($id) 
    {
//        if (Yii::$app->user->identity->username != 'admin') {
//            return $this->actionError();
//        }
        $customer = Customers::findOne($id);
        $model = new CustomersForm();
        if ($model->load(Yii::$app->request->post())) {

            if (strlen(strval($model->CPP)) != 9 or !is_numeric(strval($model->CPP))){
                Yii::$app->session->setFlash('WrongCPPFormSubmitted');

                return $this->render('edit', [
                    'model' => $model,
                    'customer' => $customer
                ]);

            }
            if (strlen(strval($model->UHH))!= 10 or !is_numeric(strval($model->UHH))){
                Yii::$app->session->setFlash('WrongUHHFormSubmitted');
                return $this->render('edit', [
                    'model' => $model,
                    'customer' => $customer
                ]);

            }
            $query = Customers::find()->where(['UHH' => $model->UHH])->all();
            for ($i = 0; $i < count($query); $i++){
                if ($query[$i]->id != $customer->id ){
                    Yii::$app->session->setFlash('HaveUHHFormSubmitted');
                    return $this->render('edit', [
                        'model' => $model,
                        'customer' => $customer
                    ]);

                }

            }
//            $customers = Customers::find()->all();
            $customer->fullname = $model->fullname;
            $customer->shortname = $model->shortname;
            $customer->leg_address = $model->leg_address;
            $customer->description = $model->description;
            $customer->UHH = $model->UHH;
            $customer->CPP = $model->CPP;
            $customer->doc_type_id = $model->doc_type_id;
            $customer->customer_group_name_id = $model->customer_group_name_id + 1;
            $customer->save();

            $query = Customers::find()->where(['fullname' => $model->fullname])->all();

            
            return $this->redirect(array('customers/view', 'id'=>$query[0]->id));
        }
        $query = CustomerGroupName::find()->orderBy('id')->all();
        $customer_group_name = Array();
        foreach ($query as $group_name){
            array_push($customer_group_name, $group_name->name);
        }
        return $this->render('edit', [
            'model' => $model,
            'customer' => $customer,
            'customer_group_name' => $customer_group_name
        ]);

    }
    public function actionSearchfull()
    {

        $search = Yii::$app->request->get('search');

        $search1 = str_replace(' ','', $search);

        $query = Customers::find()->orFilterWhere(['like', 'replace(shortname, " ", "")', $search1])
            ->orFilterWhere(['like', 'replace(fullname, " ", "")', $search1])
            ->orFilterWhere(['id'=> $search1]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $customers = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'customers' => $customers,
            'pages' => $pages,
            'searchfull' => $search1
        ]);

    }
    public function actionCopeCert(){
        $customers = Customers::find()->all();
        foreach ($customers as $customer){
            $certs = $customer->cert;
            $uzs = $customer->uzs;
        }
    }
    public function actionAssociation($id)
    {
        $pickup = Yii::$app->request->get('pickup');
        if($pickup != NULL){

            $parent = Customers::findOne($id);
            $child = Customers::findOne($pickup);
            $child->parent_id = $id;
            $child->save();

            $certs = $child->cert;
            foreach ($certs as $cert){

                $child_cert = Cert::findOne($cert->id);
                $child_cert->parent_customer = $id;
                $child_cert->save();

                $new_cert = new Cert();
                $new_cert->num = $cert->num;
                $new_cert->st_date = $cert->st_date;
                $new_cert->ex_date = $cert->ex_date;
                $new_cert->sc_link = $cert->sc_link;
                $new_cert->customer_id = $id;
                $new_cert->cert_group_name_id = $cert->cert_group_name_id;
                $new_cert->save();


                $file = fopen(Yii::$app->basePath . '/web/scans/' . $cert->customer_id . '/' . $cert->sc_link, 'rb'); 


                $path = Yii::$app->params['pathUploads'] . 'scans/' . $id . '/';
                FileHelper::createDirectory($path);
                $newfile = fopen($path . '/' . $new_cert->sc_link, 'wb');
                while(($line = fgets($file)) !== false) {
                    fputs($newfile, $line);
                }
                fclose($newfile);
                fclose($file); 

                $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
                $current_date = date('Y-m-d', time());
                $current_date = date('Y-m-d', strtotime( '' . $current_date. '- 60 days'));
                if($new_cert->ex_date <= $temp_ex_date and $new_cert->ex_date >= $current_date)
                {

                    $mail_sended = new Mail;
                    $mail_sended->cert_id = $new_cert->id;
                    $mail_sended->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
                    $mail_sended->sended = false;
                    $mail_sended->save();
                

                }
            }
            $addresses = $child->address;
            foreach ($addresses as $address){

                $new_address = new Address();
                $new_address->region_id = $address->region_id;
                $new_address->district = $address->district;
                $new_address->city = $address->city;
                $new_address->street = $address->street;
                $new_address->num = $address->num;
                $new_address->branch = $address->branch;
                $new_address->customer_id = $id;
                $new_address->child_customer = $pickup;
                $new_address->save();
            }
            $contacts = $child->contacts;
            foreach ($contacts as $contact){

                $new_contact = new Contact();
                $new_contact->name = $contact->name;
                $new_contact->position = $contact->position;
                $new_contact->w_tel = $contact->w_tel;
                $new_contact->m_tel = $contact->m_tel;
                $new_contact->mail = $contact->mail;
                $new_contact->ityn = $contact->ityn;
                $new_contact->description = $contact->description;
                $new_contact->customer_id = $id;
                $new_contact->child_customer = $pickup;
                $new_contact->department = $contact->department;
                $new_contact->save();
            }
            $schemes = $child->scheme;
            foreach ($schemes as $scheme){

                $new_scheme = new Scheme();
                $new_scheme->sc_link = $scheme->sc_link;
                $new_scheme->description = $scheme->description;
                $new_scheme->customer_id = $id;
                $new_scheme->child_customer = $pickup;
                $new_scheme->save();


                $path = Yii::$app->params['pathUploads'] . 'scheme/' . $id . '/';
                FileHelper::createDirectory($path);
                copy(Yii::$app->basePath . '/web/scheme/' . $pickup . '/' . $new_scheme->sc_link, $path . '/' . $new_scheme->sc_link);
              
            }

            $uzs = $child->uzs;
            foreach ($uzs as $uz){

                $new_uz = new Uz();
                $new_uz->type_id = $uz->type_id;
                $new_uz->net_id = $uz->net_id;
                $new_uz->supply_time = $uz->supply_time;
                $new_uz->supply_ex_time = $uz->supply_ex_time;
                $new_uz->description = $uz->description;
                $new_uz->customer_id = $id;
                $new_uz->child_customer = $pickup;
                $new_uz->child_uz = $uz->id;



                $child_cert = $uz->actualcert;
                if ($child_cert != NULL){
                    $query = Cert::find()->andWhere(['num'=>$child_cert->num])->all();
                    $parent_cert = $child_cert;
                    foreach ($query as $cert){
                        if ($parent_cert->id < $cert->id){
                            $parent_cert = $cert;
                        }
                    }
                    $new_uz->support_a = $parent_cert->id;
                }

                $child_address = $uz->address;
                if ($child_address != NULL){
                    $query = Address::find()->andWhere(['region_id' =>$child_address->region_id])
                        ->andWhere(['region_id' =>$child_address->region_id])
                        ->andWhere(['district' =>$child_address->district])
                        ->andWhere(['city' =>$child_address->city])
                        ->andWhere(['street' =>$child_address->street])
                        ->andWhere(['num' =>$child_address->num])
                        ->andWhere(['branch' =>$child_address->branch])
                        ->all();

                    $parent_address = $child_address;
                    foreach ($query as $address){
                        if ($parent_address->id < $address->id){
                            $parent_address = $address;
                        }
                    }
                    $new_uz->address_id = $parent_address->id;
                }

                $new_uz->save();


                $child_certuzs = $uz->certuzs;
                if ($child_certuzs != NULL){
                    $query = Certuz::find()->andWhere(['uz_id' =>$uz->id])->all();
                    foreach ($query as $certuz){
                        $child_cert = $certuz->cert;
                        $query_cert = Cert::find()->andWhere(['num'=>$child_cert->num])->all();
                        $parent_cert_id = NULL;
                        foreach ($query_cert as $cert){
                            if ($cert->id > $child_cert->id){
                                $parent_cert_id = $cert->id;
                            }
                        }
                        $certuz = new CertUz;
                        $certuz->cert_id = $parent_cert_id;
                        $certuz->uz_id = $new_uz->id;
                        $certuz->save();
                    }
                }
            }


            $log_tickets = $child->logTicket;

            foreach ($log_tickets as $log_ticket){
                $new_log_ticket = new LogTicket();
                $new_log_ticket->status = $log_ticket->status;
                $new_log_ticket->reg_date = $log_ticket->reg_date;
                $new_log_ticket->topic = $log_ticket->topic;
                $new_log_ticket->res_person = $log_ticket->res_person;
                $new_log_ticket->kbase_link = $log_ticket->kbase_link;
                $new_log_ticket->priority = $log_ticket->priority;
                $new_log_ticket->type = $log_ticket->type;
                $new_log_ticket->description = $log_ticket->description;
                $new_log_ticket->solution_time= $log_ticket->solution_time;
                $new_log_ticket->customer_id= $id;
                $new_log_ticket->child_customer= $pickup;

                $contact = $log_ticket->contact;
                if ($contact != NULL){
                    $contacts = Contact::find()->andWhere(['name' =>$contact->name])
                        ->andWhere(['position' =>$contact->position])
                        ->andWhere(['w_tel' =>$contact->w_tel])
                        ->andWhere(['m_tel' =>$contact->m_tel])
                        ->andWhere(['mail' =>$contact->mail])
                        ->andWhere(['ityn' =>$contact->ityn])
                        ->andWhere(['description' =>$contact->description])
                        ->andWhere(['department' =>$contact->department])
                        ->all();

                    foreach ($contacts as $c){
                        if ($contact->id < $c->id){
                            $contact = $c;
                        }                        
                    }
                    $new_log_ticket->contact_id = $contact->id;
                }

                $uz = $log_ticket->uz; //Всегд НУЛ!
                if ($uz != NULL){
                    $new_log_ticket->uz_id = $uz->parentUz->id;
                }

                $new_log_ticket->save();

            }

            return $this->redirect(array('customers/view', 'id'=>$id));
        }

        $query = Customers::find()->all();
        $customers = Array();
        foreach ($query as $value)
        {
            if ($value->parent_id == NULL and $value->id != $id){
                array_push($customers, $value->id . ' - ' . $value->fullname);
            }
        }

        return $this->render('association', [
            'customers' => $customers,
            'id' => $id,
        ]);

    }

    public function actionTest(){
        $customers = Customers::find()->all();
        $check = Array();
        foreach ($customers as $customer){
            $shortname =  $customer->shortname;
            if (strpos($shortname, 'ЧУ') !== false or strpos($shortname, 'ООО') !== false or 
                strpos($shortname, 'ЧУЗ') !== false or strpos($shortname, 'НУЗ') !== false or 
                strpos($shortname, 'АО') !== false or strpos($shortname, 'Нефросовет-Ярославль')!== false
                or strpos($shortname, 'Общество с огр')!== false)
            {
                $customer->customer_group_name_id = 2;
            }
            elseif (strpos($shortname, 'КГАУЗ') !== false or strpos($shortname, 'АНО') !== false
                    or strpos($shortname, 'КГАОУ') !== false ){
                $customer->customer_group_name_id = 3;

            }
            else{

                $customer->customer_group_name_id = 1;
            }  
            $customer->save();


            
        }
        return $this->render('test', [
            'customers' => $check
        ]);
    }


    // КГБУЗ - бюджетное

    // КГКУЗ - бюджетное 

    // ФГБУ - бюджетное/федеральное 

    // КГБОУ - бюджетное

    // КГКУ - бюджетное

    // ФГБУЗ - бюджетное/федеральное

    // ТФОМС - бюджетное

    // МЗКК - бюджетное

    // КГБПОУ - бюджетное

    // Агенство государственного заказа Красноярского края - бюджетное

    // ГУ МВД - бюджетное

    // Администрация города Дивногорск - бюджетное

    // Администрация Пировского района - бюджетное

    // ГБУЗ - бюджетное

    // Территориальный орган Росздравнадзора по Красноярскому краю - бюджетное

    // МУ - бюджетное

    // КГАУЗ - автономное

    // АНО - автономное

    // ООО - коммерческое

    // НУЗ - коммерческое

    // ЧУЗ - коммерческое

    // АО - коммерческое

    // Нефросовет-Ярославль - коммерческое

    // ЧУ - коммерческое?


}