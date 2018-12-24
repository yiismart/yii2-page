<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use smart\storage\components\StorageInterface;

$settings = [
    'minHeight' => 250,
    'toolbarFixedTopOffset' => 56,
    'plugins' => [
        'fullscreen',
        'video',
        'table',
    ],
];

if (isset(Yii::$app->storage) && (Yii::$app->storage instanceof StorageInterface)) {
    $settings['imageUpload'] = Url::toRoute(['image']);
    $settings['fileUpload'] = Url::toRoute(['file']);
}

?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
]); ?>

    <?= $form->field($model, 'active')->checkbox() ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'alias') ?>
    <?= $form->field($model, 'content')->widget(\vova07\imperavi\Widget::className(), ['settings' => $settings]) ?>

    <div class="form-group form-buttons row">
        <div class="col-sm-12">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('cms', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
