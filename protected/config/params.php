<?php

// this contains the application parameters that can be maintained via GUI
return array(
	// this is displayed in the header section
	'title'=>'Greencomet',
	// this is used in error pages
	'adminEmail'=>'webmaster@example.com',
	'defaultPageSize'=>10,
	'testMessage'=>'Test Succeed',
	// number of posts displayed per page
	'postsPerPage'=>10,
	// maximum number of comments that can be displayed in recent comments portlet
	'recentCommentCount'=>10,
	// maximum number of tags that can be displayed in tag cloud portlet
	'tagCloudCount'=>20,
   'salt'=>'$a$b$i$k',
	// whether post comments need to be approved before published
	'commentNeedApproval'=>true,
  // 'force_https' => true,
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; 2014 by Green Comet <br /> All Rights Reserved.',
        'rolesModels'=>array(
            'Admin','Country','State','Region','City','Category',
            'User' => array('create,update','delete','list') 
            ,'CategoryQuestion'),
        'rolesActions'=>array('create,update','delete','list'),
        'rolesActionsToPerform'=>array(
            'list' => 'admin',
            ),
    
    'rolesModelsFront'=>array(
            'User' => array('frontaccess'),
            'Poster' => array('createtask'),
            ),
    
    
        'superAdminId'=>'1',
        'DEFAULTLanguage'=>'en_us',
        'allowImages'=>array("jpg","jpeg","png"),//allow images to upload
        'allowVideos'=>array("mp4"),//allow images to upload
        'allowDocuments' => array(
                                    "jpg"=>array("type" => 'image', "action"=>"show"), 
                                    "jpeg"=>array("type" => 'image', "action"=>"show"), 
                                    "png"=>array("type" => 'image', "action"=>"show"), 
                                    "gif"=>array("type" => 'image', "action"=>"show"), 
                                    "pdf"=>array("type" => 'pdf', "action"=>"download"), 
                                    "doc"=>array("type" => 'doc', "action"=>"download"), 
                                    "docx"=>array("type" => 'doc', "action"=>"download"), 
                                    "ppt"=>array("type" => 'ppt', "action"=>"download"), 
                                    "pptx"=>array("type" => 'ppt', "action"=>"download"), 
                                    "pps"=>array("type" => 'ppt', "action"=>"download"), 
                                    "ppsx"=>array("type" => 'ppt', "action"=>"download"), 
                                    "odt"=>array("type" => 'doc', "action"=>"download"), 
                                    "xls"=>array("type" => 'excel', "action"=>"download"), 
                                    "xlsx"=>array("type" => 'excel', "action"=>"download"), 
                                    "zip"=>array("type" => 'zip', "action"=>"download"),
                                    "mp4"=>array("type" => 'video', "action"=>"play"), 
                                ), // attachment filetypes
        'maxfileSize' => 8 * 1024 * 1024,// maximum file size in bytes(10 mb)
        'minfileSize' => 10,// minimum file size in bytes(10 kb)
        'pathSeparator' => "/",// minimum file size in bytes(10 kb)
        'mediaFolder' => 'media',// maximum file size in bytes
        
        'adminEmail'=>'virendra.yadav@aryavratinfotech.com',
        'braintreeapi' => array(
            'class' => 'ext.BraintreeApi.BraintreeApi',
            'environment' => 'sandbox', //'sandbox' or 'production'
            'merchant_id' => '33fzc6y3t9hpdxhn',
            'master_merchant_id' => 'k54hhv2tkvyjdms8',
            'public_key' => 'r5qvcb49bzdb9fkk',
            'private_key' => 'c45bf46e2e8862e95035083ccce41f22',
            'clientside_key' => 'MIIBCgKCAQEA8bzhFy/J98wxrQLoAOXqR6yTz56xnUbTfJmyhrw4VWWkcNHl7I8qOEdacyaiSGxD2VwMOMsvwnp8qffr1s3P1lovMX/HyjUzdmkyav6/B/dlOwI9cAVnQ2uTO4Ar1CE0vYr0PupvtgZQ1CFE6q0mqkJf63fCS6UDqASrJ817R68BwLw7rSPOEBn7TM9v9ugcnEBLsUa7Atsx8lmDXKwlgLR7K9+Ft0zBeHId/hZkK6MEzqjBCaHL8OIzhz/k5CPkTbaJHmrtEzveyvzhrkCLZNJP7ukJvDV2SbChQYhP76YxoB7uEHTPRBtTm/0pBQnCaLvDcSUDVcAnw0ZiJgJBtwIDAQAB',
        ),
    
);
