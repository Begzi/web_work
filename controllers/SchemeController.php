<?php


namespace app\controllers;


use app\models\Cert;
use app\models\SchemeForm;
use app\models\Scheme;
use app\models\Customers;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use Yii;

class SchemeController extends BaseController
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
        $model = new SchemeForm();

        if ($model->load(Yii::$app->request->post())) {

            $scheme = new Scheme;

            $scheme->description = $model->description;
            $scheme->customer_id = $customer_id;

            $scheme->sc_link = UploadedFile::getInstance($model, 'sc_link');

            if ($scheme->validate()) {
                // file is uploaded successfully Туловский Петр отдел ПО сопровождения
                $path = Yii::$app->params['pathUploads'] . 'scheme/' . $customer_id . '/';
                FileHelper::createDirectory($path);
                $scheme->sc_link->saveAs( $path  . $scheme->sc_link);
            }
            $scheme->save();

            return $this->redirect(array('scheme/show', 'customer_id'=> $customer_id));

        }


        return $this->render('add', [
            'model' => $model,
            'customer_id' => $customer_id
        ]);
    }
    public function actionShow($customer_id)
    {
        $model = new SchemeForm();

        if ($model->load(Yii::$app->request->post())) {
            $scheme = Scheme::findOne($model->scheme_i);

            $scheme->description = $model->description;

            $scheme->save();

        }
        
        $customer = Customers::findOne($customer_id);
        $scheme = $customer->scheme;

        for ($i = 0; $i < count($scheme); $i++){
            $text = preg_replace( "#\r?\n#", "<br />", $scheme[$i]->description );
            $scheme[$i]->description = $text;

        }
        return $this->render('show', [
            'scheme' => $scheme,
            'customer_id' => $customer_id,
            'customer' => $customer,
            'model' => $model,
        ]);
    }
    public function actionDelete($id){
        $scheme = Scheme::findOne($id);
        $customer_id = $scheme->customer_id;
        $scheme->delete();
        return $this->redirect(array('scheme/show', 'customer_id'=> $customer_id));
    }
    public function actionTmp()//Нужно чтобы модальные окна в аккаунте работали корректно. Костыль
    {
        return $this->redirect(array('expire/view'));
    }

}