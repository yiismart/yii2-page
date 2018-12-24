<?php

use yii\helpers\Html;
use smart\grid\GridView;

// Title
$title = Yii::t('page', 'Pages');
$this->title = $title . ' | ' . Yii::$app->name;

// Breadcrumbs
$this->params['breadcrumbs'] = [
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?php if ($canAddPage): ?>
<p class="form-buttons">
    <?= Html::a(Yii::t('cms', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
</p>
<?php endif; ?>

<?= GridView::widget([
    'dataProvider' => $model->getDataProvider(),
    'filterModel' => $model,
    'rowOptions' => function ($model, $key, $index, $grid) {
        return !$model->active ? ['class' => 'table-warning'] : [];
    },
    'columns' => [
        'title',
        [
            'class' => 'smart\grid\ActionColumn',
            'options' => ['style' => 'width: 80px;'],
            'template' => '{link} {update} {delete}',
            'buttons' => [
                'link' => function($url, $model, $key) {
                    $title = Yii::t('page', 'Link');

                    return Html::a('<i class="fas fa-link"></i>', ['/page/page/index', 'alias' => empty($model->alias) ? $model->id : $model->alias], [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => 0,
                    ]);
                },
            ],
        ],
    ],
]) ?>
