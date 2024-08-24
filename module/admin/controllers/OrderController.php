<?php

namespace app\module\admin\controllers;

use app\components\Utils;
use app\models\CartItem;
use app\models\Order;
use app\module\admin\models\search\OrderSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
      Utils::crudActionsDisableOnly(['create', 'delete', 'update'], ['change-status', 'cancel', 'ship'])
    ]);
  }

  /**
   * Lists all Order models.
   *
   * @return string
   */
  public function actionIndex()
  {
    $searchModel = new OrderSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    return $this->render("index", [
      "searchModel" => $searchModel,
      "dataProvider" => $dataProvider,
    ]);
  }

  /**
   * Displays a single Order model.
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
   * Creates a new Order model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Order();

    if ($this->request->isPost) {
      if ($model->load($this->request->post()) && $model->save()) {

        $this->linkAllOrderRelations($this->request->post(), $model);
        return $this->redirect(["view", "id" => $model->id]);
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render("create", [
      "model" => $model,
    ]);
  }

  public function linkAllOrderRelations($post, $model)
  {
    $submittedCartItems = ArrayHelper::getValue(
      $post,
      "Order.cartItems"
    );


    $model->linkAll("cartItems", $submittedCartItems, CartItem::class);
  }

  public function actionChangeStatus($id)
  {
    $status = $this->request->post("status");
    if (!array_key_exists($status, Order::getStatusOptions())) {
      Yii::$app->session->setFlash("error", "Invalid status");

      return $this->redirect(["view", "id" => $id]);
    }
    $model = $this->findModel($id);
    $model->status = $status;
    $model->save();

    return $this->redirect(["view", "id" => $model->id]);
  }

  public function actionCancel($id)
  {
    $model = $this->findModel($id);
    $model->status = Order::STATUS_CANCELED;
    $model->save();
    return $this->redirect(['index']);
  }

  public function actionShip($id)
  {
    $model = $this->findModel($id);
    $model->status = Order::STATUS_SHIPPED;
    $model->save();
    return $this->redirect(['index']);
  }
  public function unlinkAllOrderRelations($model)
  {
    $model->unlinkAll("cartItems", true);
  }

  /**
   * Finds the Order model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Order the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Order::findOne(["id" => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException("The requested page does not exist.");
  }
}
