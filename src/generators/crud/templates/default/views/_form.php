<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}
$apiUrl = '@'.Inflector::pluralize($generator->getControllerID());
$attributePrefix = Inflector::underscore($model->formName()) . '.';
echo "<?php\n";
?>

use <?= ltrim($generator->modelClass, '\\') ?>;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= StringHelper::basename($generator->modelClass) ?> */
?>

<div class="row">
    <div class="col-md-6">

    <?= '<' ?>?php $form = ActiveForm::begin() ?>
<?php  foreach($generator->getColumnNames() as $name): ?>

        <?= '<' ?>?= $form->field($model, '<?= $name ?>') ?>
<?php endForeach; ?>

        <div class="form-group">

            <?= '<' ?>?= Html::submitButton(
                $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        </div>

        <?= '<' ?>?php ActiveForm::end() ?>

    </div>
</div>