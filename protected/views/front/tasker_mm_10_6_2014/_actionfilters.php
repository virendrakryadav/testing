<div class="advncsearch">
    <div class="advnc_row">
        <div class="fltbtn_cont"><?php echo CHtml::link(CHtml::encode(Yii::t('poster_mytasklist', 'Reset Filter')), 'javascript:void(0)', array('id' => 'resetFilter' , 'class'=>'btn-u rounded btn-u-red')); ?></div>
<!--        <div class="fltbtn_cont1">
            <?php //$filters = UserAttrib::getUserSavedFilters($filter_type);
            //if( $filters )
            //echo UtilityHtml::getSearchFilterList($filter_type); ?>
        </div>-->
        <div class="fltbtn_cont2" id="saveFilter">
        <?php if(!isset($reset))
        {
            //print_r($_GET);
            echo CHtml::ajaxLink(CHtml::encode(Yii::t('poster_createtask', 'Save filter')), Yii::app()->createUrl('tasker/saveFilterForm'), 
            array(
                'type' => 'POST', 
                'data' => array('filter_type' => $filter_type),
                'success' => 'function(data){ $("#saveFilterForm").html(data); $("#saveFilter").css("display","none");$("#saveFilterForm").css("display","block"); }'), 
                array('id' => 'saveFilter', 'class' => 'btn-u rounded btn-u-sea', 'live' => false
            ));
        }
        ?> 
        </div>
    </div>
    <div  id="saveFilterForm" ></div>
</div>