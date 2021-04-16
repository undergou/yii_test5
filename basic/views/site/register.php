<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'register';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="block-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to Register:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'register']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'displayname') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>