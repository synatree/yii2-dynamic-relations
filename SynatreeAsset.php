<?php

namespace synatree\dynamicrelations;

use yii\web\AssetBundle;

class SynatreeAsset extends AssetBundle {

	public $sourcePath = '@vendor/synatree/assets';
	public $js = [
		'js/dynamic-relations.js'
	];
}
