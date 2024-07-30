<?php

namespace app\module\admin\controllers;

use app\models\FeaturedOffer;
use app\module\admin\models\search\FeaturedOfferSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FeaturedOfferController implements the CRUD actions for FeaturedOffer model.
 */
class FeaturedOfferController extends Controller
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
   * Lists all FeaturedOffer models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new FeaturedOfferSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single FeaturedOffer model.
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
   * Creates a new FeaturedOffer model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new FeaturedOffer();

    if ($this->request->isPost) {
      if ($model->load($this->request->post())) {
        $model->image_banner = UploadedFile::getInstance($model, 'image_banner');
        $model->image_portrait = UploadedFile::getInstance($model, 'image_portrait');
        $model->image_small_landscape = UploadedFile::getInstance($model, 'image_small_landscape');
        if ($model->upload() && $model->save()) {
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
   * Updates an existing FeaturedOffer model.
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
      $model->load($this->request->post()) &&
      $model->save()
    ) {
      return $this->redirect(["view", "id" => $model->id]);
    }

    return $this->render("update", [
      "model" => $model,
    ]);
  }

  /**
   * Deletes an existing FeaturedOffer model.
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
   * Finds the FeaturedOffer model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return FeaturedOffer the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = FeaturedOffer::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }
}
