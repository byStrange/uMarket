<?php

namespace app\module\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\Image;
use app\models\Product;
use app\models\ProductSpecification;
use app\models\ProductTranslation;
use app\models\User;
use app\module\admin\models\search\ProductSearch;
use yii\web\Response;
use yii\web\UploadedFile as WebUploadedFile;
use yii\widgets\ActiveForm;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
    ]);
  }

  /**lang:
   * Lists all Product models.
   *
   * @return string
   */

  public function actionIndex()
  {
    $searchModel = new ProductSearch();
    $dataProvider = $searchModel->search($this->request->queryParams, true);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single Product model.
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
   * Links all the relations of Product model.
   * @param Yii\web\request::post $post
   * @param Product $model
   *
   * @return null
   */

  public function linkAllProductRelations($post, $model)
  {


    $submittedToProducts = ArrayHelper::getValue(
      $post,
      "Product.toProducts"
    );
    $submittedViewers = ArrayHelper::getValue($post, "Product.viewers");
    $submittedLikedUsers = ArrayHelper::getValue(
      $post,
      "Product.likedUsers"
    );

    $model->linkAll("viewers", $submittedViewers, User::class);
    $model->linkAll("likedUsers", $submittedLikedUsers, User::class);
    $model->linkAll("toProducts", $submittedToProducts, Product::class);
  }

  /**
   * @param Product $model
   *
   * */
  public function unlinkAllProductRelations($model)
  {
    $model->unlinkAll("toProducts", true);
    $model->unlinkAll("toProducts", true);
    $model->unlinkAll("viewers", true);
    $model->unlinkAll("likedUsers", true);
  }

  /**
   * Creates a new Product model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate($popup = "")
  {
    $model = new Product();

    if ($this->request->isPost) {

      $submittedImages = WebUploadedFile::getInstances($model, 'images');

      if ($model->load($this->request->post())) {
        if (count($submittedImages) < 5) {
          $model->addError('images', 'minimum 5 images required, but only ' . (string)count($submittedImages));
        } else {
          $model->save();
          $model->upload($submittedImages);
          $this->linkAllProductRelations($this->request->post(), $model);

          $this->saveSpecifications($model->id, $this->request->post('ProductSpecification', []));

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

  public function actionDeleteImage()
  {
    $this->response->format = Response::FORMAT_JSON;
    $id = $this->request->post('key');

    $image = Image::findOne($id);
    $image->delete();

    if (!$image) {
      return ['error' => true, 'reason' => "Image with id $id Found"];
    }
  }

  /**
   * Updates an existing Product model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);
    $translationModel = new ProductTranslation();

    if ($this->request->isPost) {
      if ($model->load($this->request->post()) && $model->save()) {
        $images = WebUploadedFile::getInstances($model, 'images');
        $model->upload($images);

        $this->saveSpecifications($model->id, $this->request->post('ProductSpecification', []));

        $this->unlinkAllProductRelations($model);

        $this->linkAllProductRelations($this->request->post(), $model);
        return $this->redirect(["view", "id" => $model->id]);
      } elseif (
        $translationModel->load($this->request->post()) &&
        $translationModel->save()
      ) {
        return $this->redirect(["update", "id" => $model->id]);
      }
    }

    return $this->render("update", [
      "model" => $model,
      "translationModel" => $translationModel,
    ]);
  }

  /**
   * Deletes an existing Product model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $product = Product::findOne($id);
    $product->is_deleted = true;
    $product->save();

    return $this->redirect(["index"]);
  }

  /**
   * Finds the Product model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Product the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Product::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }

  protected function saveSpecifications($productId, $specificationsData)
  {
    ProductSpecification::deleteAll(['product_id' => $productId]);

    foreach ($specificationsData as $specData) {
      if (!empty($specData['spec_key']) && !empty($specData['spec_value'])) {

        $specification = new ProductSpecification();
        $specification->product_id = $productId;
        $specification->spec_key = $specData['spec_key'];
        $specification->spec_value = $specData['spec_value'];
        $specification->save();
      }
    }
  }

  public function actionRemoveSpecification($id)
  {
    $this->response->format = Response::FORMAT_JSON;
    $specification = ProductSpecification::findOne($id);
    $specification->delete();
    if (!$specification) {
      $this->response->statusCode = 404;
      return ['ok' => false, 'error' => "Specification not found", "errorCode" => "NotFound", 'action' => "removeSpecification", 'data' => null];
    }

    return ['ok' => true, 'action' => "removeSpecification", "id" => $id];
  }

  public function actionUpdateSpecification($id)
  {
    $this->response->format = Response::FORMAT_JSON;
    $specification = ProductSpecification::findOne($id);

    if (!$specification) {
      $this->response->statusCode = 404;
      return ['ok' => false, 'error' => "Specification not found", "errorCode" => "NotFound", 'action' => "updateSpecification", 'data' => null];
    }

    $data = $this->request->getBodyParams();

    $specification->spec_key = $data['spec_key'];
    $specification->spec_value = $data['spec_value'];

    if (!$specification->save()) {
      $this->response->statusCode = 400;
      return ['ok' => false, 'error' => "Specification not updated", "errorCode" => "BadRequest", 'action' => "updateSpecification", 'data' => null];
    }

    $this->response->statusCode = 201;
    return ['ok' => true, 'action' => "updateSpecification", "id" => $id, 'data' => $specification];
  }

  public function actionMarkAsPublished($id)
  {
    $product = Product::findOne($id);
    if (!$product) {
      return $this->render('404');
    }

    $product->markAs(Product::STATUS_PUBLISHED);

    return $this->redirect(['index']);
  }

  public function actionMarkAsDisabled($id)
  {
    $product = Product::findOne($id);
    if (!$product) {
      return $this->render('404');
    }

    $product->markAs(Product::STATUS_DISABLED);
    return $this->redirect(['index']);
  }

  public function actionAddSpecification()
  {
    $model = new ProductSpecification();
    return $this->renderPartial('_spec_form', [
      'form' => ActiveForm::begin(),
      'model' => $model,
      'index' => Yii::$app->request->get('index'),
    ]);
  }
}
