<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 3/11/18
 * Time: 6:06 PM
 */

namespace codexten\yii\gii\generators\model;

use codexten\yii\db\ActiveRecord;
use yii\gii\generators\model\Generator;

/**
 * Class ModelGenerator
 *
 * @property ActiveRecord $modelClass
 * @package codexten\yii\gii\generators\model
 */
class ModelGenerator extends Generator
{
    public $baseClass = ActiveRecord::class;

    /**
     * {@inheritdoc}
     */
    public function generateRules($table)
    {
        $rules = parent::generateRules($table);
        foreach ($rules as $key => $rule) {
            $rules[$key] = str_replace('::className()', '::class', $rule);
        }

        return $rules;
    }

}