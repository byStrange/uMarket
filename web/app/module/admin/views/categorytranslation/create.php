<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CategoryTranslation $model */

$this->title = 'Create Category Translation';
$this->params['breadcrumbs'][] = ['label' => 'Category Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-translation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
