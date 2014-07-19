<?php

/**
 * This is the model class for table "{{dta_user}}".
 *
 * The followings are the available columns in table '{{dta_user}}':
 * @property string $user_id
 * @property string $user_type
 * @property integer $is_verified
 * @property string $gender
 * @property string $marrital_status
 * @property string $firstname
 * @property string $lastname
 * @property string $password
 * @property string $tagline
 * @property string $date_of_birth
 * @property string $preferred_language_code
 * @property string $country_code
 * @property integer $state_id
 * @property integer $state_ispublic
 * @property integer $region_id
 * @property integer $region_ispublic
 * @property integer $city_id
 * @property integer $city_ispublic
 * @property string $zipcode
 * @property integer $profile_ispublic
 * @property string $profile_info
 * @property string $contact_info
 * @property string $billaddr_street1
 * @property string $billaddr_street2
 * @property integer $billaddr_city_id
 * @property integer $billaddr_city_isprivate
 * @property integer $billaddr_region_id
 * @property integer $billaddr_region_ispublic
 * @property integer $billaddr_state_id
 * @property integer $billaddr_state_ispublic
 * @property string $billaddr_country_code
 * @property string $billaddr_zipcode
 * @property integer $geoaddr_issame
 * @property string $geoaddr_street1
 * @property string $geoaddr_street2
 * @property integer $geoaddr_city_id
 * @property integer $geoaddr_city_isprivate
 * @property integer $geoaddr_state_id
 * @property integer $geoaddr_state_ispublic
 * @property integer $geoaddr_region_id
 * @property integer $geoaddr_region_ispublic
 * @property string $geoaddr_zipcode
 * @property string $geoaddr_country_code
 * @property string $about_me
 * @property integer $work_start_year
 * @property string $prefereces_setting
 * @property string $timezone
 * @property string $startup_page
 * @property integer $notify_by_sms
 * @property integer $notify_by_email
 * @property integer $notify_by_chat
 * @property integer $notify_by_fb
 * @property integer $notify_by_tw
 * @property integer $notify_by_gplus
 * @property string $credit_account_setting
 * @property string $task_last_post_at
 * @property integer $task_post_cnt
 * @property integer $task_post_total_price
 * @property integer $task_post_total_hours
 * @property integer $task_post_cancel_cnt
 * @property integer $task_post_cancel_price
 * @property integer $task_post_cancel_hours
 * @property integer $task_post_rank
 * @property integer $task_post_review_cnt
 * @property string $task_last_done_at
 * @property integer $task_done_cnt
 * @property integer $task_pending_cnt
 * @property integer $task_done_total_price
 * @property integer $task_done_total_hours
 * @property integer $task_done_rank
 * @property integer $task_done_review_cnt
 * @property integer $connections_cnt
 * @property integer $references_cnt
 * @property integer $group_cnt
 * @property integer $fb_isconnected
 * @property integer $tw_isconnected
 * @property integer $gplus_isconnected
 * @property integer $in_isconnected
 * @property string $social_sites_auth_dtl
 * @property string $created_at
 * @property string $last_updated_at
 * @property string $last_accessed_at
 * @property string $status
 * @property string $payment_customer_id
 */
class User extends CActiveRecord
{
    public $repeatpassword; 
	public $newpassword;
	public $oldpassword;
    public $email;
    public $phone;
	public $image;
	public $video;
	public $weburl;
	public $url;
    public $chatidof;
	public $geograplical;
	public $social;
	public $socialof;
    public $mobile;
	public $terms_agree;
    public $chat_id;
	public $url_ispublic;
	public $weburl_ispublic;
	//for About Us
	public $payment;
	public $certificate;
	public $year;
	//public $yearof;
	public $skills;
	//public $tag;
        public $account_preference;
        public $card_preference;
        public $paypal;
        public $card_name;
        public $card_number;
        public $card_number_hidden_validation;
        public $card_expire_month;
        public $card_expire_year;
        public $card_cvv;
        public $card_other_error;
        public $card_number_hidden;
        public $card_id;
        public $card_preference_hidden;
        public $paypal_email;
        public $paypal_email_validation;
	//for setting page
	public $contactbychat;
	public $contactbyemail;
	public $contactbyphone;
	public $start_time;
	public $end_time;
	public $all_days;
        public $select_days;
        
        public $sun;
        public $mon;
        public $tue;
        public $wed;
        public $thu;
        public $fri;
        public $sat;
        public $token;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
            Yii::import('ext.validators.ECCValidator');
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, firstname','required','on' => 'updateimage'),
			array('email, password, repeatpassword', 'required','on' => 'register'),                        
			array('newpassword, repeatpassword', 'required','on' => 'userchangepassword,passwordchange'),
			array('login_name,firstname,password,repeatpassword','required','on'=>'insert'),
                        array('firstname,login_name,email,gender, password, repeatpassword, user_roleid', 'required', 'on' => 'hasRoleInsert'),
                        array('firstname,login_name,email,gender, user_roleid', 'required', 'on' => 'hasRoleUpdate'),
                        array('lastname,gender', 'filter', 'filter'=>array($this,'filterPostalCode'), 'on' => 'hasRoleInsert'),
                        // array('firstname', 'required','message'=>"First Name cannot be blank.", 'on'=>'insert,hasRoleInsert,hasRoleUpdateupdate,updateaccount'),
                        array('firstname,lastname,account_type,is_verified,login_name','required','on'=>'update'),
                        array('is_admin', 'numerical', 'integerOnly'=>true),
                        // You can also check multiple type of cards
                        // 'format'=>array(ECCValidator::MASTERCARD, ECCValidator::VISA)),

                    
                        array('mobile', 'required','on' => 'contactinformation'),
//                      array('mobile', 'numerical','on' => 'contactinformation'),
			array('firstname,', 'required','on' => 'updateprofile'),
			//array('firstname,lastname', 'match' ,'pattern'=>'/^\S+$/', 'message'=>'Space not allowed', 'on'=>'updateprofile'),
			array('firstname,lastname', 'filter', 'filter'=>array( $this, 'filterPostalCode' )),
			array('firstname,lastname', 'match' ,'pattern'=>'/^[a-zA-Z0-9 ]*$/', 'message'=>'Alphabets are Allowed', 'on'=>'updateprofile'),
                    
                        array('login_name', 'match' ,'pattern'=>'/^[a-zA-Z ]*$/', 'message'=>'Alphabets are Allowed', 'on'=>'update,insert'),
		
                        array('url,weburl', 'match' ,'pattern'=>'/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', 'message'=>'Invalid URL', 'on'=>'updateprofile'),
			array('source_app','required',"on" => "insert,update,AboutUs"),
			array('billaddr_street1,billaddr_country_code,billaddr_region_id,billaddr_state_id,billaddr_city_id,billaddr_zipcode', 'required','on' => 'addressinfo'),
			array('billaddr_street1,billaddr_country_code,billaddr_region_id,billaddr_state_id,billaddr_city_id,billaddr_zipcode,geoaddr_street1,geoaddr_country_code,geoaddr_region_id,geoaddr_state_id,geoaddr_city_id,geoaddr_zipcode', 'required','on' => 'addressinfogeo'),
			array('billaddr_zipcode,geoaddr_zipcode', 'numerical','on' => 'addressinfogeo,addressinfo'),
			//array('private', 'required', 'requiredValue' => 1, 'message' => 'Please accept the term and condition','on' => 'updateprofile'),
			//array('tagline', 'required','on' => 'aboutus'),
			array('about_me', 'length', 'min'=>10,'max'=>1000),
			array('tagline', 'length', 'min'=>5,'max'=>50),
			
                        array('firstname,phone,login_name', 'required', 'on'=>'updateaccount'),
          
			//array('firstname, email, password, repeatpassword , mobile, country_code, state_id, region_id, city_id, zipcode', 'required','on' => 'insert'),
			//array('firstname, email, mobile, country_code, state_id, region_id, city_id, zipcode', 'required','on' => 'update'),
			array('email', 'required','on' => 'forgotpassword'),
			//array('email', 'email','on' => 'forgotpassword'),
			//array('firstname, lastname, email, password, repeatpassword', 'filter'=>array($this,'filterPostalCode'), 'on' => 'register'),
			array('password', 'match' ,'pattern'=>'/^\S+$/', 'message'=>'Space not allowed', 'on'=>'register,insert, hasRoleInsert,changepassword, userchangepassword,passwordchange'),
			//new password rule
			array('newpassword', 'match' ,'pattern'=>'/^\S+$/', 'message'=>'Space not allowed', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword,passwordchange'),
			array('newpassword', 'match' ,'pattern'=>'/(?=.*[\W])/', 'message'=>'Contains at least one special character', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword,passwordchange'),
			array('newpassword', 'match' ,'pattern'=>'/(?=.*[\d])/', 'message'=>'Contains at least one digit', 'on'=>'insert, hasRoleInsert,changepassword, userchangepassword,passwordchange'),
			array('repeatpassword', 'compare', 'compareAttribute'=>'newpassword', 'message'=>"Password don't match",'on'=>'changepassword, userchangepassword,passwordchange'),
			array('oldpassword, newpassword, repeatpassword', 'required','on' => 'changepassword'),
			array('oldpassword', 'equalPasswords','on' => 'changepassword'),
			array('password, newpassword', 'length', 'min'=>6,'max'=>50),
			
			array('mobile', 'numerical'),
			array('mobile', 'validatePhoneNumber','on' => 'contactinformation'),
			array('password', 'match' ,'pattern'=>'/(?=.*[\W])/', 'message'=>'Password must contain at least one special character and one digit', 'on'=>'register, insert, hasRoleInsert, userchangepassword,passwordchange'),
			array('password', 'match' ,'pattern'=>'/(?=.*[\d])/', 'message'=>'Password must contain at least one special character and one digit', 'on'=>'register, insert, hasRoleInsert,changepassword, userchangepassword,passwordchange'),
			array('terms_agree', 'required', 'requiredValue' => 1, 'message' => 'Please accept the terms and conditions','on' => 'register'),
			array('email, password', 'required','on' => 'login'),
//			array('email', 'unique'),
                        array('email', 'unique', 'className' => 'UserContact', 'attributeName' => 'contact_id', 'message'=>'Email already exist','on' => 'insert ,register , hasRoleInsert'),
			array('email', 'email','message'=>'Email is invalid'),
			array('repeatpassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Password does not match",'on'=>'register,insert,update'),
			//array('firstname, lastname, email, password, mobile, country_code, state_id, city_id, zipcode, user_created_at, user_updated_at, user_image, user_video', 'required'),
//			array('state_id,city_id,zipcode', 'numerical', 'integerOnly'=>true),
			array('email, password,', 'length', 'min'=>3,'max'=>100),
			array('mobile', 'length', 'min'=>10,'max'=>20),
//			array('zipcode', 'length', 'min'=>3, 'max'=>10),
			array('status', 'length','min'=>1, 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			
			array('created_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'register,insert'),
                        array('last_updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'updateprofile,update,hasRoleUpdate'),
                    
//                        user card validation
                        array('card_name', 'match','pattern' => '/^[a-zA-Z0-9\s]+$/','message'=>'Card Name should contain alphabets.','on' => 'accountdetail'),
                        array('card_name,card_expire_month,card_expire_year,card_cvv', 'required','on' => 'accountdetail'),
                        array('card_number','required','on' =>'accountdetail' ),
                        array('card_cvv','length', 'min'=>3,'max'=>4),
                        array('card_cvv','numerical'),
//                        array('card_number','ext.validators.ECCValidator','format'=>ECCValidator::ALL,'on' => 'accountdetail'),
//                        array('card_number','checkUniqueCardnumber','on' => 'accountdetail'),
                        array('card_expire_month', 'checkExpire','on' => 'accountdetail'),
                    

//                        user card validation End
//                        user paypal validation
                        array('paypal_email', 'required','on' => 'paypalaccountdetail'),
                        array('paypal_email', 'email'),
                        array('primary_email', 'email'),
                        array('paypal_email', 'checkUniquePaypalEmail'),
//                        user paypal validation End   
//                        
//                           
                        array('select_days', 'validateTimetable','on' => 'setting'),  
                        array('user_id, login_name,firstname, lastname, email, password, mobile, country_code, state_id, region_id, city_id, zipcode, status, user_created_at, user_updated_at, user_image, user_video,location_longitude,location_latitude', 'safe', 'on'=>'search'),
                    
//                           
//                      array('email, password, repeatpassword', 'required','on' => 'register'),
//			array('firstname, password, preferred_language_code, contact_info, timezone, startup_page, created_at', 'required'),
//			array('is_verified, state_id, state_ispublic, region_id, region_ispublic, city_id, city_ispublic, profile_ispublic, billaddr_city_id, billaddr_city_isprivate, billaddr_region_id, billaddr_region_ispublic, billaddr_state_id, billaddr_state_ispublic, geoaddr_issame, geoaddr_city_id, geoaddr_city_isprivate, geoaddr_state_id, geoaddr_state_ispublic, geoaddr_region_id, geoaddr_region_ispublic, work_start_year, notify_by_sms, notify_by_email, notify_by_chat, notify_by_fb, notify_by_tw, notify_by_gplus, task_post_cnt, task_post_total_price, task_post_total_hours, task_post_cancel_cnt, task_post_cancel_price, task_post_cancel_hours, task_post_rank, task_post_review_cnt, task_done_cnt, task_pending_cnt, task_done_total_price, task_done_total_hours, task_done_rank, task_done_review_cnt, connections_cnt, references_cnt, group_cnt, fb_isconnected, tw_isconnected, gplus_isconnected, in_isconnected', 'numerical', 'integerOnly'=>true),
//			array('user_type, gender, status', 'length', 'max'=>1),
//			array('marrital_status, country_code, billaddr_country_code, geoaddr_country_code', 'length', 'max'=>2),
//			array('firstname, lastname', 'length', 'max'=>50),
//			array('password, billaddr_street1, billaddr_street2, geoaddr_street1, geoaddr_street2, startup_page', 'length', 'max'=>100),
//			array('tagline', 'length', 'max'=>200),
//			array('preferred_language_code', 'length', 'max'=>5),
//			array('zipcode, billaddr_zipcode, geoaddr_zipcode, timezone', 'length', 'max'=>20),
//			array('profile_info, contact_info, prefereces_setting, credit_account_setting, social_sites_auth_dtl', 'length', 'max'=>2000),
//			array('about_me', 'length', 'max'=>4000),
//			array('date_of_birth, task_last_post_at, task_last_done_at, last_updated_at, last_accessed_at', 'safe'),
//			// The following rule is used by search().
//			// @todo Please remove those attributes that should not be searched.
//			array('user_id, user_type, is_verified, gender, marrital_status, firstname, lastname, password, tagline, date_of_birth, preferred_language_code, country_code, state_id, state_ispublic, region_id, region_ispublic, city_id, city_ispublic, zipcode, profile_ispublic, profile_info, contact_info, billaddr_street1, billaddr_street2, billaddr_city_id, billaddr_city_isprivate, billaddr_region_id, billaddr_region_ispublic, billaddr_state_id, billaddr_state_ispublic, billaddr_country_code, billaddr_zipcode, geoaddr_issame, geoaddr_street1, geoaddr_street2, geoaddr_city_id, geoaddr_city_isprivate, geoaddr_state_id, geoaddr_state_ispublic, geoaddr_region_id, geoaddr_region_ispublic, geoaddr_zipcode, geoaddr_country_code, about_me, work_start_year, prefereces_setting, timezone, startup_page, notify_by_sms, notify_by_email, notify_by_chat, notify_by_fb, notify_by_tw, notify_by_gplus, credit_account_setting, task_last_post_at, task_post_cnt, task_post_total_price, task_post_total_hours, task_post_cancel_cnt, task_post_cancel_price, task_post_cancel_hours, task_post_rank, task_post_review_cnt, task_last_done_at, task_done_cnt, task_pending_cnt, task_done_total_price, task_done_total_hours, task_done_rank, task_done_review_cnt, connections_cnt, references_cnt, group_cnt, fb_isconnected, tw_isconnected, gplus_isconnected, in_isconnected, social_sites_auth_dtl, created_at, last_updated_at, last_accessed_at, status', 'safe', 'on'=>'search'),
		);
	}
        /*public function behaviors()
        {
            return array(
                'preview' => array(
                    'class' => 'ext.imageAttachment.ImageAttachmentBehavior',
                    // size for image preview in widget
                    'previewHeight' => 200,
                    'previewWidth' => 300,
                    // extension for image saving, can be also tiff, png or gif
                    'extension' => 'jpg',
                    // folder to store images
                    'directory' => Yii::getPathOfAlias('webroot').'/images/producttheme/preview',
					//'directory' =>Yii::app()->basePath.'/../images/uploads',
                    // url for images folder
					'url' => Yii::app()->request->baseUrl . '/images/producttheme/preview',
                    //'url' => Yii::app()->request->baseUrl.'/images/uploads',
                    // image versions
                    'versions' => array(
                        'small' => array(
                            'resize' => array(200, null),
                        ),
                        'medium' => array(
                            'resize' => array(800, null),
                        )
                    )
                )
            );
        }*/
	public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
	}
        
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->{Globals::FLD_NAME_PASSWORD});
	}
        public function findByEmail($email)
        {
            return UserContact::model()->findByAttributes(array('contact_id' => $email));
        }
        
//        public function findByEmailWithdetail($email)
//        {
//            $criteria=new CDbCriteria;
//            $criteria->with = array('usercontact');
//            $criteria->addInCondition('usercontact.contact_id', $email );
//            
//            return User::model()->findAll($criteria);
//        }
        
	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
	
	public function equalPasswords($attribute,$params)
	{
            if (isset($this->oldpassword))
            {
                $user = User::model()->findByPk(Yii::app()->user->id);
	              if ($user->password != md5($this->oldpassword.Yii::app()->params["salt"]))
                {
              
                    $this->addError($attribute, 'Old password is incorrect.');
                }      
            }
	}
        public function validateTimetable($attribute,$params)
	{
            
            if (isset($this->select_days))
            {
                if($this->select_days != '0')
                {
                    if (!isset($_POST['User']['start_time']) || $_POST['User']['start_time']=='' )
                    {
                        $this->addError('start_time','Please select start time');
                    } 
                     
                    if (!isset($_POST['User']['end_time']) || $_POST['User']['end_time']=='' )
                    {
                        $this->addError('end_time','Please select end time');
                    }
                    if ($_POST['User']['start_time']!='' && $_POST['User']['end_time'] !='')
                    {
                        if($_POST['User']['start_time'] > $_POST['User']['end_time'])
                        {
                            $this->addError('start_time','Start time must be less than End Time');
                            
                        }   
                    }
                    if ($this->select_days == 'days')
                    {
                        if (    $_POST['User']['mon'] == '0' &&  $_POST['User']['tue'] == '0' &&  $_POST['User']['wed'] == '0' &&  
                                $_POST['User']['thu'] == '0' &&  $_POST['User']['fri'] == '0' &&  $_POST['User']['sat'] == '0' &&  
                                $_POST['User']['sun'] == '0' )
                        {
                            $this->addError('mon','Please select atleast one week day');
                        }
                    }
                }
            }
	}
        public function checkUniqueCardnumber($attribute,$params)
	{
           
            if (isset($this->card_number) )
            { 
                $user = User::model()->findByPk(Yii::app()->user->id);
                if(isset($user->prefereces_setting))
                { 
                    $preferences = json_decode($user->prefereces_setting, true);
                    if($this->card_number != $_POST['User']['card_number_hidden_validation'])
                    {
                        if(isset($preferences['card']))
                        {
                           for($i=0;$i<count($preferences['card']);$i++)
                           {
                               if(isset($preferences['card'][$i]))
                               {
                                    if(in_array($this->card_number, $preferences['card'][$i]))
                                    {//echo $this->card_number;
                                        $this->addError($attribute, 'Card number already in use.');
                                    }
                               }
                           }
                        }
                    }
                }
                 
            }
	}
	public function checkUniquePaypalEmail($attribute,$params)
	{
           
            if (isset($this->paypal_email) )
            { 
                $user = User::model()->findByPk(Yii::app()->user->id);
                if(isset($user->prefereces_setting))
                { 
                    $preferences = json_decode($user->prefereces_setting, true);
                    if($this->paypal_email != $_POST['User']['paypal_email_validation'])
                    {
                        if(isset($preferences['paypal']))
                        {
                           for($i=0;$i<count($preferences['paypal']);$i++)
                           {
                               if(isset($preferences['paypal'][$i]))
                               {
                                    if(in_array($this->paypal_email, $preferences['paypal'][$i]))
                                    {//echo $this->card_number;
                                        $this->addError($attribute, 'Paypal email already in use.');
                                    }
                               }
                           }
                        }
                    }
                }
                 
            }
	}
        public function checkExpire($attribute,$params)
	{
           
            if (isset($this->card_expire_month)  )
            { 
               // echo date('Y');
               if($this->card_expire_month<=date('m') && $this->card_expire_year<=date('Y'))
               {
                 $this->addError($attribute, "Expiration must be greater than '".date('M')." / ".date('Y')."'");
               }
                 
            }
	}
        public function getFieldValue($id,$fieldName)
	{  
            $data = User::model()->findByPk($id);
            return $data->$fieldName;
                        
        } 
	public function beforeSave() 
	{
		if  (       Yii::app()->controller->action->id == "register"
                        ||  Yii::app()->controller->action->id == "forgotpassword"
                        ||  Yii::app()->controller->action->id == "changepassword"
                        ||  Yii::app()->controller->action->id == "create"
                        ||  Yii::app()->controller->action->id == "userchangepassword"
                        ||  Yii::app()->controller->action->id == "passwordchange"
//                        ||  Yii::app()->controller->action->id == "update"
                        ||  Yii::app()->controller->action->id == "savepassword"
                    )
                {                               
			$pass = md5($this->password.Yii::app()->params["salt"]);
			$this->password = $pass;
		}
		return true;
	}


	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'userrole' => array(self::BELONGS_TO, 'UserRole', Globals::FLD_NAME_USER_ROLE_ID),
			'usercontact' => array(self::HAS_ONE, 'UserContact', Globals::FLD_NAME_USER_ID),
			'userspeciality' => array(self::BELONGS_TO, 'UserSpeciality', Globals::FLD_NAME_USER_ID),
			'userspecialityHasMany' => array(self::HAS_MANY, 'UserSpeciality', Globals::FLD_NAME_USER_ID),
                    
//			'userSkills' => array(self::HAS_ONE, 'SkillLocale', array('skill_id' => 'skill_id'), 'through'=>'userspecialityHasMany'),
                    
			'userworklocationHasMany' => array(self::HAS_MANY, 'UserWorkLocation', Globals::FLD_NAME_USER_ID),
			'citylocale' => array(self::BELONGS_TO, 'CityLocale', Globals::FLD_NAME_CITY_ID),
			'regionlocale' => array(self::BELONGS_TO, 'RegionLocale', Globals::FLD_NAME_REGION_ID ),
			'statelocale' => array(self::BELONGS_TO, 'StateLocale', Globals::FLD_NAME_STATE_ID),
			'countrylocale' => array(self::BELONGS_TO, 'CountryLocale', Globals::FLD_NAME_COUNTRY_CODE),
                    
                    'task' => array(self::BELONGS_TO, 'Task', array(Globals::FLD_NAME_USER_ID => Globals::FLD_NAME_CREATER_USER_ID)),
                    'taskskill' => array(self::HAS_MANY, 'TaskSkill',array(Globals::FLD_NAME_TASK_ID => Globals::FLD_NAME_TASK_ID), 'through'=>'task'),
                    
                    'userspecialityHasOne' => array(self::HAS_ONE, 'UserSpeciality',Globals::FLD_NAME_USER_ID),
                    
                    
		);
	}
        
        public function getUserByPk($userId)
        {            
            return $user = User::model()->with('userspecialityHasMany','userworklocationHasMany')->findByPk( $userId );	
            
        }
        
        public function getUsers($skills ='' , $task_id = '' , $country_code = '' , $region_id = '' , $locationRange = '' , $limit = '-1' )
    {
//            print_r($skills);
//            print_r($locationRange);
//            exit;
            $criteria=new CDbCriteria;
            $criteria->with = array('userspeciality');
            if($skills !='')
            {
                $criteria->addInCondition('userspeciality.skill_id', $skills );
            }
            if( $locationRange )
            {
                $criteria2 = new CDbCriteria;
                $criteria2->addCondition('location_longitude >='.$locationRange['min_lon']);
                $criteria2->addCondition('location_longitude <='.$locationRange['max_lon']);
                $criteria2->addCondition('location_latitude  >='.$locationRange['min_lat']);
                $criteria2->addCondition('location_latitude  <='.$locationRange['max_lat']);
                
                $criteria->mergeWith($criteria2, 'OR');
            }
            else
            {
                $criteria->compare("t.".Globals::FLD_NAME_COUNTRY_CODE,$country_code,false,'OR');
                $criteria->compare("t.".Globals::FLD_NAME_REGION_ID,$region_id,false,'OR');
            }
            $criteria->addCondition( "t.".Globals::FLD_NAME_USER_ID."!= '". Yii::app()->user->id ."'");
            $criteria->limit = $limit;
           // print_r($criteria);exit;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));


    }
     public function getUsersByID( $id )
    {
       return $user = User::model()->findByPk( $id );	
    }
		 
        public function getUsersByLatLng($locationRange)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
          //echo $locationRange['min_lon'];
                                
		$criteria=new CDbCriteria;
               
                $criteria->addCondition('location_longitude >='.$locationRange['min_lon']);
                $criteria->addCondition('location_longitude <='.$locationRange['max_lon']);
                $criteria->addCondition('location_latitude  >='.$locationRange['min_lat']);
                $criteria->addCondition('location_latitude  <='.$locationRange['max_lat']);
                
                $list = User::model()->findAll($criteria);
                return $list;
                
        }
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => Yii::t('label_model', 'lbl_user_id'),
			'user_type' => Yii::t('label_model', 'lbl_user_type'),
			'is_verified' => Yii::t('label_model', 'lbl_is_verified'),
			'gender' => Yii::t('label_model', 'lbl_gender'),
			'marrital_status' => Yii::t('label_model', 'lbl_marrital_status'),
			'firstname' => Yii::t('label_model', 'lbl_firstname'),
			'lastname' => Yii::t('label_model', 'lbl_lastname'),
			'password' => Yii::t('label_model', 'lbl_password'),
			//'tagline' => 'Tagline',
			'date_of_birth' => Yii::t('label_model', 'lbl_date_of_birth'),
			'preferred_language_code' => Yii::t('label_model', 'lbl_preferred_language_code'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'state_id' => Yii::t('label_model', 'lbl_state_id'),
			'state_ispublic' => Yii::t('label_model', 'lbl_state_ispublic'),
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'region_ispublic' => Yii::t('label_model', 'lbl_region_ispublic'),
			'city_id' => Yii::t('label_model', 'lbl_city_id'),
			'city_ispublic' => Yii::t('label_model', 'lbl_city_ispublic'),
			'zipcode' => Yii::t('label_model', 'lbl_zipcode'),
			'profile_ispublic' => Yii::t('label_model', 'lbl_profile_ispublic'),
			'profile_info' => Yii::t('label_model', 'lbl_profile_info'),
			'contact_info' => Yii::t('label_model', 'lbl_contact_info'),
			'billaddr_street1' => Yii::t('label_model', 'lbl_billaddr_street1'),
			'billaddr_street2' => Yii::t('label_model', 'lbl_billaddr_street2'),
			'billaddr_city_id' => Yii::t('label_model', 'lbl_billaddr_city_id'),
			'billaddr_city_isprivate' => Yii::t('label_model', 'lbl_billaddr_city_isprivate'),
			'billaddr_region_id' => Yii::t('label_model', 'lbl_billaddr_region_id'),
			'billaddr_region_ispublic' => Yii::t('label_model', 'lbl_billaddr_region_ispublic'),
			'billaddr_state_id' => Yii::t('label_model', 'lbl_billaddr_state_id'),
			'billaddr_state_ispublic' => Yii::t('label_model', 'lbl_billaddr_state_ispublic'),
			'billaddr_country_code' => Yii::t('label_model', 'lbl_billaddr_state_ispublic'),
			'billaddr_zipcode' => Yii::t('label_model', 'lbl_billaddr_zipcode'),
			'geoaddr_issame' => Yii::t('label_model', 'lbl_geoaddr_issame'),
			'geoaddr_street1' => Yii::t('label_model', 'lbl_geoaddr_street1'),
			'geoaddr_street2' => Yii::t('label_model', 'lbl_geoaddr_street2'),
			'geoaddr_city_id' => Yii::t('label_model', 'lbl_geoaddr_city_id'),
			'geoaddr_city_isprivate' => Yii::t('label_model', 'lbl_geoaddr_city_isprivate'),
			'geoaddr_state_id' => Yii::t('label_model', 'lbl_geoaddr_state_id'),
			'geoaddr_state_ispublic' => Yii::t('label_model', 'lbl_geoaddr_state_ispublic'),
			'geoaddr_region_id' => Yii::t('label_model', 'lbl_geoaddr_region_id'),
			'geoaddr_region_ispublic' => Yii::t('label_model', 'lbl_geoaddr_region_ispublic'),
			'geoaddr_zipcode' => Yii::t('label_model', 'lbl_geoaddr_zipcode'),
			'geoaddr_country_code' => Yii::t('label_model', 'lbl_geoaddr_country_code'),
			//'about_me' => 'About Me',
			//'work_start_year' => 'Work Start Year',
			'prefereces_setting' => Yii::t('label_model', 'lbl_prefereces_setting'),
			'timezone' => Yii::t('label_model', 'lbl_timezone'),
			'startup_page' => Yii::t('label_model', 'lbl_startup_page'),
			'notify_by_sms' => Yii::t('label_model', 'lbl_notify_by_sms'),
			'notify_by_email' => Yii::t('label_model', 'lbl_notify_by_email'),
			'notify_by_chat' => Yii::t('label_model', 'lbl_notify_by_chat'),
			'notify_by_fb' => Yii::t('label_model', 'lbl_notify_by_fb'),
			'notify_by_tw' => Yii::t('label_model', 'lbl_notify_by_tw'),
			'notify_by_gplus' => Yii::t('label_model', 'lbl_notify_by_gplus'),
			'credit_account_setting' => Yii::t('label_model', 'lbl_credit_account_setting'),
			'task_last_post_at' => Yii::t('label_model', 'lbl_task_last_post_at'),
			'task_post_cnt' => Yii::t('label_model', 'lbl_task_post_cnt'),
			'task_post_total_price' => Yii::t('label_model', 'lbl_task_post_total_price'),
			'task_post_total_hours' => Yii::t('label_model', 'lbl_task_post_total_hours'),
			'task_post_cancel_cnt' => Yii::t('label_model', 'lbl_task_post_cancel_cnt'),
			'task_post_cancel_price' => Yii::t('label_model', 'lbl_task_post_cancel_price'),
			'task_post_cancel_hours' => Yii::t('label_model', 'lbl_task_post_cancel_hours'),
			'task_post_rank' => Yii::t('label_model', 'lbl_task_post_rank'),
			'task_post_review_cnt' => Yii::t('label_model', 'lbl_task_post_review_cnt'),
			'task_last_done_at' => Yii::t('label_model', 'lbl_task_last_done_at'),
			'task_done_cnt' => Yii::t('label_model', 'lbl_task_done_cnt'),
			'task_pending_cnt' => Yii::t('label_model', 'lbl_task_pending_cnt'),
			'task_done_total_price' => Yii::t('label_model', 'lbl_task_done_total_price'),
			'task_done_total_hours' => Yii::t('label_model', 'lbl_task_done_total_hours'),
			'task_done_rank' => Yii::t('label_model', 'lbl_task_done_rank'),
			'task_done_review_cnt' => Yii::t('label_model', 'lbl_task_done_review_cnt'),
			'connections_cnt' => Yii::t('label_model', 'lbl_connections_cnt'),
			'references_cnt' => Yii::t('label_model', 'lbl_references_cnt'),
			'group_cnt' => Yii::t('label_model', 'lbl_group_cnt'),
			'fb_isconnected' => Yii::t('label_model', 'lbl_fb_isconnected'),
			'tw_isconnected' => Yii::t('label_model', 'lbl_tw_isconnected'),
			'gplus_isconnected' => Yii::t('label_model', 'lbl_gplus_isconnected'),
			'in_isconnected' => Yii::t('label_model', 'lbl_in_isconnected'),
			'social_sites_auth_dtl' => Yii::t('label_model', 'lbl_social_sites_auth_dtl'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'last_updated_at' => Yii::t('label_model', 'lbl_last_updated_at'),
			'last_accessed_at' => Yii::t('label_model', 'lbl_last_accessed_at'),
			'status' => Yii::t('label_model', 'lbl_status'),
			'newpassword' => Yii::t('label_model', 'lbl_newpassword'),
			'repeatpassword' => Yii::t('label_model', 'lbl_repeatpassword'),
                        'oldpassword' => Yii::t('label_model', 'lbl_oldpassword'),
			'url' => Yii::t('label_model', 'lbl_url'),
			'weburl' => Yii::t('label_model', 'lbl_weburl'),
			'url_ispublic' => Yii::t('label_model', 'lbl_url_ispublic'),
			'weburl_ispublic' => Yii::t('label_model', 'lbl_weburl_ispublic'),
			'about_me'=>Yii::t('label_model', 'lbl_about_me'),
			// Label for about us
			'payment'=>Yii::t('label_model', 'lbl_select_days'),
			'certificate'=>Yii::t('label_model', 'lbl_certificate'),
			'work_start_year'=>Yii::t('label_model', 'lbl_work_start_year'),
			'skills'=>Yii::t('label_model', 'lbl_skills'),
			'tagline'=>Yii::t('label_model', 'lbl_tagline'),
			'card_expire_month'=>Yii::t('label_model', 'lbl_card_expire_month'),
			'card_number'=>Yii::t('label_model', 'lbl_card_number'),
			'card_name'=>Yii::t('label_model', 'lbl_card_name'),
			//label for setting
			'contactbychat'=>Yii::t('label_model', 'lbl_contactbychat'),
			'contactbyemail'=>Yii::t('label_model', 'lbl_contactbyemail'),
			'contactbyphone'=>Yii::t('label_model', 'lbl_contactbyphone'),
			'all_days'=>Yii::t('label_model', 'lbl_all_days'),
			'select_days'=>Yii::t('label_model', 'lbl_select_days'),
			
			'mobile'=>Yii::t('label_model', 'lbl_mobile'),
			'sun'=>Yii::t('label_model', 'lbl_sun'),
			'mon'=>Yii::t('label_model', 'lbl_mon'),
			'tue'=>Yii::t('label_model', 'lbl_tue'),
			'wed'=>Yii::t('label_model', 'lbl_wed'),
			'thu'=>Yii::t('label_model', 'lbl_thu'),
			'fri'=>Yii::t('label_model', 'lbl_fri'),
			'sat'=>Yii::t('label_model', 'lbl_sat'),
      
        
		);
	}
    
	public function getGenderOptions() {
                return array(
                        "M"=>'Male',
                        "F"=>'Female',
                );
        }
	    
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($adminuser = true)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('usercontact');
		
		$criteria->compare('usercontact.'.Globals::FLD_NAME_CONTACT_ID,$this->{Globals::FLD_NAME_EMAIL},true);
                $criteria->compare('t.'.Globals::FLD_NAME_USER_ID,$this->{Globals::FLD_NAME_USER_ID});
		$criteria->compare('usercontact.'.Globals::FLD_NAME_CONTACT_TYPE, Globals::DEFAULT_VAL_CONTACT_TYPE);
		$criteria->compare('usercontact.'.Globals::FLD_NAME_IS_PRIMARY,Globals::DEFAULT_VAL_CONTACT_IS_PRIMARY);
                
                $criteria->compare('t.'.Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS});
                if($adminuser==false)
                {
                    $criteria->compare('t.'.Globals::FLD_NAME_USER_TYPE , Globals::DEFAULT_VAL_USER_TYPE_GENERAL);
                }
                else
                {
                    $criteria->compare('t.'.Globals::FLD_NAME_USER_TYPE , Globals::DEFAULT_VAL_USER_TYPE_ADMIN);
                }
		$criteria->compare('t.'.Globals::FLD_NAME_USER_ROLE_ID,$this->user_roleid);
                if(Yii::app()->user->id != Yii::app()->params['superAdminId'] )
		{
			$criteria->compare(Globals::FLD_NAME_IS_ADMIN , Globals::DEFAULT_VAL_0 );
		}
		$criteria->addCondition('t.user_id!="'.Yii::app()->params['superAdminId'].'"');
                
		$criteria->compare(Globals::FLD_NAME_LOGIN_NAME,$this->{Globals::FLD_NAME_LOGIN_NAME}, true);
		$criteria->compare(Globals::FLD_NAME_FIRSTNAME,$this->{Globals::FLD_NAME_FIRSTNAME},true);                
		$criteria->compare(Globals::FLD_NAME_LASTNAME,$this->{Globals::FLD_NAME_LASTNAME},true);
//                echo '<pre>';
//                print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('userDataSession',Yii::app()->params['defaultPageSize'])
                                        	),
                    'sort'=>array(
                                            'attributes'=>array(
                                                Globals::FLD_NAME_LOGIN_NAME => array(
                                                            'asc'=>'t.'.Globals::FLD_NAME_LOGIN_NAME,
                                                            'desc'=>'t.'.Globals::FLD_NAME_LOGIN_NAME.' DESC',
                                                            ),
                                                Globals::FLD_NAME_FIRSTNAME =>array(
                                                            'asc'=>'t.'.Globals::FLD_NAME_FIRSTNAME,
                                                            'desc'=>'t.'.Globals::FLD_NAME_FIRSTNAME.' DESC',
                                                            ),
                                                Globals::FLD_NAME_CONTACT_ID =>array(
                                                            'asc'=> 'usercontact.'.Globals::FLD_NAME_CONTACT_ID,
                                                            'desc'=>'usercontact.'.Globals::FLD_NAME_CONTACT_ID.' DESC',
                                                            ),
//                                                'city_name'=>array(
//                                                            'asc'=>'citylocale.'.Globals::FLD_NAME_CITY_NAME,
//                                                            'desc'=>'citylocale.'.Globals::FLD_NAME_CITY_NAME.' DESC',
//                                                            ),
//                                                'city_priority'=>array(
//                                                            'asc'=>'citylocale.'.Globals::FLD_NAME_CITY_PRIORITY,
//                                                            'desc'=>'citylocale.'.Globals::FLD_NAME_CITY_PRIORITY.' DESC',
//                                                            ),
                                                            '*',
                                            ),
                                  'defaultOrder'=>'t.'.Globals::FLD_NAME_FIRSTNAME.' ASC',
                            ),
                                      
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function CheckUser($email,$verification_code)
        {
            //echo trim($verification_code);
            $criteria=new CDbCriteria;
            $criteria->with = array('usercontact');            
            $criteria->compare('usercontact.contact_id' , $email);
            $criteria->compare('t.verification_code', $verification_code);
            //echo CommonUtility::pre($criteria);
            $result = User::model()->find($criteria);
            return $result;
        }
        
         public static function isPremiumUser($user_id)
        {
            $isPremium = false;
            $criteria=new CDbCriteria;
            $criteria->compare('t.'.Globals::FLD_NAME_USER_ID , $user_id);
            $criteria->compare('t.'.Globals::FLD_NAME_ACCOUNT_TYPE , Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM);
            $result = User::model()->find($criteria);
            if($result)
            {
                $isPremium = true;
            }
            return $isPremium;
        }
        
        public function getTaskerList( array $filter = array() )
        {         
           $filter['sort'] = empty($filter['sort']) ? 't.'.Globals::FLD_NAME_RATING_AVG_AS_TASKER.' DESC ' : $filter['sort']; 
           $filter['limit'] = empty($filter['limit']) ? '-1' : $filter['limit'];
           $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            if(empty($filter['filterArray']))
                    $filter['filterArray'] = array(0); // for dispay 0 records
            // print_r($filter['filterArray']);
            $criteria=new CDbCriteria;
            //$criteria->with = array('userspecialityHasOne');
           
            $criteria->addCondition( "t.".Globals::FLD_NAME_USER_ID." != '".Yii::app()->user->id."'" );
            $criteria->addCondition( "t.".Globals::FLD_NAME_USER_TYPE." != '".Globals::DEFAULT_VAL_USER_TYPE_ADMIN."'" );
            $criteria->addCondition( "t.".Globals::FLD_NAME_FIRSTNAME." != ''" );
            $criteria->addCondition( "t.".Globals::FLD_NAME_STATUS." != 'n'" );
            $criteria->addCondition( "t.".Globals::FLD_NAME_IS_VERIFIED." != '0'" );
           
             
            if( isset($filter[Globals::FLD_NAME_QUICK_FILTER]) && ($filter[Globals::FLD_NAME_QUICK_FILTER] == Globals::FLD_NAME_PREVIOUSLY_WORKED ||$filter[Globals::FLD_NAME_QUICK_FILTER] == Globals::FLD_NAME_SELECTION_TYPE  ))
            {
                if(isset($filter['filterArray']))
                    $criteria->addInCondition('t.'.Globals::FLD_NAME_USER_ID, $filter['filterArray'] );
                    else
                    $criteria->addCondition( "t.".Globals::FLD_NAME_USER_ID." = '0'" ); // if no previous task by user view 0 tasks
            }
            if( isset($filter['sort']) && ($filter['sort'] == 'orderByIds'))
            {
                if(isset($filter['filterArray']))
                {
                    echo $userIds = implode(',', $filter['filterArray']);
                    $filter['sort'] = 'FIELD(t.'.Globals::FLD_NAME_USER_ID.' ,'.$userIds.') DESC , t.'.Globals::FLD_NAME_RATING_AVG_AS_TASKER.' DESC '; 
                }
                   
            }
            
            
            if( isset($filter[Globals::FLD_NAME_QUICK_FILTER]) && $filter[Globals::FLD_NAME_QUICK_FILTER] == Globals::FLD_NAME_BOOKMARK_SUBTYPE )
            {
                if(isset($filter['filterArray']))
                    $criteria->addInCondition('t.'.Globals::FLD_NAME_USER_ID, $filter['filterArray'] );
                    else
                    $criteria->addCondition( "t.".Globals::FLD_NAME_USER_ID." = '0'" ); // if no previous task by user view 0 tasks
            }
            if( isset($filter[Globals::FLD_NAME_QUICK_FILTER]) && $filter[Globals::FLD_NAME_QUICK_FILTER] == Globals::FLD_NAME_ACCOUNT_TYPE )
            {
                     $criteria->addCondition('t.'.Globals::FLD_NAME_ACCOUNT_TYPE.' ="'.Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM.'"' );
            }
            if( isset($filter[Globals::FLD_NAME_QUICK_FILTER]) && $filter[Globals::FLD_NAME_QUICK_FILTER] == Globals::FLD_NAME_RATING_AVG_AS_TASKER )
            {
                    $criteria->addCondition('t.'.Globals::FLD_NAME_RATING_AVG_AS_TASKER.' != ""' );
                    $filter['sort'] = "t.".Globals::FLD_NAME_RATING_AVG_AS_TASKER." DESC";
                    $filter['limit'] = Globals::DEFAULT_VAL_HIGHLY_RATED_FILTER_LIMIT;
            }
            if( isset($filter[Globals::FLD_NAME_QUICK_FILTER]) && $filter[Globals::FLD_NAME_QUICK_FILTER] == Globals::FLD_NAME_TASK_DONE_TOTAL_PRICE )
            {
                    $filter['sort'] = "t.".Globals::FLD_NAME_TASK_DONE_TOTAL_PRICE." DESC";
                    $filter['limit'] = Globals::DEFAULT_VAL_MOST_VALUED_FILTER_LIMIT;
                    
            }
            
            if( isset($filter[Globals::FLD_NAME_MOST_EXPERIENCED]) && $filter[Globals::FLD_NAME_MOST_EXPERIENCED] != "" )
            {
                
                if($filter['sort'] == 't.task_done_cnt ASC' || $filter['sort'] == 't.task_done_cnt DESC')
                {
                    $filter['sort'] = $filter['sort'];
                }
                else
                {
                    $filter['sort'] = "t.".Globals::FLD_NAME_TASK_DONE_CNT." DESC ,".$filter['sort'];
                }
            }
            if( strlen( $filter[Globals::FLD_NAME_RATING] ) > 0  ) 
            {
                $criteria->addCondition( "t.".Globals::FLD_NAME_RATING_AVG_AS_TASKER." = '".$filter[Globals::FLD_NAME_RATING]."'");

            }
            if(isset($filter['active_within']) && strlen( $filter['active_within'] ) > 0  ) 
            {
                $activeDate = date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH , strtotime("-".$filter['active_within']." days"));
                $criteria->addCondition( "t.".Globals::FLD_NAME_LAST_ACCESSED_AT." >= '".$activeDate."'");

            }
            
            if( isset($filter['completed_projects']) && strlen( $filter['completed_projects'] ) > 0  ) 
            {
               
                $criteria->addCondition( "t.".Globals::FLD_NAME_TASK_DONE_CNT." >= '".$filter['completed_projects']."'");

            }
            if(isset($filter['average_price']) &&  strlen( $filter['average_price'] ) > 0  ) 
            {
   
                $criteria->addCondition( "t.".Globals::FLD_NAME_TASK_DONE_AVG_PRICE." >= '".$filter['average_price']."'");

            }
            
            if(!empty($filter[Globals::FLD_NAME_LOCATIONS] ))
                    $criteria->addInCondition('t.'.Globals::FLD_NAME_BILLADDR_COUNTRY_CODE, $filter[Globals::FLD_NAME_LOCATIONS]);
            
            if( strlen( $filter[Globals::FLD_NAME_USER_NAME]) > 0 ) 
            {
                $taskerName = trim($filter[Globals::FLD_NAME_USER_NAME]);
                $names = explode(' ', $taskerName);
                $critName = new CDbCriteria;
                foreach ( $names as $name ) 
                {
                    $critName->addSearchCondition( "t.".Globals::FLD_NAME_FIRSTNAME, $name , true, 'OR');
                    $critName->addSearchCondition( "t.".Globals::FLD_NAME_LASTNAME, $name , true, 'OR');
                }
                $criteria->mergeWith($critName);
                $criteria->addSearchCondition( "t.for_search", $name , true, 'OR');
//                     $criteria->addSearchCondition( "user.".Globals::FLD_NAME_FIRSTNAME , $taskerName  );
            }            
            $criteria->addCondition( "t.".Globals::FLD_NAME_USER_ID." != '".Yii::app()->user->id."'" );
            $criteria->order = "FIELD(t.".Globals::FLD_NAME_ACCOUNT_TYPE.", '".Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM."') DESC ,".$filter['sort'];
            $criteria->limit = $filter['limit'];
            //$criteria->order='t.user_id desc';
           //print_r($criteria);
            if($criteria->limit > 0)
            {
                return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination' => false
                ));
            }
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                'pagination'=>array(
                                        'pageSize' => $filter['pageSize']
                                    ),
            ));
        }
        
        public function getRelatedUsersOfUser( $user_id , array $filter = array() )
        {  
            $usersArray = array(); 
            ////bookmark users
            $bookmarkUser = UserBookmark::getpotentialTaskerOfUser( $user_id );
            if($bookmarkUser)
            {
                foreach ($bookmarkUser as $user)
                {
                    $usersArray[$user->{Globals::FLD_NAME_BOOKMARK_USER_ID}] =  CommonUtility::getUserFullName($user->{Globals::FLD_NAME_BOOKMARK_USER_ID} , true);
                }
            }
            //// previously worked for users
            $hiredForUser = TaskTasker::taskerPreviouslyWorkedTasks($user_id);
            if($hiredForUser)
            {
                foreach ($hiredForUser as $user)
                {
                    $usersArray[$user->task->{Globals::FLD_NAME_CREATER_USER_ID}] =  CommonUtility::getUserFullName($user->task->{Globals::FLD_NAME_CREATER_USER_ID} , true);
                }
            }
            //// invited users
            $invitedUser =  TaskTasker::getInvitedTaskersByUser($user_id);
            if($invitedUser)
            {
                foreach ($invitedUser as $user)
                {
                    $usersArray[$user->{Globals::FLD_NAME_TASKER_ID}] =  CommonUtility::getUserFullName($user->{Globals::FLD_NAME_TASKER_ID} , true );
                }
            }
            //// hired by users
            $hiredUser =  TaskTasker::getTaskerHiredByUser($user_id);
            if($hiredUser)
            {
                foreach ($hiredUser as $user)
                {
                    $usersArray[$user->{Globals::FLD_NAME_TASKER_ID}] =  CommonUtility::getUserFullName($user->{Globals::FLD_NAME_TASKER_ID} , true);
                }
            }
            return $usersArray;

        }
        
        
        public function validatePhoneNumber($phone)
        {
            echo 'test';exit;
            Yii::setPathOfAlias('libphonenumber',Yii::getPathOfAlias('application.extensions.libphonenumber'));
 
            $phonenumber=new libphonenumber\LibPhone($phone);

            /**
            * Checking the number is valid or not  
            *
            * @return boolean
            */
            $phonenumber->validate();   //return true if valid

            //to convert to international format
            $phonenumber->toInternational();

            //to get national format
            $phonenumber->toNational();

            //to get E164 format
            $phonenumber->toE164();

            /*to get out of country calling number format
            *need to pass the region value
            */
            $phonenumber->toOutOfCountryCallingNumber($region);
            echo $phonenumber;exit;
        }
        
        public function getUserByIdAndPassword($user_id,$password)
        {
            $password = md5($password.Yii::app()->params["salt"]);
            $user = User::model()->findByAttributes(array('user_id' => $user_id,'password' => $password));
            return $user;
        }
        
        public function getUserByEmailForApi($email)
        {
            $user = User::model()->with('usercontact')->find('usercontact.contact_id = "'.$email.'"');
            return $user;
        }
        
        
}