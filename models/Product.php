<?php

namespace app\models;

use app\components\Utils;
use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "main_product".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property float $price
 * @property float|null $discount_price
 * @property string $status
 * @property int $views
 * @property int $created_by_id
 * @property int $average_rating
 * @property int $total_ratings
 * @property string $brand
 * @property int $category_id
 * 
 *
 *
 * @property Category $category
 * @property User $createdBy
 * @property Product[] $fromProducts
 * @property Image[] $images
 * @property CartItem[] $cartItems
 * @property Wishlistitem[] $wishlistitems
 * @property Product[] $toProducts
 * @property ProductSpecification[] $specifications
 * @property User[] $likedUsers
 * @property User[] $viewers
 * @property Rating[] $ratings
 * @property ProductTranslation[] $translations
 * @property FeaturedOffer $featuredOffers
 */
class Product extends \yii\db\ActiveRecord
{
  const STATUS_DRAFT = "draft";
  const STATUS_PUBLISHED = "published";
  const STATUS_DISABLED = "disabled";
  const STATUS_ARCHIVED = "archived";
  const STATUS_OUT_OF_STOCK = "out_of_stock";
  const VISIBLE_STATUSES = [Product::STATUS_OUT_OF_STOCK, Product::STATUS_PUBLISHED];

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return "main_product";
  }

  public static function find()
  {
    return new ProductQuery(get_called_class());
  }

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [["price", "status", "title"], "required"],
      [["title", "description", "brand"], "string", "max" => 255],
      [["created_at", "updated_at"], "safe"],
      [
        ["price", "discount_price", "average_rating", "total_ratings"],
        "number",
      ],
      [["created_by_id"], "default", "value" => Yii::$app->user->id],
      [["views", "created_by_id"], "integer"],
      [["views"], "default", "value" => 0],
      [["status"], "string", "max" => 20],
      [
        ["category_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => Category::class,
        "targetAttribute" => ["category_id" => "id"],
      ],
      [
        ["created_by_id"],
        "exist",
        "skipOnError" => true,
        "targetClass" => User::class,
        "targetAttribute" => ["created_by_id" => "id"],
      ],
      [['average_rating', 'total_ratings'], 'default', 'value' => 0]
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels()
  {
    return [
      "id" => "ID",
      "created_at" => Yii::t('app', "Created At"),
      "updated_at" => Yii::t('app', "Updated At"),
      "price" => Yii::t('app', "Price"),
      "brand" => Yii::t('app', "Brand"),
      "discount_price" => Yii::t("app", "Discount Price"),
      "status" => Yii::t("app", "Status"),
      "views" => Yii::t("app", "Views"),
      "created_by_id" => Yii::t("app", "Created By ID"),
    ];
  }


  public function behaviors()
  {
    return [
      [
        "class" => TimestampBehavior::class,
        "value" => new Expression("now()"),
      ],
    ];
  }

  public static function getStatusOptions()
  {
    return [
      self::STATUS_DRAFT =>  Yii::t('app', 'Draft'),
      self::STATUS_PUBLISHED => Yii::t("app", "Published"),
      self::STATUS_DISABLED => Yii::t("app", "Disabled"),
      self::STATUS_ARCHIVED => Yii::t("app", "Archived"),
      self::STATUS_OUT_OF_STOCK => Yii::t("app", "Out of Stock"),
    ];
  }

  public static function getMostFamous8()
  {
    return self::find()
      ->active()
      ->andWhere(["status" => [self::STATUS_PUBLISHED, self::STATUS_OUT_OF_STOCK]])
      /*->select(['id', 'average_rating', 'total_ratings'])*/
      ->orderBy([
        "total_ratings" => SORT_DESC,
        "average_rating" => SORT_DESC,
      ])
      ->limit(8)
      ->all();
  }

  public function getTranslations()
  {
    return $this->hasMany(ProductTranslation::class, [
      "product_id" => "id",
    ]);
  }

  /**
   * Gets query for [[Category]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCategory()
  {
    return $this->hasOne(Category::class, [
      "id" => "category_id",
    ]);
  }

  public function getRatings()
  {
    return $this->hasMany(Rating::class, [
      "product_id" => "id",
    ]);
  }

  public function updateRatingStats()
  {
    $this->total_ratings = $this->getRatings()->count() ? $this->getRatings()->count() : 0;
    $this->average_rating = $this->getRatings()->average("score") ? $this->getRatings()->average("score") : 0;
    return $this->save(false);
  }

  public function afterSave($insert, $changedAttributes)
  {
    parent::afterSave($insert, $changedAttributes);
    if ($insert) {
      $this->updateRatingStats();
    }
  }

  /**
   * Gets query for [[CreatedBy]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCreatedBy()
  {
    return $this->hasOne(User::class, ["id" => "created_by_id"]);
  }

  /**
   * Gets all the products in which this product was being used
   *
   * @return \yii\db\ActiveQuery
   */
  public function getFromProducts()
  {
    return $this->hasMany(Product::class, [
      "id" => "from_product_id",
    ])->viaTable("main_product_related_products", [
      "to_product_id" => "id",
    ]);
  }

  public function getFeaturedOffers()
  {
    return $this->hasMany(FeaturedOffer::class, ['id' => 'featured_offer_id'])->viaTable('main_featuredoffer_main_products', ['product_id' => 'id']);
  }
  public function getProductTranslationForLanguage($lang = "")
  {
    /*Utils::printAsError(Yii::$app->language);*/
    $translations = ProductTranslation::findOne([

      "product_id" => $this->id,
      "language_code" => $lang ? $lang : Yii::$app->language,
    ]);
    $newTr = new ProductTranslation(['title' => $this->title, "description" => $this->description]);
    return $translations ? $translations : $newTr;
  }

  public function getProductSalePercentage()
  {

    if ($this->discount_price > $this->price) {
      return false;
    }

    $offers = $this->getFeaturedOffers()->andWhere(FeaturedOffer::activeOffers(true))->orderBy(['created_at' => SORT_DESC])->all();
    if (count($offers) > 1) {
      // handle the warning
    }

    $offer = count($offers) ? $offers[0] : null;

    if ($offer && $offer->isActive()) {
      $perc = null;
      switch ($offer->price_type) {
        case 'percentage':
          $perc = $offer->discount;
          break;
        case 'fixed':
          $discount_amount = $this->price - $offer->discount;
          $perc = ($discount_amount / $this->price) * 100;

        case 'amount':
          $perc = ($offer->discount / $this->price) * 100;
      }

      return $perc;
    }
    return $this->discount_price
      ? ($this->discount_price / $this->price) * 100 - 100
      : 0;
  }

  /**
   * Gets query for [[Images]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getImages()
  {
    return $this->hasMany(Image::class, ['id' => 'image_id'])->viaTable('main_product_images', ['product_id' => 'id']);
  }

  /**
   * Gets query for [[CartItems]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getCartItems()
  {
    return $this->hasMany(CartItem::class, ["product_id" => "id"]);
  }

  /**
   * Gets query for [[Wishlistitems]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getWishlistitems()
  {
    return $this->hasMany(Wishlistitem::class, ['product_id' => 'id']);
  }

  /**
   * Gets query for [[ProductSpecifications]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getSpecifications()
  {
    return $this->hasMany(ProductSpecification::class, ['product_id' => 'id']);
  }

  /**
   * Gets all related_products of the product
   *
   *
   * @return \yii\db\ActiveQuery
   */

  public function getToProducts()
  {
    return $this->hasMany(Product::class, [
      "id" => "to_product_id",
    ])->viaTable("main_product_related_products", [
      "from_product_id" => "id",
    ]);
  }

  /**
   * Gets query for [[Users]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getLikedUsers()
  {
    return $this->hasMany(User::class, ["id" => "user_id"])->viaTable(
      "main_product_likes",
      ["product_id" => "id"]
    );
  }

  /**
   * Gets query for [[Users0]].
   *
   * @return \yii\db\ActiveQuery
   */
  public function getViewers()
  {
    return $this->hasMany(User::class, ["id" => "user_id"])->viaTable(
      "main_product_viewers",
      ["product_id" => "id"]
    );
  }

  // product price has a few priority checks. Priority goes as following:
  // 1. featured offer (type product)
  // 2. featured offer (type category)
  // 3. discount price
  // 4. price
  // 
  // statement 1 states that if there is a featured offer targeting specifically that product the discount price from that featured offer will be used no matter what.
  // statement 2 states that if there is a featured offer targeting a single category and a product is a part of that category the discount price from that featured offer will be used..
  // if there no featured offer then the discount price will be used if it is set, otherwise the price will be used.
  // so cleanPrice is the real value of a product in the platform 
  public function cleanPrice()
  {
    $offers = $this->getFeaturedOffers()->andWhere(FeaturedOffer::activeOffers(true))->orderBy(['created_at' => SORT_DESC])->all();

    if (count($offers) > 1) {
      // handle the warning
    }

    $cleanPrice = $this->price;

    $featuredOffer = count($offers) ? $offers[0] : null;

    if ($featuredOffer && $featuredOffer->isActive()) {
      switch ($featuredOffer->price_type) {
        case 'percentage':
          $cleanPrice =  $this->price - (($this->price / 100) * $featuredOffer->discount);
          break;
        case 'amount':
          $cleanPrice = $this->price - $featuredOffer->discount;
        case 'fixed':
          $cleanPrice = $featuredOffer->discount;
      }
      return $cleanPrice;
    }

    $category = $this->category;
    $discount_price_from_category = 0;

    global $discount_price_from_category;
    /** @var Category $category */
    if ($category && $category->featuredOffer && $category->featuredOffer->isActive()) {

      switch ($featuredOffer->price_type) {
        case 'percentage':
          $discount_price_from_category =  $this->price - (($this->price / 100) * $featuredOffer->discount);
          break;
        case 'amount':
          $discount_price_from_category = $this->price - $featuredOffer->discount;
        case 'fixed':
          $discount_price_from_category = $featuredOffer->discount;
      }
    }

    if ($discount_price_from_category) {
      return $discount_price_from_category;
    }

    return $this->discount_price ? $this->discount_price : $this->price;
  }
  public function priceAsCurrency()
  {
    return Yii::$app->formatter->asCurrency((int)$this->cleanPrice());
  }

  public function discountPriceAsCurrency()
  {
    return Yii::$app->formatter->asCurrency($this->discount_price);
  }

  public function comparisonPrice()
  {
    if ($this->cleanPrice() >= $this->price) {
      return false;
    }
    return ['discount_price' => $this->priceAsCurrency(), 'price' => Yii::$app->formatter->asCurrency($this->price)];
  }

  public function isOnTheCart()
  {
    $session = Yii::$app->session;
    $cart_id = $session->get('cart_id');
    if (!$cart_id) {
      return false;
    }

    $cart_item = $this->getCartItems()->where(['cart_id' => $cart_id])->one();
    if ($cart_item) {
      return true;
    }

    return false;
  }

  public function isOnTheWishlist()
  {
    $session = Yii::$app->session;
    $user_cart = Yii::$app->user->identity ? Yii::$app->user->identity->cart : null;

    $cart_id = $user_cart ? Yii::$app->user->identity->cart->id : $session->get('cart_id');
    if (!$cart_id) return false;

    $wishlistitem = $this->getWishlistitems()->where(['cart_id' => $cart_id])->one();
    if ($wishlistitem) {
      return true;
    }
    return false;
  }

  public function linkAll($relation, $ids_list, $relation_model)
  {
    if (!is_array($ids_list)) {
      return;
    }
    foreach ($ids_list as $id) {
      if ($id) {
        $this->link($relation, $relation_model::findOne(["id" => $id]));
      }
    }
  }

  public function markAs($status)
  {
    if (!in_array($status, array_keys(self::getStatusOptions()))) {
      throw new \Exception("Invalid status");
    }
    $this->status = $status;

    if (!$this->save()) {
      throw new \Exception("Failed when saving. Could not mark product as " . $status);
    }
  }

  public static function toOptionsList($includeDescription = false)
  {
    $products = Product::find()->active()->andWhere(['status' => Product::VISIBLE_STATUSES])->all();
    $options = [];

    foreach ($products as $product) {
      if ($includeDescription) {
        $options[$product->id] = [
          'label' => (string) $product,
          'description' => Yii::$app->formatter->asCurrency($product->price)
        ];
      } else {
        $options[$product->id] = (string) $product;
      }
    }

    return $options;
  }

  public function upload($images)
  {
    foreach ($images as $image) {
      $path = Utils::uploadImage($image);
      $image = new Image();
      $image->image = $path;
      $image->alt = "alt";
      $image->save();
      /*Utils::printAsError($image->errors);*/
      $this->link('images', $image);
    }
  }

  public function _getImagesAsHTMLMarkup()
  {
    $initialPreview = [];
    $initialPreviewConfig = [];
    $images = $this->images;

    $images = $this->images;

    foreach ($images as $image) {
      $initialPreview[] = Yii::getAlias('@web') . '/' . $image->image; // URL to the image
      $initialPreviewConfig[] = [
        'caption' => basename($image->image), // Display filename
        'size' => filesize(Yii::getAlias('@webroot') . '/' . $image->image), // File size
        'url' => Url::to(['delete-image']), // URL to delete action
        'key' => $image->id, // Unique identifier for the file
      ];
    }

    return [
      "initialPreview" => $initialPreview,
      "initialPreviewConfig" => $initialPreviewConfig
    ];
  }

  public function __toString()
  {
    return $this->getProductTranslationForLanguage()->title
      ? $this->getProductTranslationForLanguage()->title
      : $this->createdBy->username . " -> " . $this->id;
  }

  public static function _getBrands()
  {
    return self::find()->active()->select(['brand'])->where('brand != \'\'')->asArray()->all();
  }

  public static function _getTranslation($product)
  {
    if (isset($product->asArray) && $product->asArray) {
      $translation = Utils::find($product->translations, function ($translation) {
        return $translation['language_code'] == Yii::$app->language;
      });
      if ($translation) {
        return new ProductTranslation(['title' => $translation['title'], 'description' => $translation['description']]);
      }
      return new ProductTranslation(['title' => $product->title, 'description' => $product->description]);
    }
    return $product->getProductTranslationForLanguage();
  }

  public static function _getSalesPercentage($product)
  {
    if (isset($product->asArray) && $product->asArray) {
      return $product->sale_percentage;
    }
    return $product->getProductSalePercentage();
  }

  public static function _getImages($product)
  {
    return $product->images;
  }

  public static function _getComparisionPrice($product)
  {
    if (isset($product->asArray) && $product->asArray) {
      if ($product->effective_price >= $product->price) return null;

      return ["discount_price" => Yii::$app->formatter->asCurrency($product->effective_price), "price" => Yii::$app->formatter->asCurrency($product->price)];
    }
    return $product->comparisonPrice();
  }
}
