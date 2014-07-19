<script>
function chackMailAndPhone()
{    
    if($("#email").val() == "")
    {
        $("#updatestatus").html("Please insert Primary Email Id");
        $("#updatestatus").removeClass("alert alert-success fade in alert-dismissable");
        $("#updatestatus").addClass("alert alert-danger fade in alert-dismissable");
        $("#updatestatus").show();
        return false;
    }
    if($("#phone").val() == "")
    {
        $("#updatestatus").html("Please insert Primary Phone Id");
        $("#updatestatus").removeClass("alert alert-success fade in alert-dismissable");
        $("#updatestatus").addClass("alert alert-danger fade in alert-dismissable");
        $("#updatestatus").show();
        return false;
    }      
}
</script>

<div class="container content">
<?php
$notification = $notificationsetting;
?>
    <!--Left bar start here-->
    <div class="col-md-3">
        <!--Dashbosrd start here-->
        <?php $this->renderPartial('//commonfront/header_on_leftsidebar'); ?>
        <!--Dashbosrd start here-->

        <!--left nav start here-->
        <div class="margin-bottom-30">
            <div class="notifi-set">
                <ul>
                    <li><a  href="#">Username/Password</a></li>
                    <li><a href="#">Payment</a></li>
                    <li><a href="#">Profile</a></li>
                    <li><a href="#" class="active">Notifications</a></li>
                </ul>
            </div>
        </div>
        <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'notification-form',
        ));
        ?>
        <div class="margin-bottom-30">
            <div style="padding: 11px 0 0 0;text-align: right">
                <?php                                
		echo CHtml::ajaxSubmitButton(Globals::DEFAULT_VAL_SAVE,Yii::app()->createUrl('notification/notificationsetting'),array(
			   'type'=>'POST',
			   'dataType'=>'json',
                            'beforeSend' => 'function(){ 
                                return chackMailAndPhone();
                                                }',
			   'success'=>'js:function(data){
                                $("#updatestatus").html("Notifications Updated....");
                                $("#updatestatus").removeClass("alert alert-danger fade in alert-dismissable");
                                $("#updatestatus").addClass("alert alert-success fade in alert-dismissable");
                                $("#updatestatus").show();			   	
			   }',
			),array('class'=>'btn-u btn-u-lg rounded btn-u-sea push','style'=>'width: 258px;'));
	?>
                </div>
       </div>  
        <!--left nav Ends here-->


    </div>
    <!--Left bar Ends here-->

    <!--Right part start here-->
    <div class="col-md-9">
        <div id="updatestatus" onclick="$('#updatestatus').hide();" style="display: none"></div>
        <h2 class="h2"> Email Notifications</h2>
        <p class="margin-bottom-15">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortormauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis</p>
        
        
        
        
        <div class="margin-bottom-15 overflow-h">
        <div class="col-lg-3 no-mrg">Email Notifications are sent to: </div> 
        <div class="col-lg-6 no-mrg">
        <strong class="color-orange" id="primaryemail"><?php echo $model[Globals::FLD_NAME_PRIMARY_EMAIL];?></strong>
        
        <?php   echo CHtml::ajaxLink(Globals::DEFAULT_VAL_CHANGE, Yii::app()->createUrl('notification/edituserprimarydetail'),
                        array(
                                'type' =>'Post',
                                'data' =>array( 'edittype' => Globals::DEFAULT_VAL_EMAIL),
                                'beforeSend' => 'function(){                                     
                                        }',
                                'complete' => 'function(){    
                                    $("#edituserprimaryemail").hide();
                                        }',
                                'update'=>'#primaryemail',
                            ), 
                        array('live'=>false,'id' => 'edituserprimaryemail')); ?>  
        
        </div>       
        </div> 
        
        <div class="margin-bottom-15 overflow-h">
        <div class="col-lg-3 no-mrg">SMS Notifications are sent to: </div> 
        <div class="col-lg-6 no-mrg">
        <input type="hidden" id="phone" value="<?php echo $model[Globals::FLD_NAME_PRIMARY_PHONE]?>">
        <strong class="color-orange" id="primaryphone" ><?php echo $model[Globals::FLD_NAME_PRIMARY_PHONE]?></strong>
        <?php   echo CHtml::ajaxLink(Globals::DEFAULT_VAL_CHANGE, Yii::app()->createUrl('notification/edituserprimarydetail'),
                        array(
                                'type' =>'Post',
                                'data' =>array( 'edittype' => Globals::DEFAULT_VAL_PRIMARY_PHONE),
                                'beforeSend' => 'function(){                                            
                                        //$("#profile_box").addClass("displayLoading"); 
                                        }',
                                'complete' => 'function(){                                                   
                                        $("#edituserprimaryphone").hide();
                                        }',
                                'update'=>'#primaryphone',
                            ), 
                        array('live'=>false,'id' => 'edituserprimaryphone')); ?>
        </div>
        
        </div>                                    
            
        <!--Poster notify start here-->        
        <div class="margin-bottom-30">
            <div id="accordion" class="panel-group">
                <div class="panel panel-default margin-bottom-20">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#collapseOne" class="collapsed" data-parent="#accordion" data-toggle="collapse" class="">Poster                            
                            <span class="accordian-state"></span></a>
                        </h4>
                    </div>

                    <div class="panel-collapse collapse" id="collapseOne" style="height: 0px;">
                        <div class="panel-body">    
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Notification</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">SMS</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $postercount = 1;
                                        foreach($notification as $notificationPoster)
                                        {
                                            if($notificationPoster[Globals::FLD_NAME_USER_NOTIFICATION][Globals::FLD_NAME_USER_APPLICABLE_FOR] == 'p' )
                                            {
                                              $email =   $notificationPoster[Globals::FLD_NAME_USER_SEND_EMAIL];
                                              $sms =   $notificationPoster[Globals::FLD_NAME_USER_SEND_SMS];
                                              ?>
                                                <tr>
                                                    <td><?php echo $notificationPoster[Globals::FLD_NAME_USER_NOTIFICATION_LOCALE][Globals::FLD_NAME_DESCRIPTION]; ?></td>
                                                    <td align="center"><input type="checkbox" <?php if($email == 1){ ?>checked ="checked"<?php } ?> name="posteremail<?php echo $postercount;?>"></td>
                                                    <td align="center"><input type="checkbox" <?php if($sms == 1){ ?>checked ="checked"<?php } ?> name="postersms<?php echo $postercount;?>"></td>
                                                    <input type="hidden" name="posternotid<?php echo $postercount;?>" value="<?php echo $notificationPoster[Globals::FLD_NAME_USER_NOTIFICATION_ID];?>" >
                                                </tr>
                                             <?php 
                                             $postercount++;
                                            }                                            
                                        }                                        
                                        ?> 
                                    <input type="hidden" name="postercount" value="<?php echo $postercount;?>" >
                                    </tbody>
                                </table>
                            </div>
                        </div></div></div>
                <!--Poster notify ends here-->

                <!--Doer notify start here-->
                <div class="margin-bottom-30">
                    <div class="panel panel-default margin-bottom-20">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#collapseTwo" class="collapsed" data-parent="#accordion" data-toggle="collapse">
                                    Doer
                                    <span class="accordian-state"></span>
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseTwo">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Notification</th>
                                                <th  class="text-center">Email</th>
                                                <th  class="text-center">SMS</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td><div class="col-lg-3 mrg2">New Project Is Posted</div>
                                                    <div class="col-lg-3 mrg2">
                                                        <select class="form-control mrg3">
                                                            <option>Category</option>
                                                        </select></div>
                                                    <div class="col-lg-4 mrg2">
                                                        <select class="form-control mrg3">
                                                            <option>subcategory</option>
                                                        </select></div>
                                                </td>
                                                <td align="center"><input type="checkbox" name="checkbox-inline"></td>
                                                <td align="center"><input type="checkbox" name="checkbox-inline"></td>
                                            </tr>

                                            <tr>
                                                <td colspan="3">
                                            <div class="col-md-7 no-mrg">
                                            <div class="v-search2">
                                            <div class="v-searchcol1">
                                            <img src="<?php echo Globals::BASE_URL;?>/public/media/image/in-searchic.png">
                                            </div>
                                            <div class="v-searchcol4"><input type="text" placeholder="Search Skills" name=""></div>
                                            <div class="v-searchcol5">
                                            <img src="<?php echo Globals::BASE_URL;?>/public/media/image/in-closeic.png">
                                            </div>
                                            </div>
                                            <button class="btn-u btn-u-sm rounded btn-u-sea" type="button">Add</button>
                                            <div class="clr"></div>
                                            </div>

                                            <div class="col-md-12 no-mrg">
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 1</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 2</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 3</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 4</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 5</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 6</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 7</div>
                                            </div>
                                            <div class="alert2 alert-block alert-warning fade in mrg7" style="overflow:hidden;">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <div class="mrg10">Skill 8</div>
                                            </div>
                                            <div class="clr"></div> </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $doercount = 1;
                                            foreach($notification as $notificationDoer)
                                            {
                                                if($notificationDoer[Globals::FLD_NAME_USER_NOTIFICATION][Globals::FLD_NAME_USER_APPLICABLE_FOR] == 't' )
                                                {
                                                 $email =   $notificationDoer[Globals::FLD_NAME_USER_SEND_EMAIL];
                                                $sms =   $notificationDoer[Globals::FLD_NAME_USER_SEND_SMS];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $notificationDoer[Globals::FLD_NAME_USER_NOTIFICATION_LOCALE][Globals::FLD_NAME_DESCRIPTION]; ?></td>
                                                        <td align="center"><input type="checkbox" <?php if($email == 1){ ?>checked ="checked"<?php } ?> name="doeremail<?php echo $doercount;?>"></td>
                                                        <td align="center"><input type="checkbox" <?php if($sms == 1){ ?>checked ="checked"<?php } ?> name="doersms<?php echo $doercount;?>"></td>
                                                        <input type="hidden" name="doernotid<?php echo $doercount;?>" value="<?php echo $notificationDoer[Globals::FLD_NAME_USER_NOTIFICATION_ID];?>" >
                                                    </tr>
                                                <?php  
                                                $doercount++;
                                                }                                            
                                            }
                                            ?>  
                                        <input type="hidden" name="doercount" value="<?php echo $doercount;?>" >
                                        </tbody>
                                    </table>
                                </div>
                            </div></div></div>
                    <!--Doer notify ends here-->

                    <!--system notify start here-->
                    <div class="margin-bottom-30">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="#collapseThree" class="collapsed" data-parent="#accordion" data-toggle="collapse">
                                        System
                                        <span class="accordian-state"></span>
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse" id="collapseThree">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Notification</th>
                                                    <th class="text-center">Email</th>
                                                    <th class="text-center">SMS</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php 
                                                $systemcount = 1;
                                                foreach($notification as $notificationSystem)
                                                {
                                                    if($notificationSystem[Globals::FLD_NAME_USER_NOTIFICATION][Globals::FLD_NAME_USER_APPLICABLE_FOR] == 's' )
                                                    {
                                                    $email =   $notificationSystem[Globals::FLD_NAME_USER_SEND_EMAIL];
                                                    $sms =   $notificationSystem[Globals::FLD_NAME_USER_SEND_SMS];
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $notificationSystem[Globals::FLD_NAME_USER_NOTIFICATION_LOCALE][Globals::FLD_NAME_DESCRIPTION]; ?></td>
                                                            <td align="center"><input type="checkbox" <?php if($email == 1){ ?>checked ="checked"<?php } ?> name="systememail<?php echo $systemcount;?>"></td>
                                                            <td align="center"><input type="checkbox" <?php if($sms == 1){ ?>checked ="checked"<?php } ?> name="systemsms<?php echo $systemcount;?>"></td>
                                                            <input type="hidden" name="systemnotid<?php echo $systemcount;?>" value="<?php echo $notificationSystem[Globals::FLD_NAME_USER_NOTIFICATION_ID];?>" >
                                                        </tr>
                                                    <?php   
                                                    $systemcount++;
                                                    }                                            
                                                }
                                                ?> 
                                             <input type="hidden" name="systemcount" value="<?php echo $systemcount;?>" >
                                            </tbody>
                                        </table>
                                    </div>
                                </div></div></div>                        
                        <!--system notify ends here-->
                        <!--Right part ends here-->

                    </div></div>
            </div>                                 
<?php $this->endWidget(); ?>
            <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    App.init();
                });
            </script>

