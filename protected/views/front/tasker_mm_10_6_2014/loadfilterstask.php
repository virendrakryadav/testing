<div class="smartsearch">
<ul>
<?php
if($filters)
{
    $i=0;
    foreach( $filters as $filter)
    {
        ?>
    <li id="filter_<?php echo $i  ?>"><a href="<?php echo $filter->{Globals::FLD_NAME_VAL_STR};?>"><?php   echo $filter->{Globals::FLD_NAME_ATTRIB_DESC}; ?></a>
        <a id="deletefilter<?php echo $i ?>" onclick="deleteFilter('<?php echo $filter->{Globals::FLD_NAME_ATTRIB_TYPE} ?>' , '<?php echo $filter->{Globals::FLD_NAME_ATTRIB_DESC} ?>' , '<?php echo $filter->{Globals::FLD_NAME_USER_ID} ?>' , '<?php echo $i ?>' )" href="javascript:void(0)"><img src="<?php echo CommonUtility::getPublicImageUri("remove-btn.png") ?>"></a>        
   </li>       
        <?php
        $i++;
    }
}
else
{
    ?>
    <li><a href="javascript:void(0)" id="loadPremiumTask"><?php echo Yii::t('tasklist', 'txt_no_filters_found') ?></a></li>
    <?php
}
?> 
</ul>
</div>
