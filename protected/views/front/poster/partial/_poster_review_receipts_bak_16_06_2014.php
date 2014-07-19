<!--Project detail Start here-->
<div class="col-md-12 mrg-auto overflow-h no-pdn">
    <div class="project-cont2">
        <div class="tasker_row1">
            <div class="proposal_row no-mrg">
                <div class="col-md-10 no-mrg">
                    <span class="proposal_title">
                        <a href="#"><?php echo ucfirst($task->{Globals::FLD_NAME_TITLE}) ?> </a></span></div>
            </div>
            <div class="proposal_col4 ">Posted: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?> </span></div>
            <div class="proposal_col4 ">Start date: <span class="date"><?php echo CommonUtility::formatedViewDate($task->{Globals::FLD_NAME_CREATED_AT}) ?></span></div>
            <div class="proposal_col4 ">Type: <span class="date"><?php echo ucwords(UtilityHtml::getTaskType($task->{Globals::FLD_NAME_TASK_KIND})); ?> </span></div>
            <div class="proposal_col4 ">Category: <span class="date"><?php echo $task->categorylocale->{Globals::FLD_NAME_CATEGORY_NAME} ?> </span></div>
        </div>  
    </div>
    <div class="project-col5">
        <span class="project-col2">Completed</span>
        <img src="<?php echo CommonUtility::getThumbnailMediaURI($model->{Globals::FLD_NAME_USER_ID}, Globals::IMAGE_THUMBNAIL_PROFILE_PIC_80_80) ?>">
        <span class="project-col2"><a href="#"><?php echo UtilityHtml::getUserFullNameWithPopoverAsPoster($model->{Globals::FLD_NAME_USER_ID}) ?></a></span>
    </div>
</div>
<!--Project detail Ends here-->

<!--Upload Receipts Start here-->
<div class="col-md-12 no-mrg2">
    <h4 class="panel-title">Upload Receipts</h4>
    <p class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis acneque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor.</p>

    <div class="col-md-9 no-mrg overflow-h sky-form">
        <div class="col-md-7 no-mrg overflow-h">
            <label class="input input-file" for="file">
                <div class="button"><input type="file" onchange="this.parentNode.nextSibling.value = this.value" id="file">Browse</div><input type="text" readonly="">
            </label>
            <span class="text-12">Must be in PDF, PNG, or JPG format</span>
        </div>
        <div class="col-md-2">
            <button class="btn-u btn-u-sea btn-pdn" type="button">Upload</button></div>
    </div>
</div>
<!--Upload Receipts Ends here-->

<!--Uploaded Start here-->
<div class="col-md-12 no-mrg2">
    <h4 class="panel-title">Uploaded</h4>
    <div class="col-md-12 no-mrg">
        <div class="alert-uoload alert-block alert-warning fade in">
            <button data-dismiss="alert" class="close3" type="button"><img src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png") ?>"></button>
            <div class="col-lg-2 uploaded-receipts"><img src="<?php echo CommonUtility::getPublicImageUri("recipt.jpg") ?>"></div>
            <div class="col-lg-12 sky-form margin-bottom-5"><div class="input-group col-md-12 f-left">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control" placeholder="Amount">
                </div></div>
        </div>
        <div class="alert-uoload alert-block alert-warning fade in">
            <button data-dismiss="alert" class="close3" type="button"><img src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png") ?>"></button>
            <div class="col-lg-2 uploaded-receipts"><img src="<?php echo CommonUtility::getPublicImageUri("recipt.jpg") ?>"></div>
            <div class="col-lg-12 sky-form margin-bottom-5"><div class="input-group col-md-12 f-left">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control" placeholder="Amount">
                </div></div>
        </div>
        <div class="alert-uoload alert-block alert-warning fade in">
            <button data-dismiss="alert" class="close3" type="button"><img src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png") ?>"></button>
            <div class="col-lg-2 uploaded-receipts"><img src="<?php echo CommonUtility::getPublicImageUri("recipt.jpg") ?>"></div>
            <div class="col-lg-12 sky-form margin-bottom-5"><div class="input-group col-md-12 f-left">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control" placeholder="Amount">
                </div></div>
        </div>
        <div class="alert-uoload alert-block alert-warning fade in">
            <button data-dismiss="alert" class="close3" type="button"><img src="<?php echo CommonUtility::getPublicImageUri("in-closeic.png") ?>"></button>
            <div class="col-lg-2 uploaded-receipts"><img src="<?php echo CommonUtility::getPublicImageUri("recipt.jpg") ?>"></div>
            <div class="col-lg-12 sky-form margin-bottom-5"><div class="input-group col-md-12 f-left">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control" placeholder="Amount">
                </div></div>
        </div>
    </div>
</div>

<!--Uploaded Ends here-->

<!--Other Expenses Start here-->
<div class="col-md-12 no-mrg2 sky-form">
    <h4 class="panel-title margin-bottom-10">Other Expenses</h4>
    <div class="col-md-12 no-mrg">
        <div class="col-md-2 no-mrg">
            <div class="input-group col-md-12 f-left">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" placeholder="Amount">
            </div>
        </div>
        <div class="col-md-8">
            <input class="form-control" type="text" placeholder="Label">
        </div>
        <button type="button" class="btn-u rounded btn-u-sea">+ Add Expense</button>
    </div>
    <div class="col-md-12 mrg-auto2">Add an expense without a receipt.</div>
    <div class="col-md-12 mrg-auto2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Label</th>
                        <th class="align-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>$5</td>
                        <td>Parking ticket @ 110 Main</td>
                        <td align="center"><a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("del-ic.png") ?>" /></a></td>

                    </tr>
                <td>$10</td>
                <td>Parking ticket @ 110 Main</td>
                <td align="center"><a href="#"><img src="<?php echo CommonUtility::getPublicImageUri("del-ic.png") ?>" /></a></td>
                </tr>


                </tbody>
            </table>
        </div>
    </div>

</div>
<!--Other Expenses Ends here-->