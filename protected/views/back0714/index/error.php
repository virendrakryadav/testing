
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/back/error.css" />
<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	Yii::t('admin_index_error','error_text'),
);
?>



<div class="row-fluid">
	<div class="span12 page-404">
		<div class="number">
		<?php echo $code; ?>
		</div>
	<div class="details">
	<h3><?php echo Yii::t('admin_index_error','error_invalid_text')?></h3>
	<p>
		<?php echo CHtml::encode($message); ?>
	</p>
							
		</div>
	</div>
</div>

















