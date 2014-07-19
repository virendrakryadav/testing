<?php
/* @var $this PaymentController */

//start $form widget

 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id'=>'create-paymentk-form',
				//'enableAjaxValidation' => false,
            //                    'enableClientValidation' => true,
				
			)); 
			
			$this->widget('ext.BraintreeApi.widgets.CCForm', array(
        'form' => $form,
        'form_id' => 'payment-form', //Now optional as can be retrieved in widget from $form
        'model' => $payment,
        'values' => $payment->attributes,  //Now optional as can be retrieved in widget from $payment
        //'type' => 'customer', //can use this instead of fields array below, options are 'customer', 'creditcard', 'charge_min', 'address'
        'fields' => array(
            'amount',
            'orderId',
            'creditCard' => array('number','cvv','month','year','name'),
            'merchantAccountId',
            'customer' => array('firstName','lastName','company','phone','fax','website','email'),
            'billing' => array('firstName','lastName','company','streetAddress','extendedAddress','locality','region','postalCode','countryCodeAlpha2'),
            'shipping' => array('firstName','lastName','company','streetAddress','extendedAddress','locality','region','postalCode','countryCodeAlpha2'),
        ),
 
    ));
    
    ?>


<?php $this->endWidget(); ?>