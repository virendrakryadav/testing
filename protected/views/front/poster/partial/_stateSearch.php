<?php   $this->widget('zii.widgets.CMenu',array(
			'activeCssClass' => 'active',
			'id' => 'state',
			//'method' => 'get',
			'items'=>array(
				array('label'=>'all', 'url'=>array('#'),array('class'=>"active")),
				array('label'=>'Open', 'url'=>array('mytaskslist?state=o')),
				array('label'=>'Close', 'url'=>array('mytaskslist?state=f')),
				array('label'=>'Awarded', 'url'=>array('mytaskslist?state=a')),
				array('label'=>'Cancel', 'url'=>array('mytaskslist?state=c')),
			),
		)); 
		
?>


</div>
<div class="task_toptab_col2">
<div class="archive_col1"><select name="archive" class="span2">
<option><?php echo Yii::t('poster_createtask', 'Select Archive')?></option>
</select>
<input name="" type="button" class="archive_btn" value="Archive" />
<select name="archive" class="span2">
<option><?php echo Yii::t('poster_createtask', 'Sort by Relevance')?></option>
</select>
</div>
</div>
</div>