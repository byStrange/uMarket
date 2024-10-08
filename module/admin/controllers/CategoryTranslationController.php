<?php

namespace app\module\admin\controllers;

use app\components\Utils;
use app\models\CategoryTranslation;
use app\module\admin\models\search\CategoryTranslationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryTranslationController implements the CRUD actions for CategoryTranslation model.
 */
class CategoryTranslationController extends Controller
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
      Utils::crudActionsDisableOnly(['delete'])
    ]);
  }

  /**
   * Lists all CategoryTranslation models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new CategoryTranslationSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single CategoryTranslation model.
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
   * Creates a new CategoryTranslation model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new CategoryTranslation();

    if ($this->request->isPost) {
      if ($model->load($this->request->post())) {

        $model->image_file = UploadedFile::getInstance($model, 'image');
        $model->upload();

        if ($model->save()) {
          return $this->redirect(["view", "id" => $model->id]);
        }
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render("create", [
      "model" => $model,
    ]);
  }

  /**
   * Updates an existing CategoryTranslation model.
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
      $model->image_file = UploadedFile::getInstance($model, 'image');
      $model->upload();
      if ($model->save()) {
        return $this->redirect(["view", "id" => $model->id]);
      }
    }

    return $this->render("update", [
      "model" => $model,
    ]);
  }

  /**
   * Deletes an existing CategoryTranslation model.
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
   * Finds the CategoryTranslation model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return CategoryTranslation the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = CategoryTranslation::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }
}
