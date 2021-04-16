<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class MyRbacController extends Controller {

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

        $Authentification = $auth->createPermission('Authentification');
        $Authentification->description = 'Аунтификация';

        $resetPass = $auth->createPermission('resetPass');
        $resetPass->description = 'Восстановление пароля';
        
        
        
        // Запишем эти разрешения в БД
        $auth->add($AdminPage);
        $auth->add($resetPass);

        // Теперь добавим наследования. Для роли active мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли active и еще добавим собственное разрешение viewAdminPage
        
        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($active,$resetPass);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $active);
        
        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $AdminPage);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1); 
    }
}