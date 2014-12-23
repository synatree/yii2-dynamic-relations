<?php

use yii\base\Widget;

class DynamicRelations extends Widget
{
	public function run(){
		$this->render('template', [
			'title' => $this->title,
			'collection' => $this->collection,
			'viewPath' => $this->viewPath,
		]);
	}

}
