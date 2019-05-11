<?php

use yii\helpers\Html;
use yii\helpers\Url;
use smart\imperavi\Imperavi;
use smart\widgets\ActiveForm;
use smart\page\backend\assets\PageAsset;

PageAsset::register($this);

?>
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'url', ['append' => [
        ['button' => '<i class="fas fa-sync"></i>', 'options' => ['id' => 'make-url', 'data-url' => Url::toRoute(['make-url'])]],
    ]]) ?>

    <?= $form->field($model, 'text')->widget(Imperavi::className()) ?>

    <div class="form-group form-buttons row">
        <div class="col-sm-10 offset-sm-2">
            <?= Html::submitButton(Yii::t('cms', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('cms', 'Cancel'), ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
