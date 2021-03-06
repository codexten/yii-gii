<?php
/**
 * Created by PhpStorm.
 * User: jomon
 * Date: 10/8/18
 * Time: 8:38 PM
 */

namespace codexten\yii\gii\generators\package;

use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\gii\CodeFile;
use yii\helpers\Inflector;

class PackageGenerator extends \yii\gii\Generator
{
    public $packageName;
    public $namespace;
    public $branchAlias;
    public $baseDir = '/en';
    public $branch = 'master';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Package Generator';
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'It will generate package, create repository and push first init commit to gitlab server';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['packageName',], 'filter', 'filter' => 'trim'],
            [['packageName'], 'required'],
        ]);
    }

    public function beforeValidate()
    {
        if (!$this->packageName) {
            $this->packageName = Console::prompt("Package Name : ", [
                'required' => true,
            ]);
            $this->normalizePackageName();
        }

        if (!$this->namespace) {
            $this->namespace = Console::prompt("Name Space : ", [
                'required' => true,
//                'default' => $this->getDefaultNamespace(),
            ]);
        }

        if (!$this->branchAlias) {
            $this->branchAlias = Console::prompt("Branch Alias: ", [
                'required' => true,
                'default' => $this->getBranchAlias(),
            ]);
        }

        return parent::beforeValidate();
    }

    protected function getBranchAlias()
    {
        if (strpos($this->packageName, 'yii/')) {
            return '2.0.x-dev';
        }

        return '1.0.x-dev';
    }

    protected function getDefaultNamespace()
    {
        return '';
    }


    /**
     * {@inheritdoc}
     */
    public function generate()
    {

//
//        $this->packageName = $this -
//
//            $nameSpace = Console::prompt("Name Space : ", [
//                'required' => true,
//
//            ]);
//        $branchAlias = Console::prompt("Branch Alias : ", [
//            'required' => true,
//        ]);


        $files = [];
        $templatePath = $this->getTemplatePath();

        foreach (FileHelper::findFiles($templatePath) as $file) {
            if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $path = str_replace($templatePath, '', $file);
                $files[] = new CodeFile($this->getFilePath($path), $this->render($path));
            }
        }

        return $files;
    }

    protected function normalizePackageName()
    {
        if (!strpos($this->packageName, '/')) {
            $packageName = explode('-', $this->packageName);
            $this->packageName = "{$packageName[0]}/$this->packageName";
        }
    }

    protected function getFilePath($path)
    {
        $path = str_replace('.php', '', $path);
        if (pathinfo($path, PATHINFO_EXTENSION) === '') {
            $path = $path . '.php';
        }

        return $this->getPackageDir() . $path;
    }

    protected function getPackageDir()
    {
        return $this->baseDir . '/dev-' . $this->branch . '/' . $this->getVendorName() . '/' . $this->getPackageShortName();

    }

    protected function getVendorName()
    {
        if (strpos($this->packageName, '/')) {
            $packageName = explode('/', $this->packageName);
        } else {
            $packageName = explode('-', $this->packageName);
        }

        return $packageName[0];
    }

    public function getPackageFullName()
    {
        if (strpos($this->packageName, '/')) {
            return $this->packageName;
        }

        return $this->getVendorName() . '/' . $this->packageName;
    }

    protected function getPackageShortName()
    {
        if (strpos($this->packageName, '/')) {
            $packageName = explode('/', $this->packageName);

            return $packageName[1];
        }

        return $this->packageName;
    }
}