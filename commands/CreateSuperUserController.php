<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use yii\console\ExitCode;

class CreateSuperUserController extends Controller
{
    public function actionIndex()
    {
        $username = $this->prompt("Username:");
        $email = $this->prompt("Email:");
        $password = $this->prompt("Password:");

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password); // Assuming you have a method to hash the password
        $user->setAccessToken();
        $user->setAuthKey();
        $user->is_active = true;
        $user->is_superuser = true;
        $user->first_name = $username . " first name";
        $user->last_name = $username . " last name";

        if ($user->save()) {
            echo "Superuser created successfully.\n";
            return ExitCode::OK;
        } else {
            echo "Failed to create superuser.\n";
            var_dump($user->errors);
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
?>
