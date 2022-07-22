<?php


namespace app\controllers;


use app\models\Cert;
use app\models\LogTicket;
use app\models\Kbase;
use app\models\KbaseForm;
use phpDocumentor\Reflection\Types\Array_;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class KbaseController extends BaseController
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

    public function actionIndex() {
        $query = Kbase::find();
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $kbase = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'kbase' => $kbase,
            'pages' => $pages
        ]);
    }

    public function actionDownload($dir) // загрузить файл загрузки
    {
        $file = Yii::getAlias($dir);
        return Yii::$app->response->sendFile($file); 
    }

    public function actionDelete($dir) //удалить файл загрузки
    { 
        unlink($dir);
        if (\Yii::$app->request->referrer) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->goHome();
        }
        //setReturnUrl() потом вызвать  return $this->goBack();
    }
    

    /**
     * @return string|\yii\web\Response
     */
    public function actionView($id){
        function build_sorter($key) {
            return function ($a, $b) use ($key) {
                return strnatcmp($a[$key], $b[$key]);
            };
        }

        $kbase = Kbase::findOne($id);
        $model = new KbaseForm();
    // Изменение описания и тип обмена документооборота
        if ($model->load(Yii::$app->request->post())) {
            if ($model->description != NULL ) {
                $kbase->description = $model->description;
                $kbase->save();
                if ($model->sc_link != NULL){
                    $path = Yii::$app->params['pathUploads'] . 'kbase/files/' . $kbase->id . '/d/' ;
                    FileHelper::createDirectory($path);
                    $model->sc_link = UploadedFile::getInstances ($model, 'sc_link');
                    foreach ($model->sc_link as $file) {
                        $file->saveAs( $path  . $file->baseName . '.' . $file->extension);    
                    }          

                }
            } elseif ($model->solution != NULL ) {
                $kbase->solution = $model->solution;
                $kbase->save();
                if ($model->sc_link != NULL){
                    $path = Yii::$app->params['pathUploads'] . 'kbase/files/' . $kbase->id . '/s/' ;
                    FileHelper::createDirectory($path);
                    $model->sc_link = UploadedFile::getInstances ($model, 'sc_link');
                    foreach ($model->sc_link as $file) {
                        $file->saveAs( $path  . $file->baseName . '.' . $file->extension);   
                    }           

                }
            } else {
                $path = Yii::$app->params['pathUploads'] . 'kbase/files/' . $kbase->id . '/f/' ;
                FileHelper::createDirectory($path);
                $model->sc_link = UploadedFile::getInstances ($model, 'sc_link');
                foreach ($model->sc_link as $file) {
                    $file->saveAs( $path  . $file->baseName . '.' . $file->extension);
                }
            }
        }

        $kbase = Kbase::findOne($id);

        $text = preg_replace( "#\r?\n#", "<br />", $kbase->description );
        $kbase->description = $text;
        // при вывводе примечания выводились и знак следующей строки! нужно оставить это после проверки на ввод не кода
        $text = preg_replace( "#\r?\n#", "<br />", $kbase->solution );
        $kbase->solution = $text;
        // при вывводе примечания выводились и знак следующей строки! нужно оставить это после проверки на ввод не кода



        return $this->render('view', [
            'kbase' => $kbase,
            'model' => $model
            ]);
    }

    public function actionAdd() {
        $model = new KbaseForm();
        if ($model->load(Yii::$app->request->post())) {

            $query = Kbase::find()->all();
            $kbase = new Kbase();
            $kbase->name = $model->name;
            $kbase->id = count($query) + 1;
            $kbase->save();

            $query = Kbase::find()->where(['name' => $model->name])->all();

            $path = Yii::$app->params['pathUploads'] . 'kbase/files/' . $query[0]->id . '/d/';
            FileHelper::createDirectory($path);
            $path = Yii::$app->params['pathUploads'] . 'kbase/files/' . $query[0]->id . '/f/';
            FileHelper::createDirectory($path);
            $path = Yii::$app->params['pathUploads'] . 'kbase/files/' . $query[0]->id . '/s/';
            FileHelper::createDirectory($path);

            return $this->redirect(array('kbase/view', 'id'=>$query[0]->id));
        }
        return $this->render('add', [
            'model' => $model,
        ]);

    }

    public function actionSearchfull(){

        $search = Yii::$app->request->get('search');

        $search1 = str_replace(' ','', $search);

        $query = Kbase::find()->orFilterWhere(['like', 'name', $search1])
            ->orFilterWhere(['id'=> $search1]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 15]);
        $kbase = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', [
            'kbase' => $kbase,
            'pages' => $pages,
            'searchfull' => $search1
        ]);

    }

    public function actionEdit($id) {
        $model = new KbaseForm();
        $kbase =  Kbase::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

//            $customers = Customers::find()->all();
            $kbase->name = $model->name;
            $kbase->save();

            return $this->redirect(array('kbase/view', 'id'=>$kbase->id));
        }
        return $this->render('edit', [
            'model' => $model,
            'kbase' => $kbase
        ]);

    }

    public function actionDeletekbase($id) {
        $kbase =  Kbase::findOne($id);
        for ($i = 0; $i < count($kbase->logTickets); $i++){
            $query = LogTicket::findOne($kbase->logTickets[$i]->id);
            $query->kbase_link = NULL;
            $query->save();
        }
        $kbase->delete();
        $kbase =  Kbase::find()->all();
        $k=1;
        foreach ($kbase as $value)
        {
            $value->id = $k;
            $k++;
            $value->save();
        }
        return $this->redirect(array('kbase/index'));

    }
}