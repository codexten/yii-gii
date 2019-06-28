<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */
/* @var $model ActiveRecord */

$queryClassFullName=false;
if($queryClassName){
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
}


echo "<?php\n";

use yii\db\ActiveRecord;
use yii\helpers\StringHelper; ?>

namespace <?= $generator->ns ?>;

use Yii;
use yii\helpers\Url;
use <?= '\\' . ltrim($generator->baseClass, '\\') . ";\n" ?>
<?php if($queryClassFullName):?>
use <?= '\\' . ltrim($queryClassFullName, '\\') . ";\n" ?>

<?php endIf; ?>
/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
 * Database fields:
 *
<?php foreach ($properties as $property => $data): ?>
 * @property <?= "{$data['type']} \${$property}"  . ($data['comment'] ? ' ' . strtr($data['comment'], ["\n" => ' ']) : '') . "\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
 * Defined properties:
 *
 * @property array $meta
 *
 * Defined relations:
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?=  StringHelper::basename(ltrim($generator->baseClass, '\\')) . "\n" ?>
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [<?= empty($rules) ? '' : ("\n            " . implode(",\n            ", $rules) . ",\n        ") ?>];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassFullName): ?>
<?php
    echo "\n";
?>

    /**
     * {@inheritdoc}
     * @return <?= StringHelper::basename($queryClassFullName) ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?=  StringHelper::basename($queryClassFullName) ?>(get_called_class());
    }
<?php endif; ?>

}
