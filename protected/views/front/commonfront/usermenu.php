<div class="col-md-12 no-mrg sky-form">
    <div class="col-md-12 no-mrg3">
        <label class="label text-size-14">I am using erandoo as: <?php echo CommonUtility::getUserFullName(Yii::app()->user->id); ?></label>
        <select class="form-control mrg5">
            <option>Change Persona</option>
        </select>
    </div>
    <?php
    $virtualdoer = Yii::app()->user->getState('is_virtualdoer_license');
    $inpersondoer = Yii::app()->user->getState('is_inpersondoer_license');
//    $instantdoer = Yii::app()->user->getState('is_instantdoer_license');    
    $poster = Yii::app()->user->getState('is_poster_license');
    $premiumdoer = Yii::app()->user->getState('is_premiumdoer_license');    
    
    $is_Virtualdoer = CommonUtility::getUserPrimationStatus($virtualdoer);
    $is_Inpersondoer = CommonUtility::getUserPrimationStatus($inpersondoer);
    $is_Poster = CommonUtility::getUserPrimationStatus($poster);
    $is_Premiumdoer = CommonUtility::getUserPrimationStatus($premiumdoer);
    ?>
    <div class="col-md-12 no-mrg3">
        <label class="label text-size-14">My Location: 46259 <br/>Indianapolis, Indiana USA</label>
        <select class="form-control mrg5">
            <option>Change Location</option>
        </select>
    </div>

    <div class="col-md-12 no-mrg3">
        <div class="press">
            <a id="v" onclick="setUserPrimation('v','<?php echo $virtualdoer['permission_status']; ?>');" class="nt-btn <?php if ($is_Virtualdoer) echo 'active'; ?>" href="javascript:void(0)">Virtual <br/>Doer</a>
        </div>
        <div class="press">
            <a id="i" onclick="setUserPrimation('i','<?php echo $inpersondoer['permission_status']; ?>')"  class="nt-btn <?php if ($is_Inpersondoer) echo 'active'; ?>" href="javascript:void(0)">In-Person <br/>Doer</a>
        </div>
    </div>
    <div class="col-md-12 no-mrg3">
        <div class="press">
            <a id="p" onclick="setUserPrimation('p','<?php echo $poster['permission_status']; ?>')"  class="nt-btn <?php if ($is_Poster) echo 'active'; ?>" href="javascript:void(0)">Project <br/>Poster</a></div>
        <div class="press">
            <a id="prm" onclick="setUserPrimation('prm','<?php echo $premiumdoer['permission_status']; ?>')"  class="nt-btn <?php if ($is_Premiumdoer) echo 'active'; ?>" href="javascript:void(0)">Premium <br/>Projects</a></div>
    </div>

</div>