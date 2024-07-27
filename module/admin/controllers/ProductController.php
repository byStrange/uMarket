<?php

namespace app\module\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use app\models\Category;
use app\models\Image;
use app\models\Product;
use app\models\ProductTranslation;
use app\models\User;
use app\module\admin\models\search\ProductSearch;

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
        $dataProvider = $searchModel->search($this->request->queryParams);

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
        $submittedCategories = ArrayHelper::getValue(
            $post,
            "Product.categories"
        );
        $submittedImages = ArrayHelper::getValue($post, "Product.images");
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
        $model->linkAll("categories", $submittedCategories, Category::class);
        $model->linkAll("images", $submittedImages, Image::class);
        $model->linkAll("toProducts", $submittedToProducts, Product::class);
    }

    /**
     * @param Product $model
     *
     * */
    public function unlinkAllProductRelations($model)
    {
        $model->unlinkAll("categories", true);
        $model->unlinkAll("images", true);
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
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $this->linkAllProductRelations($this->request->post(), $model);
                return $this->redirect(["view", "id" => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render("create", [
            "model" => $model,
        ]);
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
            $this->unlinkAllProductRelations($model);
            if ($model->load($this->request->post()) && $model->save()) {
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
        $this->findModel($id)->delete();

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
}
