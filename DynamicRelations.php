<?php

namespace synatree\dynamicrelations;

use yii\base\Widget;

class DynamicRelations extends Widget
{
	public $title;
	public $collection;
	public $viewPath;

	public function init(){
		parent::init();
	}

	public function run(){
		return $this->render('template', [
			'title' => $this->title,
			'collection' => $this->collection,
			'viewPath' => $this->viewPath,
		]);
	}

}
