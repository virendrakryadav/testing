<style>
.Submit
	{
		float:right;
	}
</style>
<script>
function commentvalidate()
{
    var tasker_comment = document.getElementById('tasker_review_comments').value;
	var poster_comment = document.getElementById('poster_review_comments').value;
	//alert(comment);
    if(tasker_comment == '')
	{
		$('#reviewerror').show();
		$('#reviewerror').html('Please insert comment');            
		$("#tasker_review_comments-form").css("border-color", "tomato");
		return false;
	}
	else
	{
		$('#reviewerror').hide();
		$("#tasker_review_comments").css("border-color", "");
		$('#reviewerror').html('');  
		//$("#comment"+id).val("");
	}    
}
</script>
<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'review-form',
	));
?>
	<div class="drew_comments">
		<?php 
		if($user_type == 't')
			echo $form->textArea($model, Globals::FLD_NAME_TASKER_REVIEW_COMMENTS, array('id'=>Globals::FLD_NAME_TASKER_REVIEW_COMMENTS));
		else
			echo $form->textArea($model, Globals::FLD_NAME_POSTER_REVIEW_COMMENTS, array('id'=>Globals::FLD_NAME_POSTER_REVIEW_COMMENTS));	?>
			
		<div id="reviewerror" style="color: tomato;font-size: 12px;font-weight: bold;display: none;"></div>
	</div>                    
	<?php echo $form->hiddenField($model,Globals::FLD_NAME_TASK_ID,array('value'=>$model->{Globals::FLD_NAME_TASK_ID})); ?>
		<div class="Submit">                    
		<?php
			echo CHtml::ajaxSubmitButton('Submit',Yii::app()->createUrl('poster/savereview'),array(
			'type'=>'POST',
			'success'=>'js:function(data){  
			data =JSON.parse(data);
			if(data.status==="success"){     
			$("#tasker_review_comments").val("");
			$("#poster_review_comments").val("");
			$("#write_review").hide();
			$("#review_box").html("");
			$("#review_box").append(data.reviews);
			}else{
			//$("#successMsg").show();
			// $("#successMsg").html("Cube not Posted..");                                                  
			}
			}',                               
			
			));
		?>                    
		</div>
	<div class="clear"></div>
                    <?php $this->endWidget(); ?> 