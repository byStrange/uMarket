<?php

namespace app\components;

use Exception;
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;

class Utils extends Component
{

  const localEmailDir = '@app/mail';
  public static function preSelectOptions($existingRelation)
  {
    if (empty($existingRelation)) {
      return [];
    }
    $options = [];
    $existingIds = array_column($existingRelation, "id");
    foreach ($existingIds as $id) {
      var_dump($id);
      $options[$id] = [
        "selected" => in_array($id, $existingIds),
      ];
    }
    return $options;
  }

  public static function uploadImage(
    $image,
    $outputFolder = "uploads",
    $generateImageId = null
  ) {
    if (!$image || !$image->tempName) {
      return false;
    }

    if (!is_dir($outputFolder)) {
      if (!mkdir($outputFolder, 0755, true)) {
        throw new Exception(
          "Failed to create upload directory: $outputFolder"
        );
      }
    }

    $filename = $generateImageId
      ? $generateImageId($image) . "." . $image->extension
      : $image->baseName . uniqid() . "." . $image->extension;
    $filePath = $outputFolder . "/" . $filename;

    if (!$image->saveAs($filePath)) {
      throw new Exception("Failed to save uploaded image to $filePath");
    }

    return $filePath;
  }

  public static function popupField($form, $model, $modelName = "", $field)
  {
    echo "<div class='row'>";
    echo "<div class='col-9'>";
    $d = $field($form, $model);
    echo $d;
    echo "</div>";
    echo "<div class='col-3 d-flex align-items-center'>";
    $inputId = $d->inputId;
    $inputIdSplit = explode("-", $inputId);
    $inputIdToModelName = $modelName ? $modelName : $inputIdSplit[1];
    $inputIdModelName = explode("_", $inputIdToModelName)[0];
    echo Html::a(
      "<i class='fa fa-plus' aria-hidden='true'></i>",
      Url::toRoute([$inputIdModelName . "/create"]) . "/?popup=1",
      [
        "id" => "add-" . $inputId,
        "data-popup" => "",
        "title" => "Create category object and insert it here",
      ]
    );

    echo "</div>";
    echo "</div>";
  }
  public static function renderSortLink($attributeName, $ascendingName, $descendingName, $sort, $onlySort = null)
  {
    $linkOptions = ['class' => 'dropdown-item'];
    if ($onlySort) {
      $sort->setAttributeOrders([$attributeName => $onlySort]);
      if ($sort->getAttributeOrder($attributeName) == $onlySort) {
        $pickName = null;
        if ($onlySort == SORT_ASC) {
          global $pickName;
          $pickName = $ascendingName;
        } else if ($onlySort == SORT_DESC) {
          global $pickName;
          $pickName = $descendingName;
        }
        echo Html::a($pickName, $sort->createUrl($attributeName), $linkOptions);
        return;
      }
    }
    echo Html::a($sort->getAttributeOrder($attributeName) == SORT_DESC ? $ascendingName : $descendingName, $sort->createUrl($attributeName), $linkOptions);
  }

  /**
   * Get the configuration value by key with a fallback default value.
   *
   * @param string $key The configuration key.
   * @param mixed $default The fallback value if the key does not exist.
   * @return mixed The configuration value.
   */
  public static function getConfig($key, $default = null)
  {
    $configPath = __DIR__ . '/../config/config.json'; // Adjust the path as needed

    if (!file_exists($configPath)) {
      return $default;
    }

    $configContent = file_get_contents($configPath);
    $config = json_decode($configContent, true);

    return isset($config[$key]) ? $config[$key] : $default;
  }

  /**
   * Set the configuration value for a specific key.
   *
   * @param string $key The configuration key.
   * @param mixed $value The value to set.
   * @return bool True if the configuration was successfully updated, false otherwise.
   */
  public static function setConfig($key, $value)
  {
    $configPath = __DIR__ . '/../config/config.json'; // Adjust the path as needed

    if (!file_exists($configPath)) {
      $config = [];
    } else {
      $configContent = file_get_contents($configPath);
      $config = json_decode($configContent, true);
    }

    $config[$key] = $value;
    $configContent = json_encode($config, JSON_PRETTY_PRINT);

    return file_put_contents($configPath, $configContent) !== false;
  }

  public static function printAsError($text, $die = true)
  {
    echo '<pre>';
    var_dump($text);
    echo '</pre>';
    if ($die) die;
  }
  public static function daysInSeconds(int|float $days)
  {
    return $days * 24 * 60 * 60;
  }

  public static function sendEmail($to, $subject, $content)
  {
    $timestamp = date('Y-m-d_H-i-s');
    $filename = Yii::getAlias(self::localEmailDir) . "/{$timestamp}_{$to}.eml";

    $headers = implode("\r\n", [
      "To: {$to}",
      "Subject: {$subject}",
      "X-Mailer: PHP/" . PHP_VERSION,
      "MIME-Version: 1.0",
      "Content-Type: text/html; charset=UTF-8"
    ]);

    $fullContent = $headers . "\r\n\r\n" . $content;

    if (!is_dir(dirname($filename))) {
      mkdir(dirname($filename), 0777, true);
    }

    return file_put_contents($filename, $fullContent) !== false;
  }

  # send email for real
  public static function sendEmailFr($to, $subject, $content)
  {
    try {
      $result = Yii::$app->mailer->compose()
        ->setTo($to)
        ->setSubject($subject)
        ->setHtmlBody($content)
        ->send();

      if (!$result) {
        Yii::error("Failed to send email to {$to}", 'email');
      }

      return $result;
    } catch (\Exception $e) {
      Yii::error("Error sending email to {$to}: " . $e->getMessage(), 'email');
      return false;
    }
  }
}
