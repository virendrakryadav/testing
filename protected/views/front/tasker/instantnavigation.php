<?php
if(!isset($menusLinks))
{
    $menusLinks = UtilityHtml::getInstantNavigationLinks($type);
}
$controller_id = Yii::app()->controller->id;
$action_id = Yii::app()->controller->action->id;
?>
<div class="margin-bottom-30">
    <div class="<?php if(count($menusLinks) > 1 ) echo 'notifi-set'; else echo 'search-filter';?>">
        <ul>
        <?php
            foreach( $menusLinks as $name => $link )
            {
                ?>
            <li><?php echo CHtml::link(Yii::t('poster_createtask', $name), $link);?></li>
            <?php
            }
        ?>
        </ul>
    </div>
    <div class="clr"></div>
</div>
