<?php

/** @var bool $verified */
$verified = $verified ? $verified : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verification Status</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }

    .verification-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #ffffff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    .verification-content {
      text-align: center;
    }

    .verification-icon img {
      max-width: 100px;
      margin-bottom: 20px;
    }

    .verification-message {
      font-size: 18px;
      margin: 20px 0;
    }

    .verification-button {
      margin: 20px 0;
    }

    .go-to-website-btn {
      text-decoration: none;
      background-color: #007bff;
      color: #ffffff;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 16px;
      transition: background-color 0.3s;
    }

    .go-to-website-btn:hover {
      background-color: #0056b3;
    }

    .redirect-message {
      margin-top: 20px;
      font-size: 14px;
      color: #6c757d;
    }
  </style>
  <?php if ($verified): ?>
    <meta http-equiv="refresh" content="3;url=/">
  <?php endif; ?>
</head>

<body>

  <div class="verification-container">
    <div class="verification-content">
      <div class="verification-icon">
        <?php if ($verified): ?>
          <img src="/images/icons/cmpted_logo.png" alt="Verified">
        <?php else: ?>
          <img src="/images/icons/error.png" alt="Error">
        <?php endif ?>
      </div>
      <?php if ($verified): ?>
        <p class="verification-message"><?= Yii::t('app', 'Your account has been successfully verified. You will be redirected to the home page in a few seconds.') ?></p>
      <?php else: ?>
        <p class="verification-message"><?= Yii::t('app', 'Could not verify your account. The link might be invalid, expired, or already used.') ?>"</p>
      <?php endif ?>
      <div class="verification-button">
        <a href="/shop" class="go-to-website-btn" title="Go To Website"><?= Yii::t('app', 'Go To Website') ?></a>
      </div>
    </div>
  </div>

</body>

</html>
