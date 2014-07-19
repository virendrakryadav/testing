<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="language" content="en" />
    
    <?php CommonScript::loadCssFiles(); #load Css Files  ?>
    <?php CommonScript::loadScriptFiles(); #load Scripts Files  ?>
    <?php CommonScript::activeMenu(); #Active Menu jQuery ?>
   
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<?php 
$controllerName=Yii::app()->controller->id;
$actionName=Yii::app()->controller->action->id;

if ($controllerName=='index' && $actionName=='login')
{
	?>
            <body class="login">
            <div class="logo"><?php echo Yii::t('admin_layouts_main','green_comet_text'); ?></div>
            <div class="content">
	<?php
}
else
{
	?>
            <body class="page-header-fixed">
            <div class="page-container row-fluid" id="page">
	<?php 
}
?>
	<!--	<div id="mainmenu">-->
        
	<?php echo $content; ?></div>

	<div class="clear"></div>
<?php 
if ($actionName!='login')
{	 
	include 'footer.php';
}
else
{	?>
	<div class="copyright">
		<?php echo Yii::app()->params['copyrightInfo'];?>
	</div>
	<?php 
} 

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
'id'=>'mydialog',
// additional javascript options for the dialog plugin
'options'=>array(
    'title'=>'Login',
    'autoOpen'=>false,
),
));


$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.uniform.min.js"></script>
       <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.cookie.js"></script>
        <script>
            if($.cookie('remember_menu') != null) 
            {
                $('body').addClass($.cookie('remember_menu')); 
            } 
            $(document).on('click', '.sidebar-toggler', function(){
                $.cookie('remember_menu', $('body').attr('class'), { expires: 90, path: '/'}); 
               
            });    
        </script>

</body>
                    
</html>
