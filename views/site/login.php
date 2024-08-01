<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = "Login";
$this->params["breadcrumbs"][] = $this->title;
?>

<div class="login-register-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-bs-toggle="tab" href="#lg1">
                            <h4>login</h4>
                        </a>
                        <a data-bs-toggle="tab" href="#lg2">
                            <h4>register</h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
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
                                        ]) ?>


                                    <?= $form
                                        ->field($model, "password")
                                        ->passwordInput() ?>


                                    <div class="button-box">
                                        <div class="login-toggle-btn">

                                            <?= $form
                                                ->field($model, "rememberMe")
                                                ->checkbox(
                                                    []
                                                ) ?> <a href="#">Forgot Password?</a>
                                        </div>
                                        <div class="form-group">
                                            <div>
                                                <?= Html::submitButton(
                                                    "Login",
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
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="#" method="post">
                                        <input type="text" name="user-name" placeholder="Username">
                                        <input type="password" name="user-password" placeholder="Password">
                                        <input name="user-email" placeholder="Email" type="email">
                                        <div class="button-box">
                                            <button type="submit"><span>Register</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>