<?php
use yii\helpers\Html;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" href="<?= Yii::getAlias("@web/favicon.ico"); ?>">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div id="root">
	    <button type="button" class="close remove-dynamic-relation" aria-label="Remove"><span aria-hidden="true">&times;</span></button>
            <?= $content ?>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
