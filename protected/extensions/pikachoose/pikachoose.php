<?php

/**
 * Description of PikaChoose
 *
 * @author Perochak  <me@perochak.com> <me@perochak.com>
 * @website http://www.perochak.com 
 * @license MIT
 * @uses Yii v.1.1.x
 *  Ver : 1.0
 */
class pikachoose extends CWidget{
    public $id='peropika';
    public $style='bottom';
    public $options=array();
    public $data=array();
    public $default=array(
                'autoPlay'=> true,
		'speed'=> 5000,
		'text'=> array( 'play'=> "", 'stop'=> "", 'previous'=> "Previous", 'next'=> "Next", 'loading'=> "Loading" ),
		'transition'=>'[1]',
		'showCaption'=> false,
		'IESafe'=> false,
		'showTooltips'=> false,
		'carousel'=> false,
		'carouselVertical'=> false,
		'animationFinished'=> null,
		'buildFinished'=> null,
		'bindsFinished'=> null,
		'startOn'=> 0,
		'thumbOpacity'=> 0.4,
		'hoverPause'=> false,
		'animationSpeed'=> 600,
		'fadeThumbsIn'=> false,
		'carouselOptions'=> array(),
		'thumbChangeEvent'=> 'click.pikachoose',
		'stopOnClick'=> false
    );
    
    public function init(){
        parent::init();
    }
    public function loadData(){
        if(!empty($this->data) && is_array($this->data)){
            $output='<ul id="'.$this->id.'"';
            if($this->default['carousel']){
                $output.=' class="jcarousel-skin-pika"';
            }
            $output.='>';
            foreach($this->data as $item){
		$output.='<li>'.$item.'</li>';
	    }
            $output.='</ul>';
            return $output;
        }
    }
    public function run(){

        if(empty($this->style) || !in_array($this->style, array('bottom','css3','left','left-without','rightwithout','right'))){
            $this->style='base';
        }
        
        
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($dir . 'lib');
        
        // setting options
        foreach($this->options as $key=>$value){
            if($key=='text' || $key=='carouselOptions'){
                foreach($value as $k=>$v){
                    $this->default[$key][$k]=$v;
                }
            }else{
                $this->default[$key]=$value;
            }
        }
        $this->default = CJavaScript::encode($this->default);
        // register scripts
        $clientScript = Yii::app()->getClientScript();

        $clientScript->registerCssFile($baseUrl . '/styles/'.$this->style.'.css'); //http_build_query($cssparams)

        $clientScript->registerCoreScript('jquery');
        $clientScript->registerScriptFile($baseUrl . '/jquery.jcarousel.min.js');   
        $clientScript->registerScriptFile($baseUrl . '/jquery.pikachoose.js');       
        
          $js =  "$(document).ready(function (){
                 $('#{$this->id}').PikaChoose(
                      $this->default
                 );
             });";        
        $clientScript->registerScript('Yii.PikaChoose' . $this->id, $js); 
        echo $this->loadData();
    }
}
?>
