<?php

namespace synatree\dynamicrelations\controllers;

use Yii;
use yii\web\Controller;

class LoadController extends Controller
{
	public function actionTemplate($hash)
	{
		if( $args = Yii::$app->session->get('dynamic-relations-'.$hash))
		{
		   echo $this->render( $args['path'], [
			'model' => new $args['cls'],
		   ]);	
		}

	}
}
