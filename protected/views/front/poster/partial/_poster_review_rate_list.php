<script>
    function calculateAverageRating()
    {
        rating = [];
        $('.posterreviewratingfield').each(function(id) {
            text = $(this).val();
            
            if(text!=0)
            {
//                alert(text);
                rating.push(text);
            }
        });
        result = 0;
        for (var i = 0; i< rating.length; i++) 
        {
            result = result + parseInt(rating[i]);
        }
        avgrating = result/rating.length;
        $('#over_rt').val(avgrating);
        $.ajax({
            type: "POST",
            url: '<?php echo Yii::app()->createUrl('poster/displayposterrating');?>',
            dataType: 'json',
            data: {id:'overall_rating',rating: avgrating},
            success: function (data) {
                    $('.avgrating').html(data.html);
            }
        })
    }
</script>
<?php
CommonScript::loadRatingPopOver();
$tooltip = CommonUtility::getToolTipForDoerReviewPage($data->rating_desc);
?>
<div class="col-md-12 ratting-bg2 mrg-bottom">
<!--    <div class="rat-col1 pdn-top-bot border-right" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="hover"
      data-content="<?php echo $tooltip?>" ><?php echo $data->rating_desc?></div>-->
<div class="rat-col1 pdn-top-bot border-right"><a href="#" style="color:#000;" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="hover"
      data-content="<?php echo $tooltip?>" ><?php echo $data->rating_desc?></a></div>
<div class="rat-col2 pdn-top-bot2"><?php UtilityHtml::posterReviewRating( 'ratings'.$data->rating_id,array('id' =>$data->rating_id,'task_id' => $task->{Globals::FLD_NAME_TASK_ID},'poster_id' => $task->{Globals::FLD_NAME_CREATER_USER_ID},'rating_id' =>$data->rating_id));?></div> <div class="clr"></div></div>



