<?php
class ApiController extends CController
{
    //public $layout='column1';
    public $menu=array();
    public $breadcrumbs=array();
	
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
                'actions'=>array('login','autologin'),
				'controllers'=>array('index'),
				//'expression'=>Yii::app()->user->getState("usertype")=="backuser",
            ),
            array('allow',
                'users'=>array('@'),
				//'expression'=>Yii::app()->user->getState("usertype")=="backuser",
            ),
            array('deny',
                'users'=>array('*'),
				//'expression'=>Yii::app()->user->getState("usertype")=="backuser",
            ),
        );
    }
	
    public function Permissions()
    {
            $currentController = Yii::app()->getController()->getId();
           // $currentController = ucwords($currentController); 
            $permission =  Yii::app()->user->getState('permission');
           // echo "hiii";print_r($permission);
            $replacePerform = Yii::app()->params['rolesActionsToPerform']; #Get array to replace actions names to perform
            $perform = array("not");//array('create','update','admin','view','changepassword','delete')

            if(Yii::app()->user->getState('super')=='1')
            {
                    $perform = array('create','update','admin','view','delete','userchangepassword','updateimage', 'api');
            }
            else
            {
               if(isset($permission[$currentController]))
                    {
                            foreach($permission[$currentController] as $index => $value)
                            {
                                    $actions = explode(',', $index);
                                    foreach ( $actions as $action )
                                    {
                                            if(isset($replacePerform[$action]))
                                            {
                                                    $action = $replacePerform[$action];
                                            }
                                            if(!in_array($action, $perform))
                                            {
                                                    $perform[] = $action;
                                            }
                                    }
                            }
                    } 
            }
            return $perform;
    }
}