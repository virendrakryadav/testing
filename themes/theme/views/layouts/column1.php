<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php 
	$userid  = Yii::app()->user->id;
	
	if (isset($userid) && $userid >0)
	{
            $loggedInUser = CommonUtility::getLoginUserName($userid);
            $loggedInUser = "<span class='sessionname'>".$loggedInUser."</span>";
            // $img = CommonUtility::getprofilePicMediaURI($userid);
            $img = CommonUtility::getThumbnailMediaURI($userid,Globals::IMAGE_THUMBNAIL_PROFILE_PIC_35);
            
           
	$this->widget('bootstrap.widgets.TbNavbar', array(
           
                'display'=>'inverse', // null or 'inverse'
                'brandLabel'=>CHtml::image(Yii::app()->getBaseUrl().'/images/logo.png'),
				'brandOptions'=>array( "class" => 'navbar-brand'),
                'brandUrl'=>Yii::app()->getBaseUrl(true),
               // 'collapse'=>true, // requires bootstrap-responsive.css
                'items'=>array(
                    array(
                        'class'=>'bootstrap.widgets.TbNav',
                         'htmlOptions'=>array('class'=>'nav navbar-nav'),
                        'encodeLabel'=>false,
                        'items'=>array(
                            array('label'=>"<span class='sessionname'>".Yii::t('layout_main','lbl_poster')."</span>",	
					'items'=>array(
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_create_task'), 'url'=>Yii::app()->createUrl('poster/createtask')),
                    array('icon' => 'icon-tasks', 'label'=>Yii::t('layout_main','txt_my_tasks'), 'url'=>Yii::app()->createUrl('poster/mytasks')),
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_find_tasker'), 'url'=>Yii::app()->createUrl('poster/findtasker')),
                   
                )),
                            array('label'=>"<span class='sessionname'>".Yii::t('layout_main','lbl_tasker')."</span>",
					'items'=>array(
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_find_tasks'), 'url'=>CommonUtility::getTaskListURI()),
                    array('icon' => 'icon-tasks', 'label'=>Yii::t('layout_main','txt_my_tasks'), 'url'=>Yii::app()->createUrl('tasker/mytasks')),
                   
                )),
//                            array('label'=>Yii::t('layout_main','lbl_poster'), 'url'=>Yii::app()->createUrl('poster/createtask'), 'itemOptions' => array('class' => 'top_space')),
//                                            array('label'=>Yii::t('layout_main','lbl_tasker'), 'url'=>CommonUtility::getTaskListURI(),  'itemOptions' => array('class' => 'top_space')),
                             //array('label'=>Yii::t('layout_main','txt_post_task'), 'url'=>Yii::app()->createUrl('poster/createtask'),  'itemOptions' => array('class' => 'top_space')),
                            
                        ),
                    ),
			
        array(
            'class'=>'bootstrap.widgets.TbNav',
             'id'=>'gcHeader',
            'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
                'encodeLabel'=>false,
	        'items'=>array(
			 array('label'=>'<i class="icon-group"></i>
<span class="badge">9</span>','url'=>Yii::app()->createUrl('notification/index'), 'htmlOptions'=>array('class'=>'topnitification'),),
				 array('label'=>'<i class="icon-envelope"></i>
<span class="badge">7</span>','url'=>Yii::app()->createUrl('inbox/index'), 'htmlOptions'=>array('class'=>'topnitification'),),
			        array('label'=>CHtml::image($img,Yii::t('layout_main','txt_alt_user_image') , array(
    'style' => 'width:35px;height: 35px','id'=>'profileImageIconOnHeader')).$loggedInUser,	
					'items'=>array(
                    array('icon' => 'icon-th-large', 'label'=>Yii::t('layout_main','lbl_dashboard'), 'url'=>Yii::app()->createUrl('index/dashboard')),                        
                    array('icon' => 'icon-user', 'label'=>Yii::t('layout_main','lbl_dropdown_my_profile'), 'url'=>Yii::app()->createUrl('index/updateprofile')),
//                    array('icon' => 'icon-tasks', 'label'=>Yii::t('layout_main','txt_my_tasks'), 'url'=>Yii::app()->createUrl('poster/mytaskslist')),
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
    'display'=>'inverse', // null or 'inverse'
    'brandLabel'=>CHtml::image(Yii::app()->getBaseUrl().'/images/logo.png'),
	
    'brandUrl'=>Yii::app()->getBaseUrl(true),
	'brandOptions'=>array( "class" => 'navbar-brand'),

   // 'collapse'=>true, // requires bootstrap-responsive.css    
  
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbNav',
            'encodeLabel'=>false,
			 'htmlOptions'=>array('class'=>'nav navbar-nav'),
            'items'=>array(
                array('label'=>CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_you_have_a_To_Do_list_that_needs_help')), Yii::app()->createUrl('index/login'),array(
                    'update' => '#dialog'),array('id' => 'login-'.uniqid())),'htmlOptions' => array('class' => 'top_space')),
		array('label'=>Yii::t('layout_main','txt_ready_to_work_for_yourself'), 'url'=>CommonUtility::getTaskListURI(), 	'htmlOptions' => array('class' => 'top_space')),
            ),
        ),
			
		'<div class="signin">'.CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_in')), Yii::app()->createUrl('index/login'),array(
                    'update' => '#dialog'),array('id' => 'login-'.uniqid())).'</div><div class="signin">'.CHtml::ajaxLink(CHtml::encode(Yii::t('layout_main','txt_sign_up')), Yii::app()->createUrl('index/register'),array('update' => '#dialog'),array('id' => 'register-'.uniqid())).'</div>',
        ),
 ));
} ?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->
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
<?php $this->endContent(); ?>