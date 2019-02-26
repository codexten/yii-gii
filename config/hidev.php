<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 25/2/19
 * Time: 10:53 PM
 */

return [
    'bootstrap' => ['generator'],
    'modules' => [
        'generator' => array_filter([
            'class' => 'yii\gii\Module',
            'allowedIPs' => explode(',', $params['debug.allowedIps']),
            'generators' => [
                'model' => [
                    'class' => \codexten\yii\gii\generators\model\ModelGenerator::class,
                    'templates' => [
                        'default' => '@codexten/yii/gii/generators/model/templates/default',
                    ],
                ],
                'crud' => [
                    'class' => \codexten\yii\gii\generators\crud\CrudGenerator::class,
                    'templates' => [
                        'default' => '@codexten/yii/gii/generators/crud/templates/default',
                    ],
                ],
                'package' => [
                    'class' => \codexten\yii\gii\generators\package\PackageGenerator::class,
                    'templates' => [
                        'default' => '@codexten/yii/gii/generators/package/templates/default',
                    ],
                ],
            ],
        ]),
    ],
    'controllerMap' => [
        'gii' => [
            'class' => \codexten\yii\gii\console\GiiController::class,
            'defaultParams' => [
                'enableI18N' => true,
                'overwrite' => false,
                'interactive' => true,
            ],
            'defaultCrudParams' => [
                'baseControllerClass' => \codexten\yii\web\CrudController::class,
            ],

        ],
    ],
];