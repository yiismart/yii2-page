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

<p class="form-buttons">
    <?= Html::a(Yii::t('cms', 'Add'), ['create'], ['class' => 'btn btn-primary']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $model->getDataProvider(),
    'filterModel' => $model,
    'rowOptions' => function ($model, $key, $index, $grid) {
        return !$model->active ? ['class' => 'table-inactive'] : [];
    },
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'html',
            'value' => function ($model, $key, $index, $column) {
                $title = Html::tag('div', Html::encode($model->title));
                $alias = Html::tag('span', Html::encode($model->alias), ['class' => 'badge badge-secondary']);
                return $title . $alias;
            },
        ],
        [
            'class' => 'smart\grid\ActionColumn',
            'template' => '{link} {update} {delete}',
            'buttons' => [
                'link' => function($url, $model, $key) {
                    $title = Yii::t('page', 'Link');

                    return Html::a('<i class="fas fa-link"></i>', ['/page/page/index', 'alias' => $model->alias], [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => 0,
                    ]);
                },
            ],
        ],
    ],
]) ?>
