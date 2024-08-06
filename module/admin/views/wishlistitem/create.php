<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Wishlistitem $model */

$this->title = 'Create Wishlistitem';
$this->params['breadcrumbs'][] = ['label' => 'Wishlistitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wishlistitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
