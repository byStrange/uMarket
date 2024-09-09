<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

/** @var app\models\RegisterForm $model */


$this->title = Yii::t("app", "Register");
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

<style>
.text-block {
  color: red;
}
.login-register-wrapper .login-form-container .login-register-form input {
  margin-bottom: 8px;
}
</style>
<div class="login-register-area pt-100px pb-100px">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-12 ml-auto mr-auto">
        <div class="login-register-wrapper">
          <div class="login-register-tab-list nav">
            <a href="/site/login">
              <h4><?= Yii::t("app", "Login") ?></h4>
            </a>
            <a href="/site/register" class="active">
              <h4><?= Yii::t("app", "Register") ?></h4>
            </a>
          </div>
          <div class="login-form-container">
            <div class="login-register-form">
              <?= $model->render($model); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
