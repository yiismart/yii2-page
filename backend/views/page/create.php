<?php

use yii\helpers\Html;

// Title
$title = Yii::t('page', 'Add page');
$this->title = $title . ' | ' . Yii::$app->name;

// Breadcrumbs
$this->params['breadcrumbs'] = [
    ['label' => Yii::t('page', 'Pages'), 'url' => ['index']],
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
    'model' => $model,
]) ?>
