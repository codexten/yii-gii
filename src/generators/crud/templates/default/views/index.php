<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$apiUrl = '@'.Inflector::pluralize($generator->getControllerID());
echo "<?php\n";
?>

use codexten\yii\web\widgets\IndexPage;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('<?= $generator->messageCategory ?>', '<?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>');
?>

<?= '<?' ?>php $page = IndexPage::begin([
    'title' => $this->title,
]) ?>

<?= '<?' ?>php $page->beginContent('main-actions') ?>

<?= '<?' ?>= $page->renderButton('create', '/business-category/create', ['class' => ['btn-success']]) ?>

<?= '<?' ?>php $page->endContent() ?>

<?= '<?' ?>php $page->beginContent('table') ?>

<?= '<?' ?>= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
<?php  foreach($generator->getColumnNames() as $name): ?>
        '<?= $name ?>',
<?php endForeach; ?>
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['style' => 'width: 5%'],
            'template' => '{update} {delete}',
        ],
    ],
]); ?>

<?= '<?' ?>php $page->endContent() ?>

<?= '<?' ?>php $page->end() ?>
