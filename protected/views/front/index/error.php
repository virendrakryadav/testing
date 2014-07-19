<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/back/error.css" />
<div class="page-container pagetopmargn">
    <!--Left side bar start here-->

    <!--Left side bar ends here-->
    <!--Right side content start here-->
    <div class="rightbar1">
        <div class="box">

            <div class="row-fluid">
                <div class="span12 page-404">
                    <div class="number">
                        <?php echo $code; ?>
                    </div>
                    <div class="details">
                        <h3><?php echo Yii::t('admin_index_error', 'error_invalid_text') ?></h3>
                        <p>
                            <?php echo CHtml::encode($message); ?>
                        </p>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!--Right side content ends here-->
</div>
