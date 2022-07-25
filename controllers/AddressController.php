<?php


namespace app\controllers;


use app\models\AddressForm;
use app\models\Address;
use app\models\Region;
use app\models\Uz;
use yii\filters\AccessControl;
use Yii;

class AddressController extends BaseController
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
        $model = new AddressForm();
        if ($model->load(Yii::$app->request->post())) {

            $address = new Address();
            $address->customer_id = $customer_id;
            $address->region_id = $model->region + 1;
            $address->district = $model->district;
            $address->city = $model->city;
            $address->street = $model->street;
            $address->num = $model->num;
            $address->branch = $model->branch;
            $address->save();

            return $this->redirect(array('customers/view', 'id'=>$customer_id));
        }
        $region_obj = Region::find()->all();
        $region = [];
        foreach ($region_obj as $r){
            array_push($region, $r->name);
        }
        return $this->render('add', [
            'model' => $model,
            'customer_id' => $customer_id,
            'region' => $region
        ]);
    }
    public function actionEdit($id)
    {
        $model = new AddressForm();

        $address = Address::findOne($id);
        if ($model->load(Yii::$app->request->post())) {

            $address->region_id = $model->region + 1;
            $address->district = $model->district;
            $address->city = $model->city;
            $address->street = $model->street;
            $address->num = $model->num;
            $address->branch = $model->branch;
            $address->save();



            return $this->redirect(array('customers/view', 'id'=>$address->customer_id));
        }
        $region_obj = Region::find()->all();
        $region = [];
        foreach ($region_obj as $r){
            array_push($region, $r->name);
        }
        return $this->render('edit', [
            'model' => $model,
            'address' => $address,
            'region' => $region
        ]);
    }
    public function actionDelete($id)
    {
        $address = Address::findOne($id);

        if ($address->uzs != NULL)
        {
            foreach ($address->uzs as $uz){
                $query = Uz::findOne($uz->id);
                $query->address_id = 0;
                $query->save();
            }
        }
        $address->delete();
        return $this->redirect(array('customers/view', 'id'=> $address->customer_id));
    }

    public function actionTmp(){
$mun_district = ['Абанский район'
,'Ачинский район'
,'Балахтинский район'
,'Березовский район'
,'Бирилюсский район'
,'Боготольский район'
,'Богучанский район'
,'Большемуртинский район'
,'Большеулуйский район'
,'Дзержинский район'
,'Емельяновский район'
,'Енисейский район'
,'Ермаковский район'
,'Идринский район'
,'Иланский район'
,'Ирбейский район'
,'Казачинский район'
,'Канский район'
,'Каратузский район'
,'Кежемский район'
,'Козульский район'
,'Краснотуранский район'
,'Курагинский район'
,'Манский район'
,'Минусинский район'
,'Мотыгинский район'
,'Назаровский район'
,'Нижнеингашский район'
,'Новоселовский район'
,'Партизанский район'
,'Рыбинский район'
,'Саянский район'
,'Северо-Енисейский район'
,'Сухобузимский район'
,'Таймырский Долгано-Ненецкий муниципальный район'
,'Тасеевский район'
,'Туруханский район'
,'Ужурский район'
,'Уярский район'
,'Шушенский район'
,'Эвенкийский муниципальный район'];

$city_dist=[
'город Ачинск'
,'город Боготол'
,'город Бородино'
,'город Дивногорск'
,'город Енисейск'
,'город Канск'
,'город Красноярск'
,'город Лесосибирск'
,'город Минусинск'
,'город Назарово'
,'город Норильск'
,'город Сосновоборск'
,'город Шарыпово'
,'ЗАТО город Железногорск'
,'ЗАТО город Зеленогорск'
,'ЗАТО поселок Солнечный'
,'поселок Кедровый'
];
$mun_reg=
[
'Пировский муниципальный округ'
,'Тюхтетский муниципальный округ'
,'Шарыповский муниципальный округ'
];
    }
}