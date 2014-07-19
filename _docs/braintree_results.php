<?php ?>
create customer without creditcard fail

Array
(
    [status] => 
    [result] => Braintree_Result_Error Object
        (
            [success] => 
            [_attributes] => Array
                (
                    [errors] => Braintree_Error_ErrorCollection Object
                        (
                            [_errors:Braintree_Error_ErrorCollection:private] => Braintree_Error_ValidationErrorCollection Object
                                (
                                    [_errors:Braintree_Error_ValidationErrorCollection:private] => Array
                                        (
                                        )

                                    [_nested:Braintree_Error_ValidationErrorCollection:private] => Array
                                        (
                                            [customer] => Braintree_Error_ValidationErrorCollection Object
                                                (
                                                    [_errors:Braintree_Error_ValidationErrorCollection:private] => Array
                                                        (
                                                            [0] => Braintree_Error_Validation Object
                                                                (
                                                                    [_attribute:Braintree_Error_Validation:private] => id
                                                                    [_code:Braintree_Error_Validation:private] => 91609
                                                                    [_message:Braintree_Error_Validation:private] => Customer ID has already been taken.
                                                                )

                                                        )

                                                    [_nested:Braintree_Error_ValidationErrorCollection:private] => Array
                                                        (
                                                        )

                                                    [_collection:protected] => Array
                                                        (
                                                        )

                                                )

                                        )

                                    [_collection:protected] => Array
                                        (
                                        )

                                )

                        )

                    [params] => Array
                        (
                            [customer] => Array
                                (
                                    [id] => greencometz_28
                                    [firstName] => Virendra
                                    [lastName] => Yadav
                                    [company] => Jones Co.
                                    [email] => vir.jones@example.com
                                    [phone] => 281.330.8004
                                    [fax] => 419.555.1235
                                    [website] => http://example.com
                                )

                        )

                    [message] => Customer ID has already been taken.
                    [creditCardVerification] => 
                    [transaction] => 
                    [subscription] => 
                    [merchantAccount] => 
                )

        )

)
==========================================================================
create customer without creditcard success