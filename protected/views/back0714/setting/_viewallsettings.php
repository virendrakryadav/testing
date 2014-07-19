<div class="row-fluid form-horizontal">
<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
$siteSettingType = Setting::model()->siteSettingType(Globals::FLD_NAME_ADMIN_SETTING_ALFABET);
if($siteSettingType)
{
?>
    <?php
    foreach($siteSettingType as $poster)
    {
    ?>
    <div class="control-group">
        <label class="control-label required" for="Setting_setting_label" style="width:250px;">
            <?php echo $poster->{Globals::FLD_NAME_SETTING_LABEL}?>
        </label>
        <div class="span6"><input type ='text' id ='' name="setting[<?php echo  $poster->{Globals::FLD_NAME_SETTING_ID} ?>]" value = "<?php echo $poster->{Globals::FLD_NAME_SETTING_VALUE} ?>" ><br/></div>
    </div>
    <?php
    }
    ?>
    
    <?php
    }
    $siteSettingType = Setting::model()->siteSettingType(Globals::FLD_NAME_USER_SETTING_ALFABET);
    if($siteSettingType)
    {
    ?>
    
    <?php
    foreach($siteSettingType as $poster)
    {
    ?>
    <div class="control-group">
        <label class="control-label required" for="Setting_setting_label" style="width:250px;">
            <?php echo $poster->{Globals::FLD_NAME_SETTING_LABEL}?>
        </label>
        <div class="span6"><input type ='text' id ='' name="setting[<?php echo $poster->{Globals::FLD_NAME_SETTING_ID} ?>]" value = "<?php echo $poster->{Globals::FLD_NAME_SETTING_VALUE} ?>" ><br/></div>
    </div>
    <?php 
    }
    ?>
    
<?php
} 
?>
</div>