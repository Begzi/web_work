<?php

namespace app\controllers;

use app\models\UzTypeCategoria;
use app\models\UzType;
use app\models\UzNet;
use app\models\Cert;
use app\models\Mail;
use app\models\Customers;
use yii\data\Pagination;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\filters\AccessControl;
use Yii;
use app\models\UzNetForm;
use app\models\UzTypeForm;
use app\models\CertGroupName;
use app\models\CertGroupForm;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */ 
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['about','logout', 'account', 'index', 'login'],
                'rules' => [
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['WEB'],
                    ],
                    [
                        'actions' => ['logout', 'account', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionAccount()
    {

        $modelnet = new UzNetForm;
        $modeltype = new UzTypeForm;


        if ($modelnet->load(Yii::$app->request->post())) 
        {
            $query = UzNet::find()->all();
            foreach ($query as $value){
                if ($value->num == $modelnet->num){ //такой номер сети существует
                    Yii::$app->session->setFlash('netHaveNum');
                    return $this->render('account',[
                            'modeltype' => $modeltype,
                            'modelnet' => $modelnet,
                    ]);

                }
                if ($value->name == $modelnet->name){//такое имя сети существует
                    Yii::$app->session->setFlash('netHaveName');
                    return $this->render('account',[
                            'modeltype' => $modeltype,
                            'modelnet' => $modelnet,
                    ]);

                }
            }

            $net = new UzNet;
            $net->num = $modelnet->num;
            $net->name = $modelnet->name;
            $net->id = count($query);

            $net->save();
            Yii::$app->session->setFlash('netAdded');

        }

        if ($modeltype->load(Yii::$app->request->post())) 
        {

            $query = UzType::find()->all();
            foreach ($query as $value){
                if ($value->name == $modeltype->name){//такое тип существует
                    Yii::$app->session->setFlash('typeHaveName');
                    return $this->render('account',[
                            'modeltype' => $modeltype,
                            'modelnet' => $modelnet,
                    ]);

                }
            }

            $type = new UzType;
            $type->name = $modeltype->name;
            $type->type = $modeltype->type;

            $type->id = count($query);
            $type->save();
            Yii::$app->session->setFlash('typeAdded');

        }

        $uztypecategoria = UzTypeCategoria::find()->all();
        $type = [];
        foreach ($uztypecategoria as $uztype){
            array_push($type, $uztype->name);
        }

    
        return $this->render('account',[
                'modeltype' => $modeltype,
                'modelnet' => $modelnet,
                'type' => $type,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {

        $check_date_1 = date('Y-m-d h:i', strtotime('09:00'));
        $check_date_2 = date('Y-m-d h:i', strtotime('11:59'));
        $check_date_3 = date('Y-m-d h:i', strtotime('12:00'));
        $check_date_4 = date('Y-m-d h:i', strtotime('01:00'));

        return $this->render('about', [
                'check_date_1' => $check_date_1,
                'check_date_2' => $check_date_2,
                'check_date_3' => $check_date_3,
                'check_date_4' => $check_date_4,

        ]);
    }
}
