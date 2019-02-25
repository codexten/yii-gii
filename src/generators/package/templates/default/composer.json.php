<?php
/* @var $generator \codexten\yii\gii\package\PackageGenerator*/
?>
{
  "name": "<?= $generator->getPackageFullName() ?>",
  "type": "library",
  "description": "Entero Package",
  "autoload": {
    "psr-4": {
      "<?= $generator->namespace ?>": "src"
    }
  },
  "extra": {
    "branch-alias": {
        "dev-master": "<?= $generator->branchAlias ?>"
    }
  }
}