<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }
    
	public function init()
	{
	   Yii::app()->user->setStateKeyPrefix('user_');
           if(!Yii::app()->user->getState('language'))
           {
                Yii::app()->user->setState('language',Yii::app()->params['DEFAULTLanguage']);
           }
    
      $this->initAjaxCsrfToken();
	}
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
   
   // this function will work to post csrf token.
    protected function initAjaxCsrfToken() {
 
        Yii::app()->clientScript->registerScript('AjaxCsrfToken', ' $.ajaxSetup({
                         data: {"' . Yii::app()->request->csrfTokenName . '": "' . Yii::app()->request->csrfToken . '"},
                         cache:false
                    });', CClientScript::POS_HEAD);
    }
    
    public function Permissions( $currentController = '' )
    {
            if(empty($currentController))
            {
                $currentController = Yii::app()->getController()->getId();
            }
           // $currentController = ucwords($currentController); 
            $permission =  Yii::app()->user->getState('permission');
           // echo 'dasddasdasdasdasdasdasd';
           // print_r($permission);
            $replacePerform = Yii::app()->params['rolesActionsToPerform']; #Get array to replace actions names to perform
            $perform = array("not");//array('create','update','admin','view','changepassword','delete')

            if(Yii::app()->user->getState('super')=='1')
            {
                    $perform = array('frontaccess');
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
/*    
    public function filters()
    {
             return array(
                     array(
                             'application.filters.HttpsFilter + login',
                             'bypass' => !Yii::app()->params['force_https'],
                     ),
             );
    }
*/
}