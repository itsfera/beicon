<?php
namespace app\widgets;


use yii\base\Widget;
use app\models\forms\Reg;
use app\models\forms\Subscribe as SubscribeForm ;
use Yii;

class Registration extends Widget {
    public function run(){
        $model = new Reg();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $model->createSubscriber();

            return $this->render('registrationWidget', ['model' => $model, 'status' => 'ok']);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('registrationWidget', ['model' => $model]);
        }
    }
}