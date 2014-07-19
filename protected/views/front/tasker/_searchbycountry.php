<div class="advncsearch">
    <div class="advnc_row margin-bottom-10"><?php echo Yii::t('poster_createtask', 'txt_location')?></div>
    <div class="col-md-12 pdn-auto">
        <div class="col-md-12 no-mrg">
        <?php
        $filter = isset($filter) ? $filter : '';
        Yii::import('ext.chosen.Chosen');
        $locations = CommonUtility::getCountryList();
        $name = empty($name) ? "proposalLocations" : $name;
        $locationList = '';
        $placeholder = CHtml::encode(Yii::t('poster_createtask', 'txt_select_country'));
//        echo UtilityHtml::getTaskPreferedLocations($name, $locationList, $locations,
//        array('prompt'=>'--Select your country/Region--','class' => 'form-control mrg5' ,'id'=>'User_report_to'));
            echo Chosen::multiSelect($name, $locationList, $locations, array(
            'data-placeholder' => $placeholder,
            'options' => array('displaySelectedOptions' => false,),
            'class' => 'form-control mrg5',
            'onchange' => ' 
            var data = $("#'.$name.'").serialize() ;   
            if(data == "")
            {
            data = "'.$name.'=";
            }
            SearchFunc(data);
            loadfilters("'.$filter.'");
            '
            ));
            ?>
        </div>
    </div>
</div> 