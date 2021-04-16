<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Register;
use app\models\Login;
use app\models\User;
use app\models\ResetPassword;
use app\models\RetrievePasswordForm;
use app\models\adminForm;


class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }



    public function actionRegister()
    {   
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $model = new Register();

        if(isset($_POST['register'])){
            $model->attributes = Yii::$app->request->post('register');
            
            if(($model->validate())&&($model->signup())){
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }



    public function actionLogin()
    {   
        if(!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }
        $login_model = new Login();

        if(Yii::$app->request->post('Login'))
        {
            $login_model->attributes = Yii::$app->request->post('Login');

            if($login_model->validate())
            {
                Yii::$app->user->login($login_model->getUser(), $login_model->rememberMe ? 3600*24*30 : 0);
                return $this->goHome();
            } 
        }

        return $this->render('login',[
            'login_model' => $login_model,
        ]);
    }



    public function actionLogout(){
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }   
    }


    public function actionActivation()
    {   
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $code = Yii::$app->request->get('code');
        $user_complain = User::findOne(['token' =>$code]);
        if($user_complain)
        {   
            $auth = Yii::$app->authManager;
            $active = $auth->getRole('active'); // Получаем роль editor
            $auth->assign($active, $user_complain->id);  
            $user_complain->status = "1";
            $user_complain->save();
            return $this->render('activation');
        }


        return $this->render('donactivation');
    }


    public function actionRestore()
    {   
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $code = Yii::$app->request->get('code');
        $user_complain = User::findOne(['resetKey' =>$code]);
        if($user_complain)
        {
            $model = new ResetPassword();
            
            if($model->load(Yii::$app->request->post()))
            {
                $model->attributes = Yii::$app->request->post('Restore');

                if($model->validate())
                {
                    $user_complain->password = sha1($model->newpassword);
                    $user_complain->save();
                    return $this->goHome();
                }
            }

            return $this->render('restore',[
                'model' => $model,
            ]);            
        }
        /*
        if((!Yii::$app->user->isGuest)&&(!$user_complain)){
            $model = new ResetPassword();

            $user = Yii::$app->user->identity;

            if($model->load(Yii::$app->request->post()))
            {

                $model->attributes = Yii::$app->request->post('Restore');
                

                if($model->validate())
                {
                    $user_find = User::findOne(['email' =>$user->email]);
                    $user_find->password = sha1($model->newpassword);
                    $user_find->save();
                    return $this->goHome();
                }
            }

            return $this->render('restore',[
                'model' => $model,
            ]); 
        }
        */
        return $this->goHome();
    }



    public function actionRestoremail()
    {   
        
        $model = new RetrievePasswordForm();
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        if($model->load(Yii::$app->request->post()))
        {
            $model->attributes = Yii::$app->request->post('Restoremail');    

            if($model->validate())
            {
                $user_find = User::findOne(['email' =>$model->email]);
                if($user_find)
                {
                    $model->sendResetKey($user_find->resetKey);
                    return $this->goHome();
                }
                return $this->render('donactivation');
            }
        }

        return $this->render('restoremail',[
            'model' => $model,
        ]); 
    }



    public function actionAdmin()
    {
        //Yii::$app->session->setFlash('success', "Пользователь сохранён");
        $model = new adminForm();
        $user = Yii::$app->user->identity;
        $manager = Yii::$app->authManager;
        if(Yii::$app->user->can('AdminPage'))
        {
            if($model->load(Yii::$app->request->post())){
                $model->attributes = Yii::$app->request->post('Admin');  
                if($model->validate()){
                    $user_find = User::findOne(['email' =>$model->email]);

                    if($user_find){
                        $user_find->displayname = $model->displayname;
                        $user_find->password = sha1($model->password);
                        $role = Yii::$app->authManager->getRolesByUser($user_find->id);
                        if($model->has_admin){
                            $manager->revokeAll($user_find->id);
                            $authorRole = $manager->getRole('admin');
                            $manager->assign($authorRole,$user_find->id);
                        }else{
                            $manager->revokeAll($user_find->id);
                            $authorRole = $manager->getRole('active');
                            $manager->assign($authorRole,$user_find->id);
                        }
                        $user_find->save();
                        return $this->goHome();
                    }                     
                    return $this->goHome();
                }
                return $this->goHome();
            }       
        }else{
            return $this->goHome();
        }
        

        return $this->render('update',[
            'model' => $model,
        ]);
    }





    /*/S
    public function actionInit() {
        $auth = Yii::$app->authManager;
        
        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...
        
        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $active = $auth->createRole('active');
        
        // запишем их в БД
        $auth->add($admin);
        $auth->add($active);
        
        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $AdminPage = $auth->createPermission('AdminPage');
        $AdminPage->description = 'Просмотр админки';
        
        
        // Запишем эти разрешения в БД
        $auth->add($AdminPage);
        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $active);
        
        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $AdminPage);

        //$auth->assign($admin, 1); 
    
    }
    */

    public function actionLoginVk($uid,$first_name,$hash){
        $user = new User();
        if($user->saveFromVk($uid,$first_name,$hash)){
            return $this->goHome();
        }
    }

}
