<?php

namespace app\controllers;


use app\models\Cert;
use app\models\Mail;
use app\models\MailBase;
use app\models\Uz;
use app\models\Customers;
use yii\data\Pagination;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Contact;
use yii\filters\AccessControl;
use Yii;
use app\models\ExpireForm;
use app\models\CertGroupName;

class ExpireController extends BaseController
{
    /**
     * {@inheritdoc}
     */ 
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['manager', 'admin'],
                    ],
                ],
            ],
        ];
    }


    public function actionView()
    {
        
        $modelcertgroupname = new ExpireForm();
        if ($modelcertgroupname->load(Yii::$app->request->post())) 
        {
            $mail_or_group = strstr($modelcertgroupname->next_step, ' - ');

            $id = strstr($modelcertgroupname->next_step, ' - ', true);

            $mail_or_group = substr($mail_or_group, 3);
            if (strstr($mail_or_group, ' - '))
            {
                $send_mail = strstr($mail_or_group, ' - ');
                $send_mail = substr($send_mail, 3);      
                $mail_or_group = strstr($mail_or_group, ' - ', true);              
            }

            if ($mail_or_group == 'group')
            {
                $query = CertGroupName::findOne($id);
                if ($send_mail != NULL)
                {
                    $mail_array = Array();
                    $modelcertgroupname->text = preg_replace( "#\r?\n#", "<br />", $modelcertgroupname->text );
                    while($send_mail != '***')
                    {
                        $send_mail = strstr($send_mail, '***');
                        $send_mail = substr($send_mail, 3);      
                        $mail_tmp = strstr($send_mail, '***', true); 
                        $send_mail = strstr($send_mail, '***');
                        array_push($mail_array, $mail_tmp);
                    }
                    $uzs_array = Array();
                    $customer_name_array = Array();
                    for ($i = 0 ; $i < count($query->cert); $i++)
                    {
                        $uzs_text = '';
                        for ($k = 0; $k < count($query->cert[$i]->certuzs); $k++)
                        {
                            $uzs_text = $uzs_text . $query->cert[$i]->certuzs[$k]->uz->uztype->name . '<br>';
                        }
                        array_push($uzs_array, $uzs_text);
                        array_push($customer_name_array, $query->cert[$i]->customer->shortname);
                    }

                    foreach ($mail_array as $email)
                    {       
                        $query_contact_find = Contact::find()->where(['mail' => $email])->one();
                        for ($i = 0; $i < count($customer_name_array); $i++)
                        {
                            if ($customer_name_array[$i] == $query_contact_find->customer->shortname)
                            {
                                $text = str_replace( "НАЗВАНИЕУЧРЕЖДЕНИЯ", $customer_name_array[$i], $modelcertgroupname->text );
                                $text = str_replace( "ПОСТРОЧНОЕПЕРЕЧИСЛЕНИЕУЗЛОВУЧРЕЖДЕНИЯ", $uzs_array[$i], $text );
                                break;
                            }
                        }

                        Yii::$app->mailer->compose()
                            ->setFrom(['support@pik-b.ru'])
                            ->setTo('begzi@pik-b.ru')
                            ->setSubject($email)
                            ->setHtmlBody($text . $email)
                            ->send();
                        $text = '';
                    }
                    if ($query->state == 0 )
                    {
                        $query->state = 1;
                    }
                    elseif ($query->state == 7)
                    {
                        $query->state = 8;                        
                    }
                    foreach ($query->cert as $cert1)
                    {
                        $query_mail = Mail::findOne($cert1->mail->id);
                        $query_mail->sended = 1;
                        $query_mail->save();
                        
                    }

                }
                else
                {
                    $query->state = $query->state + 1;
                    if ($query->state == 1 or $query->state == 8)
                    {
                        $query->sended = true;
                    }
                }
                $query->save();
            }
            elseif ($mail_or_group == 'mail')
            {
                $query = Mail::findOne($id);
                if ($send_mail != NULL)
                {
                    $text = preg_replace( "#\r?\n#", "<br />", $modelcertgroupname->text );
                    Yii::$app->mailer->compose()
                        ->setFrom(['support@pik-b.ru'])
                        ->setTo('begzi@pik-b.ru')
                        ->setSubject($modelcertgroupname->mail)
                        ->setHtmlBody($text . $modelcertgroupname->mail)
                        ->send();
                    $query->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
                    $query->sended = true;
                    if ($query->state == 0 )
                    {
                        $query->state = 1;
                    }
                    elseif ($query->state == 7)
                    {
                        $query->state = 8;                        
                    }

                }
                else
                {
                    $query->state = $query->state + 1;
                    if ($query->state == 1 or $query->state == 8)
                    {
                        $query->sended = true;
                    }
                }
                $query->save(); 
            }
            elseif ($mail_or_group == 'mailbase')
            {
                $query = MailBase::findOne($id);
                if ($send_mail != NULL)
                {
                    $text = preg_replace( "#\r?\n#", "<br />", $modelcertgroupname->text );
                    Yii::$app->mailer->compose()
                        ->setFrom(['support@pik-b.ru'])
                        ->setTo('begzi@pik-b.ru')
                        ->setSubject($modelcertgroupname->mail)
                        ->setHtmlBody($text . $modelcertgroupname->mail)
                        ->send();
                    $query->st_date_send = Yii::$app->formatter->asTime( time(), 'php:Y-m-d');
                    $query->sended = true;
                    if ($query->state == 0 )
                    {
                        $query->state = 1;
                    }
                    elseif ($query->state == 7)
                    {
                        $query->state = 8;                        
                    }

                }
                else
                {
                    $query->state = $query->state + 1;
                    if ($query->state == 1 or $query->state == 8)
                    {
                        $query->sended = true;
                    }
                }
                $query->save();                 
            }
            else
            {
                return $this->redirect(array('customers/view')); //костыль, чтобы модальные окна работали корректно                    
            }
            return $this->redirect(array('scheme/tmp')); //костыль, чтобы модальные окна работали корректно

        }

        $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        $current_date = date('Y-m-d', time());
        $current_date = date('Y-m-d', strtotime( '' . $current_date. '- 60 days'));

        $cert = Cert::find()->andWhere(['>', 'ex_date', $current_date])
                            ->andWhere(['<', 'ex_date', $temp_ex_date])->all();
        $cert_group = CertGroupName::find()->andWhere(['>', 'ex_date', $current_date])
                            ->andWhere(['<', 'ex_date', $temp_ex_date])->all();

        // for ($j = 0; $j < count($cert); $j++)
        // {
        //     for ($i = 0; $i < count($cert_group); $i++)  //DELETE THIS SHIT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        //     {
                
        //         if ($cert_group[$i]->ex_date == $cert[$j]->ex_date)
        //         {
        //             $cert[$j] = NULL; 
        //             break;
        //         }
        //         if (($cert_group[$i]->ex_date < date('Y-m-d', time())) and ($cert_group[$i]->state < 7))
        //         {
        //             $cert_group[$i]->state = $cert_group[$i]->state + 7;
        //         }
        //     }
        //     if ($cert[$j] != NULL)
        //     {
        //         if (($cert[$j]->ex_date < date('Y-m-d', time())) and ($cert[$j]->mail->state < 7))
        //         {
        //             $mail = Mail::find()->where(['cert_id' => $cert[$j]->id])->one();  
        //             $mail->state = $mail->state + 7;
        //             $mail->save();    
        //         }
        //     }
        // }
        for ($i = 0; $i < count($cert_group); $i++)
        {
            
            if (($cert_group[$i]->ex_date < date('Y-m-d', time())) and ($cert_group[$i]->state < 7))
            {
                $cert_group[$i]->state = $cert_group[$i]->state + 7;
            }
        }
        for ($j = 0; $j < count($cert); $j++)
        {
            if ($cert[$j]->cert_group_name_id != 0)
            {
                $cert[$j] = NULL;
            }
            else
            {
                if (($cert[$j]->ex_date < date('Y-m-d', time())) and ($cert[$j]->mail->state < 7))
                {
                    $mail = Mail::find()->where(['cert_id' => $cert[$j]->id])->one(); 
                    if ($mail != NULL) {
                        $mail->state = $mail->state + 7;
                        $mail->save(); 

                    }    
                }                
            }
        }
        for ($i = 0; $i < count($cert); $i++)
        {
            if ($cert[$i] != NULL)
            {
                array_push($cert_group,$cert[$i]);
            }
        }

        $uz = Uz::find()->andWhere(['>', 'supply_ex_time', $current_date])
                            ->andWhere(['<', 'supply_ex_time', $temp_ex_date])->all();

        for ($j = 0; $j < count($uz); $j++)
        {
            if (($uz[$j]->supply_ex_time < date('Y-m-d', time())) and ($uz[$j]->mailbase->state < 7))
            {
                $mail = Mailbase::find()->where(['uz_id' => $uz[$j]->id])->one();  
                $mail->state = $mail->state + 7;
                $mail->save();    
            }

        }

        return $this->render('view',[
                'cert_group' => $cert_group,
                'modelcertgroupname' => $modelcertgroupname,
                'uz' => $uz,
        ]);            
    }

    public function actioanRole()
    {
        $query = Mail::find()->all();
    }
    
}