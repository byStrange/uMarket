<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "main_cartitem".
 *
 * @property int $id
 * @property int $quantity
 * @property int $cart_id
 * @property int $product_id
 *
 * @property Cart $cart
 * @property Order[] $orders
 * @property Product $product
 */
class CartItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "main_cartitem";
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [["quantity", "cart_id", "product_id"], "required"],
            [["quantity", "cart_id", "product_id"], "default", "value" => null],
            [["quantity", "cart_id", "product_id"], "integer"],
            [
                ["cart_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Cart::class,
                "targetAttribute" => ["cart_id" => "id"],
            ],
            [
                ["product_id"],
                "exist",
                "skipOnError" => true,
                "targetClass" => Product::class,
                "targetAttribute" => ["product_id" => "id"],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            "id" => "ID",
            "quantity" => "Quantity",
            "cart_id" => "Cart ID",
            "product_id" => "Product ID",
        ];
    }

    /**
     * Gets query for [[Cart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart()
    {
        return $this->hasOne(Cart::class, ["id" => "cart_id"]);
    }
    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ["id" => "order_id"])->viaTable(
            "main_order_order_items",
            ["cartitem_id" => "id"]
        );
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ["id" => "product_id"]);
    }

    public static function toOptionsList() {
      return ArrayHelper::map(self::find()->select(['cart_id', 'product_id', 'id'])->all(), 'id', function ($model) {
        return (string)($model);
      });
    }

    public function __toString()
    {
      return  (string)$this->cart . ' -> ' . (string)$this->product;
    }
}
