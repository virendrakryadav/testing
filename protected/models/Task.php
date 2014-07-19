<?php

/**
 * This is the model class for table "{{dat_task}}".
 *
 * The followings are the available columns in table '{{dat_task}}':
 * @property string $task_id
 * @property string $creator_user_id
 * @property string $creator_role
 * @property integer $is_external
 * @property string $language_code
 * @property string $title
 * @property string $description
 * @property string $state
 * @property string $price
 * @property string $price_currency
 * @property integer $is_location_region
 * @property integer $location_region_id
 * @property string $location_street1
 * @property string $location_street2
 * @property string $location_country_code
 * @property integer $location_state_id
 * @property integer $location_city_id
 * @property string $location_zipcode
 * @property integer $is_public
 * @property string $bid_start_dt
 * @property string $bid_close_dt
 * @property string $tasker_user_id
 * @property string $task_finished_on
 * @property integer $rank
 * @property string $attachments
 * @property string $work_hrs
 * @property string $created_at
 * @property integer $created_bygetMyTaskList
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $status
 */
class Task extends CActiveRecord
{
    public $preferred_location_check;
    public $location_list;
    public $bid_start_today;
    public $state;
    public $creator_user_id;
    public $location_geo_area;
    public $country_code;
    public $tasker_id;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('title, description,price,task_finished_on,creator_role', 'required','on'=>'insert,update'),
                        array('task_cancel_reason', 'required','on'=>'cancelTask'),
                        array('title, description,price,task_finished_on,creator_role,ref_done_by_name,ref_done_by_email,ref_done_by_phone', 'required','on'=>'addportfolio'),
			array('ref_done_by_phone', 'match','pattern' => '/^[0-9\s]+$/','message'=>'Ref done by phone should contain numeric value','on' => 'addportfolio'),
			array('ref_done_by_name', 'match','pattern' => '/^[a-zA-Z\s]+$/','message'=>'Ref done by name should contain alphabets','on' => 'addportfolio'),
			array('ref_done_by_email', 'email','message'=>'Ref done by email is not valid','on' => 'addportfolio'),
                        array('is_external,  is_public, rank, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('state','required','on'=>'MyTaskslist'),
                        array('rank, ref_remarks', 'required','on'=>'confirmTask'),
			array('creator_user_id', 'length', 'max'=>20),
			array('creator_role, status', 'length', 'max'=>1),
			array('language_code', 'length', 'max'=>5),
			array('title', 'length', 'min'=>10,'max'=>40),
			array('description', 'length', 'min'=>10, 'max'=>4000),
			array('title,description,min_price ,max_price ,cash_required', 'filter', 'filter'=>array( $this, 'filterPostalCode' )),
			array('state', 'length', 'max'=>2),
			array('min_price ,max_price ,cash_required', 'length', 'max'=>12),
                    
                        array('max_price','compare','compareAttribute'=>'min_price','operator'=>'>=', 'allowEmpty'=>false , 'message'=>'{attribute} must be greater than "{compareAttribute}".','on'=>'virtualTask,inpersonTask'),
                      // array('max_price,min_price', 'type', 'type'=>'int'),
                    // array('price', 'numerical', 'min'=>1),
//                        array('task_finished_on', 'type', 'type'=>'datetime', 'datetimeFormat'=>'dd-MM-'),
//                        array('task_finished_on', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => Globals::DEFAULT_VAL_DATE_FORMATE_D_M_Y_SLASH),
                     //   array('tasker_in_range', 'getminValue' , 'on' => 'instantTask'),
                        array('tasker_in_range', 'numerical', 'min'=>2,'max'=>20),
                        array('price,max_price,cash_required ,min_price ', 'numerical', 'min'=>0),
                       // array('price', 'type', 'type'=>'float', 'message'=>"Price is incurrect."),
                        //array('price,min_price ,max_price,cash_required', 'match', 'pattern'=>'/^[¥£$€]?[ ]?[-]?[ ]?[0-9]*[.,]{0,1}[0-9]{0,2}[ ]?[¥£$€]?$/'),
                      //  array('work_hrs', 'numerical'),
			array('price_currency', 'length', 'max'=>3),
//			array('location_street1, location_street2', 'length', 'max'=>100),
//			array('location_country_code', 'length', 'max'=>4),
			array('attachments', 'length', 'max'=>1000),
//			array('work_hrs', 'length', 'max'=>500),

                        array('work_hrs', 'length', 'max'=>4),
                        array('work_hrs', 'numerical', 'min'=>Globals::DEFAULT_VAL_MIN_WORK_HRS , 'max'=>Globals::DEFAULT_VAL_MAX_WORK_HRS ),

			array('bid_close_dt, task_finished_on, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('title,task_id, tasker_id, country_code,location_geo_area,creator_user_id, creator_role, is_external, language_code, description, state, price, price_currency,  is_public, bid_start_dt, bid_close_dt, task_finished_on, rank, attachments, work_hrs, created_at, created_by, updated_at, updated_by, status,source_app', 'safe', 'on'=>'search,getMyTaskList'),
		
                        ///virtual task ///
                        array('title, description,end_date,bid_duration,max_price,min_price', 'required','on'=>'virtualTask'),
                        //array('start_date, end_date','date','format'=>'dd-mm-yy','on'=>'virtualTask'),
//                      array('start_date ','compare','created','operator'=>'<'),
                        array('payment_mode','radioValidate','on'=>'virtualTask,inpersonTask'),
//                         array('end_date', 'compare', 'compareAttribute'=>'start_date', 'operator'=>'>','on'=>'virtualTask'),
                       // array('end_date','compareDate','on'=>'virtualTask'),
                        //array('bid_close_dt','validateCloseDate','on'=>'virtualTask'),
                        // end virtual task//
                    
                        ///in-person task ///
                        //array('title, description,task_finished_on,tasker_in_range', 'required','on'=>'inpersonTask'),
                        array('title, description,end_date,end_time,max_price,min_price', 'required','on'=>'inpersonTask'),
                        // end in-person task//
                        
                         ///instant task ///
                        array('description,end_time,min_price', 'required','on'=>'instantTask'),
                        // end instant task//
                        array('source_app','default','value'=>Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB, 'setOnEmpty'=>false,'on'=>'insert,addportfolio,virtualTask,inpersonTask,instantTask,saveinpersontask'),
                        array('created_by','default','value'=>Yii::app()->user->getState('actionUserId'), 'setOnEmpty'=>false,'on'=>'insert,addportfolio,virtualTask,inpersonTask,instantTask'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
                        array('updated_by','default', 'value'=>Yii::app()->user->getState('actionUserId'),'on'=>'update,virtualTask,inpersonTask,instantTask,saveinpersontask')
                    );
	}
	// For Trim the string
	public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
	}
        public function radioValidate($attribute,$params)
        {
            
            if($this->{Globals::FLD_NAME_PAYMENT_MODE} == 'f')
            {      
                if($this->{Globals::FLD_NAME_PRICE} == '' || $this->{Globals::FLD_NAME_PRICE} == '0')
                {
                    $this->addError('price',$this->getAttributeLabel('price').' is required in fixed price.');
                }
            }
        }
        public function compareDate($attribute,$params)
        {
            if(isset($this->{Globals::FLD_NAME_TASK_START_DATE}) && isset($this->{Globals::FLD_NAME_TASK_END_DATE}))
            {      
                $datetime1 = date_create($this->{Globals::FLD_NAME_TASK_START_DATE});
                $datetime2 = date_create($this->{Globals::FLD_NAME_TASK_END_DATE});
                $interval = date_diff($datetime1, $datetime2);
                $difference =  $interval->format('%R%a');
                if($difference < 0 || $difference == '+0' )
                {
                    if($this->{Globals::FLD_NAME_TASK_START_DATE}!='')
                    {
                        $startDate = $this->{Globals::FLD_NAME_TASK_START_DATE};
                        $this->addError('end_date',$this->getAttributeLabel('end_date').' must be greater than "'.$startDate.'".');
                    }
                    else
                    {
                        $startDate = 'start date';
                        $this->addError('end_date',$this->getAttributeLabel('end_date').' must be greater than '.$startDate);
                    }
                }
            }
        }
        
        public function validateCloseDate($attribute,$params)
        {
            if(isset($this->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE}) && isset($this->{Globals::FLD_NAME_TASK_END_DATE}))
            {      
                $datetime1 = date_create($this->{Globals::FLD_NAME_TASK_END_DATE});
                $datetime2 = date_create($this->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE});
                $interval = date_diff($datetime1, $datetime2);
                $difference =  $interval->format('%R%a');
                if($difference > 0 || $difference == '+0' )
                {
                   // echo $difference;exit;
                    if($this->{Globals::FLD_NAME_TASK_END_DATE}!='')
                    {
                        $startDate = $this->{Globals::FLD_NAME_TASK_END_DATE};
                        $this->addError('bid_close_dt',$this->getAttributeLabel('end_date').' must be less than "'.$startDate.'".');
                    }
//                    else
//                    {
//                        $startDate = 'Bid End Date';
//                        $this->addError('bid_close_dt',$this->getAttributeLabel('end_date').' must be less than '.$startDate);
//                    }
                }
            }
        }
        
        
        public function getminValue($attribute,$params)
        {
            if(isset($this->{Globals::FLD_NAME_TASKER_IN_RANGE}) && ($this->{Globals::FLD_NAME_TASKER_IN_RANGE} != '' ))
            {      
               $task = self::getTaskById($this->{Globals::FLD_NAME_TASK_ID});
                if( $this->{Globals::FLD_NAME_TASKER_IN_RANGE} < $task[0]->{Globals::FLD_NAME_TASKER_IN_RANGE} )
                {
                    $this->addError($attribute,$this->getAttributeLabel($attribute).' must be greater than "'.$task[0]->{Globals::FLD_NAME_TASKER_IN_RANGE}.'".');
                }
            }
        }
        
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'taskReference' => array(self::BELONGS_TO, 'TaskReference', Globals::FLD_NAME_TASK_ID),
                    'taskTasker' => array(self::HAS_ONE, 'TaskTasker', array(Globals::FLD_NAME_TASK_ID => Globals::FLD_NAME_TASK_ID)),
                    'taskTaskerBelongsTo' => array(self::BELONGS_TO, 'TaskTasker', array(Globals::FLD_NAME_TASK_ID => Globals::FLD_NAME_TASK_ID)),
                    'receivedby' => array(self::BELONGS_TO, 'User', array('tasker_id' => 'user_id'), 'through'=>'taskTaskerBelongsTo'),
                    'tasklocation' => array(self::BELONGS_TO, 'TaskLocation', Globals::FLD_NAME_TASK_ID),
                    'country' => array(self::BELONGS_TO, 'CountryLocale', array('country_code' => 'country_code'), 'through'=>'tasklocation'),
                    'taskcategory' => array(self::HAS_ONE, 'TaskCategory', Globals::FLD_NAME_TASK_ID),
                    'category' => array(self::BELONGS_TO, 'Category', array(Globals::FLD_NAME_CATEGORY_ID => Globals::FLD_NAME_CATEGORY_ID), 'through'=>'taskcategory'),
                    'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', array(Globals::FLD_NAME_CATEGORY_ID => Globals::FLD_NAME_CATEGORY_ID), 'through'=>'category'),
                    'taskSkill' => array(self::HAS_MANY, 'TaskSkill', Globals::FLD_NAME_TASK_ID),
                    'taskSkillBelongs' => array(self::HAS_ONE, 'TaskSkill', Globals::FLD_NAME_TASK_ID),
                    'user' => array(self::BELONGS_TO, 'User', array(Globals::FLD_NAME_CREATER_USER_ID => Globals::FLD_NAME_USER_ID)),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'task_id' => Yii::t('label_model', 'lbl_task_id'),
			'creator_user_id' => Yii::t('label_model', 'lbl_creator_user_id'),
			'creator_role' => 'Creator Role',Yii::t('label_model', 'lbl_creator_role'),
			'is_external' => Yii::t('label_model', 'lbl_is_external'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'title' => Yii::t('label_model', 'lbl_title'),
			'description' => Yii::t('label_model', 'lbl_description'),
			'state' => Yii::t('label_model', 'lbl_state'),
			'price' => Yii::t('label_model', 'lbl_price'),
			'price_currency' => Yii::t('label_model', 'lbl_price_currency'),
			'start_date' => Yii::t('label_model', 'lbl_start_date'),
			'end_date' => Yii::t('label_model', 'lbl_end_date'),
                        'cash_required' => Yii::t('label_model', 'lbl_cash_required'),
			//'is_location_region' => 'Is Location Region',
			//'location_region_id' => 'Location Region',
//			'location_street1' => 'Location Street1',
//			'location_street2' => 'Location Street2',
//			'location_country_code' => 'Location Country Code',
//			'location_state_id' => 'Location State',
//			'location_city_id' => 'Location City',
//			'location_zipcode' => 'Location Zipcode',
			'is_public' => Yii::t('label_model', 'lbl_is_public'),
                    
                    'min_price' => Yii::t('label_model', 'lbl_min_price'),
                    'max_price' => Yii::t('label_model', 'lbl_max_price'),
                    'end_time' => Yii::t('label_model', 'lbl_end_time'),
                    'task_cancel_reason' => Yii::t('label_model', 'lbl_task_cancel_reason'),
			'bid_duration' => Yii::t('label_model', 'lbl_bid_duration'),
			'bid_start_dt' => Yii::t('label_model', 'lbl_bid_start_dt'),
			'bid_close_dt' => Yii::t('label_model', 'lbl_bid_close_dt'),
			//'tasker_user_id' => Yii::t('label_model', 'lbl_tasker_user_id'),
			'task_finished_on' => Yii::t('label_model', 'lbl_task_finished_on'),
			'rank' => Yii::t('label_model', 'lbl_rank'),
			'attachments' => Yii::t('label_model', 'lbl_attachments'),
			'work_hrs' => Yii::t('label_model', 'lbl_work_hrs'),
			'source_app' => Yii::t('label_model', 'lbl_source_app'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
			'status' => Yii::t('label_model', 'lbl_status'),
			'ref_done_by_name' => Yii::t('label_model', 'lbl_ref_done_by_name'),
			'ref_done_by_email' => Yii::t('label_model', 'lbl_ref_done_by_email'),
			'ref_done_by_phone' => Yii::t('label_model', 'lbl_ref_done_by_phone'),
			
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array(Globals::FLD_NAME_COUNTRY_SML,Globals::FLD_NAME_TASK_LOCATION_SML,Globals::DEFAULT_VAL_USER,Globals::FLD_NAME_RECEIVE_BY,"taskTaskerBelongsTo");
		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);
//		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,$this->{Globals::FLD_NAME_CREATER_USER_ID},true);
		$criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,$this->{Globals::FLD_NAME_CREATOR_ROLE},true);
		$criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,$this->{Globals::FLD_NAME_IS_EXTERNAL});
		$criteria->compare(Globals::FLD_NAME_TASK_STATE,$this->{Globals::FLD_NAME_TASK_STATE});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_TITLE,$this->{Globals::FLD_NAME_TITLE},true);
		$criteria->compare(Globals::FLD_NAME_DESCRIPTION,$this->{Globals::FLD_NAME_DESCRIPTION},true);
		$criteria->compare(Globals::FLD_NAME_TASK_STATE,$this->{Globals::FLD_NAME_TASK_STATE},true);
		$criteria->compare(Globals::FLD_NAME_PRICE,$this->{Globals::FLD_NAME_PRICE},true);
		$criteria->compare(Globals::FLD_NAME_PRICE_CURRENCY,$this->{Globals::FLD_NAME_PRICE_CURRENCY},true);
		//$criteria->compare('is_location_region',$this->{Globals::FLD_NAME_IS_LOCATION_REGION});
		//$criteria->compare('location_region_id',$this->location_region_id);
//		$criteria->compare('location_street1',$this->location_street1,true);
//		$criteria->compare('location_street2',$this->location_street2,true);
//		$criteria->compare('location_country_code',$this->location_country_code,true);
//		$criteria->compare('location_state_id',$this->location_state_id);
//		$criteria->compare('location_city_id',$this->location_city_id);
//		$criteria->compare('location_zipcode',$this->location_zipcode,true);
		$criteria->compare(Globals::FLD_NAME_IS_PUBLIC,$this->{Globals::FLD_NAME_IS_PUBLIC});
		$criteria->compare(Globals::FLD_NAME_BID_START_DATE,$this->{Globals::FLD_NAME_BID_START_DATE},true);
		$criteria->compare(Globals::FLD_NAME_TASK_BID_CLOSE_DATE,$this->{Globals::FLD_NAME_TASK_BID_CLOSE_DATE},true);
		//$criteria->compare(Globals::FLD_NAME_TASKER_USER_ID,$this->{Globals::FLD_NAME_TASKER_USER_ID},true);
		$criteria->compare(Globals::FLD_NAME_TASK_FINISHED_ON,$this->{Globals::FLD_NAME_TASK_FINISHED_ON},true);
		$criteria->compare(Globals::FLD_NAME_RANK,$this->{Globals::FLD_NAME_RANK});
		$criteria->compare(Globals::FLD_NAME_TASK_ATTACHMENTS,$this->{Globals::FLD_NAME_TASK_ATTACHMENTS},true);
		$criteria->compare(Globals::FLD_NAME_WORK_HRS,$this->{Globals::FLD_NAME_WORK_HRS},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_BY,$this->{Globals::FLD_NAME_CREATED_BY});
                $criteria->compare(Globals::DEFAULT_VAL_USER.'.'.Globals::FLD_NAME_FIRSTNAME,$this->{Globals::FLD_NAME_CREATER_USER_ID});
                $criteria->compare(Globals::FLD_NAME_TASK_LOCATION_SML.'.'.Globals::FLD_NAME_LOCATION_GEO_AREA,$this->{Globals::FLD_NAME_LOCATION_GEO_AREA});
                $criteria->compare(Globals::FLD_NAME_TASK_LOCATION_SML.'.'.Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE});
                $criteria->compare(Globals::FLD_NAME_RECEIVE_BY.'.'.Globals::FLD_NAME_FIRSTNAME,$this->{Globals::FLD_NAME_TASKER_ID});
                if(!empty($this->{Globals::FLD_NAME_TASKER_ID}))
                {
                    $criteria->compare("taskTaskerBelongsTo".'.'.Globals::FLD_NAME_TASKER_STATUS,Globals::DEFAULT_VAL_TASK_TYPE);  
                }
                
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('taskDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
		));
	}
        public function searchPostedTasks($id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                if(empty($id)) $id = Yii::app()->user->id; // for dispay active user
                @$title = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE];
                @$state = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
		$criteria=new CDbCriteria;
               
                $criteria->with = array("taskcategory");
                $criteria->compare("t.".Globals::FLD_NAME_CREATER_USER_ID,$id);
		$criteria->compare("t.".Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
                $criteria->compare(Globals::FLD_NAME_TASK_STATE,$state,true);
                $criteria->compare(Globals::FLD_NAME_TITLE,$title,true);
              
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('taskDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
		));
        }
        public function searchDoneTasks($id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                if(empty($id)) $id = Yii::app()->user->id; // for dispay active user
                @$title = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TITLE];
                 @$state = $_GET[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_STATE];
		$criteria=new CDbCriteria;
               
                $criteria->with = array("taskTasker");
                $criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,$id);
                $criteria->compare(Globals::FLD_NAME_TASK_STATE,$state,true);
		$criteria->compare("t.".Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
                $criteria->compare(Globals::FLD_NAME_TITLE,$title,true);
               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('taskDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
		));
        }
        public function getMyTaskListAsPoster($state = '' , $taskKind = '', $category_id = '' , $filterArray = '' , $skills = '', $rating = '' , $minPrice = '' , $maxPrice = '' , $minDate = '' , $maxDate = '', $sort = '' , $taskTitle = '' , $limit = '-1' , $pagination = true , $id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                $taskTitle = trim($taskTitle);
                if(empty($filterArray)) $filterArray = array(0); // for dispay 0 records
                if(empty($id)) $id = Yii::app()->user->id; // for dispay active user
              
                $sort = empty($sort) ? 't.'.Globals::FLD_NAME_TASK_ID.' DESC' : $sort;
                $skills[0] = empty($skills[0]) ? '' : $skills[0];
		$criteria=new CDbCriteria;
		$criteria->with = array('taskcategory');
		$criteria->compare("t.".Globals::FLD_NAME_CREATER_USER_ID,$id);
		$criteria->compare("t.".Globals::FLD_NAME_STATUS,  Globals::DEFAULT_VAL_A);
		//$criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,Yii::app()->user->id,false,'OR');
                if( strlen( $state ) > 0 ) 
                {
                     $criteria->addSearchCondition( Globals::FLD_NAME_TASK_STATE , $state);
                }
                if( strlen( $taskTitle ) > 0 ) 
                     $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TITLE , $taskTitle , true );
                if( strlen( $taskKind ) > 0 ) 
                {
                    if($taskKind != Globals::DEFAULT_VAL_TASK_TYPE)
                        $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TASK_KIND , $taskKind );
                }
                if( strlen( $rating ) > 0 ) 
                    $criteria->compare( "t.".Globals::FLD_NAME_RANK , $rating );
                
                 if( strlen( $minDate ) > 0 && strlen( $maxDate ) > 0  ) 
                 {
                     $criteria->addBetweenCondition("t.".Globals::FLD_NAME_CREATED_AT, $minDate, date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH ,strtotime($maxDate . "+1 days")));
                 }
                if( strlen( $minPrice ) > 0 && strlen( $maxPrice ) > 0 ) 
                    $criteria->addCondition("t.".Globals::FLD_NAME_PRICE." >= '".$minPrice."' AND t.".Globals::FLD_NAME_PRICE." <= '".$maxPrice."' ");
                
                
                if( isset( $skills ) && count( $skills ) > 0 && $skills[0] != ''  ) 
                {
                    if($filterArray)
                    $criteria->addInCondition( "t.".Globals::FLD_NAME_TASK_ID , $filterArray );
                    else
                    $criteria->addInCondition( "t.".Globals::FLD_NAME_TASK_ID , array(0) ); // if no task by skills view 0 tasks
                        
                }
                
                 if( isset( $category_id ) && strlen( $category_id ) > 0  ) 
                     $criteria->addInCondition( "taskcategory.".Globals::FLD_NAME_CATEGORY_ID , $filterArray );
	
                
//                $criteria->order = $sort;
                
//                $criteria->order = "FIELD(t.".Globals::FLD_NAME_IS_PREMIUM_TASK.", '1') DESC ,".$sort;
//                $criteria->order = " t.".Globals::FLD_NAME_CREATED_AT." DESC ,".$sort;
                $criteria->order = $sort;
                
                $criteria->limit = $limit;
                
                //print_r($criteria);
                if( $pagination == false )
                {
                    
                    return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
                  
		));
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                    'pagination' =>array(
//                        'pageSize' =>10
//                    )
                  
		));
	}
        public function getMyTaskListAsTasker($state = '' , $taskKind = '', $category_id = '' , $filterArray = '' , $skills = '', $rating = '' , $minPrice = '' , $maxPrice = '' , $minDate = '' , $maxDate = '', $sort = '' ,$taskTitle ='' , $limit = '-1' , $pagination = true  , $id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                $taskTitle = trim($taskTitle);
                if(empty($id)) $id = Yii::app()->user->id; // for dispay active user
                if(empty($filterArray)) $filterArray = array(0); // for dispay 0 records
                $sort = empty($sort) ? 'taskTasker.'.Globals::FLD_NAME_TASKER_CREATED_AT.' DESC' : $sort;
                $skills[0] = empty($skills[0]) ? '' : $skills[0];
		$criteria=new CDbCriteria;
		$criteria->with = array('taskTasker','taskcategory','user');
		//$criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,Yii::app()->user->id);
		$criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,$id,false);
                if( strlen( $state ) > 0 ) 
                {
                     $criteria->addSearchCondition( Globals::FLD_NAME_TASK_STATE , $state);
                }
                if( strlen( $taskKind ) > 0 ) 
                {
                    if($taskKind != Globals::DEFAULT_VAL_TASK_TYPE)
                        $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TASK_KIND , $taskKind );
                }
                if( strlen( $taskTitle ) > 0 ) 
                     $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TITLE , $taskTitle , true );
                if( strlen( $rating ) > 0 ) 
                    $criteria->compare( "t.".Globals::FLD_NAME_RANK , $rating );
                
                 if( strlen( $minDate ) > 0 && strlen( $maxDate ) > 0  ) 
                    $criteria->addCondition("t.".Globals::FLD_NAME_CREATED_AT." >= '".$minDate."' AND t.".Globals::FLD_NAME_CREATED_AT." <= '".$maxDate."'");
                if( strlen( $minPrice ) > 0 && strlen( $maxPrice ) > 0 ) 
                    $criteria->addCondition("t.".Globals::FLD_NAME_PRICE." >= '".$minPrice."' AND t.".Globals::FLD_NAME_PRICE." <= '".$maxPrice."' ");
                
                
                if( isset( $skills ) && count( $skills ) > 0 && $skills[0] != ''  ) 
                {
                    if($filterArray)
                    $criteria->addInCondition( "t.".Globals::FLD_NAME_TASK_ID , $filterArray );
                    else
                    $criteria->addInCondition( "t.".Globals::FLD_NAME_TASK_ID , array(0) ); // if no task by skills view 0 tasks
                        
                }
                
                 if( isset( $category_id ) && strlen( $category_id ) > 0  ) 
                $criteria->addInCondition( "taskcategory.".Globals::FLD_NAME_CATEGORY_ID , $filterArray );
//                $criteria->order = "FIELD(user.".Globals::FLD_NAME_ACCOUNT_TYPE.", '".Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM."') DESC ,".$sort;
//                $criteria->order = "FIELD(t.".Globals::FLD_NAME_IS_PREMIUM_TASK.", '1') DESC ,".$sort;
//                $criteria->order = " taskTasker.".Globals::FLD_NAME_TASKER_CREATED_AT." DESC ,".$sort;
                $criteria->order = $sort;
                $criteria->limit = $limit;
                if( $pagination == false )
                {
                    return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
                  
		));
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getMyInboxTaskListAsPoster($state = '' , $limit = '-1' , $pagination = true)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            
		$criteria=new CDbCriteria;
		$criteria->with = array('taskTasker','user');
		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,Yii::app()->user->id,false);
		//$criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,Yii::app()->user->id,false,'OR');
                if( strlen( $state ) > 0 ) 
                {
                     $criteria->addSearchCondition( Globals::FLD_NAME_TASK_STATE , $state);
                }
		
                $criteria->limit = $limit;
                if( $pagination == false )
                {
                    
                    return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
                  
		));
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  
		));
	}
      
        public function getInboxMessages($filter = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            $filter['sort'] = empty($filter['sort']) ? 't.'.Globals::FLD_NAME_MSG_ID.' DESC ' : $filter['sort']; 
            $filter['limit'] = empty($filter['limit']) ? '-1' : $filter['limit'];
            $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            $filter[Globals::FLD_NAME_TASK_STATE] = empty($filter[Globals::FLD_NAME_TASK_STATE]) ? '' : $filter[Globals::FLD_NAME_TASK_STATE];
            
                $proposedTask = TaskTasker::getTaskIdOfUserProposed(Yii::app()->user->id  );    
		$criteria= new CDbCriteria;
		//$criteria->with = array('taskTasker');
		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,Yii::app()->user->id,false);
                
                if($proposedTask != '')
                {
                    $criteria2 = new CDbCriteria;
                    $criteria2->addInCondition("t.".Globals::FLD_NAME_TASK_ID,$proposedTask);
                    if( isset( $filter[Globals::FLD_NAME_TASK_STATE] ) ) 
                    {
                         $criteria2->addSearchCondition( "t.".Globals::FLD_NAME_TASK_STATE , $filter[Globals::FLD_NAME_TASK_STATE]);
                    }
                   // $criteria2->compare("taskTasker.".Globals::FLD_NAME_SELECTION_TYPE,  Globals::DEFAULT_VAL_TASKER_SELECTION_TYPE_BID);
                    //selection_type
                    $criteria->mergeWith($criteria2 , 'OR');
                }
                
		//$criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,Yii::app()->user->id,false,'OR');
                if( isset( $filter[Globals::FLD_NAME_TASK_STATE] ) ) 
                {
                     $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TASK_STATE , $filter[Globals::FLD_NAME_TASK_STATE]);
                }
                $criteria->limit = $filter['limit'];
       // print_r($criteria);
        //exit;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                  
		));
	}
        
        public function getMyPostedTaskList( $limit = Globals::TASK_LIMIT,$state="")
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with = array('taskTasker');
		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,Yii::app()->user->id);
		//$criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,Yii::app()->user->id,false,'OR');
                
                if(!empty($state))
                {
                    $criteria->compare(Globals::FLD_NAME_TASK_STATE,$state);
                }
                
		$criteria->order = "t.".Globals::FLD_NAME_TASK_ID." DESC";
                $criteria->limit = $limit;
                $taskList = Task::model()->findAll($criteria);
                return $taskList;
	}
        
        public function userTaskList($user_id = '') //tasklist as tasker
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                if(empty($user_id)) $user_id = Yii::app()->user->id;
		$criteria=new CDbCriteria;
               
                $criteria->with('taskcategory','category','categorylocale');
                
		$criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,'t');
                $criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,$user_id);
                $criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
                
                //$criteria->limit = Globals::TASK_LIMIT;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getUserTaskList($user_id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            if(empty($user_id)) $user_id = Yii::app()->user->id;
		$criteria=new CDbCriteria;

		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,$user_id);
		$criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,'p');
                $criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
                $criteria->limit = Globals::TASK_LIMIT;
		$taskList = Task::model()->with('taskcategory','category','categorylocale')->findAll($criteria,array('order' => 't.'.Globals::FLD_NAME_TASK_ID.' DESC'));
                if($taskList)
                {
                    return $taskList;
                }
	}
        public function getUserDoneTaskList($user_id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            if(empty($user_id)) $user_id = Yii::app()->user->id;
		$criteria=new CDbCriteria;
                $criteria->compare("taskTasker.".Globals::FLD_NAME_TASKER_ID,$user_id);
		             
		$taskList = Task::model()->with('taskcategory','taskTasker')->findAll($criteria,array('order' => 't.'.Globals::FLD_NAME_TASK_ID.' DESC'));
                 return $taskList;
                
	}
        public function getTaskListAverage($locationRange,$type)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('creator_user_id',Yii::app()->user->id);
		$criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,'p');
//                $criteria->addCondition('tasklocation.location_longitude >='.$locationRange['min_lon']);
//                $criteria->addCondition('tasklocation.location_longitude <='.$locationRange['max_lon']);
//                $criteria->addCondition('tasklocation.location_latitude  >='.$locationRange['min_lat']);
//                $criteria->addCondition('tasklocation.location_latitude  <='.$locationRange['max_lat']);
//                $criteria->order = "task_id DESC";
		$taskList = Task::model()->with('tasklocation')->findAll($criteria);
                return $taskList;
	}

        public function getTaskList( $quickFilter = '' ,
                $minPrice = '' ,
                $maxPrice = '' ,
                $minDate = '' , 
                $maxDate = '' , 
                $rating = '' , 
                $taskKind = '' ,
                $taskTitle = '' ,
                $startDate = '',
                $filterArray = '' ,
                $locations = '' ,
                $category_id = '' ,
                $skills = '' ,
                $sort = '',
                $startDateArray='',
                $endDateArray = '',
                $date5toold='',
                $fielterFiend='',
                $startLimit = '',
                $endLimit = '',
                $userLicense = array(),
                $filters = array())
	{
           // print_r($skills);
                $taskTitle = trim($taskTitle);
                if(empty($filterArray))
                    $filterArray = array(0); // for dispay 0 records
                $filters[Globals::FLD_NAME_HIRED] = empty($filters[Globals::FLD_NAME_HIRED]) ? '' : $filters[Globals::FLD_NAME_HIRED];
                $filters[Globals::FLD_NAME_JOBS] = empty($filters[Globals::FLD_NAME_JOBS]) ? '' : $filters[Globals::FLD_NAME_JOBS];
             
                 $sort = empty($sort) ? 't.'.Globals::FLD_NAME_TASK_ID.' DESC' : $sort;
               
		$criteria=new CDbCriteria;
                $criteria->with = array("tasklocation","user" ,"taskcategory");
            
                
                
                if(!empty($fielterFiend))
                {                   
                    if($fielterFiend == "created_at")
                    {                                               
                        if(!empty($startDateArray))
                        {
                            $totlearray = count($startDateArray);
                            $criteria2 =new CDbCriteria;
                            for($i=0;$i<$totlearray;$i++)
                            {   
                                if(@$endDateArray[$i] == "old")
                                {
//                                   $criteria->condition( "t.created_at <= '".@$startDateArray[$i]."'");
                                    $criteria2->addCondition( "date(t.".$fielterFiend.") <= '".@$startDateArray[$i]."'",'OR');
                                }
                               else
                               {
                                    $criteria2->addBetweenCondition('date(t.'.$fielterFiend.')', @$endDateArray[$i], @$startDateArray[$i],'OR');
                               }
                            }
                            $criteria->mergeWith($criteria2 , 'AND');
                        }
                        if(!empty($date5toold))
                        {
                            $criteria->addCondition( "date(t.".$fielterFiend.") <= '".$date5toold."'" );
                        }
                        
                    }
                    if($fielterFiend == "end_date")
                    {
                        if(!empty($startDateArray))
                        {
                            $totlearray = count($startDateArray);
                            $criteria2 =new CDbCriteria;
                            for($i=0;$i<$totlearray;$i++)
                            {   
                               if(@$endDateArray[$i] == "old")
                               {
                                   $criteria2->addCondition( "date(t.".$fielterFiend.") >= '".@$startDateArray[$i]."'",'OR');
                               }
                               else
                               {
                                  $criteria2->addBetweenCondition('date(t.'.$fielterFiend.')',@$startDateArray[$i], @$endDateArray[$i] ,'OR');
                               }
                            }
                            $criteria->mergeWith($criteria2 , 'AND');
                        }
                        if(!empty($date5toold))
                        {
                            $criteria->addCondition( "date(t.".$fielterFiend.") >= '".$date5toold."'" );
                        }
                    }
                    
                }
                if(!empty($startLimit) && !empty($endLimit))
                {                   
                    $totlearray = count($startLimit);
                    $criteria3 =new CDbCriteria;
                    for($i=0;$i<$totlearray;$i++)
                    {   
                        if(@$endLimit[$i] == "abow")
                        {
                            $criteria3->addCondition( "t.proposals_cnt >= '".@$startLimit[$i]."'",'OR');
                        }
                        else
                        {
                            $criteria3->addBetweenCondition('t.proposals_cnt',@$startLimit[$i], @$endLimit[$i] ,'OR');
                        }
                    }
                    $criteria->mergeWith($criteria3 , 'AND');                       
                }
//                echo"<pre>";
//                print_r($criteria);
//                exit();
                
                if( $quickFilter == Globals::FLD_NAME_PREVIOUSLY_WORKED  ) 
                {
                    if(!empty($filterArray))
                    $criteria->addInCondition('t.'.Globals::FLD_NAME_CREATER_USER_ID, $filterArray );
                    else
                    $criteria->addCondition( "t.".Globals::FLD_NAME_CREATER_USER_ID." = '0'" ); // if no previous task by user view 0 tasks
                }
                if( $quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE ) 
                     $criteria->addInCondition('t.'.Globals::FLD_NAME_TASK_ID, $filterArray );
                if( isset( $skills ) && count( $skills ) > 0 && $skills[0] != ''  ) 
                {
                    if($filterArray)
                    $criteria->addInCondition( "t.".Globals::FLD_NAME_TASK_ID , $filterArray );
                    else
                    $criteria->addInCondition( "t.".Globals::FLD_NAME_TASK_ID , array(0) ); // if no task by skills view 0 tasks
                        
                }
                if( isset( $category_id ) && strlen( $category_id ) > 0  ) 
                     $criteria->addInCondition( "taskcategory.".Globals::FLD_NAME_CATEGORY_ID , $filterArray );
                if( $quickFilter == Globals::FLD_NAME_TASKER_IN_RANGE  ) 
                {
                    if(!empty($filterArray))
                    {
                        $criteria->addCondition('tasklocation.location_longitude >='.$filterArray[Globals::FLD_NAME_MIN_LON]);
                        $criteria->addCondition('tasklocation.location_longitude <='.$filterArray[Globals::FLD_NAME_MAX_LON]);
                        $criteria->addCondition('tasklocation.location_latitude  >='.$filterArray[Globals::FLD_NAME_MIN_LAT]);
                        $criteria->addCondition('tasklocation.location_latitude  <='.$filterArray[Globals::FLD_NAME_MAX_LAT]);
                    }
                }
                if( $quickFilter == Globals::FLD_NAME_RANK ) 
                {
//                    if(!empty($filterArray))
//                    {
//                        $criteria->addCondition('tasklocation.location_longitude >='.$filterArray[Globals::FLD_NAME_MIN_LON]);
//                        $criteria->addCondition('tasklocation.location_longitude <='.$filterArray[Globals::FLD_NAME_MAX_LON]);
//                        $criteria->addCondition('tasklocation.location_latitude  >='.$filterArray[Globals::FLD_NAME_MIN_LAT]);
//                        $criteria->addCondition('tasklocation.location_latitude  <='.$filterArray[Globals::FLD_NAME_MAX_LAT]);
//                    }
                }
                
                if( $quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE ) 
                     $criteria->addCondition('user.'.Globals::FLD_NAME_ACCOUNT_TYPE.' ="'.Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM.'"' );
                
                 if( $quickFilter == Globals::FLD_NAME_ENDING_TODAY ) 
                     $criteria->addCondition('t.'.Globals::FLD_NAME_TASK_FINISHED_ON.' ="'.date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH).'" or  t.'.Globals::FLD_NAME_TASK_END_DATE.' ="'.date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH).'"' );
                
                  if( $quickFilter == Globals::FLD_NAME_FEW_PROPOSALS ) 
                     $criteria->addCondition('t.'.Globals::FLD_NAME_PROPOSALS_CNT.' <= "'.  Globals::DEFAULT_VAL_TASK_FEW_PROPOSALS_CNT_ON_PUBLIC_SEARCH.'"' );
                  
                
                
                if( $quickFilter == Globals::FLD_NAME_PRICE ) 
                    $sort = "t.".Globals::FLD_NAME_PRICE." DESC";
                
                if( strlen( $rating ) > 0 ) 
                    $criteria->addSearchCondition( "t.".Globals::FLD_NAME_RANK , $rating );
                if( strlen( $taskKind ) > 0 ) 
                {
                    if($taskKind != Globals::DEFAULT_VAL_TASK_TYPE)
                        $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TASK_KIND , $taskKind );
                }
//                if( strlen( $taskTitle ) > 0 ) 
//                     $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TITLE , $taskTitle , true );
                
                if( strlen( $taskTitle ) > 0 ) 
                {     
                    $criteria->addSearchCondition( "t.".Globals::FLD_NAME_DESCRIPTION , $taskTitle , true );
                    $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TITLE , $taskTitle , true ,'OR');
//                    $criteria4 =new CDbCriteria;                     
//                     $criteria4->addSearchCondition( "t.".Globals::FLD_NAME_DESCRIPTION , $taskTitle , true,'OR');
//                     $criteria4->addSearchCondition( "t.".Globals::FLD_NAME_TITLE, $taskTitle , true,'OR');
//                     $criteria->mergeWith($criteria4,'AND');
                }
//                echo"<pre>";
//                print_r($criteria);
//                exit();
                
                
                if( strlen( $minDate ) > 0 && strlen( $maxDate ) > 0  ) 
                    $criteria->addCondition("date(t.".Globals::FLD_NAME_CREATED_AT.") >= '".$minDate."' AND date(t.".Globals::FLD_NAME_CREATED_AT.") <= '".$maxDate."'");
                if( strlen( $minPrice ) > 0 && strlen( $maxPrice ) > 0 ) 
                    $criteria->addCondition("date(t.".Globals::FLD_NAME_PRICE.") >= '".$minPrice."' AND date(t.".Globals::FLD_NAME_PRICE.") <= '".$maxPrice."' ");
                if($locations) 
                {
                   // $criteria->addInCondition('user.'.Globals::FLD_NAME_BILLADDR_COUNTRY_CODE, $locations);
                }
                if($filters[Globals::FLD_NAME_HIRED] != '')
                {
                    $hiredTasks = TaskTasker::getTaskerHiredByUserTaskId($filters[Globals::FLD_NAME_HIRED]);
                     $criteria->addInCondition('t.'.Globals::FLD_NAME_TASK_ID, $hiredTasks );
                }
                else if($filters[Globals::FLD_NAME_JOBS] != '')
                {
                    
                    $hiredTasks = TaskTasker::getTaskerRecentTasksTaskId($filters[Globals::FLD_NAME_HIRED]);
                     $criteria->addInCondition('t.'.Globals::FLD_NAME_TASK_ID, $hiredTasks );
                }
                else
                {
//                    $criteria->addCondition( "t.".Globals::FLD_NAME_CREATER_USER_ID." != '".Yii::app()->user->id."'" );
//                     $criteria->compare(Globals::FLD_NAME_TASK_STATE,Globals::DEFAULT_VAL_TASK_STATE_OPEN);
                     $criteria->addInCondition(Globals::FLD_NAME_TASK_STATE, array(Globals::DEFAULT_VAL_TASK_STATE_OPEN, Globals::DEFAULT_VAL_TASK_STATE_ASSIGNED));
                }
                $criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
                
                $criteria->addInCondition(Globals::FLD_NAME_TASK_KIND, $userLicense);
                
                $criteria->compare(Globals::FLD_NAME_HIRING_CLOSED,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
                $criteria->addCondition("date(t.".Globals::FLD_NAME_TASK_BID_CLOSE_DATE.") >= '".date(Globals::DEFAULT_VAL_DATE_FORMATE_Y_M_D_DASH_TIME)."'");
                
//                $criteria->compare(Globals::FLD_NAME_IS_PUBLIC,'1');
                $criteria->compare("t.".Globals::FLD_NAME_STATUS,Globals::DEFAULT_VAL_A);
//                if(isset($_POST['sort']) && $_POST['sort'] != '' )
//                        $sort = $_POST['sort'];
//                $criteria->order = "FIELD(user.".Globals::FLD_NAME_ACCOUNT_TYPE.", '".Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM."') DESC ,".$sort;
                $criteria->order = "FIELD(t.".Globals::FLD_NAME_IS_PREMIUM_TASK.", '1') DESC ,".$sort;
                
//                echo"<pre>";
//                print_r($criteria);
//                exit();
                
//                $criteria->together = true;
              // print_r($criteria);exit;
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array( 'pageSize'=>Globals::TASK_LIST_PAGE_SIZE ),
                                        ));
	}
   
        public function getTaskIsPublic($task_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
                $criteria->compare(Globals::FLD_NAME_TASK_ID,$task_id);
		$criteria->compare(Globals::FLD_NAME_IS_PUBLIC,'1');
                $taskList = Task::model()->findAll($criteria);
                if(count($taskList)>0)
                {
                    return true;
                }
                return false;
	}

        
         public static function isPremiumTask($task_id)
        {
            $criteria=new CDbCriteria;
            $criteria->compare(Globals::FLD_NAME_TASK_ID,$task_id);
            $criteria->compare(Globals::FLD_NAME_IS_PREMIUM_TASK,'1');
            $taskList = Task::model()->findAll($criteria);
            if(count($taskList)>0)
            {
                return true;
            }
            return false;
        }

        public function getUserTaskListByTypeandCategory($formType = '' , $category_id = '')
        {
            $criteria = new CDbCriteria();
            $criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,Yii::app()->user->id);
            $criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,'p');
            if(!empty($formType))
            {
               
                $criteria->compare('t.'.Globals::FLD_NAME_TASK_KIND,$formType);
            }
            if(!empty($category_id))
            {
                    $criteria->compare('category.'.Globals::FLD_NAME_CATEGORY_ID, $category_id );
            }
            $criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
            $criteria->limit = Globals::TASK_LIMIT;
            $criteria->order = "t.".Globals::FLD_NAME_TASK_ID." DESC";
            $taskList = Task::model()->with('taskcategory','category','categorylocale')->findAll($criteria);
            return $taskList;
        }
		
		
        public function getRelatedTaskListByTypeandCategory($task_type='',$data='',$task_id='',$taskSkills)
        {
				
				$criteria = new CDbCriteria();
				$criteria->with = array('taskcategory','taskSkill');
				$criteria->compare('t.'.Globals::FLD_NAME_TASK_STATE,"o");
				if(!empty($task_type))
				{
				   $criteria->compare('t.'.Globals::FLD_NAME_TASK_KIND,$task_type);
				}
				if(!empty($data['category'][Globals::FLD_NAME_CATEGORY_ID]))
				{
					$criteria->compare('taskcategory.'.Globals::FLD_NAME_CATEGORY_ID,$data['category'][Globals::FLD_NAME_CATEGORY_ID]);
				}
				if(!empty($task_id))
				{
				   $criteria->addCondition('t.'.Globals::FLD_NAME_TASK_ID.'!='.$task_id);
				}
				$criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL_NOT);
				$criteria->limit = Globals::TASK_LIMIT;
				$criteria->order = "t.".Globals::FLD_NAME_TASK_ID." DESC";
			
				$taskList = Task::model()->findAll($criteria);
				
				/*echo '<pre>';
				print_r($taskList);exit;*/
				return $taskList;
				
		}

        public function userPostList()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,Yii::app()->user->id);
                $criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,'p');
		$criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL);
               // print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function userPostedTasks()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare(Globals::FLD_NAME_CREATER_USER_ID,Yii::app()->user->id);
                $criteria->compare(Globals::FLD_NAME_CREATOR_ROLE,'t');
		$criteria->compare(Globals::FLD_NAME_IS_EXTERNAL,Globals::DEFAULT_VAL_IS_EXTERNAL);
    // print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getTaskById($id)
	{
		$task = self::getTaskByIdFromDB($id);
		return $task;
	}
        public function getTaskByIdFromDB($id)
	{
		$criteria=new CDbCriteria;
                  $criteria->compare(Globals::FLD_NAME_TASK_ID,$id);
                  $task = Task::model()->findAll($criteria);
                  if($task)
                  {
                     return $task;
                  }
	}
	public function getMaxAndMinPriceOfTask()
        {
            $criteria = new CDbCriteria();
            $criteria->order = Globals::FLD_NAME_PRICE." DESC";
            $criteria->limit = 1;
            $priceMAX = Task::model()->findAll($criteria);
            $prices["maxPrice"] = $priceMAX[0]->{Globals::FLD_NAME_PRICE};
            
            $criteria2 = new CDbCriteria();
            $criteria2->order = Globals::FLD_NAME_PRICE;
            $criteria2->limit = 1;
            $priceMIN = Task::model()->findAll($criteria2);
            $prices["minPrice"] = $priceMIN[0]->{Globals::FLD_NAME_PRICE};
            
            return $prices;
        }
	public function searchProjects($options=array())
        {
            @$searchTerm = $options['search_term'];
            @$category = $options['category'];
            $criteria = new CDbCriteria();
            
            if($searchTerm)
            {
                $criteria->compare('t.'.Globals::FLD_NAME_TITLE,$searchTerm,true);
                $criteria->compare('t.'.Globals::FLD_NAME_FOR_SEARCH,$searchTerm,true,'OR',true);
                $criteria->compare('t.'.Globals::FLD_NAME_DESCRIPTION,$searchTerm,true,'OR',true);
            }
            if($category)
            {
                $criteria->compare('taskcategory.'.Globals::FLD_NAME_CATEGORY_ID,$category);
            }
            $criteria->limit = 10;
            $task = Task::model()->with('user','taskcategory')->findAll($criteria);
            return $task;
        }
	public function getFiles($task_id , $tasker_id = '')
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		$criteria=new CDbCriteria;
                $criteria->compare(Globals::FLD_NAME_TASK_ID,$task_id);
                $task = Task::model()->find($criteria);
                $taskAttachments = array();
                $taskerAttachments = array();
                $attachments = array();
                $file_id = 0;
                if($task)
                {
                    if($task->{Globals::FLD_NAME_TASK_ATTACHMENTS})
                    {
                        $taskAttachments = CJSON::decode($task->{Globals::FLD_NAME_TASK_ATTACHMENTS});
                        foreach ($taskAttachments as $attachment)
                        {
                            $attachments[$file_id][Globals::FLD_NAME_FILE_ID] = $file_id;
                            $attachments[$file_id][Globals::FLD_NAME_TYPE] = $attachment[Globals::FLD_NAME_TYPE];
                            $attachments[$file_id][Globals::FLD_NAME_FILE] = $attachment[Globals::FLD_NAME_FILE];
                            $attachments[$file_id][Globals::FLD_NAME_UPLOAD_ON] = $attachment[Globals::FLD_NAME_UPLOAD_ON];
                            $attachments[$file_id][Globals::FLD_NAME_UPLOADED_BY] = $attachment[Globals::FLD_NAME_UPLOADED_BY];
                            $attachments[$file_id][Globals::FLD_NAME_FILESIZE] = $attachment[Globals::FLD_NAME_FILESIZE];
                            $attachments[$file_id][Globals::FLD_NAME_IS_PUBLIC] = $attachment[Globals::FLD_NAME_IS_PUBLIC];
                            $attachments[$file_id][Globals::FLD_NAME_TASK_ID] = $task_id;
                            $attachments[$file_id][Globals::FLD_NAME_TASKER_ID] = $tasker_id;
                            $attachments[$file_id][Globals::FLD_NAME_IS_POSTER] = Globals::DEFAULT_VAL_IS_POSTER_ACTIVE;
                            $attachments[$file_id][Globals::FLD_NAME_TASK_TASKER_ID] = Globals::DEFAULT_VAL_0;
                            $file_id++;
                        }
                        
                        //$taskAttachments = CJSON::decode($task->{Globals::FLD_NAME_TASK_ATTACHMENTS});
                    }
                }
               
                
                if($tasker_id != '')
                {
                    $criteria2 = new CDbCriteria;
                    $criteria2->compare(Globals::FLD_NAME_TASKER_ID,$tasker_id);
                    $criteria2->compare(Globals::FLD_NAME_TASK_ID,$task_id);
                    $taskTasker = TaskTasker::model()->find($criteria2);
                    if($taskTasker)
                    {
                        if($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS})
                        {
                            $taskerAttachments = CJSON::decode($taskTasker->{Globals::FLD_NAME_TASKER_ATTACHMENTS});
                            foreach ($taskerAttachments as $attachment)
                            {
                                $attachments[$file_id][Globals::FLD_NAME_FILE_ID] = $file_id;
                                $attachments[$file_id][Globals::FLD_NAME_TYPE] = $attachment[Globals::FLD_NAME_TYPE];
                                $attachments[$file_id][Globals::FLD_NAME_FILE] = $attachment[Globals::FLD_NAME_FILE];
                                $attachments[$file_id][Globals::FLD_NAME_UPLOAD_ON] = $attachment[Globals::FLD_NAME_UPLOAD_ON];
                                $attachments[$file_id][Globals::FLD_NAME_UPLOADED_BY] = $attachment[Globals::FLD_NAME_UPLOADED_BY];
                                $attachments[$file_id][Globals::FLD_NAME_FILESIZE] = $attachment[Globals::FLD_NAME_FILESIZE];
                                $attachments[$file_id][Globals::FLD_NAME_IS_PUBLIC] = $attachment[Globals::FLD_NAME_IS_PUBLIC];
                                $attachments[$file_id][Globals::FLD_NAME_TASK_ID] = $task_id;
                                $attachments[$file_id][Globals::FLD_NAME_TASKER_ID] = $tasker_id;
                                $attachments[$file_id][Globals::FLD_NAME_IS_POSTER] = Globals::DEFAULT_VAL_IS_POSTER_INACTIVE;
                                $attachments[$file_id][Globals::FLD_NAME_TASK_TASKER_ID] = $taskTasker->{Globals::FLD_NAME_TASK_TASKER_ID};
                                $file_id++;
                            }
                        }
                    }
                     
                }
                //$attachments = array_merge($taskAttachments , $taskerAttachments);
                return CJSON::encode($attachments);
               
	}
        
        public function getTaskAsTasker($user_id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare( "taskTasker.".Globals::FLD_NAME_TASKER_ID , $user_id );
        $taskers = Task::model()->with('taskTasker','taskcategory','category','categorylocale')->findAll($criteria);
      
        return $taskers;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Task the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
