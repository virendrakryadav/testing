<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	
        <!-- for Facebook -->          

<meta property="og:image" content="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.jpg" />


<!-- for Twitter -->          
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="" />


   <meta name="robots" content="noindex" />
	<meta name="language" content="en" />
	<!-- Css here -->
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/colorbox.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/responsive.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/js/front/scrollbar/jquery.mCustomScrollbar.css" rel="stylesheet" />
    
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->bootstrap->register(); ?>
</head>
<body>

<script> 
    function reloadGrid(data,id)
    {
            //$.fn.yiiGridView.update('portfolio-grid-task');
            $.fn.yiiGridView.update(id);
            $("#msgPortfolio").html("");
            $("#msgPortfolio").css("display","block");
            $("#msgPortfolio").append(data);
            return false;
    }
    function loadpopup(data , id)
    {
        if(!id)
        {
            id = 'loadpopupForAllTasks';
        }
        jQuery("#"+id).html(data);
        
       
        jQuery("#"+id).fadeTo("slow", 1.0); 
      
        jQuery("#overlay").fadeTo("slow", 0.3);  
        $("#"+id).mCustomScrollbar();
    }
    function loadpopupUserProfile(data , id)
    {
        if(!id)
        {
            id = 'loadpopupForProfileAddress';
        }
        jQuery("#"+id).html(data);
        
        jQuery("#"+id).addClass("profile_popup");
        jQuery("#"+id).fadeTo("slow", 1.0); 
      
        jQuery("#overlayProfile").fadeTo("slow", 0.3);  
        $("#"+id).mCustomScrollbar();
    }
    
    function closepopup(id)
    {
        if(!id)
        {
            id = 'loadpopupForAllTasks';
        }
        jQuery("#"+id).fadeOut("slow"); 
        jQuery("#overlay").fadeOut("slow"); 
    }
    $( document ).ready(function() {
        
    jQuery('#cboxClose').on('click', closepopup());
    $( ".fortooltip" ).hover(function() {   
        $('#'+$(this).attr('id')).tooltip('show');
    });       
});
//    $(document).ready(function(){
//        $(".controls-row .help-block.error").attr("onmouseover","hoverMenu(this);");
//    });
</script>
   <?php CommonScript::loadAjaxPopover(); ?>
<?php 
	$userid  = Yii::app()->user->id;
	
	if (isset($userid) && $userid >0)
	{
            $loggedInUser = CommonUtility::getLoginUserName();
            $loggedInUser = "<span class='sessionname'>".$loggedInUser."</span>";
            // $img = CommonUtility::getprofilePicMediaURI($userid);
            $img = CommonUtility::getThumbnailMediaURI($userid,Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35);
            
           
	$this->widget('bootstrap.widgets.TbNavbar', array(
           
                'type'=>'inverse', // null or 'inverse'
                'brand'=>CHtml::image(Yii::app()->getBaseUrl().'/images/logo.png'),
                'brandUrl'=>Yii::app()->getBaseUrl(true),
                'collapse'=>true, // requires bootstrap-responsive.css
                'items'=>array(
                    array(
                        'class'=>'bootstrap.widgets.TbMenu',
                         'htmlOptions'=>array('class'=>'pull-center'),
                        'encodeLabel'=>false,
                        'items'=>array(
                            array('label'=>"<span class='sessionname'>".Yii::t('layout_main','lbl_poster')."</span>",	
					'items'=>array(
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_create_task'), 'url'=>Yii::app()->createUrl('poster/createtask')),
                    array('icon' => 'icon-tasks', 'label'=>Yii::t('layout_main','txt_my_tasks'), 'url'=>Yii::app()->createUrl('poster/mypostedtaskposter')),
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_find_tasker'), 'url'=>Yii::app()->createUrl('poster/findtasker')),
                   
                )),
                            array('label'=>"<span class='sessionname'>".Yii::t('layout_main','lbl_tasker')."</span>",
					'items'=>array(
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_find_task'), 'url'=>CommonUtility::getTaskListURI()),
                    array('icon' => 'icon-tasks', 'label'=>Yii::t('layout_main','txt_my_tasks'), 'url'=>Yii::app()->createUrl('tasker/mypostedtasktasker')),
                   
                )),
//                            array('label'=>Yii::t('layout_main','lbl_poster'), 'url'=>Yii::app()->createUrl('poster/createtask'), 'itemOptions' => array('class' => 'top_space')),
//                                            array('label'=>Yii::t('layout_main','lbl_tasker'), 'url'=>CommonUtility::getTaskListURI(),  'itemOptions' => array('class' => 'top_space')),
                             //array('label'=>Yii::t('layout_main','txt_post_task'), 'url'=>Yii::app()->createUrl('poster/createtask'),  'itemOptions' => array('class' => 'top_space')),
                            
                        ),
                    ),
			
        array(
            'class'=>'bootstrap.widgets.TbMenu',
             'id'=>'gcHeader',
            'htmlOptions'=>array('class'=>'pull-right'),
                'encodeLabel'=>false,
	        'items'=>array(
			        array('label'=>CHtml::image($img,Yii::t('layout_main','txt_alt_user_image') , array(
    'style' => 'width:35px;height: 35px','id'=>'profileImageIconOnHeader')).$loggedInUser,	
					'items'=>array(
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_dropdown_my_profile'), 'url'=>Yii::app()->createUrl('index/updateprofile')),
                    array('icon' => 'icon-tasks', 'label'=>Yii::t('layout_main','txt_my_tasks'), 'url'=>Yii::app()->createUrl('poster/mytaskslist')),
                    //array('icon' => 'icon-adjust', 'label'=>Yii::t('blog','Change Profile Pick'), 'url'=>Yii::app()->createUrl('index/updateimage')),
                    //array('icon' => 'icon-upload', 'label'=>Yii::t('blog','Upload Video'), 'url'=>Yii::app()->createUrl('index/updatevideo')),
                    array('icon' => 'icon-lock', 'label'=>Yii::t('layout_main','lbl_dropdown_change_password'), 'url'=>Yii::app()->createUrl('index/changepassword')),
                    '---',
                    array('icon' => 'icon-key', 'label'=>Yii::t('layout_main','lbl_dropdown_logout'), 'url'=>Yii::app()->createUrl('index/logout')),
                )),
				
            ),
        ),
    ),
));
}
else
{
$this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::image(Yii::app()->getBaseUrl().'/images/logo.png'),
    'brandUrl'=>Yii::app()->getBaseUrl(true),
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>Yii::t('layout_main','txt_you_have_a_To_Do_list_that_needs_help'), 'url'=>Yii::app()->createUrl('poster/createtask'), 'itemOptions' => array('class' => 'top_space')),
				array('label'=>Yii::t('layout_main','txt_ready_to_work_for_yourself'), 'url'=>CommonUtility::getTaskListURI(), 	'itemOptions' => array('class' => 'top_space')),
            ),
        ),
			
		'<div class="signin">'.CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_in')), Yii::app()->createUrl('index/login'),array(
                    'update' => '#dialog'),array('id' => 'login-'.uniqid())).'</div><div class="signin">'.CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_up')), Yii::app()->createUrl('index/register'),array('update' => '#dialog'),array('id' => 'register-'.uniqid())).'</div>',
        ),
 ));
} ?>
     
<div class="wrapper">
  <!--Header Start Here-->
<!--  <header class="header">
    <div class="content_wrap">
      <div class="logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="green comet"></div>
       <div class="signin_cont">
	  <?php
	  if(empty($userid))
	  {
	  ?>
        <div class="signin"><?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_in')), Yii::app()->createUrl('index/login'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?></div>
        <div class="signin"><?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_up')), Yii::app()->createUrl('index/register'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?>
		</div>
		<?php } 
		else
		{ ?> 
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/dashboard'); ?>"><?php 
			if(isset(Yii::app()->user->fullname) && !empty(Yii::app()->user->fullname))
			{ echo 'Welcome '.Yii::app()->user->fullname; }
			else if(isset(Yii::app()->user->name))
			{ echo 'Welcome '.Yii::app()->user->name; }?></a></div>
		
	 <?php }
		?>
      </div>
    </div>
  </header>-->
  <!--This div for Light Box only-->
<div id="dialog"></div>
<!--This div for Light Box only-->
  <!--Content Start Here-->
 <?php echo $content; ?></div>
    <?php          echo      UtilityHtml::getPopup(); ?>
     <?php          echo      UtilityHtml::getPopupNotClose(); ?>
    
  <!--Footer Start Here-->
<div class="footer">
    <div class="footer_nav">
	<a href="<?php echo Yii::app()->getBaseUrl()?>"><?php echo CHtml::encode(Yii::t('layout_main','txt_footer_home')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('layout_main','txt_footer_how_to_use')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('layout_main','txt_footer_join_us')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('layout_main','txt_footer_need_help')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('layout_main','txt_footer_site_faqs')); ?></a>
	</div>
  </div>
  <!--Footer Ends Here-->

<?php /*?><div class="container" id="page">
<div  id="language-selector" style="float:right; margin:5px;">
    <?php 
       // $this->widget('application.components.widgets.LanguageSelector');
    ?>
</div>
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Go To Admin', 'url'=>array('admin/index/login')),
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page --><?php */?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/front/jquery.placeholder.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="js/minified/jquery-1.9.1.min.js"%3E%3C/script%3E'))</script>
	<!-- custom scrollbars plugin -->	
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/front/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
    (function($){
        $(window).load(function(){
            $(".wrapperewrwerwe").mCustomScrollbar();
        });
    })(jQuery);
</script>
</body>
</html>
