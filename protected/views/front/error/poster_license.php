<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/back/error.css" />
<div class="container content">
    

<!--Left bar start here-->
<div class="col-md-3 leftbar-fix" >
<!--Dashbosrd start here-->
<?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
<!--left nav start here-->
<div class="margin-bottom-30">

</div>
<!--left nav Ends here-->

</div>
<!--Left bar Ends here-->

<!--Right part start here-->
<div class="col-md-9 right-cont" onclick="$('#errorMsg').parent().fadeOut();">
    
    <div id="type_title" class="breadcrumbs fixed col-md-65">
        <h1 id="title_virtual" class="pull-left text-30"><?php echo ErrorCode::ERROR_TEXT_IS_POSTER_LICENSE ?></h1>
       
    </div>
    

<div id="taskType"  >
    <div class="col-md-12 mrg-auto5">
        <p>
            <?php echo CHtml::encode($message); ?>
        </p>
    <input class="btn-u btn-u-lg rounded btn-u-red push" type="button" onclick="window.location.href = '<?php echo Yii::app()->request->urlReferrer; ?>'" value="Cancel" >
    <input type="button" class="btn-u btn-u-lg rounded btn-u-sea push"  value="Get License" >
</div>
</div>
<div id="accordionDiv" style="display: <?php if(isset($task->{Globals::FLD_NAME_TASK_ID})) echo 'block'; else echo 'none' ?>"  >


   
</div>
</div>

<!--Choose a Category and Subcategory Ends here-->


<!--Right part ends here-->
</div>
