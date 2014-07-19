<div class="pro_tab">
    <h2 class="h2">Account Setting</h2>
    <div id="yw2" class="tabs-above">
        <div class="tab-content">
            <div id="yw2_tab_1" class="tab-pane fade active in">
                <?php
                /** @var BootActiveForm $form */
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'setting-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    //'validateOnChange' => true,
                    //'validateOnType' => true,
                    ),
                        ));

                //$var = '{"contact_by":""c",'e','p'", "ref_check_by":"'c','e','p'", 
#     "create_team":"y","tax":"{"id":"123", "form":"1099","apply":"n"}", "work_hrs":"[{"day":"mon","hrs":"9-10,16-18"},{"day":"tue","hrs":"9-10,16-18"}]"}';
                //echo'<pre>';
                //print_r(json_decode($var));
                //{"contact_by":["c","e","p"],"ref_check_by":["c","e","p"],"work_hrs":{"day":"mon","hrs":"9-10"}}

                /* $contact_by[]='c';
                  $contact_by[]='e';
                  $contact_by[]='p';
                  $work['day']='mon';
                  $work['hrs']='9-10';
                  $newarray['contact_by'] = $contact_by;
                  $newarray['ref_check_by'] = $contact_by;
                  $newarray['work_hrs'] = $work; */
                //echo'<pre>';
                //print_r(json_encode($newarray));


                $contactbychat = '';
                $contactbyemail = '';
                $contactbyphone = '';
                $day = '';
                $starttime = '';
                $endtime = '';
                if (isset($model->credit_account_setting) && !empty($model->credit_account_setting)) {
                    $vall = json_decode($model->credit_account_setting);


                    //echo'<pre>';
                    //print_r($vall->work_hrs->day);
//					$day = $vall->work_hrs->day;
//					$time = $vall->work_hrs->hrs;
//					$time = explode("-", $time);
//					$starttime = $time[0];
//					$endtime = $time[1];
                    //echo $vall->contact_by[0];
                    //echo count($vall->contact_by);
                    /*
                      if(isset($vall->contact_by[0]) && $vall->contact_by[0] == 'c')
                      {
                      $contactbychat = '1';
                      }
                      if(isset($vall->contact_by[1]) && $vall->contact_by[1] == 'e')
                      {
                      $contactbyemail = '1';
                      }
                      if(isset($vall->contact_by[2]) && $vall->contact_by[2] == 'p')
                      {
                      $contactbyphone = '1';
                      } */
                    $totelPrivacy = count($vall->contact_by);
                    for ($im = 0; $im < $totelPrivacy; $im++) {
                        if (isset($vall->contact_by[$im])) {
                            if ($vall->contact_by[$im] == 'c') {
                                $contactbychat = '1';
                            }
                            if ($vall->contact_by[$im] == 'e') {
                                $contactbyemail = '1';
                            }
                            if ($vall->contact_by[$im] == 'p') {
                                $contactbyphone = '1';
                            }
                        }
                    }
                }
                ?>
                <div id="msgSetting" style="display:none" class="flash-success"></div>

                <div class="controls-row bottom_border nopadding"><div class="span7 nopadding"><h4>View portfolio</h4></div><div class="span2 space_top"><i class="icon-plus-sign"></i>Add new portfolio</div></div>

                <div class="controls-row bg_color">
                    <div class="span2 nopadding">
                        <label class="padding_top">Filter your portfolio</label></div>
                    <div class="span3 nopadding"> <input type="text" value="Select date" maxlength="50" name="User" class="span3"></div>
                    <div class="span3"> <select name="User" class="span3">
                            <option value="">Please choose year</option>
                        </select></div><div class="space filter">
                        <input type="submit" value="Search" name="" class="update_bnt filter">										</div>
                </div>
                <div class="controls-row ">
                    
                   
                    
                    <div class="span3 nopadding">
                        <div class="portfolio_cont"><img src="../images/portfolio-img.jpg"> <div class="over"></div>
                            <div class="portfolio_title">Handcrafted executive desk </div>
                            <div class="portfolio_detail"><input type="submit" value="Detail" name="" class="detail_bnt">	</div>

                        </div>

                    </div>

                    <div class="span3">
                        <div class="portfolio_cont"><img src="../images/portfolio-img.jpg"><div class="over"></div>
                            <div class="portfolio_title">Handcrafted executive desk </div>
                            <div class="portfolio_detail"><input type="submit" value="Detail" name="" class="detail_bnt">	</div>

                        </div>

                    </div>

                    <div class="span3">
                        <div class="portfolio_cont"><img src="../images/portfolio-img.jpg"><div class="over"></div>
                            <div class="portfolio_title">Handcrafted executive desk </div>
                            <div class="portfolio_detail"><input type="submit" value="Detail" name="" class="detail_bnt">	</div>

                        </div>
                    </div>

                </div>





<?php $this->endWidget(); ?>

            </div>
        </div>
    </div>
</div>