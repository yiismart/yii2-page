<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use dkhlystov\helpers\Translit;
use vova07\imperavi\Widget as Imperavi;
use smart\storage\components\StorageInterface;
use smart\page\backend\assets\PageAsset;

PageAsset::register($this);

// Imperavi settings
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
    <?= $form->field($model, 'alias', ['inputTemplate' => '<div class="input-group">{input}<div class="input-group-append">' . Html::button(Html::encode(Yii::t('page', 'Make')), [
        'id' => 'pageform-makealias',
        'class' => 'btn btn-outline-secondary',
    ]) . '</div></div>'])->textInput(['data-url' => Url::toRoute(['alias'])]) ?>
    <?= $form->field($model, 'content')->widget(Imperavi::className(), ['settings' => $settings]) ?>

    <div class="form-group form-buttons row">
        <div class="col-sm-12">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('cms', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
