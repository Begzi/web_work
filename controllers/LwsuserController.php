<?php


namespace app\controllers;


use app\models\Cert;
use app\models\LwsuserForm;
use app\models\User;
use app\models\Customers;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\filters\AccessControl;
use Yii;

class LwsuserController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]   
        ];
    }

    public function actionAdd()
    {
        $model = new LwsuserForm();

        if ($model->load(Yii::$app->request->post())) {

            $user = new User;

            $user->login = $model->username;
            $user->password = $model->password;
            $user->name = $model->name;

            $user->hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->save();
            $role = ['admin', 'manager','TZI'];

            $userRole = Yii::$app->authManager->getRole($role[$model->role]);
            Yii::$app->authManager->assign($userRole, $model->getUserform()->getId());   



            return $this->redirect(array('site/account'));

        }


        return $this->render('add', [
            'model' => $model
        ]);
    }

    public function actionEdit()
    {
        $model = new LwsuserForm();

        if ($model->load(Yii::$app->request->post()) && $model->validatePassword()) {

            $user = User::findOne((Yii::$app->user->identity->id));

            $user->login = $model->username;
            $user->name = $model->name;

            if($model->new_password != NULL && $model->validateNewPassword()){

                $user->password = $model->new_password;
                $user->hash = Yii::$app->getSecurity()->generatePasswordHash($user->password);

            }
            else{

                $model->password = '';
                $model->edit_password = '';
                $model->new_password = '';
                $model->check_new_password = '';
                return $this->render('edit', [
                    'model' => $model
                ]);

            }

            $user->save();




            return $this->redirect(array('site/account'));

        }

        $model->password = '';
        $model->edit_password = '';
        $model->new_password = '';
        $model->check_new_password = '';
        return $this->render('edit', [
            'model' => $model
        ]);
    }
}