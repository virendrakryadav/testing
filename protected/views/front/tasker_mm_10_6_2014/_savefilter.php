<div class="savefilterrow" >
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'savefilter-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
       // 'validateOnSubmit' => true,
    //'validateOnChange' => true,
    //'validateOnType' => true,
    ),
        ));
?>

<div class="savefiltr_col1 popup_padding">
<?php echo $form->textField($userAtrib, Globals::FLD_NAME_ATTRIB_DESC, array('class' => 'span2', 'placeholder' => CHtml::encode(Yii::t('poster_createtask', 'Filter Description')))); ?>
<?php echo $form->error($userAtrib, Globals::FLD_NAME_ATTRIB_DESC); ?></div>
<?php echo CHtml::hiddenField(Globals::FLD_NAME_FILTER_TYPE, $filter_type); ?>

<div class="savefiltr_col2">
 <?php
//if(Yii::app()->controller->action->id == "filterformmytasks" && Yii::app()->controller->id == "poster")
//{
//    $action = "poster/savefiltermytasks";
//}
//elseif(Yii::app()->controller->action->id == "filterformmytasks" && Yii::app()->controller->id == "tasker")
//{
//    $action = "tasker/savefiltermytasks";
//}
//elseif(Yii::app()->controller->action->id == "savefiltertaskproposalform" && Yii::app()->controller->id == "tasker")
//{
//    $action = "tasker/savefiltertaskproposal";
//}
//else
//{
    $action = "tasker/savefilter";
//}
 $successUpdate = '
if(data.status==="success")
{
    $("#saveFilter").css("display","block");$("#saveFilterForm").css("display","none");
      loadfilters("'.$filter_type.'");
}
else
{
    $.each(data, function(key, val) {
    $("#savefilter-form #"+key+"_em_").text(val);                                                    
    $("#savefilter-form #"+key+"_em_").show();
    
    });
}';
CommonUtility::getAjaxSubmitButton('', Yii::app()->createUrl($action), 'okbtn', 'saveFilter', $successUpdate);
?>
</div>
<div class="savefiltr_col2"><a onclick='$("#saveFilter").css("display","block");$("#saveFilterForm").css("display","none");'  href="#"><img src="<?php echo CommonUtility::getPublicImageUri( "cancel.png" ) ?>"></a></div>
<?php $this->endWidget(); ?>
</div>
