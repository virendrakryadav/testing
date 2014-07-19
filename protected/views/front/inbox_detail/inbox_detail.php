<style>
    .reply_to{
        float: left;
        width: 80%;
    }
    .reply_to > input {
        background-color: #FFFFFF;
        border: 1px solid #CCCCCC;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        transition: border 0.2s linear 0s, box-shadow 0.2s linear 0s;
        float: left;
        width: 90%;
    }
    .inboxreply_full {
    background: none repeat scroll 0 0 #EBEBEB;
    float: right;
    width: auto;
    }
</style>
<script text="text/javascript">
  $(function(){
    $("#attach").click(function(){
      $(".controls").toggle();
      e.preventDefault();
    });
  });
</script>
<script>
    $(document).ready(function() {
    $('#selectall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});
</script>
<div class="container content">
    <!--Left side bar start here-->
    <div class="col-md-3">
        <!--erandoo start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--erandoo end here-->
        <!--Top search start here-->
        <div class="left_search margin-bottom-30">
            <div class="left_searchcol1">
                <img src="<?php  echo CommonUtility::getPublicImageUri( "in-searchic.png" ) ?>" />
            </div>
            <div class="left_searchcol2"><input name="" type="text" placeholder="<?php echo CHtml::encode(Yii::t('inbox_index', 'txt_show_all'))?>"/></div>
            <div class="left_searchcol3">
                <img src="<?php  echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>" />
            </div>
        </div>
        <!--Top search Ends here-->
  
        <!--Smart search start here-->
        <div class="margin-bottom-30">
            <div class="notifi-set">
                <?php echo CHtml::hiddenField( Globals::FLD_NAME_QUICK_FILTER , "", array('id' => 'quickFilterValue')); ?>      
                <?php echo CHtml::hiddenField(Globals::FLD_NAME_TASK . '[' . Globals::FLD_NAME_TASK_STATE . ']', 'a', array('id' => 'taskStateValue')); ?>
                <ul>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_all_messages')), 'javascript:void(0)', array('id' => 'loadmytasksAll','class' => 'active')); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_current')), 'javascript:void(0)', array('id' => 'loadmytasksAll')); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_open')), 'javascript:void(0)', array('id' => 'loadmytasksOpen')); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_close')), 'javascript:void(0)', array('id' => 'loadmytasksClose')); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_cancel')), 'javascript:void(0)', array('id' => 'loadmytasksCancel')); ?></li>
                    <li><?php echo CHtml::link(CHtml::encode(Yii::t('inbox_index', 'txt_archived')), 'javascript:void(0)', array('id' => 'loadmytasksArchived')); ?></li>
                </ul>
            </div>
            <div class="clr"></div> 
        </div>
        <!--Smart search ends here-->
  
        <!--filter start here-->
        <div class="margin-bottom-30">
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20 sky-form">
                    <div class="panel-heading">
                        <h2 class="panel-title">
                            <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">
                            <?php echo CHtml::encode(Yii::t('inbox_index', 'txt_filter'))?>
                            <span class="accordian-state"></span>
                            </a>
                        </h2> 
                    </div>
                    <div class="panel-collapse collapse in sky-form" id="collapseOne">
                        <div class="panel-body no-pdn">
                            <div class="col-md-12 no-mrg">
                                <div class="message-filter">
                                    <ul>
                                        <li><a href="#" class="active"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_all'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_messages'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_proposals'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_payment'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_terms'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_invites'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_feedback'));?></a></li>
                                        <li><a href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_drafts'));?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>     
        <!--filter ends here-->
    </div>
    <!--Left side bar ends here-->

    <!--Right side content start here-->
    <div class="col-md-9 sky-form">
    <h3 class="h2 text-30a"><?php echo Yii::t('inbox_index', 'Messages') ?></h3>
        <!--top head sort by start here-->
        <div class="margin-bottom-20">
            <div class="sortby-row">
                <div class="col-md-3 no-mrg">
                        <?php echo CHtml::encode(Yii::t('inbox_index', 'txt_inbox'));?>
                </div> 
                <div class="col-md-3 sortby-noti no-mrg">
                    <select class="form-control mrg3" name="archive">
                        <option><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_sort_by'))?></option>
                    </select>
                </div>
            </div>
        </div>
        <!--top head sort by ends here-->

        <!--right message start here-->
        <div class="col-md-12 no-mrg"> 
            <!--reply start here-->  
            <div class="inboxreply_full">
                <div class="reply_row1">
                    <div class="reply_to">
                        <?php echo CHtml::encode(Yii::t('inbox_index', 'To'))?>
                        <input type="test" value="" placeholder="" style="margin:-20px 0 0 33px; width:120%;">
                    </div>
                </div>
                <div class="reply_row2">
                    <div class="reply_col1"><textarea name="message"></textarea></div>
                    <div class="reply_row3">
                        <div class="reply_col2" id="attach"><a href="#" class="btn-u rounded btn-u-blue"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_attach_file'))?></a></div>
                        <div class="reply_col2"><a href="#" class="btn-u rounded btn-u-blue"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_save_as_draft'))?></a></div>
                        <div class="reply_col2"><a href="#" class="btn-u rounded btn-u-blue"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_delete'))?></a></div>
                        <div class="reply_col3"><a href="#" class="btn-u rounded btn-u-sea"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_reply'))?></a></div>
                            <div class="controls" style="display : none;">
                                <?php
                                $imageName = Globals::DEFAULT_INBOX_IMAGE;
                                ?>
                                <img id="imagePriview" src="<?php echo $imageName;?>" height="50" width="50"></img>
                                <input type="hidden" id="imageNameHidden" name="imageNameHidden">
                                <input type="hidden" id="path" value="<?php echo Globals::BASH_URL.'/'.Globals::FRONT_USER_PORTFOLIO_TEMP_PATH; ?>">
                                <?php
                                //echo Yii::app()->getBaseUrl();
                                $this->widget('ext.EAjaxUpload.EAjaxUpload',
                                        array(
                                                'id'=>'uploadFileNew',
                                                'config'=>array(
                                                    'action'=>Yii::app()->createUrl('inbox/updateimage'),
                                                    'allowedExtensions'=>Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES],//array("jpg","jpeg","gif","exe","mov" and etc...
                                                    'sizeLimit'=>Yii::app()->params[Globals::FLD_NAME_MAX_FILE_SIZE],// maximum file size in bytes
                                                    //'minSizeLimit'=>10*1024*1024,// minimum file size in bytes
                                                    'onComplete'=>"js:function(id, fileName, responseJSON){                                                                                
                                                            $('.qq-upload-list').remove();
                                                            var path = document.getElementById('path').value;
                                                            document.getElementById('imagePriview').src = path+fileName;
                                                            document.getElementById('imageNameHidden').value = fileName;
                                                        }",
                                                    )
                                        )); 
                                            ?>
                                </div>
                    </div>
                </div>

                <div class="replymess">
                    <div class="replymess1">
                        <div class="replymess2">Me</div>
                        <div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
                        <div class="reply_col3"><a class="interested_btn" href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mark_as_read'))?></a></div>
                    </div>
                    <div class="replymess1">
                        <div class="replymess2">Walter</div>
                        <div class="replymess3">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim </div>
                        <div class="reply_col3"><a class="interested_btn" href="#"><?php echo CHtml::encode(Yii::t('inbox_index', 'txt_mark_as_read'))?></a></div>
                    </div>
                </div>
            </div>
            <!--reply ends here-->           
        </div>
        <!--right message ends here-->
    </div>
    <!--Right side content ends here-->
</div>