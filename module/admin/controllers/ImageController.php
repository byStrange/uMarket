<?php

namespace app\module\admin\controllers;

use app\models\Image;
use app\module\admin\models\search\ImageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
{
  /**
   * @inheritDoc
   */
  public function behaviors()
  {
    return array_merge(parent::behaviors(), [
      "verbs" => [
        "class" => VerbFilter::className(),
        "actions" => [
          "delete" => ["POST"],
        ],
      ],
    ]);
  }

  /**
   * Lists all Image models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new ImageSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single Image model.
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
   * Creates a new Image model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate($popup = "")
  {
    $model = new Image();

    if ($this->request->isPost) {
      if ($model->load($this->request->post())) {
        $model->image_file = UploadedFile::getInstance($model, "image_file");
        if ($model->image_file) $model->upload();

        if ($model->save()) {
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
   * Updates an existing Image model.
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
      $model->image_file = UploadedFile::getInstance($model, 'image_file');

      if ($model->image_file) $model->upload();
      $model->save();
      return $this->redirect(["view", "id" => $model->id]);
    }

    return $this->render("update", [
      "model" => $model,
    ]);
  }

  /**
   * Deletes an existing Image model.
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
   * Finds the Image model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Image the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Image::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }
}
