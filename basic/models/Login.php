<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Login extends Model
{
	public $username;
	public $password;
	public $rememberMe = false;



	public function rules()
	{
		return [
			[['password','username'],'required'],
			['rememberMe', 'boolean'],
			['password','validatePassword'],
		];
	}



	public function validatePassword($attribute,$params)
	{	
		if(!$this->hasErrors()){
			$user = $this->getUser();

			if($user->status == '0'){
				$this->addError($attribute,'Пользователь не активирован');
			}
			if(!$user || !$user->validatePassword($this->password))
			{
				$this->addError($attribute,'Пароль или пользователь введены неверно');
			}	
		}
		
		
	}


	public function getUser(){
		return User::findOne(['username' =>$this->username]);
	}

	/*
	public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
    */
}