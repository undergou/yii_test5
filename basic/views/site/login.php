<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($login_model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($login_model, 'password')->passwordInput() ?>

        <?= $form->field($login_model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
    <script type="text/javascript">
      VK.init({apiId: 7823346});
    </script>

    <!-- VK Widget -->
    <div id="vk_auth"></div>
    <script type="text/javascript">
      VK.Widgets.Auth("vk_auth", {"authUrl":"/site/login-vk"});
    </script>
    <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v10.0&appId=823272624938824&autoLogAppEvents=1" nonce="vwjwvFLY"></script>
<div class="fb-login-button" data-width="200" data-size="medium" data-button-type="login_with" data-layout="rounded" data-auto-logout-link="true" data-use-continue-as="false"></div>
    <script>
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        }); 
        function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '823272624938824',
              cookie     : true,
              xfbml      : true,
              version    : 'v10'
            });
              
            FB.AppEvents.logPageView();   
              
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));

</script>
</div>
