<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{  
    public static function tableName()
    {
        return '{{users}}';
    }



    public function setPassword($password){
        $this->password = sha1($password);
    }


    public function validatePassword($password){
        return $this->password === sha1($password);
    }


    public function saveFromVk($uid,$name,$hash){
        $flag_user =  User::findOne(['id' =>$uid]);
        $manager = Yii::$app->authManager;
        if($flag_user){
            return Yii::$app->user->login($flag_user);
        }
        $sha = "pfejrpfpwed[wf@gmail.com";
        $this->id = $uid;
        $this->username = $name;
        $this->displayname = $name;
        $this->status = "0";
        $this->token = bin2hex(random_bytes(10));
        $this->resetKey = bin2hex(random_bytes(10));
        $this->email = $sha;
        $this->password = sha1($hash);
        $this->save();
        $authorRole = $manager->getRole('active');
        $manager->assign($authorRole,$uid);
        return Yii::$app->user->login($this);
    }

    //================================================================
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
 
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

}
