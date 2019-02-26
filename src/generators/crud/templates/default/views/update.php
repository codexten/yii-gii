<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use codexten\yii\web\widgets\UpdatePage;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= strtr($generator->generateString('Update ' .
    Inflector::camel2words(StringHelper::basename($generator->modelClass)) .
    ': {nameAttribute}', ['nameAttribute' => '{nameAttribute}']), [
    '{nameAttribute}\'' => '\' . $model->' . $generator->getNameAttribute()
]) ?>;
?>
<?= '<?' ?>php $page = UpdatePage::begin() ?>

<?= '<?' ?>php $page->beginContent('form') ?>

<?= '<?' ?>= $this->render('_form', ['model' => $model]) ?>

<?= '<?' ?>php $page->endContent() ?>

<?= '<?' ?>php $page->end() ?>
