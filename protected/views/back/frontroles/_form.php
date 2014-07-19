<?php
/* @var $this RolesController */
/* @var $model Roles */
/* @var $form CActiveForm */
?>

<div class="search-form">
<div class="wide form form-horizontal">
<?php CommonScript::rolesFormScript(); #load checkbox script and validation ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'roles-form',
        'htmlOptions' => array('name' => 'rolesForm'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation' => true,
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
		//'validateOnChange' => true,
		//'validateOnType' => true,
		//'validateOnClick' => true
	),
)); ?>

<!--	<p class="note">Fields with <span class="required">*</span> are required.</p>-->

	
<?php 
        $models = Yii::app()->params['rolesModels']; #Get Models from params
?>
<div class="row-fluid "> 
        

	<?php echo $form->errorSummary($model); ?>
        
	<div class="control-group">
		<?php echo $form->labelEx($model,'role_name',array('class'=>'control-label','label'=>Yii::t('admin_roles_form','role_name_text'))); ?>
		<div class="controls"><?php echo $form->textField($model,'role_name',array('class'=>'span6','size'=>20,'maxlength'=>20)); ?>
                    <span class="help-inline">
                        <?php echo $form->error($model,'role_name'); ?>
                    </span>
                </div>
        </div>

	<div class="row-fluid">
            
           <div class="control-group"> <?php   echo $form->labelEx($model,'role_permission',array('label'=>Yii::t('admin_roles_form','Role Permission Admin'))); ?></div>
            
           
                <?php
                        $permissions =  $model->role_permission;
                       
                        if(isset($permissions))
                        {
                            $permissions =  CJSON::decode($permissions);
                        }
                         //print_r($permissions);
                        $countHead=1;
                        foreach($models as $index => $newmodel)
                        {
                            
                             if(is_array($newmodel))
                            {

                                $controller  = $index."Controller"; 
                                $actions = $newmodel; #Get Actions of models from params
                                
                                $newmodel = strtolower($index);
                                $newmodelDEFAULT = $newmodel;
                                $var = $newmodel;
                                $varBackModel = 'back['.$newmodel.']';
                                $varBackClass = 'back_'.$newmodel;
                            }
                            else
                            {
                               $controller  = $newmodel."Controller"; 
                                $actions = Yii::app()->params['rolesActions']; #Get Actions of models from params
                                $newmodelDEFAULT = $newmodel;
                                $newmodel = strtolower($newmodel);
                                $var = $newmodel;
                                $varBackModel = 'back['.$newmodel.']';
                                $varBackClass = 'back_'.$newmodel;
                            }
                            
                           
                            //exit;
                            
                            ?>
                            <div class="span3" style="margin:0 0 27px 0;">
                            <table class="table_role" style="width:90%">
                                <tr style="background: #ddd;color: #000;font-weight: bold">
                                    <td class="role_label"><?php echo CHtml::label($var,$varBackModel."[".$newmodel."]"); ?></td>
                                    <td class="role_chk_header"><?php echo CHtml::checkBox($varBackModel,'',array('value'=>'','uncheckValue'=>'','checked'=>'','style'=>'margin-top:7px;','onclick'=>'checkBoxes(this)','class'=>$varBackClass.' '.$varBackClass.'head'.$countHead)); ?></td>
                                </tr>
                                     
                            <?php
                          
                           $isChechedCounter=0;
                           $count=1;
                           
                            foreach($actions as $action)
                            {
                                $isChecked = false;
                               
                                if(isset($permissions[$newmodel][$action]))
                                {
                                    $isChecked = true;
                                    $isChechedCounter++;
                                }
                                $listId = '';
                               // echo $action;
                                if(trim($action)!='list')
                                {
                                   $listId =  'checkView('.$varBackClass.'_list)';
                                   //$listId =  '';
                                }
                               ?>
                                <tr style="background: #f1faff;color: #000;font-weight: bold;border-bottom: 1px solid #edeaea">
                                    <td><?php echo CHtml::label($action,$varBackModel."[".$action."]"); ?></td>
                                    <td><?php echo CHtml::checkBox($varBackModel."[".$action."]",$isChecked,array('value'=>1,'style'=>'margin-top:0px;','onclick'=>$listId,'class'=>$varBackClass.'Sub '.$varBackClass.$count)); ?></td>
                                </tr>
                            <?php 
                            $count++;
                            }
                            //echo $isChechedCounter;
                            if(count($actions)==$isChechedCounter)
                            {
                                //echo $form->hiddenField($$var,'headerchecked',array('value'=>'1','class'=>$var)); 
                            ?>
                            <script>
                                $('.<?php echo $varBackClass ?>').prop('checked', true );
                            </script>
                            <?php
                            }
                            ?>
                            <script>
                                $("input[type='checkbox'].<?php echo $varBackClass.'Sub'; ?>").change(function()
                                {
                                    var a = $("input[type='checkbox'].<?php echo $varBackClass.'Sub'; ?>");
                                    if(a.length == a.filter(":checked").length)
                                    {
                                        $('.<?php echo $varBackClass ?>').prop('checked', true );
                                    }
                                    else
                                    {
                                        $('.<?php echo $varBackClass ?>').prop('checked', false );
                                    }
                                    checkboxesrefresh()
                                });
                            </script>
                            </table>
                            </div>
                            <?php 
                            $countHead++;
                        }
                ?>
         
                                    
	



</div><!-- form -->
<?php 

        $models = Yii::app()->params['rolesModelsFront']; #Get Models from params

?>

<div class="row-fluid">
            
           <div class="control-group"> <?php   echo $form->labelEx($model,'role_permission',array('label'=>Yii::t('admin_roles_form','Role Permission Front'))); ?></div>
            
           
                <?php
                        $permissions =  $model->role_permission_front;
                       
                        if(isset($permissions))
                        {
                            $permissions = CJSON::decode($permissions);
                        }
                         //print_r($permissions);
                        $countHead=1;
                        foreach($models as $index => $newmodel)
                        {
                            
                             if(is_array($newmodel))
                            {

                                $controller  = $index."Controller"; 
                                $actions = $newmodel; #Get Actions of models from params
                                
                                $newmodel = strtolower($index);
                                $newmodelDEFAULT = $newmodel;
                        $var = $newmodel;
                                $varFrontModel = 'front['.$newmodel.']';
                                $varFrontClass = 'front_'.$newmodel;
                                
                            }
                            else
                            {
                               $controller  = $newmodel."Controller"; 
                                $actions = Yii::app()->params['rolesActions']; #Get Actions of models from params
                                $newmodelDEFAULT = $newmodel;
                                $newmodel = strtolower($newmodel);
                          $var = $newmodel;
                                $varFrontModel = 'front['.$newmodel.']';
                                $varFrontClass = 'front_'.$newmodel;
                            }
                            
                           
                            //exit;
                            
                            ?>
                            <div class="span3" style="margin:0 0 27px 0;">
                            <table class="table_role" style="width:90%">
                                <tr style="background: #ddd;color: #000;font-weight: bold">
                                    <td class="role_label"><?php echo CHtml::label($var,$varFrontModel."[".$newmodel."]"); ?></td>
                                    <td class="role_chk_header"><?php echo CHtml::checkBox($varFrontModel,'',array('value'=>'','uncheckValue'=>'','checked'=>'','style'=>'margin-top:7px;','onclick'=>'checkBoxes(this)','class'=>$varFrontClass.' '.$varFrontClass.'head'.$countHead)); ?></td>
                                </tr>
                                     
                            <?php
                          
                           $isChechedCounter=0;
                           $count=1;
                           
                            foreach($actions as $action)
                            {
                                $isChecked = false;
                               // print_r($permissions[$newmodelDEFAULT]);
                                if(isset($permissions[$newmodel][$action]))
                                {
                                    $isChecked = true;
                                    $isChechedCounter++;
                                }
                                $listId = '';
                               // echo $action;
                                if(trim($action)!='list')
                                {
                                  // $listId =  'checkView('.$varFrontClass.'_list)';
                                    $listId =  '';
                                }
                               ?>
                                <tr style="background: #f1faff;color: #000;font-weight: bold;border-bottom: 1px solid #edeaea">
                                    <td><?php echo CHtml::label($action,$varFrontModel."[".$action."]"); ?></td>
                                    <td><?php echo CHtml::checkBox($varFrontModel."[".$action."]",$isChecked,array('value'=>1,'style'=>'margin-top:0px;','onclick'=>$listId,'class'=>$varFrontClass.'Sub '.$varFrontClass.$count)); ?></td>
                                </tr>
                            <?php 
                            $count++;
                            }
                            
                            if(count($actions)==$isChechedCounter)
                            {
                                //echo $form->hiddenField($$var,'headerchecked',array('value'=>'1','class'=>$var)); 
                            ?>
                            <script>
                                $('.<?php echo $varFrontClass ?>').prop('checked', true );
                            </script>
                            <?php
                            }
                            ?>
                            <script>
                                $("input[type='checkbox'].<?php echo $varFrontClass.'Sub'; ?>").change(function()
                                {
                                    var a = $("input[type='checkbox'].<?php echo $varFrontClass.'Sub'; ?>");
                                    if(a.length == a.filter(":checked").length)
                                    {
                                        $('.<?php echo $varFrontClass ?>').prop('checked', true );
                                    }
                                    else
                                    {
                                        $('.<?php echo $varFrontClass ?>').prop('checked', false );
                                    }
                                    checkboxesrefresh()
                                });
                            </script>
                            </table>
                            </div>
                            <?php 
                            $countHead++;
                        }
                ?>
         
                                    
		<?php //echo $form->textArea($model,'role_permission',array('rows'=>6, 'cols'=>50)); ?>
		<?php // echo $form->error($model,'role_permission'); ?>

	<div class="row-fluid" style="margin-left:0px; overflow:hidden;">
            <div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('admin_roles_form','create_text') : Yii::t('admin_roles_form','save_text'),array('class'=>'btn blue','onclick' => 'return validateCheckBoxes(this.form)')); ?><?php echo CHtml::button(Yii::t('admin_roles_form','cancel_text'), array('onClick' => 'backUrl()', 'id'=>'form-reset-button', 'class'=>'btn')); ?> 
            </div>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div></div>
