<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 3/11/18
 * Time: 6:06 PM
 */

namespace codexten\yii\gii\generators\crud;

use entero\module\api\ActiveController;
use entero\web\CrudController;
use Yii;
use yii\gii\CodeFile;
use yii\gii\generators\crud\Generator;
use yii\helpers\ArrayHelper;

class CrudGenerator extends Generator
{
    public $apiControllerClass;
    public $baseApiControllerClass = ActiveController::class;
    public $baseControllerClass = CrudController::class;
    public $skipped_columns = ['id', 'created_at', 'updated_at'];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [
                ['apiControllerClass', 'baseApiControllerClass'],
                'filter',
                'filter' => 'trim',
            ],
            [['apiControllerClass'], 'required'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $files = parent::generate();

        $apiControllerFile = Yii::getAlias('@' . str_replace('\\', '/',
                ltrim($this->apiControllerClass, '\\')) . '.php');

        $files[] = new CodeFile($apiControllerFile, $this->render('apicontroller.php'));


        return $files;
    }

    /**
     * {@inheritdoc}
     */
    public function getColumnNames()
    {
        $columns = parent::getColumnNames();
        foreach ($this->skipped_columns as $name) {
            ArrayHelper::removeValue($columns, $name);
        }

        return $columns;
    }
}