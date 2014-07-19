<?php
if(isset($recentTasks))
{
    foreach($recentTasks as $recentTask)
    {
        $selectTemplate[$recentTask->{Globals::FLD_NAME_TASK_ID}] = ucfirst($recentTask->{Globals::FLD_NAME_TITLE});
    }
}
if(isset($selectTemplate))
{
        echo CHtml::dropDownList('recent_task_template','', $selectTemplate, 
         array('prompt'=> CHtml::encode(Yii::t('poster_createtask', 'Use Recent Project As Template')),
                               'ajax' => array(
                               'type' => 'POST',
                                'dataType' => 'json', 
                               'url' => CController::createUrl('poster/getrecenttasktemplatedetail'),
                               'success' => "function(data){
                                   if(data.status==='success')
                                    {
                                        
                                        var vall = $('#Task_description').val().length;
                                        var total=".Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.";
                                        total = total-vall;
                                        $('#wordcountPosterComments').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'))."'+total);
                                        
                                        $('#Task_description').val(data.description);
                                        $('#Task_title').val(data.title);
                                        if( data.is_premium == 1 )
                                        {
                                            $('#Task_is_premium').parent().removeClass('switch-off');
                                            $('#Task_is_premium').parent().addClass('switch-on');
                                            $('#Task_is_premium').prop('disabled', false);
                                            $('#Task_is_premium').prop('checked', true);
                                        }
                                        else
                                        {
                                            $('#Task_is_premium').parent().removeClass('switch-on');
                                            $('#Task_is_premium').parent().addClass('switch-off');
                                            $('#Task_is_premium').prop('disabled', true);
                                            $('#Task_is_premium').prop('checked', false);
                                        }
                                        if( data.is_highlighted == 1 )
                                        {
                                            $('#Task_is_highlighted').parent().removeClass('switch-off');
                                            $('#Task_iis_highlighted').parent().addClass('switch-on');
                                            $('#Task_iis_highlighted').prop('disabled', false);
                                            $('#Task_iis_highlighted').prop('checked', true);
                                        }
                                        else
                                        {
                                            $('#Task_is_highlighted').parent().removeClass('switch-on');
                                            $('#Task_is_highlighted').parent().addClass('switch-off');
                                            $('#Task_is_highlighted').prop('disabled', true);
                                            $('#Task_is_highlighted').prop('checked', false);
                                        }
                                        if( data.is_public == 1 )
                                        {
                                            $('#Task_is_public').prop('checked', true);
                                            
                                        }
                                        else
                                        {
                                            $('#Task_is_private').prop('checked', true);
                                        }
                                        
                                        $('#Task_price').val(parseInt(data.price));
                                        $('#Task_min_price').val(parseInt(data.min_price));
                                        $('#Task_max_price').val(parseInt(data.max_price));
                                        $('#Task_task_cash_required').val(parseInt(data.task_cash_required));
                                        $('#Task_work_hrs').val(data.work_hrs);
                                        $('#Task_payment_mode').val(data.payment_mode);
                                        setPriceMode(data.payment_mode);
                

                                    }
                                    else
                                    {
                                        alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                    }
                                }",
                               'data' => array('task_id'=>'js:this.value')),'class' => 'form-control mrg3 selectbg','live'=>false));
}
?>
