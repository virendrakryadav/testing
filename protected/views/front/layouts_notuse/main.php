<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<!-- Css here -->
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/style.css" rel="stylesheet" type="text/css">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/colorbox.css" rel="stylesheet" type="text/css">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/responsive.css" rel="stylesheet" type="text/css">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/front/reset.css" rel="stylesheet" type="text/css">	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        
</head>
<body>
<?php
/*echo"<pre>";
print_r($_SESSION);
exit;*/
$userid  = Yii::app()->user->id;
//exit;
?>
<div class="wrapper">
  <!--Header Start Here-->
  <header class="header">
    <div class="content_wrap">
      <div class="logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="green comet"></div>
      <div class="needhelp"><a href="#"><?php echo CHtml::encode(Yii::t('blog','You have a To-Do list that needs help?')); ?></a></div>
      <div class="needhelp"><a href="#"><?php echo CHtml::encode(Yii::t('blog','Ready to work for yourself?')); ?></a></div>
      <div class="signin_cont">
	  <?php
	  if(empty($userid))
	  {
	  ?>
        <div class="signin"><?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('blog','sign in')), Yii::app()->createUrl('index/login'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?></div>
        <div class="signin"><?php echo CHtml::ajaxLink(CHtml::encode(Yii::t('blog','sign up')), Yii::app()->createUrl('index/register'),array('update' => '#dialog'),array('id' => 'simple-link-'.uniqid()));?>
		</div>
		<? } 
		else
		{ ?> 
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/dashboard'); ?>"><?php 
			if(isset(Yii::app()->user->fullname) && !empty(Yii::app()->user->fullname))
			{ echo 'Welcome '.Yii::app()->user->fullname; }
			else if(isset(Yii::app()->user->name))
			{ echo 'Welcome '.Yii::app()->user->name; }?></a></div>
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/updateprofile'); ?>"><?=CHtml::encode(Yii::t('blog','My Profile'));?></a></div>
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/updateimage'); ?>"><?=CHtml::encode(Yii::t('blog','Change Profile Pick'));?></a></div>
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/changepassword'); ?>"><?=CHtml::encode(Yii::t('blog','Change Password'));?></a></div>
			<div class="signin"><a href="<?php echo Yii::app()->createUrl('index/logout'); ?>">Logout</a></div>
	 <? }
		?>
      </div>
    </div>
  </header>
  <!--This div for Light Box only-->
<div id="dialog"></div>
<!--This div for Light Box only-->
  <!--Content Start Here-->
 <?php echo $content; ?>
  <!--Footer Start Here-->
  <div class="footer"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/footer.jpg" width="1280" height="216">
    <div class="footer_nav">
	<a href="#"><?php echo CHtml::encode(Yii::t('blog','Home')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('blog','How to use?')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('blog','Join us')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('blog','Need help?')); ?></a>
	<a href="#"><?php echo CHtml::encode(Yii::t('blog','Site FAQ’s')); ?></a>
	</div>
  </div>
  <!--Footer Ends Here-->
</div>
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
</body>
</html>
