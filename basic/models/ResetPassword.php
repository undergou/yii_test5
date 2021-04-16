<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ResetPassword extends Model
{
	public $newpassword;

	public function rules()
	{
		return [
			['newpassword','required'],
			['newpassword','match', 'pattern' => '(^(?xi)(?=(?:.*[0-9]){2})(?=(?:.*[a-z]){2})(?=(?:.*[!"#$%&\'()*+,./:;<=>?@\[\]^_`{|}~-]){2}).{6,}$)']
		];
	}
}