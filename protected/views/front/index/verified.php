<style>
    .go_to_login {
    height: auto;
    margin: 10px;
}
.create_acunt_right1 {
    height: auto;
    width: 202px;
}

.sign_form {
    float: left;
    padding: 10px;
    width: 93%;
}

.create_acunt_left {
    float: left;
    height: auto;
    width: 436px;
}
    </style>
<input type="hidden" id="body" value="<?php echo $msg ?>" >
<?php UtilityHtml::popupforUserVerification($msg); ?>
