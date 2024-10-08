<?php

namespace app\module\admin\controllers;

use app\models\Category;
use app\models\CategoryTranslation;
use app\module\admin\models\search\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
   * Lists all Category models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new CategorySearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single Category model.
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
   * Creates a new Category model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate($popup = "")
  {
    $model = new Category();

    if ($this->request->isPost) {
      if ($model->load($this->request->post())) {
        $model->image_file = UploadedFile::getInstance($model, 'image');
        $model->upload();
        if ($model->save()) {
          if ($popup) {
            return $this->renderPartial(
              "@app/module/admin/views/_popup_response",
              ["model" => $model]
            );
          }
          return $this->redirect(["view", "id" => $model->id]);
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
   * Updates an existing Category model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $translationModel = new CategoryTranslation();

    if ($this->request->isPost) {
      if ($model->load($this->request->post())) {
        $model->image_file = UploadedFile::getInstance($model, 'image');
        $model->upload();
        if ($model->save()) {
          return $this->redirect(["view", "id" => $model->id]);
        }
      } elseif (
        $translationModel->load($this->request->post())
      ) {
        $translationModel->image_file = UploadedFile::getInstance($translationModel, 'image');
        $translationModel->upload();
        if ($translationModel->save()) {
          return $this->redirect(["update", "id" => $model->id]);
        }
      }
    }

    return $this->render("update", [
      "model" => $model,
      "translationModel" => $translationModel,
    ]);
  }

  /**
   * Deletes an existing Category model.
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
   * Finds the Category model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Category the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Category::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }
}
