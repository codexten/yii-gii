<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 6/10/18
 * Time: 3:15 PM
 */

namespace codexten\yii\gii\console;

use codexten\yii\dev\components\En;
use Yii;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use codexten\yii\helpers\ArrayHelper;

/**
 * Class EnController
 *
 * @property En $en
 * @package codexten\yii\gii\console
 */
class GiiController extends \yii\console\Controller
{
    public $defaultParams = [];
    public $defaultMigrationParams = [];
    public $defaultModelParams = [];
    public $defaultCrudParams = [];

    public function actionIndex($repo)
    {
        $this->runAction('migration', [$repo]);
        $this->runAction('model', [$repo]);
        $this->runAction('crud', [$repo]);
    }

    public function actionMigration($repo = 'root')
    {
        $config = $this->getGiiConfig('migration', $repo);
        if (!$config) {
            return;
        }
        $namespace = "{$config['namespace']}migrations";
        $migrationPath = $this->getNamespacePath($namespace);
        $defaultParams = $this->en->getParams($repo);
        $defaultParams = ArrayHelper::merge($defaultParams, [
            'migration-namespaces' => $namespace,
            'use-table-prefix' => true,
        ]);
        $defaultParams = ArrayHelper::merge($this->defaultParams, $this->defaultMigrationParams, $defaultParams);
        foreach ($config['migration'] as $name => $migrationConfig) {
            if ($this->isMigrationExist($migrationPath, $name)) {
                continue;
            }
            $params = ArrayHelper::merge($defaultParams, []);
            $params = ArrayHelper::merge($params, $migrationConfig);
            $params = ArrayHelper::merge($this->defaultParams, $params);

            ArrayHelper::remove($params, 'enableI18N');
            ArrayHelper::remove($params, 'overwrite');
            ArrayHelper::remove($params, 'messageCategory');

            $params[0] = $name;

            Yii::$app->runAction('migrate/create', $params);
        }
    }

    public function actionModel($repo = 'root')
    {
        $config = $this->getGiiConfig('model', $repo);
        if (!$config) {
            return;
        }
        $defaultParams = $this->en->getParams($repo);
        $defaultParams = ArrayHelper::merge($defaultParams, [
            'ns' => "{$config['namespace']}models",
            'generateQuery' => true,
            'useTablePrefix' => true,
        ]);
        $defaultParams = ArrayHelper::merge($this->defaultParams, $this->defaultModelParams, $defaultParams);
        foreach ($config['model'] as $tableName => $crud) {
            ArrayHelper::ensure($crud);
            $modelClass = Inflector::camelize($tableName);
            $params = ArrayHelper::merge($defaultParams, [
                'tableName' => Yii::$app->db->tablePrefix . $tableName,
                'modelClass' => $modelClass,
            ]);
            $params = ArrayHelper::merge($params, $crud);
            $params = ArrayHelper::merge($this->defaultParams, $params);
            if (!isset($params['queryNs'])) {
                $params['queryNs'] = "{$params['ns']}\\query";
            }
            $this->runGiiAction('model', $params);
        }
    }

    public function actionCrud($repo = 'root')
    {
        $config = $this->getGiiConfig('crud', $repo);
        if (!$config) {
            return;
        }
        $defaultParams = $this->en->getParams($repo);
        $defaultParams = ArrayHelper::merge($defaultParams, []);
        $defaultParams = ArrayHelper::merge($this->defaultParams, $this->defaultCrudParams, $defaultParams);
        foreach ($config['crud'] as $tableName => $crud) {
            $modelClass = Inflector::camelize($tableName);
            $namespace = $config['namespace'];
            if (isset($crud['namespace'])) {
                $namespace = $crud['namespace'];
                unset($crud['namespace']);
            }

            $params = ArrayHelper::merge($defaultParams, [
                'apiControllerClass' => "{$namespace}api\\{$modelClass}Controller",
                'controllerClass' => "{$namespace}controllers\\{$modelClass}Controller",
                'modelClass' => "{$namespace}models\\{$modelClass}",
                'viewPath' => $this->getNamespacePath($namespace) . 'views/' . Inflector::camel2id($modelClass),
            ]);
            $params = ArrayHelper::merge($params, $crud);
            $params = ArrayHelper::merge($this->defaultParams, $params);
            $controllerFile = $this->getNamespacePath($params['controllerClass']) . '.php';
            FileHelper::createDirectory(dirname($controllerFile));

            $this->runGiiAction('crud', $params);
        }
    }

    public function actionPackage()
    {
        $this->runGiiAction('package', []);
    }

    public function afterAction($action, $result)
    {
        $root = Yii::getAlias('@root');
        exec("chown -R www-data:www-data {$root} /en");

        return parent::afterAction($action, $result);
    }

    protected function getGiiConfig($type, $repo)
    {
        $config = $this->en->getConfig($type, $repo);
        if (!$config) {
            Console::output("Gii {$type} config not Found in {$repo}\n");

            return false;
        }

        return $config;
    }

    protected function runGiiAction($action, $params)
    {
        Yii::$app->runAction("generator/{$action}", $params);
    }

    /**
     * Returns the file path matching the give namespace.
     *
     * @param string $namespace namespace.
     *
     * @return string file path.
     * @since 2.0.10
     */
    protected function getNamespacePath($namespace)
    {
        return str_replace('/', DIRECTORY_SEPARATOR, Yii::getAlias('@' . str_replace('\\', '/', $namespace)));
    }

    protected function isMigrationExist($dir, $name)
    {
        if (!file_exists($dir)) {
            return false;
        }

        $files = FileHelper::findFiles($dir, [
            'filter' => function ($path) use ($name) {
                $name = ucfirst($name);

                return strpos($path, $name);
            },
        ]);

        return count($files) === 0 ? false : true;
    }

    /**
     * @return null|object|En
     * @throws \yii\base\InvalidConfigException
     */
    public function getEn()
    {
        return \Yii::$app->get('en');
    }
}