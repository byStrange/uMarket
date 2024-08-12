<?php
?>
<div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">

  <button class="offcanvas-close"></button>
  <div class="user-panel">
    <ul>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Language
        </a>
        <ul class="dropdown-menu dropdown-menu-dark flex-column" style="display: none" aria-labelledby="navbarDarkDropdownMenuLink">
          <li class="w-100 m-0 p-1"><a class="text-white dropdown-item" href="/site/lang?l=uz">Uz</a></li>
          <li class="w-100 m-0 p-1"><a class="text-white dropdown-item" href="/site/lang?l=en">En</a></li>
          <li class="w-100 m-0 p-1"><a class="text-white dropdown-item" href="/site/lang?l=ru">Ru</a></li>
        </ul>
      </li>

      <?php if (!Yii::$app->user->isGuest): ?>
        <li><a href="/site/account"><i class="fa fa-user"></i> <?= Yii::t('app', 'Profile') ?></a></li>
        <?php if (Yii::$app->user->identity->is_superuser): ?>
          <li><a href="/admin"><i class="fa fa-wrench"></i> <?= Yii::t('app', 'Admin panel') ?></a></li>
        <?php endif; ?>
      <?php else: ?>
        <li><a href="site/login"><?= Yii::t('app', 'Login') ?></a></li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="inner customScroll">
    <div class="offcanvas-menu mb-4">
      <ul>
        <li><a href="/"><?= Yii::t('app', 'Home') ?></a></li>
        <li><a href="/shop"><?= Yii::t('app', 'Shop') ?></a></li>
      </ul>
    </div>
    <!-- OffCanvas Menu End -->
  </div>
</div>
