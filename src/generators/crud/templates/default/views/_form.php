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

use codexten\yii\vue\widgets\Form;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $action string */
/* @var $fetchUrl string */
/* @var $method string */
?>

<?= '<?' ?>php $form = Form::begin([
    'action' => $action,
    'fetchUrl' => $fetchUrl,
    'method' => $method,
    'cols' => 2,
]) ?>

<?= '<?' ?>php $form->beginContent('body') ?>

<div class="row">
    <div class="col-md-4">

<?= '<?' ?>= $form->fields([
    'cols' => 1,
    'fields' => [
<?php
$count = 0;
//if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "        '"  . $attributePrefix . $name . "',\n";
        } else {
            echo "        //'"  . $attributePrefix . $name . "',\n";
        }
    }
//} else {
//    foreach ($tableSchema->columns as $column) {
//        $format = $generator->generateColumnFormat($column);
//        if (++$count < 6) {
//            echo "        '"   . $attributePrefix . $column->name .  "',\n";
//        } else {
//            echo "        //'"   . $attributePrefix . $column->name .  "',\n";
//        }
//    }
//}
?>
    ],
]) ?>

    </div>
</div>

<?= '<?' ?>php $form->endContent() ?>

<?= '<?' ?>php $form->end() ?>
