<?php


namespace app\controllers;

use yii\web\Controller;
use app\models\Cert;
use app\models\Mail;
use app\models\MailBase;
use app\models\CheckCertBase;
use app\models\Uz;
use Yii;
class BaseController extends Controller
{

    public function Main()
    {

        $certs = Yii::$app->cache->get('certMenu1');
        if ($certs != NULL){
            return $certs;
        }

        $temp_ex_date = date('Y-m-d', strtotime(' + 30 days'));
        $current_date = date('Y-m-d h:i', time());

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



          
        Yii::$app->cache->set('certMenu1', $certs, 8);
        return $certs;
    }


}