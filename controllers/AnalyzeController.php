<?php


namespace app\controllers;


use app\models\Uz;
use app\models\UzNet;
use app\models\UzType;
use app\models\UzTypeCategoria;
use app\models\Cert;
use app\models\Customers;
use app\models\CustomerGroupName;
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

        $search = Yii::$app->request->get('search');
        if ($search != NULL and $search != 'Пустота'){
            // $search = str_replace(" ", '', $search);
            $current_date = date('Y-m-d h:i', time());

            $search_range_num = strpos($search, '***');
            $search_check = substr($search, - (strlen($search) - $search_range_num - 3));
            $search1 = substr($search, 0, $search_range_num );
            if ($search1 == "Заказчики"){
                Yii::$app->session->setFlash('Customer');

                $search_range_num = strpos($search_check, '***');
                $search_group = substr($search_check, 0, $search_range_num );
                $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));                

                $search_range_num = strpos($search_check, '***');
                $search_number_net = substr($search_check, 0, $search_range_num );
                $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));                

                $search_range_num = strpos($search_check, '***');
                $search_uz_type = substr($search_check, 0, $search_range_num );
                $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));

                // тут иф был для проверки серч груп не равен нулл, туда никогда б не заходили
                if ($search_number_net == $search_uz_type){ //Пустота и Пустота

                    $search_uz_cert = $search_check;  // Тут не выбраны сеть и тип

                    if ($search_uz_cert == 'Все узлы'){
                        if ($search_group == 'Пустота'){
                            $query = Customers::find()->with('uzs');
                        }
                        else{
                            $query = Customers::find()->andWhere(['customer_group_name_id' => $search_group]);
                        }

                    }
                    else{
                        if ($search_group == 'Пустота'){
                            $query = Customers::find()->with('uzs')->all();
                        }
                        else{
                            $query = Customers::find()->andWhere(['customer_group_name_id' => $search_group])->all();
                        }
                        Yii::$app->session->setFlash('TechWithoutPoint');
                        $customers=Array();
                        for ($i = 0; $i < count($query); $i++){
                            $uzs = $query[$i]->uzs;
                            $k = 0;
                            foreach ($uzs as $uz){
                                if ($uz->actualcert->ex_date > $current_date){
                                    $k++;
                                }
                            }
                            if ($search_uz_cert == 'Узлы с тех поддержкой'){
                                if ($k != 0){
                                    array_push($customers, $query[$i]);
                                }                                    
                            }
                            elseif ($search_uz_cert == 'Узлы без тех поддержки'){
                                if ($k == 0){
                                    array_push($customers, $query[$i]);
                                }   
                            }
                        }
                    }
                }
                else{
                    // тут выбраны тип либо сеть, либо оба
                    $customers = [];
                    Yii::$app->session->setFlash('TechWithoutPoint');

                    $search_range_num = strpos($search_check, '***');
                    $search_uz_cert = substr($search_check, 0, $search_range_num );
                    $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3)); 

                    $search_opion_3_1 = $search_opion_3_2 = NULL;
                    $search_range_num = strpos($search_check, '***');
                    
                    if (!$search_range_num){ // если '***' нету, то выбрана 1 из нет и тип
                        if ($search_number_net == 'Номер сети') // стали не равные нулл нулл, то есть либо номер сети у серч намбер
                        // либо у серча тип что то другое
                        {
                            $search_opion_3_1 = $search_check;
                        }
                        else{

                            $search_opion_3_2 = 'MePicked';
                            $search_opion_3_1 = $search_check;
                        }
                    }
                    else{  //тут выбраны 2 нет и тип
                        
                        $search_opion_3_1 = substr($search_check, 0, $search_range_num );
                        $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));
                        $search_opion_3_2 = $search_check;
                    } 

                    if ($search_group == 'Пустота'){
                        $query = Customers::find()->with('uzs')->all();                                                           
                    }
                    else{
                        $query = Customers::find()->andWhere(['customer_group_name_id' => $search_group])->all();
                    }
                    if ($search_uz_cert == 'Все узлы'){
                        for ($i = 0; $i < count($query); $i++){
                            $k = 0;
                            $uzs = $query[$i]->uzs;
                            foreach ($uzs as $uz){

                                if ($search_opion_3_2 == NULL ){ //net_id
                                    if ($uz->net_id == $search_opion_3_1){
                                        $k++;
                                    }
                                }
                                elseif ($search_opion_3_2 == 'MePicked'){
                                    if ($search_uz_type == 'Тип узла'){
                                        if ($uz->type_id == $search_opion_3_1){
                                            $k++;
                                        }
                                    }
                                    else{
                                        if ($uz->uztype->type == $search_opion_3_1){
                                            $k++;
                                        }
                                    }
                                }
                                else{
                                    if ($search_uz_type == 'Тип узла'){
                                        if ($uz->type_id == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                            // return $uz->uznet->name;
                                            $k++;
                                        }
                                    }
                                    else{
                                        if ($uz->uztype->type == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                            $k++;
                                        }
                                    }                                           
                                }
                            }
                            if ($k != 0){
                                array_push($customers,$query[$i]);
                            }
                        } 

                    }
                    else{

                        for ($i = 0; $i < count($query); $i++){
                            $uzs = $query[$i]->uzs;
                            $k_check_cert = 0;
                            $k_check_uz_type = 0; //если нету такого узла и сертификата не будет
                            foreach ($uzs as $uz){

                                if ($uz->actualcert->ex_date > $current_date){
                                    if ($search_opion_3_2 == NULL ){ //net_id
                                        if ($uz->net_id == $search_opion_3_1){
                                            $k_check_cert++;
                                        }
                                    }
                                    elseif ($search_opion_3_2 == 'MePicked'){
                                        if ($search_uz_type == 'Тип узла'){
                                            if ($uz->type_id == $search_opion_3_1){
                                                $k_check_cert++;
                                            }
                                        }
                                        else{
                                            if ($uz->uztype->type == $search_opion_3_1){
                                                $k_check_cert++;
                                            }
                                        }
                                    }
                                    else{
                                        if ($search_uz_type == 'Тип узла'){
                                            if ($uz->type_id == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                // return $uz->uznet->name;
                                                $k_check_cert++;
                                            }
                                        }
                                        else{
                                            if ($uz->uztype->type == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                $k_check_cert++;
                                            }
                                        }                                           
                                    }
                                }
                                else{
                                    if ($search_opion_3_2 == NULL ){ //net_id
                                        if ($uz->net_id == $search_opion_3_1){
                                            $k_check_uz_type++;
                                        }
                                    }
                                    elseif ($search_opion_3_2 == 'MePicked'){
                                        if ($search_uz_type == 'Тип узла'){
                                            if ($uz->type_id == $search_opion_3_1){
                                                $k_check_uz_type++;
                                            }
                                        }
                                        else{
                                            if ($uz->uztype->type == $search_opion_3_1){
                                                $k_check_uz_type++;
                                            }
                                        }
                                    }
                                    else{
                                        if ($search_uz_type == 'Тип узла'){
                                            if ($uz->type_id == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                // return $uz->uznet->name;
                                                $k_check_uz_type++;
                                            }
                                        }
                                        else{
                                            if ($uz->uztype->type == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                $k_check_uz_type++;
                                            }
                                        }                                           
                                    }                                    
                                }
                            }
                            if ($search_uz_cert == 'Узлы с тех поддержкой'){
                                if ($k_check_cert != 0){
                                    array_push($customers, $query[$i]);
                                }                                    
                            }
                            elseif ($search_uz_cert == 'Узлы без тех поддержки'){
                                if ($k_check_cert == 0 and $k_check_uz_type != 0){
                                    array_push($customers, $query[$i]);
                                }   
                            }
                        }                        
                    }
                }

                $search = $search1 . $search_group;
            }
            else{
                Yii::$app->session->setFlash('Uz');

                $search_range_num = strpos($search_check, '***');
                $search_number_net = substr($search_check, 0, $search_range_num );
                $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));                

                $search_range_num = strpos($search_check, '***');
                $search_uz_type = substr($search_check, 0, $search_range_num );
                $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));

                // тут иф был для проверки серч груп не равен нулл, туда никогда б не заходили
                if ($search_number_net == $search_uz_type){ //Пустота и Пустота

                    $search_uz_cert = $search_check;  // Тут не выбраны сеть и тип, но может быть ещё даты

                    if ($search_uz_cert == 'Все узлы'){
                        $query = Uz::find();
                        

                    }
                    else{
                        
                        $query = Uz::find()->all();
                        
                        Yii::$app->session->setFlash('TechWithoutPoint');
                        $customers=Array();

                        if ($search_uz_cert == 'Узлы с тех поддержкой'){
                            foreach ($query as $uz){
                                if ($uz->actualcert->ex_date >= $current_date){
                                    array_push($customers, $uz);
                                }
                            }
                        }
                        elseif ($search_uz_cert == 'Узлы без тех поддержки'){
                            foreach ($query as $uz){
                                if ($uz->actualcert->ex_date < $current_date){
                                    array_push($customers, $uz);
                                }
                            }
                        }
                        else{//date
                            $search_range_num = strpos($search_check, '***');
                            $search_uz_cert = substr($search_check, 0, $search_range_num );
                            $search_date = substr($search_check, - (strlen($search_check) - $search_range_num - 3));

                            $search_range_num = strpos($search_date, '***');
                            $search_date_from = substr($search_date, 0, $search_range_num );
                            $search_date_end = substr($search_date, - (strlen($search_date) - $search_range_num - 3));


                            foreach ($query as $uz){
                                if ($uz->actualcert->ex_date <= $search_date_end and $uz->actualcert->ex_date >= $search_date_from){
                                    array_push($customers, $uz);
                                }
                            }
                        }                        
                    }
                }
                else{
                    // тут выбраны тип либо сеть, либо оба
                    $customers = [];
                    Yii::$app->session->setFlash('TechWithoutPoint');

                    $search_range_num = strpos($search_check, '***');
                    $search_uz_cert = substr($search_check, 0, $search_range_num );
                    $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3)); 

                    $search_opion_3_1 = $search_opion_3_2 = NULL;
                    $search_range_num = strpos($search_check, '***');
                    if ($search_uz_cert != 'По дате'){ 
                        if (!$search_range_num){ // если '***' нету, то выбрана 1 из нет и тип
                            if ($search_number_net == 'Номер сети') // стали не равные нулл нулл, то есть либо номер сети у серч намбер
                            // либо у серча тип что то другое
                            {
                                $search_opion_3_1 = $search_check;
                            }
                            else{

                                $search_opion_3_2 = 'MePicked';
                                $search_opion_3_1 = $search_check;
                            }
                        }
                        else{  //тут выбраны 2 нет и тип 
                            
                            $search_opion_3_1 = substr($search_check, 0, $search_range_num );
                            $search_check = substr($search_check, - (strlen($search_check) - $search_range_num - 3));
                            $search_opion_3_2 = $search_check;
                        } 

                        $query = Uz::find()->all();   

                        if ($search_uz_cert == 'Все узлы'){
                            foreach ($query as $uz){

                                if ($search_opion_3_2 == NULL ){ //net_id
                                    if ($uz->net_id == $search_opion_3_1){
                                        
                                        array_push($customers,$uz);
                                    }
                                }
                                elseif ($search_opion_3_2 == 'MePicked'){
                                    if ($search_uz_type == 'Тип узла'){
                                        if ($uz->type_id == $search_opion_3_1){
                                            array_push($customers,$uz);
                                        }
                                    }
                                    else{
                                        if ($uz->uztype->type == $search_opion_3_1){
                                            array_push($customers,$uz);
                                        }
                                    }
                                }
                                else{
                                    if ($search_uz_type == 'Тип узла'){
                                        if ($uz->type_id == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                            // return $uz->uznet->name;
                                            array_push($customers,$uz);
                                        }
                                    }
                                    else{
                                        if ($uz->uztype->type == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                            array_push($customers,$uz);
                                        }
                                    }                                           
                                }
                            }   
                        }
                        else{
                            foreach ($query as $uz){

                                if ($uz->actualcert->ex_date > $current_date){

                                    if ($search_uz_cert == 'Узлы с тех поддержкой'){
                                        if ($search_opion_3_2 == NULL ){ //net_id
                                            if ($uz->net_id == $search_opion_3_1){
                                                array_push($customers,$uz);
                                            }
                                        }
                                        elseif ($search_opion_3_2 == 'MePicked'){
                                            if ($search_uz_type == 'Тип узла'){
                                                if ($uz->type_id == $search_opion_3_1){
                                                    array_push($customers,$uz);
                                                }
                                            }
                                            else{
                                                if ($uz->uztype->type == $search_opion_3_1){
                                                    array_push($customers,$uz);
                                                }
                                            }
                                        }
                                        else{
                                            if ($search_uz_type == 'Тип узла'){
                                                if ($uz->type_id == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                    // return $uz->uznet->name;
                                                    array_push($customers,$uz);
                                                }
                                            }
                                            else{
                                                if ($uz->uztype->type == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                    array_push($customers,$uz);
                                                }
                                            }                                           
                                        }
                                    }
                                }
                                else{
                                    if ($search_uz_cert == 'Узлы без тех поддержки'){
                                        if ($search_opion_3_2 == NULL ){ //net_id
                                            if ($uz->net_id == $search_opion_3_1){
                                                array_push($customers,$uz);
                                            }
                                        }
                                        elseif ($search_opion_3_2 == 'MePicked'){
                                            if ($search_uz_type == 'Тип узла'){
                                                if ($uz->type_id == $search_opion_3_1){
                                                    array_push($customers,$uz);
                                                }
                                            }
                                            else{
                                                if ($uz->uztype->type == $search_opion_3_1){
                                                    array_push($customers,$uz);
                                                }
                                            }
                                        }
                                        else{
                                            if ($search_uz_type == 'Тип узла'){
                                                if ($uz->type_id == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                    // return $uz->uznet->name;
                                                    array_push($customers,$uz);
                                                }
                                            }
                                            else{
                                                if ($uz->uztype->type == $search_opion_3_2 and $uz->net_id == $search_opion_3_1){
                                                    array_push($customers,$uz);
                                                }
                                            }                                           
                                        }   
                                    }                                 
                                }
                            }                     
                        }
                    }
                }
            }

        }
        else{
            Yii::$app->session->setFlash('Customer');
            $query = Customers::find();
        }
        if (Yii::$app->session->hasFlash('TechWithoutPoint')){

        } 
        else{
            $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
            $customers = $query->offset($pages->offset)->limit($pages->limit)->all();
        }
        $typecategoria = UzTypeCategoria::find()->all();
        $type = UzType::find()->all();
        $net = UzNet::find()->all();
        $group_customer = CustomerGroupName::find()->all();
        
        return $this->render('index', compact('customers', 'pages', 'typecategoria', 'type', 'net', 'group_customer', 'search'));
    }
}