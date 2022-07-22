<?php


namespace app\controllers;


use app\models\Cert;
use app\models\CertGroup;
use app\models\CertGroupName;
use app\models\Customers;
use app\models\CertForm;
use app\models\CertGroupNameForm;
use app\models\CertUz;
use app\models\Uz;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\Mail;
use app\models\MailBase;
use Yii;

class NewcertController extends BaseController
{
      
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['WEB'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()//надо чтобы сам создавал NewCert записи, он пока не может
    {
        $cert = Cert::find()->asArray()->all();
        $customers = Customers::find()->asArray()->all();
        $k = 1;
        for ($i = 0; $i < count($cert); $i++)
        {
            $query = NewCert::find()->where(['num' => $cert[$i]['num']])->one();
            if ($query == null)
            {
                $newcert = new NewCert();
                $newcert->id = $k;
                $newcert->num = $cert[$i]['num'];
                $newcert->ex_date = $cert[$i]['ex_date'];
                $newcert->st_date = $cert[$i]['st_date'];
                $newcert->sc_link = $cert[$i]['sc_link'];
                $newcert->scanfile_format = $cert[$i]['scanfile_format'];
                $newcert->customer_id = $cert[$i]['customer_id'];
                $newcert->save();
                //newcert ничего нет внутри. ДУмать как в новые передавать!
                $k++;

            }

        }
        $cert = NewCert::find()->asArray()->all();
        return $this->render('index', compact('customers', 'cert'));
    }
    public function actionCheck()// перед использованием этой кнопки нужно использовать кнопку выше, сертификаты привести в нормальный вид и потом их же и использовать
        //надо будет newcert переименовать в обычный cert. Очень важно
    {
        $cert = Cert::find()->asArray()->all();
        $newcert = NewCert::find()->asArray()->all();
        $customers = Customers::find()->asArray()->all();
        $uzs = Uz::find()->asArray()->all();


        for ($i = 0; $i < count($cert); $i++)
        {
            for ($j = 0; $j < count($uzs); $j++)
            {
                if ($cert[$i]['uz_id'] == $uzs[$j]['id'])
                {
                    $query = NewCert::find()->where(['num' => $cert[$i]['num']])->one();
                    $certuzs = new CertUz();
                    $certuzs->cert_id = $query->id;
                    $certuzs->uz_id = $uzs[$j]['id'];
                    $certuzs->save();
                }
            }
        }


        return $this->render('check', compact('customers'));
    }
    public function actionKatya()
    {
        $uzs = Uz::find()
            ->where(['net_id' => 2])
            ->all();

        return $this->render('katya', compact('uzs'));
    }

    public function actionKonstantin()
    {
        $customer = Customers::find()
            ->all();
        $check1='Красноярск,';
        $check2='Красноярск ';
        $check3='Красноярск.';
        $uzs = array();
        for ($i=0; $i < count($customer); $i++){

            $pos1 = strripos($customer[$i]->address, $check1);
            $pos2 = strripos($customer[$i]->address, $check2);
            $pos3 = strripos($customer[$i]->address, $check3);

            if ($pos1 === true or $pos2 === true or $pos3 === true ){
                array_merge($uzs, $customer->uzs);
            }

        }
        return $this->render('konstantin', compact('uzs', 'customer'));
    }
    public function actionNewcertuz()
    {
        $uzs = Uz::find()->all();
        foreach ($uzs as $value)
        {
            $value->support_a = $value->certuzs[count($value->certuzs) - 1]->cert->id;
            $value->save();
        }
        return $this->redirect(array('customers/index'));
    }
    public function actionDoc()
    {
        $customers = Customers::find()->all();
        foreach ($customers as $value)
        {
            if ($value->doc_type_id < 2)
            {
                $value->doc_type_id = $value->doc_type_id + 1;
                $value->save();
            }
        }
        return $this->redirect(array('customers/index'));
    }

    public function actionCreatgroup()
    {

    }

    public function actionCert_group()
    {

        $current_date = date('Y-m-d', time());
        $current_date = date('Y-m-d', strtotime( '' . $current_date. '- 60 days'));
        // $certs = Cert::find()->all();

        $query = Cert::find()->andWhere(['>', 'ex_date', $current_date])->all();
        for ($j = 0; $j < count($query); $j++)
        {
            for ($i = 0; $i < count($query); $i++)
            {
                if ($query[$j]->st_date < $query[$i]->st_date)
                {
                    $tmp = $query[$j];
                    $query[$j] = $query[$i];
                    $query[$i] = $tmp;
                } 
            }
        
        }
        $tmp_array_2d = Array();
        $tmp_array_3d = Array();
        $bool = false;
        for ($i = 0; $i < count($query) - 1; $i++)
        {
            if ($query[$i]->ex_date == $query[$i + 1]->ex_date)
            {
                array_push($tmp_array_2d, $query[$i]);
                $bool = true;
            }
            elseif ($bool)
            {
                array_push($tmp_array_2d, $query[$i]);
                array_push($tmp_array_3d, $tmp_array_2d);
                $tmp_array_2d = Array();
                $bool = false; // 
            }
        }
        for ($j = 0; $j < count($tmp_array_3d); $j++)
        {

            $group = CertGroupName::find()->orFilterWhere(['ex_date' => $tmp_array_3d[$j][0]->ex_date])->all();
            if ($group == NULL)
            {
                $group = new CertGroupName;
                $group->ex_date = $tmp_array_3d[$j][0]->ex_date;
                $group->name = $j;
                $group->save();
            
                for ($i = 0; $i < count($tmp_array_3d[$j]); $i++)
                {
                    $cert = Cert::findOne($tmp_array_3d[$j][$i]->id);
                    $cert->cert_group_name_id = $group->id;
                    $cert->save();
                }
            }
        }
        return $this->render('cert_group', [
            'query' => $query,
            'tmp_array_3d' => $tmp_array_3d,
        ]);
    }


    public function actionCreatemail()
    {
        $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        $current_date = date('Y-m-d h:i', time());
        $current_date = date('Y-m-d', strtotime( '' . $current_date. '- 60 days'));

        $certs = Cert::find()->andWhere(['>', 'ex_date', $current_date])
                            ->andWhere(['<', 'ex_date', $temp_ex_date])->all();

        foreach ($certs as $cert)
        {
            if(Mail::find()->where(['cert_id' => $cert->id])->all() == NULL)
            {

                $mail_sended = new Mail;
                $mail_sended->cert_id = $cert->id;
                $mail_sended->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
                $mail_sended->sended = false;
                $mail_sended->save();
            

            }
            
        }

        $uzs = Uz::find()->andWhere(['>', 'supply_ex_time', $current_date])
                                ->andWhere(['<', 'supply_ex_time', $temp_ex_date])->all();
        foreach ($uzs as $uz)
        {
            if(MailBase::find()->where(['uz_id' => $uz->id])->all() == NULL)
            {
                $contacts = $uz->customer->contacts;
                for ($i = 0; $i < count($contacts); $i++)
                {
                    for ($j = 0; $j < count($contacts); $j++)
                    {
                        if ($contacts[$i]->department > $contacts[$j]->department)
                        {
                            $tmp = $contacts[$i];
                            $contacts[$i] = $contacts[$j];
                            $contacts[$j] = $tmp;
                        }
                    }

                }
                foreach ($contacts as $contact)
                {
                    if ($contact->mail != NULL) //проверку на корректность почты тоже делатЬ!
                    {
                        $mail = $contact->mail;
                        break;
                    }
                }
                $customer = $uz->customer;
                if ($mail != NULL)
                {
                    $text = "Добрый день.<br>
                    Общество с ограниченной ответственностью «ПИК Безопасности» информирует о том, что у " . $uz->customer->fullname . " истекает срок действия базовой гарантии на следующий узел: <br>". $uz->uztype->name ."<br>
                    Предлагаем купить техническую поддержку.
                    Дополнительную информацию можно получить по тел. (391) 989-78-00, e-mail:mail@pik-b.ru, официальный сайт: http://pik-b.ru.";
                    Yii::$app->mailer->compose()
                        ->setFrom(['support@pik-b.ru'])
                        ->setTo('begzi@pik-b.ru')
                        ->setSubject($mail)
                        ->setHtmlBody($text)
                        ->send();
                    $mail_sended = new MailBase;
                    $mail_sended->uz_id = $uz->id;
                    $mail_sended->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
                    $mail_sended->sended = true;
                    $mail_sended->state = 1;
                    $mail_sended->save();
                    $mail = NULL;
                }
                else
                {
                    $mail_sended = new MailBase;
                    $mail_sended->uz_id = $uz->id;
                    $mail_sended->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
                    $mail_sended->sended = false;
                    $mail_sended->save();       
                }             
            }
        }


        return $this->redirect(array('expire/view'));
    }

    public function actionUzsupplychange()
    {

        $uzs = Uz::find()->all();

        for ($i = 0; $i < count($uzs); $i++)
        {
            if ($uzs[$i]->supply_time == NULL)
            {
                $uzs[$i]->supply_time = '2015-05-01';
                $uzs[$i]->supply_ex_time = '2016-05-01';
                $uzs[$i]->save();
            }
        }

        return $this->redirect(array('customers/index'));
    }

}