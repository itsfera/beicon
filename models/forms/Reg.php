<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Liashkou
 * Date: 23.01.2019
 * Time: 4:16
 */

namespace app\models\forms;

//use app\models\Subscribers;

use app\models\User;

class Reg extends \yii\base\Model
{

    public $email;




    public function rules()
    {
        return [
            ['email', 'email'],
            ['email', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail'
        ];
    }

    public function reg(){
        if($this->validate()){
            $user = new User();
            $user->email = $this->email;
            $user->username = $this->email;
            $user->password = md5(rand(1111111, 9999999));
            $user->status = 0;
            $user->role = 'user';
            $user->save();
//            $subscriber = new Subscribers();
//            $subscriber->email = $this->email;
//            $subscriber->active = 0;
//
//            $subscriber->save();

//            \Yii::$app->mailer->compose('subscribe', [
//                'content' => '#'
//            ])->setTo($subscriber->email)
//                ->setFrom('noreply@beicon.it-sfera.ru')
//                ->setSubject('Подтверждение подписки')
//                ->send();
//
//            return $subscriber->id;
            \Yii::$app->mailer->compose('reg', [
                'content' => '#'
            ])->setTo($this->email)
                ->setFrom('info@beicon.ru')
                ->setSubject('Спасибо за регистрацию')
                ->send();

            return $user->id;

        } else return false;

    }

}