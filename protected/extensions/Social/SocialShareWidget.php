<?php
/**
 * Widget that generates sharing buttons for facebook, twitter and google plus.
 * Usage:
 * 	$this->widget('path.to.SocialShareWidget', array(
 *		'url' => 'http://example.org',					//required
 *		'services' => array('google', 'twitter'), 		//optional
 *		'htmlOptions' => array('class' => 'someClass'), //optional
 *		'popup' => false, 								//optional
 * 	));
 *          $this->widget('ext.Social.SocialShareWidget', array(
                                'url' => $taskUrl,
                                'media' => $taskImage,
                                'description' => $task->{Globals::FLD_NAME_DESCRIPTION},//required
                                'services' => array('facebook','google', 'twitter','pinterest', 'linkedin'),		//optional
                                'htmlOptions' => array('class' => 'share_link'),	//optional
                                'popup' => true,								//optional
                        ));
 * 
 * @author Pavle Predic <https://github.com/pavlepredic>
 * @version 0.1
 */
class SocialShareWidget extends CWidget
{
	const FACEBOOK 	= 'facebook';
	const TWITTER 	= 'twitter';
	const GOOGLE 	= 'google';
        const PINTEREST = 'pinterest';
	const LINKEDIN = 'linkedin';
	/**
	 * URL to share (required)
	 * @var string
	 */
	public $url;
	public $media;
        public $description;
	/**
	 * List of social services to use.
	 * Buttons will be generated in the order specified here.
	 * Valid services are:
	 * self::FACEBOOK, self::TWITTER and self::GOOGLE
	 * @var array
	 */
	public $services = array(self::FACEBOOK, self::TWITTER, self::GOOGLE);
	
	/**
	 * HTML options that will be used for rendering this widget
	 * @var array
	 */
	public $htmlOptions = array();
	
	/**
	 * Whether or not to use a JS popup window
	 * @var bool
	 */
	public $popup = true;
	
	/**
	 * Display names for social services.
	 * These names will be rendered in 'title' attribute.
	 * @var array
	 */
	public $serviceNames = array(
		self::FACEBOOK 	=> 'Facebook',
		self::TWITTER	=> 'Twitter',
		self::GOOGLE 	=> 'Google Plus',
                self::PINTEREST => 'Pinterest',
                self::LINKEDIN => 'Linkedin',
            
	);
	
	/**
	 * Sharing URLs used by each service.
	 * Normally there is no need to modify this.
	 * @var array
	 */
	public $serviceUrls = array(
		self::FACEBOOK 	=> 'http://www.facebook.com/sharer/sharer.php?u=',
		self::TWITTER	=> 'http://twitter.com/share?url=',
		self::GOOGLE 	=> 'https://plus.google.com/share?url=',
                self::PINTEREST	=> 'http://pinterest.com/pin/create/button/?url=',
                self::LINKEDIN	=> 'http://www.linkedin.com/shareArticle?mini=true&url=',
          //  http://www.linkedin.com/shareArticle?mini=true&url={articleUrl}&title={articleTitle}&summary={articleSummary}&source={articleSource}
	);
	
	/**
	 * By default, this widget looks for assets in
	 * dirname(__FILE__) . '/assets/socialshare'.
	 * If you placed assets in a different directory, 
	 * specify the full path here.
	 * @var string
	 */
	public $assetsPath;
	
	/**
	 * Publishes and registers required assets
	 * @see CWidget::init()
	 */
	public function init()
	{
		parent::init();
		
		$assetsDir = $this->assetsPath ? $this->assetsPath : dirname(__FILE__) . '/assets/socialshare';
		$dir = Yii::app()->assetManager->publish($assetsDir);
		$cs = Yii::app()->clientScript;
		$cs->registerCssFile($dir . '/style.css');

		if ($this->popup)
		{
			$cs->registerCoreScript('jquery');
			$cs->registerScriptFile($dir . '/script.js', CClientScript::POS_END);
		}
	}
	
	/**
	 * Outputs the widget HTML
	 * @see CWidget::run()
	 */
	public function run()
	{
		$opts = $this->htmlOptions;
		if (!isset($opts['id']))
			$opts['id'] = $this->getId();
		
		echo CHtml::tag('div', $opts, null, false);
		foreach ($this->services as $service)
		{
			if (!array_key_exists($service, $this->serviceUrls))
				throw new CHttpException(500, "Non-existant service: '$service'");
			$serviceName = isset($this->serviceNames[$service]) ? $this->serviceNames[$service] : $service;
			$url = $this->serviceUrls[$service] . urlencode($this->url);
                        if( $service == 'pinterest')
                        {
                            $url = $url."&media=".$this->media."&description=".$this->description;
                        }
			echo CHtml::link('&nbsp;', $url, array(
				'class' => $service . ' social-provider-icon', 
				'title' => $serviceName,
				'target' => '_blank',
			));
		}
		echo CHtml::closeTag('div');
	}
}