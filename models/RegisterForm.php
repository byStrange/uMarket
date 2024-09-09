<?php

namespace app\models;

use app\components\Utils;
use Yii;
use yii\base\Model;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

class RegisterForm extends Model
{
  public $username;
  public $email;
  public $password;
  public $confirmPassword;
  public $first_name;
  public $last_name;
  public $phone_number;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['username', 'email', 'password', 'confirmPassword', 'first_name', 'last_name'], 'required'],
      ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
      ['email', 'email'],
      ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
      ['password', 'string', 'min' => 6],
      ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords don\'t match.'],
      [['first_name', 'last_name'], 'string', 'max' => 255],
      ['phone_number', 'string', 'max' => 13],
      ['phone_number', 'unique', 'targetClass' => User::class, 'message' => 'This phone number has already been taken.'],
    ];
  }

  /**
   * Signs up a new user
   *
   * @return User|null the saved model or null if saving fails
   */
  public function signup()
  {
    if (!$this->validate()) {
      return null;
    }

    $user = new User();
    $user->username = $this->username;
    $user->email = $this->email;
    $user->setPassword($this->password);
    $user->first_name = $this->first_name;
    $user->last_name = $this->last_name;
    $user->phone_number = $this->phone_number;
    $user->is_superuser = false;
    $user->is_active = false;
    $user->setAuthKey();
    $user->setAccessToken();

    $sent = Utils::sendEmailFr('qosimovrahmatullo006@gmail.com', 'Your verification token', "$user->first_name welcome to our platform. Open this link in your browser: " . $user->generateAccessLink());
    return $user->save() ? $user : null;
  }

  public function render($model)
  {
    ob_start();
    $form = ActiveForm::begin();


    echo $form->field($model, 'first_name')->textInput()->label(Yii::t('app', 'First name'));
    echo $form->field($model, 'last_name')->textInput()->label(Yii::t('app', 'Last name'));
    echo $form->field($model, 'username')->textInput()->label(Yii::t('app', 'Username'));
    echo $form->field($model, 'email')->input('email')->label(Yii::t('app', 'email'));
    echo $form->field($model, 'phone_number')->textInput()->label(Yii::t('app', 'Phone number'));
    echo $form->field($model, 'password')->passwordInput()->label(Yii::t('app', 'Password'));
    echo $form->field($model, 'confirmPassword')->passwordInput()->label(Yii::t('app', 'Confirm password'));


    echo "<div class='button-box'>";
    echo Html::submitButton(Yii::t("app", "Register"));
    echo "</div>";

    ActiveForm::end();
    return ob_get_clean();
  }
}
