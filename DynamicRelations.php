<?php

namespace synatree\dynamicrelations;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;


class DynamicRelations extends Widget
{
	public $title;
	public $collection;
	public $collectionType;
	public $viewPath;

	public function init(){
		parent::init();
	}

	public function run(){
		
		if( count($this->collection) && is_object($this->collection[0]) )
		{
			$type = get_class( $this->collection[0] );
		}
		elseif( is_object($this->collectionType)) {
			$type = get_class($this->collectionType);
		}
		else{
			throw new \yii\web\HttpException(500, "No Collection Type Specified, and Collection Empty.");
		}
		$key = "dynamic-relations-$type";
		$hash = crc32($key);
		Yii::$app->session->set('dynamic-relations-'.$hash, [ 'path'=>$this->viewPath, 'cls'=>$type ]);

		return $this->render('template', [
			'title' => $this->title,
			'collection' => $this->collection,
			'viewPath' => $this->viewPath,
			'ajaxAddRoute' => Url::toRoute(['dynamicrelations/load/template', 'hash'=>$hash]),
		]);
	}

	public function uniqueOptions($field, $uniq)
	{
        	return [
	                'id' => "$field-$uniq-id",
	                'name' => "$field-$uniq-id",
	                'pluginOptions' => [
	                        'uniq' => $uniq
	                ],
	        ];
	}

	public static function relate($model, $attr, $request, $name, $clsname)
	{
		if($request[$name])
		{
			if($new = $request[$name]['new'])
			{
				foreach( $new as $useless=>$newattrs)
				{
					$newmodel = new $clsname;
					$newmodel->load( $new,$useless );
					$model->link($attr, $newmodel);		
				}
				unset( $request[$name]['new'] );
			}
			foreach($request[$name] as $id=>$relatedattr)
			{
				$existingmodel = $clsname::findOne( $id );
				$existingmodel->load([$name=>$relatedattr]);
				$existingmodel->save();
			}
		}
	}

}
