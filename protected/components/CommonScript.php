<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class CommonScript extends CComponent
{
         public function activeMenu()
	{
            $result = '<script>
                        $(document).ready(function(){ ';
                            $requestURI =  Yii::app()->urlManager->parseUrl(Yii::app()->request);
                            if($requestURI == "index/index")
                            {
                                   $result .= '$(".index ").addClass("active");';
                            }
                            $activeClasses = explode("/", $requestURI);
                            if($activeClasses[0]=='admin')
                            {
                                $activeClasses[0] = 'adminuser';
                            }
                            if($activeClasses[0]=='rating')
                            {
                                $activeClasses[0] = 'ratingmenu';
                            }
                            $result .= '
                                        $(".page-sidebar ul li.'.$activeClasses[0].' ").closest("li.parent").addClass(\'active\');
                                        $(".page-sidebar ul li.'.$activeClasses[0].' ").closest(\'li.parent\').addClass(\'current\');
                                        $(".current a span.mastersarrow").addClass("open");
                                                                                
                                        $(".page-sidebar ul li ul li.'.$activeClasses[0].'").closest("li.parentnew").addClass(\'active\');                                            
                                        $(".page-sidebar ul li ul li.'.$activeClasses[0].' .arrow ").addClass("open"); 
                                            
                                        $(".page-sidebar ul li ul li ul li ul").hide(); 
                                        $(".page-sidebar ul li ul li ul li ul.'.$activeClasses[0].'").show(); 
                                        

                                        $(".page-sidebar ul li.'.$activeClasses[0].'").addClass("active");
                                        $(".page-sidebar ul li.'.$activeClasses[0].'").addClass("open");
                                        $(".page-sidebar ul li.'.$activeClasses[0].' .arrow ").addClass("open");
                                            
                                        $(".page-sidebar ul li.'.$activeClasses[0].' .'.$activeClasses[1].'").addClass("active");
                                                                               

                        });
                        function backUrl()
                        {
                                window.location.href="admin";
                        }
                        function backUrlReferer()
                        {
                                window.location.href="'.@$_SERVER['HTTP_REFERER'].'";
                        }
                        jQuery(document).ready(function() {
			   App.init();
		});
                 $(document).on(\'click\', \'#flash_messages\', function () {
         $("#flash_messages div").remove();
         // As I see the input is direct child of the div
    });

                    </script>';
           echo $result ;

        }
        public function loadCssFiles()
	{
            $baseUrl = Globals::BASH_URL;
            $css =  '
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/screen.css" media="screen, projection" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/print.css" media="print" />
                        <!--[if lt IE 8]>
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/ie.css" media="screen, projection" />
                        <![endif]-->
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/main.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/form.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/font-awesome/css/font-awesome.min-admin.css" />

                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/style.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/style-responsive.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/default.css" />

                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/bootstrap.min.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/bootstrap-responsive.min.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/uniform.default.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/login.css" />
                        <link rel="stylesheet" type="text/css" href="'.$baseUrl.'/css/back/style-metro.css" />
                    ';
            echo $css;
        }
        public function loadScriptFiles()
	{
            $baseUrl = Yii::app()->request->baseUrl;
            $css =  '   <script type="text/javascript" src="'.$baseUrl.'/js/jquery-1.10.1.min.js"></script>
                        <script type="text/javascript" src="'.$baseUrl.'/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
                        <script type="text/javascript" src="'.$baseUrl.'/js/bootstrap.min.js"></script>
                        <script type="text/javascript" src="'.$baseUrl.'/js/twitter-bootstrap-hover-dropdown.min.js"></script>
                        <script  type="text/javascript" src="'.$baseUrl.'/js/jquery-slimscroll/jquery.slimscroll.min.js"></script>
                        <script type="text/javascript" src="'.$baseUrl.'/js/login.js"></script>
                        <script type="text/javascript" src="'.$baseUrl.'/js/app.js"></script>';
            echo $css;
        }
        public function loadAddressScript($targetId , $saveLatId , $saveLngId)
	{
            $script = 
                    "
                    <script>
    
                            $(document).ready(function(){

                                YUI().use('autocomplete', function (Y) {
                                var acNode = Y.one('#".$targetId."');

                                acNode.plug(Y.Plugin.AutoComplete, {
                                    // Highlight the first result of the list.
                                    activateFirstItem: true,
                                    // The list of the results contains up to 10 results.
                                    maxResults: 10,
                                    // To display the suggestions, the minimum of typed chars is five.
                                    minQueryLength: 1,
                                    // Number of milliseconds to wait after user input before triggering a
                                    // `query` event. This is useful to throttle queries to a remote data
                                    // source.
                                    queryDelay: 1,

                                    // Handling the list of results is mandatory, because the service can be
                                    // unavailable, can return an error, one result, or an array of results.
                                    // However `resultListLocator` needs to always return an array.
                                    resultListLocator: function (response) {
                                        // Makes sure an array is returned even on an error.
                                        if (response.error) {
                                            return [];
                                        }

                                        var query = response.query.results.json,
                                            addresses;

                                        if (query.status !== 'OK') {
                                            return [];
                                        }

                                        // Grab the actual addresses from the YQL query.
                                        addresses = query.results;

                                        // Makes sure an array is always returned.
                                        return addresses.length > 0 ? addresses : [addresses];
                                    },

                                    // When an item is selected, the value of the field indicated in the
                                    // `resultTextLocator` is displayed in the input field.
                                    resultTextLocator: 'formatted_address',

                                    // {query} placeholder is encoded, but to handle the spaces correctly,
                                    // the query is has to be encoded again:
                                    //
                                    // \"my address\" -> \"my%2520address\" // OK => {request}
                                    // \"my address\" -> \"my%20address\"   // OK => {query}
                                    requestTemplate: function (query) {
                                        return encodeURI(query);
                                    },

                                    // {request} placeholder, instead of the {query} one, this will insert
                                    // the `requestTemplate` value instead of the raw `query` value for
                                    // cases where you actually want a double-encoded (or customized) query.
                                    source: 'SELECT * FROM json WHERE ' +
                                                'url=\"http://maps.googleapis.com/maps/api/geocode/json?' +
                                                    'sensor=false&' +
                                                    'address={request}\"',

                                    // Automatically adjust the width of the dropdown list.
                                    width: 'auto'
                                });

                                // Adjust the width of the input container.
                                acNode.ac.after('resultsChange', function () {
                                    var newWidth = this.get('boundingBox').get('offsetWidth');
                                    //acNode.setStyle('width', Math.max(newWidth, 100));
                                });

                                // Fill the `lat` and `lng` fields when the user selects an item.
                                acNode.ac.on('select', function (e) {
                                    var location = e.result.raw.geometry.location;

                                    Y.one('#".$saveLatId."').set('value', location.lat);
                                    Y.one('#".$saveLngId."').set('value', location.lng);
                                    callMap(location.lat,location.lng);
                                      
                                });
                            });
                            });
                    </script>            
                    ";
            return $script;
        }
        public function loadCreateTaskScript()
	{
             $baseUrl = Yii::app()->request->baseUrl;
            $script = 
                    "
                        <script type=\"text/javascript\" src='".$baseUrl."/js/yui-min.js'></script>
                        <script src=\"http://maps.google.com/maps/api/js?sensor=false\" type=\"text/javascript\"></script>
                        <script>
                            function templateDetailFill(id)
                            {
                                var title = document.getElementById('templateTitle'+id).value;
                                var detail = document.getElementById('templateDetail'+id).value;
//                                alert(document.getElementById('Task_title').readOnly);
                                if ((document.getElementById('Task_title'))) {
                                    if(document.getElementById('Task_title').readOnly == false)
                                    {
                                        document.getElementById('Task_title').value = title;
                                    }
                                    document.getElementById('Task_description').value = detail;
                                    var vall = $('#Task_description').val().length;
                                    var total=1000;
                                    total = total-vall;
                                    $('#wordcount').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'))."'+total);
                                }
                                document.getElementById('templatdiv').style.display='none';
                            }
                            function slideIt()
                            {
                                $(\"#advanceOption\").css('position','inherit');
                                $(\"#advanceOption\").css('visibility','visible');
                                $(\"#advanceOption\").css('z-index','0');
                                $(\"#advanceOption\").toggle();
                                if ($(\"#advanceOption\").css('display') == 'none') 
                                {
                                    $(\"#advanceOptionHeader img\").attr('src', '".Globals::IMAGE_COLLAPSE."');
                                    $(\"#advanceOptionHeader span\").text('".CHtml::encode(Yii::t('poster_createtask', 'txt_show'))."');
                                } 
                                else 
                                {
                                    $(\"#advanceOptionHeader img\").attr('src', '".Globals::IMAGE_EXPAND."');
                                    $(\"#advanceOptionHeader span\").text('".CHtml::encode(Yii::t('poster_createtask', 'txt_hide'))."');
                                }
                            }
                            function slideImages()
                            {
                                $(\"#loadAttachment\").css('position','inherit');
                                $(\"#loadAttachment\").css('visibility','visible');
                                $(\"#loadAttachment\").css('z-index','0');
                                $(\"#loadAttachment\").toggle();
                            }
                            function setLocation() 
                            {
                                if($('#Task_preferred_location_check').is(':checked')) 
                                {
                                    $(\"#select_preferred_location\").css('position','inherit');
                                    $(\"#select_preferred_location\").css('visibility','visible');
                                    $(\"#select_preferred_location\").css('z-index','0');
                                }
                                else 
                                {
                                    $(\"#select_preferred_location\").css('visibility','hidden');
                                    $(\"#select_preferred_location\").css('position','absolute');
                                    $(\"#select_preferred_location\").css('z-index','-1111');
                                }
                            }

                            function activeCategory(id)
                            {
                                $('.rootCategoryThumb').fadeIn(500);
                                $('#loadCategory').fadeIn(500);
                                $('.rootCategory').fadeOut();
                                $('#loadCategoryForm').fadeOut();
                                $('.rootCategoryThumb .tast_box_new').removeClass(\"active\");
                                $('.rootCategoryThumb .tast_box_new #'+id).parent().addClass(\"active\");
                            }
                            function activeForm(id)
                            {
                                $('#loadCategory').fadeOut();
                                $('#loadCategoryForm').fadeIn(500);
                                $('#templateCategory').fadeIn(500);
                            }
                            function loadvirtualtaskform(id,task)
                            {
                                if(task==0)
                                {
                                    var locationto = '".Yii::app()->createUrl('poster/loadcategoryform')."';
                                }
                                else
                                {
                                    var locationto = '".Yii::app()->createUrl('poster/loadcategoryformtoupdate')."';
                                }
                                    $(\"#rootCategoryLoading\").addClass(\"displayLoading\");
                                    $(\"#loadpreviuosTask\").addClass(\"displayLoading\");
                                    $(\"#templateCategory\").addClass(\"displayLoading\");
                                $.ajax({
                                    url: locationto,
                                    data: { category_id: id,formType:'virtual',taskId:task ,'YII_CSRF_TOKEN' : '".Yii::app()->request->csrfToken."'},
                                    type: \"POST\",
                                    dataType: 'json',
                                    error: function () 
                                    {
                                        $(\"#rootCategoryLoading\").removeClass(\"displayLoading\");
                                        $('#loadCategoryForm').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                        // alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                    },
                                    success: function (data) 
                                    {
                                        $(\"#rootCategoryLoading\").removeClass(\"displayLoading\");
                                        $(\"#loadpreviuosTask\").removeClass(\"displayLoading\");
                                        $(\"#templateCategory\").removeClass(\"displayLoading\");
                                        $('#loadCategoryForm').html(data.form);
                                        $('#loadPreviewTask').html(data.previusTask);
                                        $('#loadTemplateCategory').html(data.template);
                                        $('#templateCategory').fadeIn(500);
                                        activeForm(\"loadcategory_\"+id);
//
//                                        $('#loadCategoryForm').html(data);
//                                         
//                                        loadSidebar(\"v\",id);
                                    }
                                });
                            }

                            function loadPreview()
                            {
                                $('.rootCategoryThumb').fadeOut(500);
                               
                                $('#loadpreview').fadeIn();
                                $('.rootCategory').fadeOut();
                                $('#loadCategoryForm').fadeOut();
                               
                            }
                            
                            function loadPreviousTaskPreview()
                            {
                                $('.rootCategoryThumb').fadeOut(500);
                                $('#loadpreview').fadeIn();
                                $('.rootCategory').fadeOut();
                                $('#loadCategoryForm').fadeOut();
                               $('#loadCategory').fadeOut(500);
                            }
                            function backForm()
                            {
                                $('.rootCategoryThumb').fadeIn();
                                $('#loadCategory').fadeOut(500);
                                $('.rootCategory').fadeOut(500);
                                $('#loadCategoryForm').fadeIn();
                               
                                $('#loadpreview').fadeOut(500);
                            }
                            function showPopup()
                            {
                                $('#templatdiv').fadeIn();
                            }
                            function loadSidebar(type , category,priview)
                            {                                                                
                                loadpreviuosTask(type , category);
                                loadtemplateCategory(type , category,priview);                                
                            }
                            function loadpreviuosTask(type , category)
                            {
                             $(\"#loadpreviuosTask\").addClass(\"displayLoading\");
                                $.ajax({
                                    url: '".Yii::app()->createUrl('poster/loadpreviuostask')."',
                                    data: { category_id: category,formType:type },
                                    datatype: 'json',
                                    type: \"POST\",
                                    error: function () {
                                       // alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                            $(\"#loadpreviuosTask\").removeClass(\"displayLoading\");
                                            $('#loadPreviewTask').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                    },
                                    success: function (data) 
                                    {
                                     $(\"#loadpreviuosTask\").removeClass(\"displayLoading\");
                                     alert(data)
//                                        $('#loadPreviewTask').html(data);
                                    },
                                   
                                 
                                });
                            }
                            function loadtemplateCategory(type , category,priview)
                            {
//                            $(\"#templateCategory\").show();
                            $(\"#templateCategory\").addClass(\"displayLoading\");
                                $.ajax({
                                    url: '".Yii::app()->createUrl('poster/loadtemplatecategory')."',
                                    data: { category_id: category,formType:type },
                                    type: \"POST\",
                                    error: function () 
                                    {

                                    $(\"#templateCategory\").removeClass(\"displayLoading\");
                                      $('#loadTemplateCategory').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                    },
                                    success: function (data) {
                                         $(\"#templateCategory\").removeClass(\"displayLoading\");
                                         //alert(data);
                                        if (category == '' || data == '') 
                                         {
                                            $(\"#templateCategory\").hide();
//                                            $(\"#templateDetailBrowse\").hide();                                            
                                         }
                                         else
                                         {                                            
                                            $(\"#templateCategory\").show();
                                            $('#loadTemplateCategory').html(data);
                                         } 
//                                         alert(priview);
                                         if(priview == 'priview')
                                         {
                                            $(\"#templateCategory\").hide();
                                         }
                                    }
                                });
                            }
                                function callMap(lat,lng,range)
                                {
                                    var address = document.getElementById('TaskLocation_location_geo_area').value;
                                   if(!range)
                                   {
                                       range = '".Globals::DEFAULT_VAL_MILES."';
                                   }
                                    $.ajax(
                                    {
                                        url: '".Yii::app()->createUrl('poster/taskersetmap')."',
                                        data: { lat: lat,lng:lng,address:address,range:range,'YII_CSRF_TOKEN' : '".Yii::app()->request->csrfToken."' },

                                        type: \"POST\",
                                        error: function () 
                                        {
                                           alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                        },
                                        success: function (data) 
                                        {

                                            $('#loadmap').html(data);
                                        }
                                    });
                                }
                                function calculateAverage()
                                {           
                                    if ($('#Task_payment_mode_0').is(':checked'))
                                    {
                                       $(\"#pricetext\").css('display','block');
                                       var latitude = $(\"#TaskLocation_location_latitude\").val();
                                       var longitude = $(\"#TaskLocation_location_longitude\").val();
                                       var range = $(\"#Task_tasker_in_range\").val();
                                       var type = 'f';
                                        $.ajax({
                                            url: '".Yii::app()->createUrl('tasker/getaverage')."',
                                            data: { latitude: latitude,longitude:longitude,range:range,type:type},
                                            type: \"POST\",
                                            error: function () 
                                            {
                                               alert('".CHtml::encode(Yii::t('poster_createtask', 'lbl_error_ocurred'))."');
                                            },
                                            success: function (data) 
                                            {
                                                    var avrege = ".Globals::DEFULT_FIXED_PRICE.";
                                                   if( $(\"#Task_price\").val())
                                                   {
                                                        if($.isNumeric($(\"#Task_price\").val()))
                                                        {
                                                            avrege = $(\"#Task_price\").val();
                                                        }
                                                   }
                                                    if(data > 0)
                                                    {
                                                      avrege =  data;
                                                    }
                                                    if( $(\"#Task_price\").val() != '' )
                                                    {
                                                            avrege =  $(\"#Task_price\").val();
                                                    }
                                                    $(\"#Task_price\").val(avrege);
                                                    $(\"#fixeprice1\").html('".Globals::DEFAULT_CURRENCY."'+avrege);
                                                    $(\"#fixeprice2\").html('".Globals::DEFAULT_CURRENCY."'+avrege);
                                            }
                                        });
                                    }
                                    if ($('#Task_payment_mode_1').is(':checked')) 
                                    {
                                       // $(\"#pricetext\").css('display','none');
                                        //$(\"#Task_price\").val('');
                                    }
                                }
                        </script>          
                    ";
            return $script;
        }
        
        public function loadTaskFormScript($is_location_region,$attachments)
	{
            $script = "
                        <script>        
                        $(document).ready(function()
                        {               
                    ";
        if (!isset($is_location_region))
        {
          $script .= "
                        $(\"#advanceOption\").css('visibility','hidden');
                        $(\"#advanceOption\").css('position','absolute');
                        $(\"#advanceOption\").css('z-index','-1111');
                        $(\"#advanceOption\").slideToggle();
                    ";
           
        }
        if (!isset($attachments))
        {
           $script .= "
                        $(\"#loadAttachment\").css('visibility','hidden');
                        $(\"#loadAttachment\").css('position','absolute');
                        $(\"#loadAttachment\").css('z-index','-1111');
                        $(\"#loadAttachment\").slideToggle();
                            ";
        }
        
        $script .= "
                        $('#Task_description').keyup(function()
                        {
                            var vall = $(this).val().length;
                            var total=".Globals::DEFAULT_VAL_TASK_DESCRIPTION_LENGTH.";
                            total = total-vall;
                            $('#wordcount').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'))."'+total);
                        });
                        $('#Task_description_editable').keyup(function () 
                        {
                            var nonedit = $('#Task_description_nonedit').val();
                            var editable = $('#Task_description_editable').val();
                            var newdescription = nonedit + ' ' + editable;
                            $('#Task_description').val(newdescription) ;
                        });
                        
                     });
     setLocation();

                    </script>

                    ";
            return $script;
        }
        public function loadTaskFormScriptFixedPrice()
	{
            $script = "
                        <script> 
        $(document).ready(function()
                        {               
                            $('#Task_payment_mode_0').change(function(){calculateAverage();});
                            $('#Task_task_finished_on').blur(function(){calculateAverage();});

                            $('#Task_payment_mode_1').change(function(){calculateAverage();});
                            $('#Task_tasker_in_range').keyup(function(){calculateAverage();});
                            $('#Task_price').blur(function(){calculateAverage();});
                             });
   

                    </script>

                    ";
            return $script;
        }
         public static function loadPopOverHide($class = ".controls-row .help-block")
	{
            $script = "
                        <script>
                          $(document).ready(function()
                          {
                                $('".$class."').hover( function()
                                {
                                    //alert();
                                    $(this).fadeOut(200);
                                } );
                            } );
                        </script>
                    ";
            return $script;
        }
        public static function errorMsgDisplay($class = ".controls .form-control")
	{
            $script = "
                        <script>
                          $(document).ready(function(){
                                    $('".$class."').on('click',function(){

//                                            $(this).next('.help-block').hide();
                                            $(this).parent().removeClass('state-error');
                                            $(this).parent().parent().removeClass('state-error');
                                             
                                      });
                                    $('".$class."').next('.help-block').addClass(\"invalid\");
                            });
                        </script>
                    ";
            return $script;
        }
         public function loadCoundownScript($id,$time,$endDate)
	{
                $script = '';
                $baseUrl = Yii::app()->request->baseUrl;
               
                $hours = substr($time, 0, 2);
                $minutes = substr($time, 2);
                $timeFormated = substr($time, 0, 2) . ':' . substr($time, 2);
                
                $timeNew = $endDate." ".$timeFormated;
                $year = CommonUtility::getYearFromDate($endDate);
                $month = CommonUtility::getMonthFromDate($endDate);
                $day = CommonUtility::getDayFromDate($endDate);
                $currentTime = CommonUtility::getCurrentDate();
                if( $timeNew > $currentTime )
                {
                    $coundown = 1;
                    $script = "
                                         <script src=\"".$baseUrl."/js/jquery.plugin.js\"></script>
                                        <script src=\"".$baseUrl."/js/jquery.countdown.js\"></script>
                                        <script>
                                            var austDay = new Date(".$year.", ". $month." -1 , ".$day ." ,". $hours.",".$minutes .");
                                               // alert();
                                            $('#".$id."').countdown({until: austDay , onExpiry: taskExpire, onTick: watchCountdown});
                                            function taskExpire()
                                            { 
                                                $('#".$id."').text('".CHtml::encode(Yii::t('poster_createtask', 'txt_task_closed'))."');
                                            }
                                            function watchCountdown(periods) { 
                                            //    $('#".$id."').text('Just ' + periods[5] + 
                                            //        ' minutes and ' + periods[6] + ' seconds to go'); 
                                            }
                                        </script>
                                ";
                }
    
    
                
            return $script;
        }
        public function loadRemainingCharScript($id,$target,$legth)
	{
            $script = "
                        <script>
                            $(document).ready(function()
                            { 
                                $('#".$id."').keyup(function()
                                {
                                   callRemaningChar();
                                });
                                $('#".$id."').bind('paste', function(){
                                    setTimeout(function() 
                                    {
                                           callRemaningChar();
                                    }, 100);
                                } );
                             });
                             function callRemaningChar()
                             {
                                var vall = $('#".$id."').val().length;
                                var total=".$legth.";
                                total = parseInt(total) - parseInt(vall);
                                //alert(total);
                                $('#".$target."').html('".CHtml::encode(Yii::t('poster_createtask', 'lbl_remaining_char'))."'+total);
                             }
                        </script>
                    ";
            return $script;
        }
        public function loadAttachmentHideShowScript($source,$target)
	{
            $script = "
                        <script>
                            $(document).ready(function()
                            { 
                                    $(\"#".$target."\").css('visibility','hidden');
                                    $(\"#".$target."\").css('position','absolute');
                                    $(\"#".$target."\").css('z-index','-1111');
                                    $(\"#".$target."\").slideToggle();
                             });
                            function ".$source."()
                            {
                                $(\"#".$target."\").css('position','inherit');
                                $(\"#".$target."\").css('visibility','visible');
                                $(\"#".$target."\").css('z-index','0');
                                $(\"#".$target."\").slideToggle();
                            }
                        </script>
                    ";
            return $script;
        }
           public function loadAttachmentSuccess($id,$target,$name)
	{
            $images = json_encode(Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES]);
            $allowArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
            foreach ($allowArray as $extension)
            {
                $typeArr[] = $extension[Globals::FLD_NAME_TYPE];
            }
            $allawTypes = array_unique($typeArr);

            $fileTypesArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
            $fileTypesArray = json_encode($fileTypesArray);
           $maxFileSize = LoadSetting::getSettingValue(Globals::SETTING_KEY_MAX_UPLOAD_FILE_SIZE);
           $totalSpaceQuota = LoadSetting::getSettingValue(Globals::SETTING_KEY_SPACE_QUOTA_ALLOWED);
//                if( isset($fileTypesArray[$extension] ))
//                {
//                    return $fileType = $fileTypesArray[$extension][Globals::FLD_NAME_TYPE];
//                }
                ///////////
            $fileName = 'responseJSON.filename';
            $fileSize = 'responseJSON.filesize';
            
            $script = "
                var filesize = responseJSON.filesize;
                var displayfilename = responseJSON.displayfilename;
                //alert(responseJSON.success);
                           var usedSize = $('#".$id."_totalFileSizeUsed').val();
                           var totalSize = $('#".$id."_totalFileSize').val();
                               usedSize =  parseInt(usedSize) + parseInt(filesize);
                                
                            if(usedSize > totalSize)
                            {
                                alert('You cannot upload more than ".$maxFileSize."MB files');
                                return false;
                            }
                             
                            var totalspaceQuotaUsed = $('#".$id."_totalFileSizeLimit').val();
                            var spaceQuotaAllowed = $('#".$id."_totalMaxFileSizeLimit').val();
                                //alert(totalspaceQuotaUsed);
                            totalspaceQuotaUsed = parseInt(totalspaceQuotaUsed) + parseInt(filesize);
                            if(totalspaceQuotaUsed > spaceQuotaAllowed)
                            {
                                alert('You have reached your maximum file upload limit(".$totalSpaceQuota."MB). Please remove previous files to continue uploading.');
                                return false;
                            }
                            $('#".$id."_totalFileSizeLimit').val(totalspaceQuotaUsed);
                            $('#".$id."_totalFileSizeUsed').val(usedSize);
                            $('#".$id." .qq-upload-list').css('display' , 'block');
                            $('#".$target."').css('display','block');
                            var fileTypesArray = ". $fileTypesArray . ";
                         
                            var divId = '';   
                            divId = ".$fileName.".split('.')[0];
                            var fileExtension = ".$fileName.".split('.')[1];
                            var images = '" . $images . "';
                            var imagesobj = $.parseJSON(images);
                            $('#".$target."').append( '<div  id=\"'+divId+'\" class=\"imagesPreview '+divId+' postedby \"></div>' ); 
                            if(imagesobj.indexOf(fileExtension) !== -1)
                            {
                                $('#".$target." .'+divId ).append( '<img style=\"height: 50px; width: 40px;\" src=\"" . Globals::FRONT_USER_VIEW_TEMP_PATH . "'+".$fileName."+'\" />');  
                            }
                            else
                            {
                                fileExtension = fileExtension.toLowerCase(); 
                               // alert(fileExtension);
                                if(fileTypesArray[fileExtension].type)
                                {
                                    switch (fileTypesArray[fileExtension].type)
                                    {
                                        case '".Globals::DEFAULT_VAL_DOC_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_DOC_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_EXCEL_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_EXCEL_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_PDF_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_PDF_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_ZIP_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_ZIP_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_PPT_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_PPT_IMAGE."';
                                        break;

                                        default: 
                                        var typeImgUrl = '".Globals::IMAGE_DOWNLOAD."';
                                        break;
                                    }
                                }
                                else
                                {
                                     var typeImgUrl = '".Globals::IMAGE_DOWNLOAD."';
                                }
                                
                                $('#".$target." .'+divId ).append( '<img style=\"height: 50px; width: 40px;\" src=\"'+typeImgUrl+'\" >');
                            }
                            
                            $('#".$target." .'+divId ).append( '<span class=\"attachFileName\" >'+displayfilename+'</span>' );      

                            $('#".$target." .'+divId ).append( '<input type=\"hidden\" class=\"totalfilecountuse\" name=\"".$name."[]\" value=\"'+".$fileName."+'\" />' );    
                            $('#".$target." .'+divId ).append( '<input type=\"hidden\" id=\"'+divId+'_size\" name=\"'+divId+'_size\" value=\"'+".$fileSize."+'\" />' );  
                            $('#".$target." .'+divId ).append( '<a title=\"".CHtml::encode(Yii::t('poster_createtask', 'Click here to remove'))."\" class=\"removeAttachment\" onclick=\"removeImage(\''+divId+'\' , \'".$id."\');\"><img src=\"" . Globals::IMAGE_REMOVE . "\"></a> ' ); 
                            $('#".$id." .qq-upload-list').css('display' , 'none');
                    ";
            return $script;
        }
        
        
   public function manageCategoryTemplate()
	{
        $result =   "<script>                   
                         function addmoreCatTemplate(id)
                         {                            
                          var num = $('#tmplnum').val();
                          var i;
                          var flag = true;
                          for(i=1;i<=num;i++)
                          {                            
                            if(($('#CategoryLocale_category_id_'+i+'_title').val() == '') && ($('#CategoryLocale_category_id_'+i+'_description').val() == ''))
                            {
                                flag = false;
                            }
                          }                                                    
                            if(flag == false)
                            {
                                alert('One or more Template is blank..');
                            }
                            else
                            {                                
                                var catId = $('#CategoryLocale_category_id').val();
                                $('#templateCon .addRemove #addmore ').attr('onclick', 'return false');

                                    $.ajax({
                                        type: \"POST\",
                                        url: '".Globals::BASH_URL."/admin/category/getcategorytemplatefield',
                                        data: {'num':num, 'category_id':catId},
                                        success: function(data) {
                                            //$('#templateCon').append(data);
                                            $(data).insertAfter('#template'+id );
                                            //$('#newpemp'+id).append(data);                                          
                                            num++;
                                            $('#templateCon #fields').html('<input type=\"hidden\" id=\"tmplnum\" name=\"totalCatTmplId\" value=\"'+num+'\"/>');                                        
                                            $('#templateCon .addRemove #addmore ').attr('onclick', 'addmoreCatTemplate()');
                                        },
                                        dataType: 'html'
                                    });
                              }

                         }
                         function deleteTemplate(id)
                         {
                         if(($('#CategoryLocale_category_id_'+id+'_title').val() == '') && ($('#CategoryLocale_category_id_'+id+'_description').val() == ''))
                         {
                            $('#template'+id ).remove();
                         }
                         else
                            {
                                if(confirm('Are you sure you want to delete this template..'))
                                {
                                    $('#template'+id ).remove();
                                }
                            }
                         }
                         jQuery(document).ready(function($)
                      {
                         $(function() {
                           if($('#tmplnum').val()==1)  { $( \"#templateCon .addRemove #remTmpl \").css(\"display\", \"none\");      }
                         });
                         
//                         $('#remTmpl').live('click', function() {                          
//                          $( '#templateCon .removeControl' ).last().remove();
//                          var num = $('#tmplnum').val();
//                          num--;
//                          $('#templateCon #fields').html('<input type=\"hidden\" id=\"tmplnum\" name=\"totalCatTmplId\" value=\"'+num+'\"/>');
//                          if(num==1)
//                          {
//                              $( '#templateCon .addRemove #remTmpl ').css('display', 'none');
//                              //$('#User_certificate_id_1_certificate_id').next('select').next('.help-block').text('');
//                              //$('#User_certificate_id_1_certificate_id').next('select').next('.help-block').css('display', 'none');
//                          }
//                          else
//                          {
//                              $( '#templateCon .addRemove #remTmpl ').css('display', 'inline');
//                          }
//                      });
                         });
                         </script>";
      echo $result;
   }
    public function loadAjaxPopover()
    {
        $result =   "<script>
                        $( document ).ready(function() 
                        {
                            var request, timeout;
                            var processing=false;
                            $('body').delegate('*[data-poload]','hover',function(event)
                            { 
                                var el = $(this);
                                
                                $('.dataLoaded').not(this).popover('hide');
                                
                                if (event.type === 'mouseenter') 
                                {
                                    timeout = setTimeout(function(){
                                        if (!processing)
                                        {
                                            processing=true;
                                            if( el.hasClass('dataLoaded') && !el.hasClass('alwaysAjax'))
                                            {
                                          
                                                el.popover('show');
                                                $(\".popover-content\").mCustomScrollbar();
                                            }
                                            else
                                            {
                                               el.addClass('loadingPopover');
                                                $.get(el.data('poload'),function(d)
                                                {
                                                
                                                    el.unbind('hover').popover({
                                                    template:'<div id=\"html-popver\" class=\"popover  htmlpopover \"><div class=\"arrow\"></div><div class=\"popover-inner\"><h2 class=\"popover-title\"></h2><div class=\"popover-content\"><div></div></div></div></div>',
                                                    content: d,
                                                    html : true, trigger : 'click'}).popover('show');
                                                    el.addClass('dataLoaded');
                                                    el.removeClass('loadingPopover');
                                                    processing=false;
                                                    $(\".popover-content\").mCustomScrollbar();
                                                });
                                            }
                                        }
                                    }, 500 );
                                } 
                                else
                                {
                                    clearTimeout(timeout);
                                    processing=false;
                                }
                                
                            });
                            $('html').mouseup(function(e)
                            {
                                var subject = $('.popover'); 
                                if(!subject.has(e.target).length)
                                {
                                $('.dataLoaded').popover('hide');
                                }
                            });
                        });
                      </script>";
      echo $result;
    }
    
    public function loadRatingPopOver()
    {
        $result = "<script>$(document).ready(function()
                {
                    $('body').delegate('*[data-toggle=\'popover\']','hover',function(event)
                    { 
                            $('[data-toggle=\'popover\']').popover({ trigger: 'hover' });
                    });
                });
            </script>";
        echo $result;
    }
//    public function loadExpenseErrorPopOver()
//    {
//        $result = "<script>$(document).ready(function()
//                {
//                    $('body').delegate('*[data-toggle=\'tooltip']','click',function(event)
//                    { 
//                            $('[data-toggle=\'tooltip']').tooltip({ trigger: 'click' });
//                    });
//                });
//            </script>";
//        echo $result;
//    }
    public function loadAjaxPopover_new()
    {
        $result =   "<script>
                        $( document ).ready(function() 
                        {
                            var request, timeout;
                            var processing=false;
                            $('body').delegate('.popovercontent','click',function(event)
                            { 
                                var el = $(this);
                                
                                $('.dataLoaded').not(this).popover('hide');
                                
                                if (event.type === 'click') 
                                {
                                    timeout = setTimeout(function(){
                                        if (!processing)
                                        {
                                            processing=true;
                                            if( el.hasClass('dataLoaded') && !el.hasClass('alwaysAjax'))
                                            {
                                          
                                                el.popover('show');
                                                $(\".popover-content\").mCustomScrollbar();
                                            }
                                            else
                                            {
                                               el.addClass('loadingPopover');
                                                $.get(el.data('poload'),function(d)
                                                {
                                                
                                                    el.unbind('click').popover({
                                                    template:'<div id=\"html-popver\" class=\"popover  htmlpopover \"><div class=\"arrow\"></div><div class=\"popover-inner\"><h2 class=\"popover-title\"></h2><div class=\"popover-content\"><div></div></div></div></div>',
                                                    content: d,
                                                    html : true}).popover('show');
                                                    el.addClass('dataLoaded');
                                                    //el.addClass('dataLoaded2');
                                                    el.removeClass('loadingPopover');
                                                    processing=false;
                                                    $(\".popover-content\").mCustomScrollbar();
                                                });
                                            }
                                        }
                                    }, 500 );
                                } 
                                else
                                {
                                    clearTimeout(timeout);
                                    processing=false;
                                }
                                
                            });
                            $('html').mouseup(function(e)
                            {
                                var subject = $('.popover'); 
                                var subject2 = $('.popovercontent'); 
                                if(!subject2.has(e.target).length )
                                {
                                  //  $('.dataLoaded').popover('hide');
                                }
                                if(!subject.has(e.target).length )
                                {
                                   // $('.dataLoaded').popover('hide');
                                }
                            });
                        });
                      </script>";
      echo $result;
    }
    
    public function popupScript($data)
    {
        
        $data = CJSON::encode($data);
        $result = '<script>
            var data = '.$data.';
                    $(document).ready(function()
                    {
                        $.ajax({
                            url: "'.Yii::app()->createUrl('poster/ajaxpopup').'",
                            data: {id: data},
                            dataType : "json",
                            type: "POST",
                            success : function (data){
                                loadpopupUserProfile(data.html);
                               // $("#loadpopupUserProfile").addClass("profile_popup");
                            }
                        });
                    });
                    </script>';
        echo $result;
    }
    
    public function popupScriptForReRegistration($data)
    {
//        $to = $data["to"];
//        $subject = $data["subject"];
//        $message = $data["message"];
//        $body = $data["body"];
        $msg = $data["msg"];
        $result = ' <script>
                    $( document ).ready(function()
                    {
                        $.ajax({
                            url: "'.Yii::app()->createUrl('index/AjaxPopUpForReVerification').'",
                            data: {msg: "'.$msg.'"},
                            dataType : "json",
                            type: "POST",
                            success : function (data){
                                loadpopupUserProfile(data.html);
                               // $("#loadpopupUserProfile").addClass("profile_popup");
                            }
                        });
                    });
                    </script>';
        echo $result;
    }
    
    public function popupScriptForRegistration($data)
    {
        $to = $data["to"];
        $subject = $data["subject"];
        $message = $data["message"];
        $body = $data["body"];
        $msg = $data["msg"];
        
        $result = '<script>
                    $(document).ready(function()
                    {
                        $.ajax({
                            url: "'.Yii::app()->createUrl('index/ajaxpopup').'",
                            data: {to: "'.$to.'",subject: "'.$subject.'",message: "'.$message.'",body: "'.$body.'",msg: "'.$msg.'"},
                            dataType : "json",
                            type: "POST",
                            success : function (data){
                                loadpopupUserProfile(data.html);
                               // $("#loadpopupUserProfile").addClass("profile_popup");
                            }
                        });
                    });
                    </script>';
        echo $result;
    }
    
     public function adminUserFormScript()
	{
            $result =   "
                        <script>
                            $(function () {
                                $('#User_is_admin').on('change', function () {
                                    var checked = $(this).prop('checked');
                                    $('#User_user_roleid').val('');
                                    $('#User_user_roleid').prop('disabled', checked);
                                            if(checked == true)
                                            {
                                                    document.getElementById('rolerr').innerHTML='';
                                                    document.getElementById('User_user_roleid').style ='';
                                            }
                                });
                            });
                            $(document).ready(function() 
                            {       
                                    if ($('#User_is_admin').attr('checked')) 
                                    {
                                        $('#User_user_roleid').prop('disabled', 'disabled');
                                    }
                            });
                        </script>
                        ";
            echo $result;
        }
        public function rolesFormScript()
	{
            $result =   '
                        <script>
 
                            function checkboxesrefresh()
                            {

                                var names;
                                var marked = new Array();
                                var k = 0;
                                var j = 0;
                                var markedUnchek = new Array();
                                $(\'input:checked\').each(function(index,value) 
                                {
                                    marked[k] = value;
                                    var str = marked[k].className;
                                    var rel = str.split(" ");
                                    var classNameNew = rel[1];
                                    $(\'.\'+classNameNew+\'\').closest("span").addClass("checked");
                                    // alert(classNameNew);
                                    k++;
                                });
                                
                                $(\'input:checkbox:not(:checked)\').each(function(index,value) 
                                {
                                        markedUnchek[j] = value;
                                        var str2 = markedUnchek[j].className;
                                        var rel2 = str2.split(" ");
                                        var classNameNew2 = rel2[1];
                                        $(\'.\'+classNameNew2+\'\').closest("span").removeClass("checked");
                                        j++;
                                });  
                            }
                            checkBoxes = function (me) 
                            {
                                $(me).closest("table").find(\'input[type="checkbox"]\').not(me).prop(\'checked\', me.checked);
                                checkboxesrefresh();
                            }
                            function checkView(myView)
                            {
                                var viewId = myView.id
                                document.getElementById(viewId).checked = true;
                                checkboxesrefresh();
                            }
                            function validateCheckBoxes(f) 
                            {
                                var checked = 0, e, i = 0
                                var role =  document.getElementById("Roles_role_name").value;
                                if(role == \'\')
                                {
                                   return true 
                                }
                                while (e = f.elements[i++]) 
                                {
                                    if (e.type == \'checkbox\' && e.checked) checked++;
                                }
                                if (checked < 1 ) 
                                {
                                    alert ("'.Yii::t('commonutlity','pls_select_one_role_msg_text').'"); return false;
                                }
                                return true
                            }
                          
                        </script>
                        ';
            echo $result;
        }
        public function iasPagerScript( $id , $item , $trigger , $loader , $triggerPageTreshold = Globals ::DEFAULT_VAL_PAGER_TRIGGERPAGETRESHOLD ,$history = true , $onRenderComplete = "" )
	{
            $result =   Yii::app()->clientScript->registerScript('iasPager', "
                                var hasToRun = 0;
                                        jQuery.ias({    
                                                        'history': ".$history.",
                                                        'trigger': '".$trigger."',
                                                        'container': '#".$id.".list-view',
                                                        'item': '.".$item."',
                                                        'pagination': '#".$id." .pager',
                                                        'next': '#".$id." .next:not(.disabled):not(.hidden) a',
                                                        'loader': '".$loader."',
                                                        triggerPageTreshold: ".$triggerPageTreshold.",
                                                        onRenderComplete: function () { 
                                                                                        ".$onRenderComplete." 
                                                                                        },
                                                                                        onPageChange: function () {
                                                                                        ".$onRenderComplete." },
                                                    });
                                              "
);
            //echo $result;
        }
        
        public function loadAttachmentSuccessForDoerReview($id,$target,$name,$attachmentDiv,$receiptDiv)
	{
            $images = json_encode(Yii::app()->params[Globals::FLD_NAME_ALLOWIMAGES]);
            $allowArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
            foreach ($allowArray as $extension)
            {
                $typeArr[] = $extension[Globals::FLD_NAME_TYPE];
            }
            $allawTypes = array_unique($typeArr);            
            $fileTypesArray = Yii::app()->params[Globals::FLD_NAME_ALLOW_DOCUMENTS];
            $fileTypesArray = json_encode($fileTypesArray);
           $maxFileSize = LoadSetting::getSettingValue(Globals::SETTING_KEY_MAX_UPLOAD_FILE_SIZE);
           $totalSpaceQuota = LoadSetting::getSettingValue(Globals::SETTING_KEY_SPACE_QUOTA_ALLOWED);
//                if( isset($fileTypesArray[$extension] ))
//                {
//                    return $fileType = $fileTypesArray[$extension][Globals::FLD_NAME_TYPE];
//                }
                ///////////
            $fileName = 'responseJSON.filename';
            $fileSize = 'responseJSON.filesize';
            $script = "
                var filesize = responseJSON.filesize;
                var displayfilename = responseJSON.displayfilename;
                //alert(responseJSON.success);
                           var usedSize = $('#".$id."_totalFileSizeUsed').val();
                           var totalSize = $('#".$id."_totalFileSize').val();

                            var receiptCount = $('#receiptCount').val();
                            receiptCount = ++receiptCount;
                            usedSize =  parseInt(usedSize) + parseInt(filesize);
                                
                            if(usedSize > totalSize)
                            {
                                alert('You cannot upload more than ".$maxFileSize."MB files');
                                return false;
                            }
                             
                            var totalspaceQuotaUsed = $('#".$id."_totalFileSizeLimit').val();
                            var spaceQuotaAllowed = $('#".$id."_totalMaxFileSizeLimit').val();
                                //alert(totalspaceQuotaUsed);
                            totalspaceQuotaUsed = parseInt(totalspaceQuotaUsed) + parseInt(filesize);
                            if(totalspaceQuotaUsed > spaceQuotaAllowed)
                            {
                                alert('You have reached your maximum file upload limit(".$totalSpaceQuota."MB). Please remove previous files to continue uploading.');
                                return false;
                            }
                            $('#".$id."_totalFileSizeLimit').val(totalspaceQuotaUsed);
                            $('#".$id."_totalFileSizeUsed').val(usedSize);
                            $('#receiptCount').val(receiptCount);
                            $('#".$id." .qq-upload-list').css('display' , 'block');
                            $('#".$target."').css('display','block');
                            $('#".$attachmentDiv."').css('display','block');

                            var fileTypesArray = ". $fileTypesArray . ";
                         
                            var divId = '';   
                            divId = ".$fileName.".split('.')[0];
                            var fileExtension = ".$fileName.".split('.')[1];
                            var images = '" . $images . "';
                            var imagesobj = $.parseJSON(images);
//                            $('#".$target."').append( '<div  id=\"'+divId+'\" class=\"imagesPreview '+divId+' postedby \"></div>' ); 
                            $('#".$receiptDiv."').append( 
                                '<div class=\"alert-uoload alert-block alert-warning fade in float-shadow\" id=\"receipt_'+receiptCount+'\">'+
                                '<input type=\"hidden\" id=\"receipt_id\" name=\"receipt_id\" value=\"'+receiptCount+'\">'+     
                                '<button class=\"closebtn\" type=\"button\" onclick=\"deleteUploadedReceipt('+receiptCount+')\" id=\"removeReceipt['+receiptCount+']\">'+
                                '<img src=".CommonUtility::getPublicImageUri("in-closeic.png"). "></button>'+
                                '<input type=\"hidden\" id=\"imageName['+receiptCount+']\" name=\"imageName['+receiptCount+']\" value=\"'+".$fileName."+'\">'+                               
                                '<div class=\"col-lg-2 uploaded-receipts \" id=\"getAtachmentsPropsal'+divId+'\"></div>'+
                                '<div class=\"col-lg-12 sky-form margin-bottom-5 \"><div class=\"input-group col-md-12 f-left \">'+
                                '<span class=\"input-group-addon \">$</span>'+
                                '<input type=\"text\" id=\"receipt_amount['+receiptCount+']\" name=\"receipt_amount['+receiptCount+']\" class=\"form-control receiptAmountField\" placeholder=\"Amount\" onchange=\"validateReceiptsAndExpense()\" value=\"\">'+  
                              
                               '</div></div>'+
                                    
                            '</div>' ); 
                            if(imagesobj.indexOf(fileExtension) !== -1)
                            {
                                $('#".$target."'+divId).append( '<img style=\"height: 150px; width: 140px;\" src=\"" . Globals::FRONT_USER_VIEW_TEMP_PATH . "'+".$fileName."+'\" />');  
                            }
                            else
                            {
                                fileExtension = fileExtension.toLowerCase(); 
                               // alert(fileExtension);
                                if(fileTypesArray[fileExtension].type)
                                {
                                    switch (fileTypesArray[fileExtension].type)
                                    {
                                        case '".Globals::DEFAULT_VAL_DOC_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_DOC_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_EXCEL_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_EXCEL_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_PDF_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_PDF_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_ZIP_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_ZIP_IMAGE."';
                                        break;

                                        case '".Globals::DEFAULT_VAL_PPT_TYPE."':
                                        var typeImgUrl = '".Globals::ATTACHMENT_TYPE_PPT_IMAGE."';
                                        break;

                                        default: 
                                        var typeImgUrl = '".Globals::IMAGE_DOWNLOAD."';
                                        break;
                                    }
                                }
                                else
                                {
                                     var typeImgUrl = '".Globals::IMAGE_DOWNLOAD."';
                                }
                                
                                $('#".$target." .'+divId ).append( '<img style=\"height: 150px; width: 140px;\" src=\"'+typeImgUrl+'\" >');
                            }
                            
                            $('#".$target." .'+divId ).append( '<span class=\"attachFileName\" >'+displayfilename+'</span>' );      

                            $('#".$target." .'+divId ).append( '<input type=\"hidden\" class=\"totalfilecountuse\" name=\"".$name."[]\" value=\"'+".$fileName."+'\" />' );    
                            $('#".$target." .'+divId ).append( '<input type=\"hidden\" id=\"'+divId+'_size\" name=\"'+divId+'_size\" value=\"'+".$fileSize."+'\" />' );  
//                            $('#".$target." .'+divId ).append( '<a title=\"".CHtml::encode(Yii::t('poster_createtask', 'Click here to remove'))."\" class=\"removeAttachment\" onclick=\"removeImage(\''+divId+'\' , \'".$id."\');\"><img src=\"" . Globals::IMAGE_REMOVE . "\"></a> ' ); 
                            $('#".$id." .qq-upload-list').css('display' , 'none');
                    ";
            return $script;
        }
}