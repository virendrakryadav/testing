<div class="popup_head">
<h2 class="heading"><?php echo Yii::t('index_playvideo','my_video_text')?></h2>
<button id="cboxClose" type="button" onclick="document.getElementById('playVideo').innerHTML='';document.getElementById('playVideo').style.display='none';
        document.getElementById('playportfolioVideo').innerHTML='';document.getElementById('playportfolioVideo').style.display='none';
    "><?php echo Yii::t('index_playvideo','close_text')?></button>
</div>
<?php
$this->widget ( 'ext.mediaElement.MediaElementPortlet',
    array ( 
    'url' => $video,
//      'width'=>'600px',
//       'height'=>'300px',  
// or you can set the model and attributes
    //'model' => $model,
    //'attribute' => 'url'
// its required and so you have to set correctly
     'mimeType' =>'video/mp4',
 
    ));
?>
