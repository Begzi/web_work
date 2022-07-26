<?php


namespace app\controllers;


// use app\models\User;
use app\models\Uz;
use app\models\Cert;
use app\models\Region;
use app\models\Customers;
use app\models\Contact;
use app\models\Scheme;
use app\models\Address;
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
            $customer->save();

            $query = Customers::find()->where(['fullname' => $model->fullname])->all();

            return $this->redirect(array('customers/view', 'id'=>$query[0]->id));
        }
        return $this->render('add', [
            'model' => $model,
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
            $customer->save();

            $query = Customers::find()->where(['fullname' => $model->fullname])->all();

            return $this->redirect(array('customers/view', 'id'=>$query[0]->id));
        }
        return $this->render('edit', [
            'model' => $model,
            'customer' => $customer
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
    public function actionAssociation($id)
    {
        $pickup = Yii::$app->request->get('pickup');
        if($pickup != NULL){

            $parent = Customers::findOne($id);
            $child = Customers::findOne($pickup);

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
                return $file;
            }
            $addresses = $child->address;
            foreach ($addresses as $address){

                $new_address = new Address();
                $new_address->region_id = $address->region_id;
                $new_address->district = $address->district;
                $new_address->city = $address->city;
                $new_address->street = $address->street;
                $new_address->num = $address->supply_ex_time;
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
                $new_address->save();
            }
            $schemes = $child->scheme;
            foreach ($schemes as $scheme){

                $new_scheme = new Scheme();
                $new_scheme->sc_link = $scheme->sc_link;
                $new_scheme->description = $scheme->description;
                $new_scheme->customer_id = $id;
                $new_scheme->child_customer = $pickup;
                $new_scheme->save();
            }

            $uzs = $child->uzs;
            foreach ($uzs as $uz){

                $new_uz = new Uz();
                $new_uz->type_id = $uz->type_id;
                $new_uz->net_id = $uz->net_id;
                $new_uz->supply_time = $uz->supply_time;
                $new_uz->description = $id;
                $new_uz->supply_ex_time = $uz->supply_ex_time;
                $new_uz->child_customer = $uz->child_customer;



                $new_uz->support_a = $cert->ex_date;
                $new_uz->address_id = $cert->ex_date;


                $new_uz->save();
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

}