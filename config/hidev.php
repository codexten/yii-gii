<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 25/2/19
 * Time: 10:53 PM
 */

return [
    'modules' => [
        'generator' => array_filter([
            'class' => 'yii\gii\Module',
            'allowedIPs' => explode(',', $params['debug.allowedIps']),
            'generators' => [
                'model' => [
                    'class' => \codexten\yii\gii\model\ModelGenerator::class,
                    'templates' => [
                        'default' => '@entero/dev/generators/model/templates/default',
                    ],
                ],
                'crud' => [
                    'class' => \codexten\yii\gii\crud\CrudGenerator::class,
                    'templates' => [
                        'default' => '@entero/dev/generators/crud/templates/default',
                    ],
                ],
                'package' => [
                    'class' => \codexten\yii\gii\package\PackageGenerator::class,
                    'templates' => [
                        'default' => '@entero/dev/generators/package/templates/default',
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
                'baseControllerClass' => \entero\web\CrudController::class,
            ],

        ],
    ],
];