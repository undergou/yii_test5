<?php

namespace app\models;

use yii\base\Model;
use Yii;

class Register extends Model
{
	public $email;
	public $password;
	public $username;
	public $displayname;
	public $token;
	public $status;

	public function rules()
	{
		return [

			[['email','password','displayname','username'],'required'],

			['username','match','pattern' => '^[A-Za-z0-9]+$'],
			['displayname','match','pattern' => '^[A-Za-z0-9]+$'],
			['email','email'],
			['email','unique','targetClass' => 'app\models\User'],
			//['password','match', 'pattern' => '//[(^(?xi)/(?=(?:.*[0-9]){2})(?=(?:.*[a-z]){2})(?=(?:.*[!"#$%&SS\'()*+,./\:;<=>?@\[\]^_`{|}~-]){2}).{6,}$)]']

		];
	}

	public function signup()
	{
		$user = new User();
		$user->email = $this->email;
		$user->setPassword($this->password);
		$user->username = $this->username;
		$user->displayname = $this->displayname;
		$user->token = bin2hex(random_bytes(10));
		$user->status = 0;
		$user->resetKey = bin2hex(random_bytes(10));
		$opl = $user->token;
		$result = Yii::$app->mailer->compose()
            ->setFrom('oc.mcdir@yandex.ru')
            ->setTo($this->email)
            ->setSubject('Active account')
            ->setHtmlBody('<a href="http://basic/activation/'.$opl.'">Activate account</a>')
            ->send();
		return $user->save();
	}

}