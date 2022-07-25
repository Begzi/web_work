<?php


namespace app\controllers;


use app\models\ContactForm;
use app\models\Contact;
use app\models\LogTicket;
use app\models\ContactPosition;
use yii\filters\AccessControl;
use Yii;

class ContactController extends BaseController
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
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {


            if (($model->m_tel == NULL) and ($model->w_tel == NULL)){
                Yii::$app->session->setFlash('NumberMustHave');
                return $this->render('add', [
                    'model' => $model,
                    'customer_id' => $customer_id
                ]);

            }

            $contact = new Contact();
            $contact->customer_id = $customer_id;
            $contact->name = $model->name;
            $contact->mail = $model->mail;
            $contact->w_tel = $model->w_tel;
            $contact->m_tel = $model->m_tel;
            $contact->position = $model->position;
            $contact->department = $model->department + 1;
            $contact->description = $model->description;
            $contact->ityn = 0;
            $contact->save();



            return $this->redirect(array('customers/view', 'id'=>$customer_id));
        }
        return $this->render('add', [
            'model' => $model,
            'customer_id' => $customer_id
        ]);
    }
    public function actionEdit($id)
    {
//        if (Yii::$app->user->identity->username != 'admin') {
//            return $this->actionError();
//        }
        $model = new ContactForm();

        $contact = Contact::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

            $contact->position = $model->position;
            $contact->name = $model->name;
            $contact->w_tel = $model->w_tel;
            $contact->m_tel = $model->m_tel;
            $contact->mail = $model->mail;
            $contact->description = $model->description;
            $contact->department = $model->department + 1;
            $contact->save();



            return $this->redirect(array('customers/view', 'id'=>$contact->customer_id));
        }
        return $this->render('edit', [
            'model' => $model,
            'contact' => $contact
        ]);
    }
    public function actionDelete($id)
    {
        $contact = Contact::findOne($id);
        $id = $contact->customer_id;
        $query = LogTicket::findOne($contact->logTicket->id);
        if ($query->contact_id != NULL)
        {
            $query->contact_id = NULL;
            $text = ' Работали с';
            if ($contact->w_tel != NULL)
            {
                $text = $text . ' ' . $contact->w_tel;
            }
            else
            {
                $text = $text . ' ' . $contact->m_tel;                
            }
            if ($contact->name != NULL)
            {
                $text = $text . ' ' . $contact->name;
            } 
            else
            {
                $text = $text . ' ' . $contact->contactPosition->name;
            }

            $query->description = $query->description . $text;
            $tmp = strlen($query->description);
            if ($tmp > 1001)
            {
                $query->description = substr($query->description, $tmp-1002) . $tmp . strlen($text);
            }
            $query->save();
        }
        $contact->delete();
        return $this->redirect(array('customers/view', 'id'=> $id));
    }

    public function actionPosition()
    {
        $contacts = Contact::find()->all();
        // $tmp = Array();
        // array_push($tmp, $contacts[0]->position);
        // foreach ($contacts as $value)
        // {  
        //                 array_push($tmp, $value->position);
        // }
        // $tmp1 = Array();
        // array_push($tmp1, $tmp[0]);
        // for ($i = 1; $i < count($tmp); $i++)
        // {
        //     $k = 0;
        //     for ($j = 0; $j <count($tmp1); $j++)
        //     {
        //         if ($tmp[$i] != $tmp1[$j])
        //         {
        //             $k++;
        //         }
        //     }
        //     if ($k == count($tmp1))
        //     {
        //         array_push($tmp1, $tmp[$i]);
        //     }
        // }
        // $tmp_departmen = '02322221022004310152022011201123100120111221212333333333322122322133333423342320202023023440332333331223430000';
        // for ($j = 0; $j <count($tmp1); $j++)
        // {
        //     $position = new ContactPosition;
        //     $position->name = $tmp1[$j];
        //     $position->Department = ($tmp_departmen[$j]);
        //     $position->save();
        // }

        $tmp1 = ContactPosition::find()->all();
        // for ($j = 0; $j <count($tmp1); $j++)
        // {
        //     $tmp1[$j]->Department = $tmp1[$j]->Department + 1;

        //     if ($tmp1[$j]->Department == 3)
        //     {
        //         $tmp1[$j]->Department = 5;
        //     }
        //     elseif ($tmp1[$j]->Department == 2)
        //     {
        //         $tmp1[$j]->Department = 3;                
        //     }
        //     elseif ($tmp1[$j]->Department == 5)
        //     {
        //         $tmp1[$j]->Department = 2;                
        //     }
        //     $tmp1[$j]->save();
        // }

        for ($i = 0; $i < count($contacts); $i++)
        {
            $query = ContactPosition::find()->where(['name' => $contacts[$i]->position])->one();
            $contacts[$i]->department = $query->Department;
            $contacts[$i]->save();
        }
        return $this->render('tmp', [
            'tmp1' => $tmp1,
        ]);
    }

}