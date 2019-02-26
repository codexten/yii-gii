<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use codexten\yii\web\widgets\Page;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
?>

<?= "<?" ?>php $page = Page::begin([
    'title' => $this->title,
]) ?>

<?= "<?" ?>php $page->beginContent('content') ?>

<?= "<?" ?>= DetailView::widget([
    'model' => $model,
    'attributes' => [
<?php
//if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "        '" . $name . "',\n";
    }
//} else {
//    foreach ($generator->getTableSchema()->columns as $column) {
//        $format = $generator->generateColumnFormat($column);
//        echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
//    }
//}
?>
    ],
]) ?>

<?= "<?" ?>php $page->endContent() ?>

<?= "<?" ?>php $page->end() ?>
