<?php


namespace app\controllers;


use app\models\Mail;
use app\models\Cert;
use app\models\ExpireForm;
use app\models\CertGroupName;
use app\models\CertGroupNameForm;
use app\models\Customers;
use app\models\CertForm;
use app\models\CerteditForm;
use app\models\CertUz;
use app\models\Uz;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\data\Pagination;
use Yii;

class CertController extends BaseController
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

        $model = new CertForm();

        $customer = Customers::find()->with('uzs')->where(['id' => $customer_id])->one();

        if ($customer->uzs == NULL ){
            Yii::$app->session->setFlash('HaveNotUzs');
            return $this->redirect(array('customers/view', 'id'=>$customer_id));

        }

        $uzs =  Uz::find()->where(['customer_id' => $customer_id])->all();
        if ($model->load(Yii::$app->request->post())) {


            $query = Cert::find()->where(['num' => $model->num])->all();
            if ($query != NULL ){
                Yii::$app->session->setFlash('HaveNum');
                return $this->render('add', [
                    'model' => $model,
                    'customer_id' => $customer_id,
                    'uzs' => $uzs,
                ]);

            }

            $cert = new Cert();
            $cert->sc_link = UploadedFile::getInstance($model, 'sc_link');

            $cert->num = $model->num;
            $cert->st_date = $model->st_date;

            $scanfile_format = substr(strval($cert->sc_link), strpos($cert->sc_link, '.') + 1 - strlen($cert->sc_link));
            if ( $scanfile_format!= 'png' and $scanfile_format != 'pdf'
                    and $scanfile_format != 'jpg' and $scanfile_format != 'jpeg'){

                $check = 'У вашего файла расширение ' . $scanfile_format;
                Yii::$app->session->setFlash('HaveFormatBad');
                return $this->render('add', [
                    'model' => $model,
                    'customer_id' => $customer_id,
                    'uzs' => $uzs,
                    'check' => $check,
                ]);

            }
            if ($cert->validate()) {
                // file is uploaded successfully Туловский Петр отдел ПО сопровождения
                $path = Yii::$app->params['pathUploads'] . 'scans/' . $customer_id . '/';
                FileHelper::createDirectory($path);
                $cert->sc_link->saveAs( $path  . $cert->num . '-' . $cert->sc_link );
                $cert->sc_link =  $cert->num . '-' . $cert->sc_link ;
            }
        

            if (date('m-d', strtotime($cert->st_date)) == '01-01'){
                $cert->ex_date = date('Y-m-d', strtotime(''.$cert->st_date.'+1 year - 1 day'));
            }
            else {
                $cert->ex_date = date('Y-m-d', strtotime(''.$cert->st_date.'+1 year'));
            }
            $cert->customer_id = $customer_id;
            $cert->save();


            $cert_group_check = Cert::find()->where(['ex_date' => $cert->ex_date])->all();
            if (count($cert_group_check) > 1)
            {                
                if (count($cert_group_check) == 2)
                {
                    $cert_group_name = new CertGroupName;
                    $cert_group_name->name = 'Добавлена гурппа ' . date('Y-m-d', time());
                    $cert_group_name->ex_date = $cert->ex_date;
                    $cert_group_name->save();                    
                }

                $cert_group_name = CertGroupName::find()->where(['ex_date' => $cert->ex_date])->one();

                if (count($cert_group_check) == 2) //Группа создалась впервые, поэтому тот сертификат который был он не знает что появилась группа
                {
                    for ($i = 0; $i < count($cert_group_check); $i++) //все сертификаты (2 сертификата)
                    {
                        $cert_group_check[$i]->cert_group_name_id = $cert_group_name->id;
                        $cert_group_check[$i]->save();
                    }
                }
                else
                {  // Тут группа уже есть, предыдущие сертификаты знают свою группу, но новый введённый нет
                    $cert =  Cert::find()->where(['num' => $model->num])->one();
                    $cert->cert_group_name_id = $cert_group_name->id;
                    $cert->save();

                }

            }
            for ($i = 0; $i < count($model->uzs_box); $i++){
                $certuz = new CertUz();
                $certuz->cert_id = $cert->id;
                $certuz->uz_id = $model->uzs_box[$i];
                $certuz->save();
                $uzs =  Uz::find()->where(['id' => $model->uzs_box[$i]])->one();
                $uzs->support_a = $cert->id;
                $uzs->save();
            }

            return $this->redirect(array('customers/view', 'id'=>$customer_id));

        }
        return $this->render('add', [
            'model' => $model,
            'customer_id' => $customer_id,
            'uzs' => $uzs,
        ]);
    }

    public function actionShow() 
    {
        $query = Cert::find()->with('customer')->with('certuzs')
            ->orderBy('ex_date DESC');
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $cert = $query->offset($pages->offset)->limit($pages->limit)->all();



        Yii::$app->session->setFlash('search_all');


        return $this->render('show', compact('cert', 'pages'));
    }

    public function actionSearchfull()
    {
        $search = Yii::$app->request->get('search');



        $search = Yii::$app->request->get('search');
        $search_range_num = strpos($search, '***');
        $search_check = substr($search, - (strlen($search) - $search_range_num - 3));
        $search = substr($search, 0, $search_range_num );
        $search1 = str_replace(' ','', $search);
        if ($search_check == "По умлочанию"){

            $querycustomer = Customers::find()->where(['like', 'replace(shortname, " ", "")', $search1])->one();

            $query = Cert::find()->with('customer')->orFilterwhere(['like', 'replace(num, " ", "")', $search])
            ->orFilterWhere(['id'=> $search1])
            ->orFilterWhere(['customer_id'=> $querycustomer->id])
            ->orderBy('ex_date DESC');
        }
        elseif ($search_check == "Заказчик"){
            // return 1;
             $query = Cert::find()->with('customer')->joinWith(['customer'] )
             ->andFilterWhere(['like', 'replace(shortname, " ", "")', $search1])
             ->orderBy('ex_date DESC');

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

       

            $query = Cert::find()
                ->andWhere(['<', 'ex_date', $search_date_end])
                ->andWhere(['>', 'ex_date', $search_date_from])
                ->with('customer')
                ->joinWith(['customer'] )
                ->andFilterWhere(['like', 'replace(shortname, " ", "")', $search1])
                ->orderBy('ex_date DESC');

            if ($search1 == '' or $search1 == ' '){
                $search = 'date';
            }

        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $cert = $query->offset($pages->offset)->limit($pages->limit)->all();
        Yii::$app->session->setFlash('search_all');
        return $this->render('show', [
            'cert' => $cert,
            'pages' => $pages,
            'searchfull' => $search
        ]);

    }
    public function actionSearch30()
    {

        
        $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        $current_date = date('Y-m-d', time());

        $query = Cert::find()->with('customer')->andWhere(['>', 'ex_date', $current_date])
                            ->andWhere(['<', 'ex_date', $temp_ex_date]);

        
        Yii::$app->session->setFlash('30clicked');

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $cert = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('show', [
            'cert' => $cert,
            'pages' => $pages,
            'searchfull' => $search1
        ]);

    }
    

    public function actionGrouponeshow($id) 
    {


        $modelcert = new ExpireForm();
        if ($modelcert->load(Yii::$app->request->post())) 
        {
            $mail_id = strstr($modelcert->next_step, ' - ', true);

            $query = Mail::findOne($mail_id);
            $text = preg_replace( "#\r?\n#", "<br />", $modelcert->text );
            Yii::$app->mailer->compose()
                ->setFrom(['support@pik-b.ru'])
                ->setTo('begzi@pik-b.ru')
                ->setSubject($modelcert->mail)
                ->setHtmlBody($text . $modelcert->mail)
                ->send();
            $query->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
            $query->sended = true;
            $query->save(); 

        }
        $certGroupName = CertGroupName::findOne($id);
        $query = Cert::find()->where(['cert_group_name_id' => $certGroupName->id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $cert = $query->offset($pages->offset)->limit($pages->limit)->all();
        $name_group = $certGroupName->name;
        Yii::$app->session->setFlash('groupOne');
        Yii::$app->session->setFlash('30clicked');
        Yii::$app->session->setFlash('search_all');


        $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        $current_date = date('Y-m-d', time());
        $current_date = date('Y-m-d', strtotime( '' . $current_date. '- 60 days'));
        if (($cert[0]->ex_date < $temp_ex_date) and ($cert[0]->ex_date > $current_date))
        {
            Yii::$app->session->setFlash('groupOneEnding');            
        }

        return $this->render('show', compact('cert', 'pages', 'certGroupName', 'modelcert'));
    }

    public function actionGroupshow()
    {
        $query = CertGroupName::find()->orderBy(['ex_date' => SORT_DESC]);

        

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $cert_group = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('groupshow', [
            'cert_group' => $cert_group,
            'pages' => $pages,
            'searchfull' => $search1
        ]);

    }

    public function actionGroupedit($group_id)
    {

        $model = new CertGroupNameForm;
        if ($model->load(Yii::$app->request->post())) 
        {
            $query_group = CertGroupName::findOne($group_id);
            $query_group->name = $model->name;
            $query_group->save();
        }
        $current_date = date('Y-m-d', strtotime(' - 60 days'));
        // $current_date = $current_date->m
        $query = Cert::find()->AndWhere(['>', 'ex_date', $current_date])
                                ->AndWhere(['<>', 'cert_group_name_id', $group_id]);
        $query1 = Cert::find()->where(['=', 'cert_group_name_id', $group_id]);
        

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15, 'pageParam' => 'first']);
        $cert = $query->offset($pages->offset)->limit($pages->limit)->all();

        $pages1 = new Pagination(['totalCount' => $query1->count(), 'pageSize' => 15, 'pageParam' => 'second']);
        $cert1 = $query1->offset($pages1->offset)->limit($pages1->limit)->all();
        $group_name = $cert1[0]->certgroupname->name;
        return $this->render('groupedit', [
            'cert' => $cert,
            'pages' => $pages,
            'cert1' => $cert1,
            'pages1' => $pages1,
            'searchfull' => $search1,
            'group_id' => $group_id,
            'group_name' => $group_name,
            'model' => $model,
        ]);

    }

    public function actionGroupeditplus($cert_id, $group_id)
    {

        $query = Cert::findOne($cert_id);
        $query->cert_group_name_id = $group_id;
        $query->save();

        return $this->redirect(array('cert/groupedit', 'group_id'=>$group_id));

    }
    public function actionGroupeditminus($cert_id, $group_id)
    {

        $query = Cert::findOne($cert_id);
        $query->cert_group_name_id = 0;
        $query->save();  
        return $this->redirect(array('cert/groupedit', 'group_id'=>$group_id));

    }
    public function actionCertgroupdelete($group_id)
    {
        $group_name = CertGroupName::find()->with('cert')->where(['id' => $group_id])->one();
        for ($i = 0; $i < count($group_name->cert); $i++)
        {
            $query = Cert::findOne($group_name->cert[$i]->id);
            $query->cert_group_name_id = NULL;
            $query->save();    
        }
        $group_name->delete(); 
        return $this->redirect(array('cert/groupshow'));

    }

    public function actionCertpdf()
    {
        // $certs_group = CertGroupName::find()->all();
        // foreach ($certs_group as $group){
        //     $group->delete();
        // }
        // $certs = Cert::find()->where(['>', 'ex_date', date('Y-m-d', strtotime('- year'))])->all();
        // for ($i = 0; $i < count($certs); $i++){
        //     $query = Cert::find()->where(['=', 'ex_date', $certs[$i]->ex_date])->all();            
        //     if (count($query) != 1){
        //         $query2 = CertGroupName::find()->where(['=', 'ex_date', $certs[$i]->ex_date])->one();
        //         if ($query2 != NULL){
        //             $certs[$i]->cert_group_name_id = $query2->id;
        //             $certs[$i]->save();   
        //         }
        //         else{
        //             $group_name = new CertGroupName();
        //             $group_name->name = 'Добавлена группа ' . date('Y-m-d');
        //             $group_name->ex_date = $certs[$i]->ex_date;
        //             $group_name->save();
        //             $certs[$i]->cert_group_name_id = $group_name->id;
        //             $certs[$i]->save();                    
        //         }
        //     }
        // }
        // return 123;


        $certs = Cert::find()->all();
        for ($i = 0; $i < count($certs); $i++){

            $certs[$i]->sc_link = $certs[$i]->sc_link . '.' . $certs[$i]->scanfile_format;
            $certs[$i]->save();

        }
        return 123;
    }
    public function actionDelete($id)
    {
        $customer_id = $cert->customer_id;
        $cert = Cert::find()->with('certuzs')->with('certgroupname')->where(['id' => $id])->one();

        unlink(Yii::$app->basePath . '/web/scans/' . $cert->customer_id . '/' . $cert->sc_link);    

        foreach ($cert->certuzs as $certuz){
            if ($certuz->uz->actualcert->id == $cert->id){
                $uz = Uz::findOne($certuz->uz->id);
                if (count($uz->certuzs) != 1){
                    $uz->support_a = $uz->certuzs[count($uz->certuzs) - 2]->cert_id;
                    $uz->save();
                }
                else{
                    $uz->support_a = NULL;
                    $uz->save();
                }
            }
            $certuz->delete();
        }

        $cert_group_name = CertGroupName::find()->where(['ex_date' => $cert->ex_date])->one();

        if ($cert_group_name != NULL)
        {
            if (count($cert_group_name->cert) == 2)
            {
                
                $querys = Cert::find()->where(['=', 'cert_group_name_id', $cert_group_name->id])->all();
                foreach ($querys as $query_cert){
                    $query_cert->cert_group_name_id = NULL;
                    $query_cert->save();
                }                 
                $cert_group_name->delete(); 
            }
        }
        $customer_id = $cert->customer_id;
        $cert->delete();

        return $this->redirect(array('customers/view', 'id'=>$customer_id));

        
    }
    public function actionEdit($id)
    {
        $cert = Cert::findOne($id);

        $model = new CerteditForm();



        if ($model->load(Yii::$app->request->post())) 
        {


            $cert->num = $model->num;
            $past_ex_date = $cert->ex_date;
            $cert->st_date = $model->st_date;

            if (date('m-d', strtotime($cert->st_date)) == '01-01')//Так нужно по документации компании
            {
                $cert->ex_date = date('Y-m-d', strtotime(''.$cert->st_date.'+1 year - 1 day'));
            }
            else 
            {
                $cert->ex_date = date('Y-m-d', strtotime(''.$cert->st_date.'+1 year'));
            }

            if ($cert->st_date != $past_st_date)//Проверка если дата изменилась, то если есть старая группа, её надо распустить
            {                
                $cert_group_name = CertGroupName::find()->where(['ex_date' => $past_ex_date])->one();

                if ($cert_group_name != NULL)
                {
                    $cert->cert_group_name_id = NULL;
                    if (count($cert_group_name->cert) == 2)
                    {
                        $querys = Cert::find()->where(['=', 'cert_group_name_id', $cert_group_name->id])->all();
                        foreach ($querys as $query_cert){
                            $query_cert->cert_group_name_id = NULL;
                            $query_cert->save();
                        }  
                        $cert_group_name->delete(); 
                    }
                }

            }

            $cert->save();


            $cert_group_check = Cert::find()->where(['ex_date' => $cert->ex_date])->all();
            if (count($cert_group_check) > 1)  // Группировка сертификатов, по дате
            {                
                if (count($cert_group_check) == 2)
                {
                    $cert_group_name = new CertGroupName;
                    $cert_group_name->name = 'Добавлена гурппа ' . date('Y-m-d', time());
                    $cert_group_name->ex_date = $cert->ex_date;
                    $cert_group_name->save();                    
                }

                $cert_group_name = CertGroupName::find()->where(['ex_date' => $cert->ex_date])->one();

                if (count($cert_group_check) == 2)
                {
                    for ($i = 0; $i < count($cert_group_check); $i++)
                    {
                        $cert_group_check[$i]->cert_group_name_id = $cert_group_name->id;
                        $cert_group_check[$i]->save();
                    }
                }
                else
                {
                    $cert =  Cert::find()->where(['num' => $model->num])->one();
                    $cert->cert_group_name_id = $cert_group_name->id;
                    $cert->save();

                }

            }

            return $this->redirect(array('customers/view', 'id'=>$cert->customer_id));

        }
        return $this->render('edit', [
            'model' => $model,
            'cert' => $cert,
        ]);
    }



    public function actionRole() 
    {


        // $quertyGroup = CertGroupName::find()->all(); Чтобы каждый сертификат знал свою группу

        // foreach ($quertyGroup as $group_name)
        // {
        //     // foreach ($group_name->certgroup as $cert)
        //     // {
        //     //     $query = Cert::findOne($cert->id);
        //     //     $query->cert_group_name_id = $cert->certgroup->group_id;
        //     //     $query->save();

        //     // }
        //     for ($i = 0; $i < count($group_name->certgroup); $i++)
        //     {
        //         $query = Cert::findOne($group_name->certgroup[$i]->cert_id);
        //         $query->cert_group_name_id = $group_name->certgroup[$i]->group_id;
        //         $query->save();

        //     }
        // }

        // return 123;

        // $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        // $current_date = date('Y-m-d', time());
        // // $certs = Cert::find()->all();

        // $query = Cert::find()->andWhere(['>', 'ex_date', $current_date])
        //                     ->andWhere(['<', 'ex_date', $temp_ex_date])->all();
        // $queryGroup = CertGroupName::find()->andWhere(['>', 'ex_date', $current_date])
        //                     ->andWhere(['<', 'ex_date', $temp_ex_date])->all();

        // for ($j = 0; $j < count($queryGroup); $j++)
        // {
        //     for ($i = 0; $i < count($query); $i++)
        //     {
        //         if ($queryGroup[$j]->ex_date == $query[$i]->ex_date)
        //         {
        //             $query[$i] = NULL;
        //         }
        //     }
        // }
        // for ($i = 0; $i < count($query); $i++)
        // {
        //     if ($query[$i] != NULL)
        //     {
        //         array_push($queryGroup,$query[$i]);
        //     }
        // }
        
        // return $this->render('tmp', [
        //     'queryGroup' => $queryGroup,
        // ]);
    }


}