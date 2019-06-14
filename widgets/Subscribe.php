<?php
namespace app\widgets;


use yii\base\Widget;
use app\models\forms\Subscribe as SubscribeForm ;
use Yii;

class Subscribe extends Widget {
    public function run(){
        $model = new SubscribeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->createSubscriber();

            return $this->render('subscribeWidget', ['model' => $model, 'status' => 'ok']);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('subscribeWidget', ['model' => $model]);
        }
    }
}