<?php
/* @var $this IndexController */

//$this->pageTitle=Yii::app()->name;
?>

<?php /*?><h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p><?php */
?>
<div style="padding-top:90px" >
    <div style="font-size:24px; height:500px" align="center">Welcome to the Dashboard
        <br>
        <br>
        <?php
//        if(Yii::app()->user->getState('superAdminId') )
//        {
            if(CommonUtility::getPrenmissionToAccessUser( 'user' , 'frontaccess'))
            echo CHtml::link('Select User', Yii::app()->createUrl('user/frontaccess'), array()) ;
//        }
        ?>
    </div>
        
</div>