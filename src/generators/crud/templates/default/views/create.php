<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$apiUrl = '@'.Inflector::pluralize($generator->getControllerID());

echo "<?php\n";
?>

use codexten\yii\web\widgets\CreatePage;


/* @var $this yii\web\View */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
?>
<?= '<?' ?>php $page = CreatePage::begin() ?>

<?= '<?' ?>php $page->beginContent('form') ?>

<?= '<?' ?>= $this->render('_form', [
    'action' => '<?= $apiUrl ?>',
    'method' => 'post',
]) ?>

<?= '<?' ?>php $page->endContent() ?>

<?= '<?' ?>php $page->end() ?>