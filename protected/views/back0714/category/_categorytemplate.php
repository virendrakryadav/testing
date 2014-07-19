<div class="controls">
 <div class="control-group">
     <?php echo CHtml::label('Title','CategoryLocale[category_id_'.$count.'][description]',array('class'=>'control-label')); ?>
             <div class="controls">
     <?php echo CHtml::textField('CategoryLocale[category_id_'.$count.'][title]','',array('size'=>60,'maxlength'=>250,'class'=>'span6','value'=>'')); ?>
     <span class="help-inline"><?php echo CHtml::error($locale,'title'); ?></span></div>
 </div>
 <div class="control-group">
     <?php echo CHtml::label('Description','CategoryLocale[category_id_'.$count.'][description]',array('class'=>'control-label')); ?>
             <div class="controls">
     <?php echo CHtml::textArea('CategoryLocale[category_id_'.$count.'][description]','', array('class'=>'span7','maxlength' => 1000, 'rows' => 8,'value'=>'','style'=>"width: 468px; height: 131px;")); ?>
      <span class="help-inline"><?php echo CHtml::error($locale,'description'); ?></span></div>
 </div>
</div>