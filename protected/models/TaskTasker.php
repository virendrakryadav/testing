<?php

/**
 * This is the model class for table "{{dta_task_tasker}}".
 *
 * The followings are the available columns in table '{{dta_task_tasker}}':
 * @property string $task_tasker_id
 * @property string $task_id
 * @property string $tasker_id
 * @property string $selection_type
 * @property string $tasker_location_longitude
 * @property string $tasker_location_latidude
 * @property string $tasker_location_geo_area
 * @property integer $tasker_in_range
 * @property string $poster_comments
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $source_app
 * @property string $status
 */
class TaskTasker extends CActiveRecord
{
    public $agree_for_expenses;
    //public $agree_for_expenses;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_tasker}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('task_id, tasker_id, selection_type, created_at, created_by, updated_at, updated_by', 'required'),
//			array('tasker_in_range, created_by, updated_by', 'numerical', 'integerOnly'=>true),
//			array('task_id, tasker_id', 'length', 'max'=>20),
//			array('selection_type, source_app', 'length', 'max'=>10),
//			array('tasker_location_longitude, tasker_location_latidude', 'length', 'max'=>30),
//			array('tasker_location_geo_area', 'length', 'max'=>100),
			
//			array('status', 'length', 'max'=>1),
                        // sendProposal//
                        array('proposed_cost,approved_cost, tasker_comments', 'required','on'=>'sendProposal'),
                        array('agree_for_expenses', 'agreeForExpenses','on'=>'sendProposal'),
                        array('proposed_cost,approved_cost', 'numerical','min'=>0),
                        array('agree_for_expenses', 'numerical' ,'integerOnly'=>true),
                        array('proposed_cost,approved_cost', 'length','max'=>7),
                        array('tasker_comments', 'length', 'max'=>Globals::DEFAULT_VAL_TASKER_POSTER_COMMENTS_LENGTH ,'min'=>10),
                       
                        // sendProposal ends//
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_tasker_id, task_id, tasker_id, selection_type, tasker_location_longitude, tasker_location_latidude, tasker_location_geo_area, tasker_in_range, poster_comments, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
                        
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert,sendProposal'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update,sendProposal'),
                        array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update,sendProposal')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
                    'user' => array(self::BELONGS_TO, 'User', 'tasker_id'),
                    'taskTaskerReceipt' => array(self::BELONGS_TO, 'TaskTaskerReceipt', Globals::FLD_NAME_TASK_TASKER_ID),
                   
		);
	}
        public function agreeForExpenses($attribute,$params)
	{
            
            if (isset($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_CASH_REQUIRED]))
            {
                if ($_POST[Globals::FLD_NAME_TASK][Globals::FLD_NAME_TASK_CASH_REQUIRED] > 0)
                {
                    if($this->{Globals::FLD_NAME_AGREE_FOR_EXPENSES} == '')
                    {
                        $this->addError($attribute, 'You must agree to expected expenses terms.');
                    }
                }
                   
            }
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
            return array(
                    'task_tasker_id' => Yii::t('label_model', 'lbl_task_tasker_id'),
                    'task_id' => Yii::t('label_model', 'lbl_task_id'),
                    'tasker_id' => Yii::t('label_model', 'lbl_tasker_id'),
                    'selection_type' => Yii::t('label_model', 'lbl_selection_type'),
                    'tasker_location_longitude' => Yii::t('label_model', 'lbl_tasker_location_longitude'),
                    'tasker_location_latidude' => Yii::t('label_model', 'lbl_tasker_location_latidude'),
                    'tasker_location_geo_area' => Yii::t('label_model', 'lbl_tasker_location_geo_area'),
                    'tasker_in_range' => Yii::t('label_model', 'lbl_tasker_in_range'),
                    'proposed_cost' => Yii::t('label_model', 'lbl_proposal_cost'),
                    'tasker_comments' => Yii::t('label_model', 'lbl_poster_comments'),
                    'created_at' => Yii::t('label_model', 'lbl_created_at'),
                    'created_by' => Yii::t('label_model', 'lbl_created_by'),
                    'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
                    'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
                    'status' => Yii::t('label_model', 'lbl_status'),
                    'source_app' => Yii::t('label_model', 'lbl_source_app'),
                    'agree_for_expenses' => Yii::t('label_model', 'lbl_agree_for_expenses'),

            );
    }
    
    public function ishired($tasker_id , $user_id)
    {  
        $data = false;
        $criteria = new CDbCriteria();
        $criteria->addCondition( "task.".Globals::FLD_NAME_CREATER_USER_ID." =:user_id");
        $criteria->addCondition("t.".Globals::FLD_NAME_TASKER_ID." ='".$tasker_id."'");
        $criteria->addCondition( "t.".Globals::FLD_NAME_SELECTION_TYPE." ='inv'");
        $criteria->params = array(':user_id' => $user_id );
        $isHired = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($isHired)>0)
        {
                $data = true;
        }
        return $data;

    }
    public function getTaskerHiredByUser($tasker_id , $user_id = '' , $filters = array())
    {  
        if(Yii::app()->user->id)
            $sessionUser = Yii::app()->user->id;
        else
            $sessionUser = 0; // for return 0 value
        $user_id = empty($user_id) ? $sessionUser: $user_id;
        $filters['limit'] = empty($filters['limit']) ? '-1': $filters['limit'];
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASKER_ID , $tasker_id );
        $criteria->compare("task.".Globals::FLD_NAME_CREATER_USER_ID , $user_id );
        $criteria->compare("t.".Globals::FLD_NAME_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
	$criteria->limit = $filters['limit'];
         $taskerHiredByUser = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($taskerHiredByUser)>0)
        {
                $data = $taskerHiredByUser;
        }
        return $data;
    }
     public function getTaskerHiredByUserTaskId( $tasker_id , $user_id = '')
    {
        $userPropesdTask = array();
        $tasks =  self::getTaskerHiredByUser($tasker_id);
        if($tasks)
        {
           foreach ( $tasks as $task)
           {
               $userPropesdTask[] = $task[Globals::FLD_NAME_TASK_ID];
           }
        }
        return $userPropesdTask;
    }
    public function getInvitedTaskersByUser( $user_id = '')
    {  
        $user_id = empty($user_id) ? Yii::app()->user->id : $user_id;
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare("task.".Globals::FLD_NAME_CREATER_USER_ID , $user_id );
        $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE , Globals::DEFAULT_VAL_INVITE );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
		//print_r($criteria);exit;
        $taskerHiredByUser = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($taskerHiredByUser)>0)
        {
                $data = $taskerHiredByUser;
        }
        return $data;
    }
      public function getInvitedTaskerForTask($task_id)
    {  
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE , Globals::DEFAULT_VAL_INVITE );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $taskerInvitedByUser = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($taskerInvitedByUser)>0)
        {
                $data = $taskerInvitedByUser;
        }
        return $data;
    }  
    public function isTaskerInvitedForTask( $task_id , $tasker_id )
    {  
        $data = false;
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->compare( "t.".Globals::FLD_NAME_TASKER_ID , $tasker_id );
       // $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE , Globals::DEFAULT_VAL_INVITE );
        $criteria->compare("t.".Globals::FLD_NAME_IS_INVITED , Globals::DEFAULT_VAL_IS_INVITED_ACTIVE );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $taskerInvitedByUser = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($taskerInvitedByUser)>0)
        {
                $data = true;
        }
        return $data;
    } 
    public function isTaskerSelectedForTask(   $task_id , $tasker_id ) // if user send proposal 
   {
        $data = false;
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->compare( "t.".Globals::FLD_NAME_TASKER_ID , $tasker_id );
       // $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE , Globals::DEFAULT_VAL_INVITE );
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_STATUS, Globals::DEFAULT_VAL_TASK_STATUS_SELECTED );
        $isTaskerSelected = TaskTasker::model()->find($criteria);
        if(count($isTaskerSelected)>0)
        {
            $data = true;
        }
        return $data;
   }
    public function getSelectedTaskerForTask($task_id)  
    {  
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $taskerInvitedByUser = TaskTasker::model()->with('user')->findAll($criteria);
        if(count($taskerInvitedByUser)>0)
        {
                $data = $taskerInvitedByUser;
        }
        return $data;
    }  
    public function getSelectedTaskerForTaskWichInvitedOrBided($task_id)  
    {  
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $taskerInvitedByUser = TaskTasker::model()->with('user')->findAll($criteria);
        if(count($taskerInvitedByUser)>0)
        {
                $data = $taskerInvitedByUser;
        }
        return $data;
    }  
    public function getActiveTaskerForTask($task_id) // invited and bided 
    {  
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $taskers = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($taskers)>0)
        {
                $data = $taskers;
        }
        return $data;
    }
    public function getAllProposalsOfTask( $task_id ,$limit = '-1' )
    {
        $criteria = new CDbCriteria();
        $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $task_id);
        $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE , Globals::DEFAULT_VAL_BID );
        $criteria->order = Globals::FLD_NAME_TASK_TASKER_ID."  DESC";
        $criteria->limit = $limit;
        $proposals = TaskTasker::model()->with('user')->findAll($criteria);
        return $proposals;
    }
//    public function getAllUsersPropsedForTask( $task_id ,$limit = '-1' )
//    {
//        $proposedUsers = self::getAllProposalsOfTask($task_id , $limit);
//        if($proposedUsers)
//        {
//            $proposedUsers
//        }
//    }
    public function getUserProposalForTask( $task_id , $user_id  )
    {
     
        $criteria = new CDbCriteria();
        $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $task_id);
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_ID , $user_id );
       // $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE,  Globals::DEFAULT_VAL_TASKER_SELECTION_TYPE_BID);
        $proposals = TaskTasker::model()->find($criteria);
        return $proposals;
    }
    
    public function getUserProposals( $user_id  )
    {
     
        $criteria = new CDbCriteria();
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_ID , $user_id );
        $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE,  Globals::DEFAULT_VAL_TASKER_SELECTION_TYPE_BID);
       //print_r($criteria);
        $proposals = TaskTasker::model()->findAll($criteria);
        return $proposals;
    }
    
    public function getTaskIdOfUserProposed( $user_id  )
    {
        $userPropesdTask = array();
        $tasks =  self::getUserProposals($user_id);
        if($tasks)
        {
           foreach ( $tasks as $task)
           {
               $userPropesdTask[] = $task[Globals::FLD_NAME_TASK_ID];
           }
        }
        return $userPropesdTask;
    }
    
    public function getProposalsByTask( $task_id , $user_id , $limit )
    {  
         $data = '';
         if( $user_id == Yii::app()->user->id )
         {
            $proposals = self::getAllProposalsOfTask( $task_id , $limit );
            if(count($proposals)>0)
            {
                $data = $proposals;
            }
         }
         elseif(!self::isUserProposed(  Yii::app()->user->id , $task_id , $user_id ))
         {
            $proposal = self::getUserProposalForTask( $task_id , Yii::app()->user->id  );
            if(count($proposal)>0)
            {
                $data = $proposal;
            }
         }
            
         return $data;
                        
   }
    public function getTaskerRecentTasks($user_id , $limit = '-1')
    {  
        $data = '';
        $criteria = new CDbCriteria();
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_ID,$user_id);
        $criteria->compare("t.".Globals::FLD_NAME_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED );
        $criteria->limit = $limit;
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $recentTasks = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($recentTasks)>0)
        {
                $data = $recentTasks;
        }
        return $data;

    }
    public function getTaskerRecentTasksTaskId( $user_id  )
    {
        $userPropesdTask = array();
        $tasks =  self::getTaskerRecentTasks($user_id);
        if($tasks)
        {
           foreach ( $tasks as $task)
           {
               $userPropesdTask[] = $task[Globals::FLD_NAME_TASK_ID];
           }
        }
        return $userPropesdTask;
    }
   public function taskerPreviouslyWorkedTasks( $tasker_id )
    {  
        $data = '';
        $criteria = new CDbCriteria();
       //$criteria->select ='t.'.Globals::FLD_NAME_TASK_TASKER_ID.', task.'.Globals::FLD_NAME_CREATER_USER_ID.' ';
        $criteria->compare("t.".Globals::FLD_NAME_TASKER_ID, $tasker_id );
        $criteria->compare("t.".Globals::FLD_NAME_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED );
      
        $recentTasks = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($recentTasks)>0)
        {
                $data = $recentTasks;
        }
        return $data;

    }
      public function prevouslyHiredTaskerByPoster( $user_id )
    {  
        $data = 0;
        $criteria = new CDbCriteria();
       //$criteria->select ='t.'.Globals::FLD_NAME_TASK_TASKER_ID.', task.'.Globals::FLD_NAME_CREATER_USER_ID.' ';
        $criteria->compare("task.".Globals::FLD_NAME_CREATER_USER_ID, $user_id );
        $criteria->compare("t.".Globals::FLD_NAME_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED );
      
        $taskers = TaskTasker::model()->with('task')->findAll($criteria);
        if(count($taskers)>0)
        {
                $data = $taskers;
        }
        return $data;

    }
    public function isUserProposed(  $user_id , $task_id , $poster )
    {  
        switch (true)
        {
            case ($user_id == $poster): 
                    $agree = 0;
                    $data = false;
                    break;
            case (Task::getTaskIsPublic($task_id) == true): 
                    $agree = 1;
                    $data = true;
                    break;
            case (self::ishired($user_id , $poster) == true): 
                    $agree = 1;
                    $data = true;
                    break;
            default: 
                    $agree = 0;
                    $data = false;
        } 
     
        if($agree==1)
        {
            if(self::isUserProposedForTask( $task_id , $user_id ) == true)
            {
                $data = false;
            }
        }
        return $data;
                        
   }
   
   public function isUserProposedForTask(   $task_id , $user_id = '' ) // if user send proposal 
   {
        $user_id = empty($user_id) ? Yii::app()->user->id : $user_id ;
        $data = false;
        $criteria = new CDbCriteria();
        $criteria->compare(Globals::FLD_NAME_TASKER_ID,$user_id);
        $criteria->compare(Globals::FLD_NAME_TASK_ID,$task_id);
        $criteria->compare(Globals::FLD_NAME_SELECTION_TYPE,Globals::DEFAULT_VAL_TASKER_SELECTION_TYPE_BID);
        $proposals = TaskTasker::model()->findAll($criteria);
        if(count($proposals)>0)
        {
            $data = true;
        }
        return $data;
   }
    public function getProposalById($id)
    {
        $taskTasker = TaskTasker::model()->findByPk($id);
        return $taskTasker;
    }
    
    public function getTaskAssignedTaskersForTask($task_id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare( "t.".Globals::FLD_NAME_TASK_ID , $task_id );
        $criteria->compare( "t.".Globals::FLD_NAME_TASKER_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED);
        $criteria->order = "t.".Globals::FLD_NAME_TASK_TASKER_ID." DESC";
        $taskers = TaskTasker::model()->with('task')->findAll($criteria);
      
        return $data;
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

		$criteria->compare(Globals::FLD_NAME_TASK_TASKER_ID,$this->{Globals::FLD_NAME_TASK_TASKER_ID},true);
		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);
		$criteria->compare(Globals::FLD_NAME_TASKER_ID,$this->{Globals::FLD_NAME_TASKER_ID},true);
		$criteria->compare(Globals::FLD_NAME_SELECTION_TYPE,$this->{Globals::FLD_NAME_SELECTION_TYPE},true);
		$criteria->compare(Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE,$this->{Globals::FLD_NAME_TASKER_LOCATION_LONGITUDE},true);
		$criteria->compare(Globals::FLD_NAME_TASKER_LOCATION_LATITUDE,$this->{Globals::FLD_NAME_TASKER_LOCATION_LATITUDE},true);
		$criteria->compare(Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA,$this->{Globals::FLD_NAME_TASKER_LOCATION_GEO_AREA},true);
		$criteria->compare(Globals::FLD_NAME_TASKER_IN_RANGE,$this->{Globals::FLD_NAME_TASKER_IN_RANGE});
		$criteria->compare(Globals::FLD_NAME_TASKER_POSTER_COMMENTS,$this->{Globals::FLD_NAME_TASKER_POSTER_COMMENTS},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_BY,$this->{Globals::FLD_NAME_CREATED_BY});
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});
		$criteria->compare(Globals::FLD_NAME_SOURCE_APP,$this->{Globals::FLD_NAME_SOURCE_APP},true);
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getProposalsOfTasks( $task_id , $quickFilter = '' , $taskerName = '' , $minPrice = '' , $maxPrice = '' , $taskerInRange = '' , $locations = '' , $rating = '' , array $values = array() ,$sort = '', $limit = Globals::DEFAULT_VAL_LIMIT , $pageSize = Globals::DEFAULT_VAL_PROPOSALS_PAGE_SIZE , $defualtSort = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                $sort = empty($sort) ? 't.'.Globals::FLD_NAME_CREATED_AT.' ASC' : $sort; 
                $values['filterArray'] = empty($values['filterArray']) ? array(0) : $values['filterArray']; // for display no value
                
                //$sort = "case when t.".Globals::FLD_NAME_TASKER_STATUS." = 's' then 1 else 2 end, t.".Globals::FLD_NAME_TASKER_STATUS." ASC";
		$criteria=new CDbCriteria;
                $criteria->with = array('user');
		$criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $task_id);
               // $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE, $task_id);
               $criteria->compare("t.".Globals::FLD_NAME_SELECTION_TYPE , Globals::DEFAULT_VAL_BID );
                if( $quickFilter == Globals::FLD_NAME_TASKER_STATUS ) 
                {
                     $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TASKER_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED);
                }
                
                if( $quickFilter == Globals::FLD_NAME_TASK_DONE_RANK ) 
                {
                    $criteria->addCondition('user.'.Globals::FLD_NAME_TASK_DONE_RANK.' !=""' );
                     $sort = "user.".Globals::FLD_NAME_TASK_DONE_RANK." DESC";
                     $limit = Globals::DEFAULT_VAL_HIGHLY_RATED_FILTER_LIMIT;
                }
                if( $quickFilter == Globals::FLD_NAME_BOOKMARK_SUBTYPE ) 
                     $criteria->addInCondition('t.'.Globals::FLD_NAME_TASKER_ID, $values['filterArray'] );
                if( $quickFilter == Globals::FLD_NAME_TASKER_PROPOSED_COST ) 
                {
                    $criteria->addCondition('t.'.Globals::FLD_NAME_TASKER_PROPOSED_COST.' !=""' );
                     $sort = "t.".Globals::FLD_NAME_TASKER_PROPOSED_COST." DESC";
                     $limit = Globals::DEFAULT_VAL_MOST_VALUED_FILTER_LIMIT;
                }
                if(isset($values[Globals::FLD_NAME_INTEREST]) && $values[Globals::FLD_NAME_INTEREST] =='' )
                {
                   $criteria->addCondition('t.'.Globals::FLD_NAME_TASKER_STATUS.' != "'.Globals::DEFAULT_VAL_TASK_STATUS_REJECTED.'"' );
                }
                
                if( $quickFilter == Globals::FLD_NAME_SELECTION_TYPE ) 
                {
                     $criteria->addSearchCondition( "t.".Globals::FLD_NAME_IS_INVITED , Globals::DEFAULT_VAL_IS_INVITED_ACTIVE );
                }
                if( $quickFilter == Globals::FLD_NAME_ACCOUNT_TYPE ) 
                     $criteria->addCondition('user.'.Globals::FLD_NAME_ACCOUNT_TYPE.' ="'.Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM.'"' );
                
                 if( $quickFilter == Globals::FLD_NAME_TASK_DONE_CNT ) 
                 {
                    $sort = "user.".Globals::FLD_NAME_TASK_DONE_CNT." DESC";
                    $limit = Globals::DEFAULT_VAL_MOST_VALUED_FILTER_LIMIT;
                 }
                     //$criteria->addCondition('t.'.Globals::FLD_NAME_TASK_DONE_CNT.' ="'.Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM.'"' );
              
                if( strlen( $taskerName ) > 0 ) 
                {
                    $taskerName = trim($taskerName);
                    $names = explode(' ', $taskerName);
                    $critName = new CDbCriteria;
                    foreach ( $names as $name ) 
                    {
                        $critName->addSearchCondition( "user.".Globals::FLD_NAME_FIRSTNAME, $name , true, 'OR');
                        $critName->addSearchCondition( "user.".Globals::FLD_NAME_LASTNAME, $name , true, 'OR');
                    }
                    $criteria->mergeWith($critName);
//                     $criteria->addSearchCondition( "user.".Globals::FLD_NAME_FIRSTNAME , $taskerName  );
                }
                if(!empty($locations)) 
                {
                  //$locations =  array_values($locations);
                   
                    
                    $criteria->addInCondition('user.'.Globals::FLD_NAME_BILLADDR_COUNTRY_CODE, $locations);
                }
                
                if( strlen( $minPrice ) > 0 && strlen( $maxPrice ) > 0 ) 
                {
                    $criteria->addCondition("t.".Globals::FLD_NAME_TASKER_PROPOSED_COST." >= '".$minPrice."' AND t.".Globals::FLD_NAME_TASKER_PROPOSED_COST." <= '".$maxPrice."' ");
               
                }
                if( strlen( $rating ) > 0  ) 
                {
                    $criteria->addCondition( "user.".Globals::FLD_NAME_TASK_DONE_RANK." = '".$rating."'");
               
                }
                if( $taskerInRange  ) 
                {
                   // echo $taskerInRange;
                    $criteria->addCondition( "t.".Globals::FLD_NAME_TASKER_IN_RANGE." <= '".$taskerInRange."'");
                    // $criteria->addSearchCondition( "t.".Globals::FLD_NAME_TASKER_IN_RANGE , $taskerInRange );
                    
                }
              //  $criteria->order = Globals::FLD_NAME_TASK_TASKER_ID."  DESC";
//             
//                if($defualtSort == false)
//                {
////                    if(isset($_POST['sort']))
////                            $sort = $_POST['sort'];
//                }
                $criteria->order = "FIELD(user.".Globals::FLD_NAME_ACCOUNT_TYPE.", '".Globals::DEFAULT_VAL_ACCOUNT_TYPE_PREMIUM."') DESC ,".$sort;
                 
//                $dataProvider=new CActiveDataProvider('Item',array(
//                        'criteria'=>array('order'=>$sort)
//                        ));

                // print_r($criteria);
                if($limit > 0 )
                {
                    $criteria->limit = $limit;
                    return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
                    ));
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    
//                    'sort'=>array(
//                    'attributes'=>array(
//                         'created_at'=>array(
//                              'asc'=>'t.created_at',
//                              'desc'=>'t.created_at DESC',
//                          ),
//                        'proposed_cost'=>array(
//                              'asc'=>'t.proposed_cost',
//                              'desc'=>'t.proposed_cost DESC',
//                          ),
//                        'tasker_in_range'=>array(
//                              'asc'=>'t.tasker_in_range',
//                              'desc'=>'t.tasker_in_range DESC',
//                          ),
//                     ),
//                        
//                 ),
                   'pagination'=>array('pageSize' => $pageSize,),
                 //    'currentPage'=>5
		));
	}
        public function getMaxAndMinPriceOfProposalsForTask( $task_id )
        {
            $criteria = new CDbCriteria();
            $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $task_id);
            $criteria->order = Globals::FLD_NAME_TASKER_PROPOSED_COST." DESC";
            $criteria->limit = 1;
            $priceMAX = TaskTasker::model()->find($criteria);
            $prices[Globals::FLD_NAME_MAXPRICE] = $priceMAX[Globals::FLD_NAME_TASKER_PROPOSED_COST];
            
            $criteria2 = new CDbCriteria();
            $criteria2->compare("t.".Globals::FLD_NAME_TASK_ID , $task_id);
            $criteria2->order = Globals::FLD_NAME_TASKER_PROPOSED_COST;
            $criteria2->limit = 1;
            $priceMIN = TaskTasker::model()->find($criteria2);
            $prices[Globals::FLD_NAME_MINPRICE] = $priceMIN[Globals::FLD_NAME_TASKER_PROPOSED_COST];
            $prices[Globals::FLD_NAME_MAXPRICE] = ($prices[Globals::FLD_NAME_MAXPRICE] == '') ? 0 : $prices[Globals::FLD_NAME_MAXPRICE];
            return $prices;
        }
        public function getReviewsOfTasker($tasker_id , $filters = array())
        {
            $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            $criteria = new CDbCriteria();
             $criteria->with = array('task');
            $criteria->compare( "t.".Globals::FLD_NAME_TASKER_ID , $tasker_id );
           // $criteria->compare( "t.".Globals::FLD_NAME_TASKER_STATUS , Globals::DEFAULT_VAL_TASK_STATUS_SELECTED);
            
            $criteria->addCondition( "t.".Globals::FLD_NAME_TASKER_COMMENTS." != ''");
            $criteria->order = "t.".Globals::FLD_NAME_TASKER_REVIEW_DT." DESC";
            //print_r($criteria);
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
    
                   'pagination'=>array('pageSize' => $filter['pageSize'],),
                     //'currentPage'=>10
		));

            //return $data;
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskTasker the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
