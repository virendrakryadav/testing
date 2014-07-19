<?php
if($data)
{
?>
<div id="receipt_1" class="alert-uoload alert-block alert-warning fade in float-shadow">
    <input type="hidden" id="viewstatus<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}; ?>" value="0">
    <div class="col-lg-3 sky-form margin-bottom-5 ">
        <span id="status<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}; ?>"></span>
        <?php echo Globals::DEFAULT_CURRENCY.$data->{Globals::FLD_NAME_RECEIPT_AMOUNT}?>
    </div>
    <div id="getAtachmentsPropsal" class="col-lg-2 uploaded-receipts ">
    <?php
    if($data->{Globals::FLD_NAME_RECEIPT_REASON} == "")
    {
        ?>
        <img style="height: 150px; width: 140px;" src=<?php echo Globals::FRONT_USER_VIEW_IMAGE_PATH.$data->{Globals::FLD_NAME_TASK_ATTACHMENT}; ?> >
    <?php
    }
    else
    {
        echo $data->{Globals::FLD_NAME_RECEIPT_REASON};
    }
    ?>
    </div>
    <div class="col-lg-12 sky-form margin-bottom-5 ">
        <div class="input-group col-md-6"> 
            <button id="approve<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}; ?>" onclick="approveUploadedReceipt('<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}; ?>','<?php echo $data->{Globals::FLD_NAME_RECEIPT_AMOUNT}; ?>')" type="button">
                <img src="<?php echo CommonUtility::getPublicImageUri( "yes.png" ) ?>">
            </button>
            <button id="delete<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}; ?>" onclick="deleteUploadedReceipt('<?php echo $data->{Globals::FLD_NAME_TASK_TASKER_RECEIPT_ID}; ?>','<?php echo $data->{Globals::FLD_NAME_RECEIPT_AMOUNT}; ?>')" type="button">
                <img src="<?php echo CommonUtility::getPublicImageUri( "in-closeic.png" ) ?>">
            </button>            
        </div>
    </div>
</div>    
<?php
}
?>