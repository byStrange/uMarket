<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = Yii::t("app", "Login");
$this->params["breadcrumbs"][] = $this->title;

use yii\bootstrap5\Alert;

$session = Yii::$app->session;
foreach (['success', 'error', 'warning', 'info'] as $type) {
  if ($session->hasFlash($type)) {
    echo Alert::widget([
      'options' => [
        'class' => 'alert-' . $type,
      ],
      'body' => $session->getFlash($type),
    ]);
  }
}

?>

<div class="login-register-area pt-100px pb-100px">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-12 ml-auto mr-auto">
        <div class="login-register-wrapper">
          <div class="login-register-tab-list nav">
            <a class="active" href="/site/login">
              <h4><?= Yii::t("app", "login") ?></h4>
            </a>
            <a href="/site/register">
              <h4><?= Yii::t("app", "register") ?></h4>
            </a>
          </div>
          <div class="login-form-container">
            <div class="login-register-form">
              <?php $form = ActiveForm::begin([
                "id" => "login-form",
                "fieldConfig" => [
                  "template" =>
                  "{label}\n{input}\n{error}",
                  "labelOptions" => [
                    "class" =>
                    "col-lg-1 col-form-label mr-lg-3",
                  ],
                  "inputOptions" => [
                    "class" =>
                    "col-lg-3 form-control",
                  ],
                  "errorOptions" => [
                    "class" =>
                    "col-lg-7 invalid-feedback",
                  ],
                ],
              ]); ?>
              <?= $form
                ->field($model, "username")
                ->textInput([
                  "autofocus" => true,
                ])->label(Yii::t('app', 'username')) ?>


              <?= $form
                ->field($model, "password")
                ->passwordInput()->label(Yii::t(
                  'app',
                  'password'
                )) ?>


              <div class="button-box">
                <div class="login-toggle-btn">

                  <?= $form
                    ->field($model, "rememberMe")->label(Yii::t('app', 'Remember me'))
                    ->checkbox(['class' => 'checkoo']) ?> <a href="#"><?= Yii::t("app", "Forgot Password?") ?></a>
                </div>
                <div class="form-group">
                  <div>
                    <?= Html::submitButton(
                      Yii::t("app", "Login"),
                      [
                        "class" =>
                        "btn btn-primary",
                        "name" =>
                        "login-button",
                      ]
                    ) ?>
                  </div>
                </div>

              </div>

              <?php ActiveForm::end(); ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
