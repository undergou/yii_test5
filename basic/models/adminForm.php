<?php

namespace app\models;

use yii\base\Model;
use Yii;

class adminForm extends Model
{
	public $email;
	public $password;
	public $displayname;
	public $has_admin = false;

	public function rules()
	{
		return [

			[['email','password','displayname'],'required'],

			['email','email'],
			['has_admin','boolean'],

			['password','match', 'pattern' => '(^(?xi)(?=(?:.*[0-9]){2})(?=(?:.*[a-z]){2})(?=(?:.*[!"#$%&\'()*+,./:;<=>?@\[\]^_`{|}~-]){2}).{6,}$)']
		];
	}





}