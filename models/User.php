<?php

namespace app\models;

use app\components\Utils;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;

/**
 * This is the model class for table "main_user".
 *
 * @property int $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $username
 * @property string $password
 * @property string $authkey
 * @property string $accesstoken
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
          "authkey",
          "accesstoken",
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
          "authkey",
          "accesstoken",
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
      "authkey" => "Auth Key",
      "accesstoken" => "Access Token",
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
  public function getCart()
  {
    return $this->hasOne(Cart::class, ["user_id" => "id"]);
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
  public function getViewedProducts($exclude = [])
  {
    $query = $this->hasMany(Product::class, ["id" => "product_id"])->viaTable(
      "main_product_viewers",
      ["user_id" => "id"]
    );

    if (!empty($exclude)) {
      $query->andWhere(['not in', 'main_product.id', $exclude]);
    }

    return $query;
  }

  public static function toOptionsList()
  {
    return ArrayHelper::map(
      self::find()
        ->select(["username", "id"])
        ->all(),
      "id",
      function ($model) {
        return (string) $model;
      }
    );
  }

  public function getRatings()
  {
    return $this->hasMany(Rating::class, ["user_id" => "id"]);
  }


  public static function getRecentlySeenProducts($limit = 5, $exclude = [])
  {
    $user = Yii::$app->user->identity;
    $query = Product::find()->where(['is_deleted' => false]);

    if ($user) {
      // Fetch recently viewed products for logged-in user from database
      $query->innerJoin('product_viewers pv', 'pv.product_id = product.id')
        ->where(['pv.user_id' => $user->id]);

      if ($exclude) {
        $query->andWhere(['not in', 'product.id', $exclude]);
      }

      return $query->limit($limit)->all();
    }

    // If user is not logged in, fetch from session
    $session = Yii::$app->session;
    $user_recently_viewed = $session->get('user_recently_viewed');

    if ($user_recently_viewed) {
      $query->andWhere(['id' => $user_recently_viewed]);

      if ($exclude) {
        $query->andWhere(['not in', 'id', $exclude]);
      }

      return $query->limit($limit)->all();
    }

    return []; // Return an empty array if no recently viewed products are found
  }


  public function hasRated($product_id)
  {
    return $this->getRatings()->andWhere(["product_id" => $product_id])->exists();
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

  public static function findIdentityByaccesstoken($access, $type = null)
  {
    return self::findOne(["accesstoken" => $access]);
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
    return $this->authkey;
  }

  public function validateAuthKey($authkey)
  {
    return $this->getAuthKey() == $authkey;
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

  public function setaccesstoken()
  {
    $this->accesstoken = Yii::$app->security->generateRandomString();
  }

  public function generateJWTPayload()
  {
    $issuedAt = time();
    $expirationTime = $issuedAt + 3600;
    $payload = [
      'iss' => 'umarket',
      'aud' => 'umarket-frontend-client',
      'iat' => $issuedAt,
      'exp' => $expirationTime,
      'sub' => $this->id,
      'jti' => bin2hex(random_bytes(16)),
      'data' => [
        'id' => $this->id,
        'username' => $this->username,
        'is_active' => $this->is_active,
        'is_superuser' => $this->is_superuser,
      ]
    ];

    return $payload;
  }
  public function setAuthKey()
  {
    $secretKey = "secretKey";
    $payload = $this->generateJWTPayload();
    $jwt = JWT::encode($payload, $secretKey, 'HS256');

    $this->authkey = $jwt;
  }

  public function generateAccessLink()
  {
    return Url::toRoute(['site/verify-access-token', 'accesstoken' => $this->accesstoken], true);
  }

  public function upload()
  {
    $uploaded_file = Utils::uploadImage($this->profile_picture);
    if ($uploaded_file) {
      $this->profile_picture = $uploaded_file;
    }
    return true;
  }
}
