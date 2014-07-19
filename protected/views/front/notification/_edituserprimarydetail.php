<script>
function validate(divid)
{
    if(divid == "primaryemail")
    {
        if($("#User_primary_email").val() == "")
        {
            $("#User_primary_email").addClass("error");
            $("#updatestatus").html("Primary Email Id Not Empty.");
            $("#updatestatus").removeClass("alert alert-success fade in alert-dismissable");
            $("#updatestatus").addClass("alert alert-danger fade in alert-dismissable");
            $("#updatestatus").show();
            return false;
        }

        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if( !emailReg.test( $("#User_primary_email").val()) ) {
            $("#User_primary_email").addClass("error");
            $("#updatestatus").html("Please insert valid Email Id");
            $("#updatestatus").removeClass("alert alert-success fade in alert-dismissable");
            $("#updatestatus").addClass("alert alert-danger fade in alert-dismissable");
            $("#updatestatus").show();
            return false;
        }
    }
    else
    {
        if($("#User_primary_phone").val() == "")
        {
            $("#User_primary_phone").addClass("error");
            $("#updatestatus").html("Primary Phone No Not Empty.");
            $("#updatestatus").removeClass("alert alert-success fade in alert-dismissable");
            $("#updatestatus").addClass("alert alert-danger fade in alert-dismissable");
            $("#updatestatus").show();
            return false;
        }
    }    
}
</script> 
 <?php
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'editprimaryemail-form',
//            'htmlOptions' => array('class'=>'editprimaryemail'),
        ));
        $divid = "";
        $rnd = rand(0,9999);        
        ?><div class="col-lg-10 no-mrg3"><?php
        if($edittype == Globals::DEFAULT_VAL_EMAIL)
        {
            $divid = Globals::DEFAULT_VAL_PRIMARY_EMAIL;
            echo $form->textField($model, Globals::FLD_NAME_PRIMARY_EMAIL, array('class'=>'form-control')); 
        }
        else
        {
            $divid = Globals::DEFAULT_VAL_PRIMARY_PHONE;
            echo $form->textField($model, Globals::FLD_NAME_PRIMARY_PHONE, array('class'=>'form-control')); 
        }  
        ?>
        </div>
            <div class="col-lg-2"><?php
        echo CHtml::ajaxSubmitButton('Update',Yii::app()->createUrl('notification/edituserprimarydetail'),array(
                    'type'=>'POST',
                    'dataType'=>'json',
                    'beforeSend' => 'function(){ 
                        return validate("'.$divid.'");
                                        }',
                    'success'=>'js:function(data){
                        var divid = "'.$divid.'";
                        $("#edituser"+divid).show();
                        if(divid == "primaryemail")
                        {                            
                            $("#email").val($("#User_primary_email").val());
                            $("#'.$divid.'").html("<strong class=\'color-orange\'>"+$("#User_primary_email").val()+"</strong>");  
                            $("#updatestatus").html("Primary Email Id Updated");
                            $("#updatestatus").removeClass("alert alert-danger fade in alert-dismissable");
                            $("#updatestatus").addClass("alert alert-success fade in alert-dismissable");
                            $("#updatestatus").show();
                        }
                        else
                        {                           
                            $("#phone").val($("#User_primary_phone").val());
                            $("#'.$divid.'").html("<strong class=\'color-orange\'>"+$("#User_primary_phone").val()+"</strong>"); 
                            $("#updatestatus").html("Primary Phone No. Updated");
                            $("#updatestatus").removeClass("alert alert-danger fade in alert-dismissable");
                            $("#updatestatus").addClass("alert alert-success fade in alert-dismissable");
                            $("#updatestatus").show();
                        }
                    }',
                ),array('class'=>'btn-u btn-u-lg rounded btn-u-sea push','id'=>'detail'.$divid.$rnd));
        ?>
            </div><?php
        $this->endWidget(); 
        
?>