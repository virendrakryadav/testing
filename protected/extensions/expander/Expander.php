<?php

class Expander extends CWidget
{
	public $id;
    public $content='';
	public $htmlOptions=array();
	public $config=array();

	public function init()
	{
		if (isset($this->id)) {
			$this->htmlOptions['id']=$this->id;
		} else {
			$this->htmlOptions['id']=$this->getId();
		}
		$this->publishAssets();
	}
	
    public function run()
    {
		echo CHtml::openTag('div', $this->htmlOptions)."\n";
        echo $this->content;
		echo CHtml::closeTag('div')."\n";
		if (!count($this->config)) {
			$config=array(
				'slicePoint'=>100,
				'preserveWords'=>true,
				'widow'=>4,
				'expandText'=>'read more',
				'expandPrefix'=>'&hellip; ',
				'summaryClass'=>'summary',
				'detailClass'=>'details',
				'moreClass'=>'read-more',
				'lessClass'=>'read-less',
				'collapseTimer'=>0,
				'expandEffect'=>'fadeIn',
				'expandSpeed'=>250,
				'collapseEffect'=>'fadeOut',
				'collapseSpeed'=>200,
				'userCollapse'=>true,
				'userCollapseText'=>'read less',
				'userCollapsePrefix'=>' ',
				'onSlice'=>null,
				'beforeExpand'=>null,
				'afterExpand'=>null,
				'onCollapse'=>null,
			);
		} else {
			$config=$this->config;
		}
		$config=CJavaScript::encode($config);
		Yii::app()->getClientScript()->registerScript(__CLASS__, "
			$('#".$this->htmlOptions['id']."').expander($config);
		");
	}
	public function publishAssets()
	{
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)){
			Yii::app()->clientScript->registerCoreScript('jquery');
            $js = YII_DEBUG ? '/jquery.expander.js' : '/jquery.expander.min.js';
			Yii::app()->clientScript->registerScriptFile($baseUrl . $js, CClientScript::POS_HEAD);
			//Yii::app()->clientScript->registerCssFile($baseUrl . '/jquery.expander.css', CClientScript::POS_HEAD);
		} else {
			throw new Exception('Expancer - Error: Couldn\'t publish assets.');
		}
	}
}
