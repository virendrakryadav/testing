<?php

class CountryLocaleController extends BackEndController
{
	/*public function actionIndex()
	{
		$this->render('index');
	}*/

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	public function loadModel($langId, $countId)
	{
		$model=CountryLocale::model()->findByPk(array(Globals::FLD_NAME_LANGUAGE_CODE => $langId, Globals::FLD_NAME_COUNTRY_CODE => $countId));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}