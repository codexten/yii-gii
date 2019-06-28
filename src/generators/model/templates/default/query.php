<?php
/**
 * This is the template for generating the ActiveQuery class.
 */

use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $className string class name */
/* @var $modelClassName string related model class name */

$modelFullClassName = $modelClassName;
if ($generator->ns !== $generator->queryNs) {
    $modelFullClassName = '\\' . $generator->ns . '\\' . $modelFullClassName;
}

echo "<?php\n";
?>

namespace <?= $generator->queryNs ?>;

use <?= '\\' . ltrim($generator->queryBaseClass, '\\') . ";\n" ?>
use <?= '\\' . ltrim($modelFullClassName, '\\') . ";\n" ?>

/**
 * This is the ActiveQuery class for [[<?= $modelFullClassName ?>]].
 *
 * @see <?= StringHelper::basename($modelFullClassName) . "\n" ?>
 */
class <?= $className ?> extends <?= StringHelper::basename($generator->queryBaseClass) . "\n" ?>
{
    /**
     * {@inheritdoc}
     * @return <?=StringHelper::basename($modelFullClassName) ?>[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return <?= StringHelper::basename($modelFullClassName) ?>|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
