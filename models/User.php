<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "main_user".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 * @property string|null $phone_number
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property bool $is_superuser
 * @property bool $is_active
 * @property string $profile_picture
 *
 * @property Cart[] $Carts
 * @property Order[] $Orders
 * @property Product[] $Products
 * @property UserAddress[] $UserAddresses
 * @property Product[] $likedProducts
 * @property Product[] $viewedProducts
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_user";
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [
        [
          "username",
          "password",
          "authKey",
          "accessToken",
          "email",
          "first_name",
          "last_name",
          "is_superuser",
          "is_active",
        ],
        "required",
      ],
      [["created_at", "updated_at"], "safe"],
      [["password"], "string"],
      [["is_superuser", "is_active"], "boolean"],
      [["profile_picture"], "file", "skipOnEmpty" => true],
      [
        [
          "username",
          "authKey",
          "accessToken",
          "email",
          "first_name",
          "last_name",
        ],
        "string",
        "max" => 255,
      ],
      [["phone_number"], "string", "max" => 13],
      [["phone_number"], "unique"],
      [["username"], "unique"],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      "id" => "ID",
      "created_at" => "Created At",
      "updated_at" => "Updated At",
      "username" => "Username",
      "password" => "Password",
      "authKey" => "Auth Key",
      "accessToken" => "Access Token",
      "phone_number" => "Phone Number",
      "email" => "Email",
      "first_name" => "First Name",
      "last_name" => "Last Name",
      "is_superuser" => "Is Superuser",
      "is_active" => "Is Active",
      "profile_picture" => "Profile Picture",
    ];
  }

  public function behaviors()
  {
    return [
      [
        "class" => TimestampBehavior::class,
        "value" => new Expression("NOW()"),
      ],
    ];
  }

  /**
   * Gets query for [[Carts]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCarts()
  {
    return $this->hasMany(Cart::class, ["user_id" => "id"]);
  }

  /**
   * Gets query for [[Orders]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getOrders()
  {
    return $this->hasMany(Order::class, ["user_id" => "id"]);
  }

  /**
   * Gets query for [[Products]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getProducts()
  {
    return $this->hasMany(Product::class, ["created_by_id" => "id"]);
  }

  /**
   * Gets query for [[UserAddresses]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getUserAddresses()
  {
    return $this->hasMany(UserAddress::class, ["user_id" => "id"]);
  }

  /**
   * Gets query for [[Products]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getLikedProducts()
  {
    return $this->hasMany(Product::class, ["id" => "product_id"])->viaTable(
      "main_product_likes",
      ["user_id" => "id"]
    );
  }

  /**
   * Gets query for [[Products0]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getViewedProducts()
  {
    return $this->hasMany(Product::class, ["id" => "product_id"])->viaTable(
      "main_product_viewers",
      ["user_id" => "id"]
    );
  }

  public static function toOptionsList() {
    return ArrayHelper::map(self::find()->select(['username', 'id'])->all(), 'id', function ($model) {
      return (string)$model;
    });
  }

  public function __toString()
  {
    return $this->username;
  }

  /**
   * Gets query for [[ProfilePicture]].
   *
   * @return \yii\db\ActiveQuery
   */

  public static function findIdentity($id)
  {
    return self::findOne(["id" => $id]);
  }

  public static function findIdentityByAccessToken($access, $type = null)
  {
    return self::findOne(["accessToken" => $access]);
  }

  public static function findByUsername($username)
  {
    return self::findOne(["username" => $username]);
  }

  public function getId()
  {
    return $this->id;
  }

  public function getAuthKey()
  {
    return $this->authKey;
  }

  public function validateAuthKey($authKey)
  {
    return $this->getAuthKey() == $authKey;
  }

  public function validatePassword($password)
  {
    return Yii::$app->security->validatePassword(
      $password,
      $this->password
    );
  }

  public function setPassword($password)
  {
    $this->password = Yii::$app->security->generatePasswordHash($password);
  }

  public function setAccessToken()
  {
    $this->accessToken = Yii::$app->security->generateRandomString();
  }
  public function setAuthKey()
  {
    $this->authKey = Yii::$app->security->generateRandomString();
  }
}
