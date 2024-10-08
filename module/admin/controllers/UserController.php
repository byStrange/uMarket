<?php

namespace app\module\admin\controllers;

use app\components\Utils;
use app\models\User;
use app\module\admin\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile as WebUploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
  /**
   * @inheritDoc
   */
  public function behaviors()
  {
    return array_merge(parent::behaviors(), [
      "verbs" => [
        "class" => VerbFilter::class,
        "actions" => [
          "delete" => ["POST"],
        ],
      ],
      Utils::crudActionsDisableOnly(['create', 'delete'])
    ]);
  }

  /**
   * Lists all User models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new UserSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single User model.
   * @param int $id ID
   * @return string
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render("view", [
      "model" => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new User model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate($popup = "")
  {
    $model = new User();

    if ($this->request->isPost) {
      if ($model->load($this->request->post())) {
        $model->setAccessToken();
        $model->setAuthKey();
        $model->setPassword($model->password);
        $model->profile_picture = WebUploadedFile::getInstance($model, 'profile_picture');
        if ($model->save() && $model->upload()) {
          if ($popup) {
            return $this->renderPartial(
              "@app/module/admin/views/_popup_response",
              ["model" => $model]
            );
          }
          return $this->redirect(["view", "id" => $model->id]);
        } else {
          var_dump($model->errors);
          die();
        }
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render("create", [
      "model" => $model,
      "popup" => $popup,
    ]);
  }

  /**
   * Updates an existing User model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if (
      $this->request->isPost &&
      $model->load($this->request->post())
    ) {
      $model->profile_picture = WebUploadedFile::getInstance($model, 'profile_picture');
      if ($model->upload() && $model->save()) {
        return $this->redirect(["view", "id" => $model->id]);
      }
    }

    return $this->render("update", [
      "model" => $model,
    ]);
  }

  /**
   * Deletes an existing User model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(["index"]);
  }

  /**
   * Finds the User model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return User the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = User::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }
}
