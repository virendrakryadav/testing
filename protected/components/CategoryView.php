<?php
/**
 * CTreeGridView class file.
 *
 * Used:
 * YiiExt - http://code.google.com/p/yiiext/
 * treeTable - http://plugins.jquery.com/project/treeTable
 * jQuery ui - http://jqueryui.com/
 *
 * @author quantum13
 * @link http://quantum13.ru/
 */


Yii::import('zii.widgets.grid.CGridView');


class CategoryView extends CGridView
{

    /**
     * @var string the base script URL for all treeTable view resources (e.g. javascript, CSS file, images).
     * Defaults to null, meaning using the integrated grid view resources (which are published as assets).
     */
    public $baseTreeTableUrl;

    /**
     * @var string the base script URL for jQuery ui draggable and droppable.
     * Defaults to null, meaning using the integrated grid view resources (which are published as assets).
     */
    public $baseJuiUrl;
    public $formActions;
    public $dataSession;
    public $dataProvider;
    public $statusField;
    public $clildTable;
    public $pkName;
    public $actionClassName;
    

    /**
     * Initializes the tree grid view.
     */
    
    public function run()       
    {
        // Set session search and page size dropDown  ///
        CommonUtility::searchSessionScript("data-grid");

	$total=$this->dataProvider->getTotalItemCount();//added line
        $controllerName=Yii::app()->getController()->id;
	$this->registerClientScript();  
		
        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        if ($total>0)
        {
             $loading = '
                            <div class="overlayGrid">
                            </div>
                            <div class="loader">
                                <img src="'.Yii::app()->request->baseUrl.'/images/loadmig.gif"/>
                                    
                            </div>


                            ';
              echo $loading;
                 echo   '<div class="grid-summary">';
            if (isset($this->formActions))
            {
                $this->multiActionButtons();
            }
            echo '<div class="rows_per_page">';
            if (isset($this->dataSession))
            {
                $this->getPagerDropdown();
            }
            $this->renderSummary();

            echo "</div></div>";//added line
        }
        $this->renderContent();
        $this->renderKeys();
        echo CHtml::closeTag($this->tagName);
    }
	
    public function multiActionButtons()
    {
        if($this->actionClassName)
        {
            $className=$this->actionClassName;
        }
        else 
        {
            $className=$this->dataProvider->modelClass;
        }
        $isSuper =  Yii::app()->user->getState('super');
        $actionUrl='common/ajaxupdate';

        echo CHtml::form();
        echo "<div class='multi-action-control'>";
        if ($this->formActions=='status' || $this->formActions=='all' )
        {
            echo '<span class="space">'.CHtml::ajaxSubmitButton(Yii::t('blog','Activate'),
            array($actionUrl,'act'=>'doActive','className'=>$className,'fieldName'=>$this->statusField,'pkName'=>$this->pkName,'super'=>$isSuper),

            array(
            'success'=>'js: function(data) { reloadGrid(data); }',
            'beforeSend'=>'ischecked'),
            array('class' => 'submitClass')).'</span>';

            echo '<span class="space">'.CHtml::ajaxSubmitButton(Yii::t('blog','In Activate'),
            array($actionUrl,'act'=>'doInactive','className'=>$className,'fieldName'=>$this->statusField,'pkName'=>$this->pkName,'super'=>$isSuper),
            array(
            'success'=>'js: function(data) { reloadGrid(data); }',
            'beforeSend'=>'ischecked'),
            array('class' => 'submitClass')).'</span>';
        }
        if ($this->formActions=='delete' || $this->formActions=='all')
        {
            echo '<span class="space">'.CHtml::ajaxSubmitButton(Yii::t('blog','Delete'),
            array($actionUrl,'act'=>'doDelete','className'=>$className,'fieldName'=>$this->statusField,'relationName'=>$this->clildTable,'pkName'=>$this->pkName,'super'=>$isSuper),
            array(
            'success'=>'js: function(data) { reloadGrid(data); }',
            'beforeSend' => 'checkForDeletion'),
            array('class' => 'submitClass')).'</span>';
        }
        echo "</div>";
        echo CHtml::endForm();
    }

    public function getPagerDropdown()
    {
        $pageSize=Yii::app()->user->getState($this->dataSession,Yii::app()->params['defaultPageSize']);

        echo '<span class="count_per_page">'.CHtml::dropDownList('count_per_page',$pageSize,
        array(10=>10,15=>15,20=>20,50=>50,100=>100,1000=>'1000'),
        array('onchange'=>"$.fn.yiiGridView.update('data-grid',{ data:{".$this->dataSession.": $(this).val() }})",'value'=>$pageSize));
        echo '</span>';
    }
   
    /**
     * Renders a table body row with id and parentId, needed for ActsAsTreeTable
     * jQuery extension.
     * @param integer $row the row number (zero-based).
     */
//    public function renderTableRow($row)
//    {
//        $model=$this->dataProvider->data[$row];
//        $locale = CategoryLocale::model()->findByAttributes(array('category_id'=>$model->category_id,'language_code'=>'en_us'));
//
//        
////        echo '<tr id="'.$locale["category_id"].'">';
////        if($this->rowCssClassExpression!==null)
////        {
////            echo '<tr id="'.$model->getPrimaryKey().'" class="'.$parentClass.$this->evaluateExpression($this->rowCssClassExpression,array('row'=>$row,'data'=>$model)).'">';
////        }
////        els
////        e
////        if(is_array($this->rowCssClass) && ($n=count($this->rowCssClass))>0)
////            echo '<tr id="'.$model->getPrimaryKey().'" class="'.$parentClass.$this->rowCssClass[$row%$n].'">';
////        else
////            echo '<tr id="'.$model->getPrimaryKey().'" class="'.$parentClass.'">';
//        foreach($this->columns as $column) {
//            $column->renderDataCell($row);
//        }
//
//        
//    }

}
