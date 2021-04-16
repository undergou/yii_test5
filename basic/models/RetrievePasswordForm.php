<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RetrievePasswordForm extends Model
{
	public $email;

	public function rules()
	{
		return [
			['email','required'],
			['email','email']
		];
	}


	public function sendResetKey($token){
		Yii::$app->mailer->compose()
            ->setFrom('oc.mcdir@yandex.ru')
            ->setTo($this->email)
            ->setSubject('Restore your password')
            ->setHtmlBody('<a href="http://basic/retrieve-password/'.$token.'">Restore password</a>')
            ->send();
	}
}