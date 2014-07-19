<div class="left_search margin-bottom-30">
<!--<div class="left_searchcol1">
    <img src="<?php  echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>" />
</div>-->
<div class="left_searchcol2 prijectlive-search">
<?php echo CHtml::textField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TITLE . ']', '', array('id' => 'taskTitle', 'placeholder' => 'Search project', 'class' => '')); ?>

</div>

<div id="search-task-project" class="left_searchcol3-prijectlive">
    <!--<img src="<?php //  echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>" />-->
     <img src="<?php  echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>" />
</div>
    
</div>
<script>
var timer = null;
$("#search-task-project").click(function(){
    
    clearTimeout(timer);
    var title = $.trim($("#taskTitle").val());
//    timer = setTimeout(function(){
        if(title != '')
        {
            window.location = '<?php echo CommonUtility::getTaskSearchUrlByTaskTitle(''); ?>'+title;
        }
//    }, 1000);
});
$('#taskTitle').bind('keyup keypress' , function(e){
var code = e.keyCode || e.which; 
    if(code == 13)
    {
           var title = $.trim($("#taskTitle").val());
            if(title != '')
            {
                window.location = '<?php echo CommonUtility::getTaskSearchUrlByTaskTitle(''); ?>'+title;
            }
             e.preventDefault();
            return false;
    }
     //e.preventDefault();
   
});
</script>
