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

use entero\web\widgets\IndexPage;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('<?= $generator->messageCategory ?>', '<?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>');
?>

<?= "<?" ?>php $page = IndexPage::begin([
    'title' => $this->title,
    'gridConfig' => [
        'url' => '<?= $apiUrl ?>',
        'actions' => ['update', 'delete'],
        'attributes' => [
<?php
$count = 0;
//if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            //'" . $name . "',\n";
        }
    }
//} else {
//    foreach ($tableSchema->columns as $column) {
//        $format = $generator->generateColumnFormat($column);
//        if (++$count < 6) {
//            echo "            '" . $column->name . "',\n";
//        } else {
//            echo "            //'" . $column->name . "',\n";
//        }
//    }
//}
?>
        ]
    ]
]) ?>

<?= "<?" ?>php $page->end() ?>
