<?php

/**
 * This is the model class for table "{{dta_inbox}}".
 *
 * The followings are the available columns in table '{{dta_inbox}}':
 * @property string $msg_id
 * @property string $msg_type
 * @property string $task_id
 * @property string $from_user_id
 * @property string $to_user_ids
 * @property string $subject
 * @property string $body
 * @property string $attachments
 * @property integer $is_public
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property string $source_app
 * @property string $status
 */
class Inbox extends CActiveRecord
{
    public $agree_for_terms;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_inbox}}';
	}
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('body', 'required'),
                        array('to_user_ids', 'checkToUserIds' , 'on' => 'save_message_msg_box'),
                        array('agree_for_terms' , 'required' , 'on' => 'approve_proposal'),
			array('is_public', 'numerical', 'integerOnly'=>true),
			array('msg_type', 'length', 'max'=>30),
			array('task_id, from_user_id, created_by, updated_by', 'length', 'max'=>20),
			//array('to_user_ids', 'length', 'max'=>8000),
			array('subject', 'length', 'max'=>200),
                        array('attachments', 'length', 'max'=>8000),
			array('source_app', 'length', 'max'=>10),
			array('status', 'length', 'max'=>1),
			array('body, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('msg_id, msg_type, task_id, from_user_id, to_user_ids, subject, body, attachments, is_public, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
                        
                        array('source_app','default','value'=>Globals::DEFAULT_VAL_TASKER_SOURCE_APP_WEB, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('created_by','default','value'=>Yii::app()->user->getState('actionUserId'), 'setOnEmpty'=>false,'on'=>'insert'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
                        array('updated_by','default', 'value'=>Yii::app()->user->getState('actionUserId'),'on'=>'update')
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
                'inboxuser' => array(self::BELONGS_TO, 'InboxUser', array(Globals::FLD_NAME_MSG_ID => Globals::FLD_NAME_MSG_ID)),
                'task' => array(self::BELONGS_TO, 'Task', Globals::FLD_NAME_TASK_ID),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'msg_id' => 'Msg',
			'msg_type' => 'key for message classification such as proposal, payment, terms, feedback etc., if required',
			'task_id' => 'Task for which this message is?',
			'from_user_id' => 'inbox of which user?',
			'to_user_ids' => 'Who all users should receive it? comma separated',
			'subject' => 'Message short desc',
			'body' => 'Message',
			'attachments' => 'comma separated list of upload files.',
			'is_public' => 'Is Public',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
			'source_app' => 'Source App',
			'status' => ' a= sent, s= saved as draft, d= means deleted, r= archived',
		);
	}
       
        public function checkToUserIds($attribute,$params)
        {
            if(!isset($this->{Globals::FLD_NAME_TO_USER_IDS}) || ($this->{Globals::FLD_NAME_TO_USER_IDS} == '' ))
            {      
                    $this->addError($attribute,'Please select user to send message.');
            }
           
        }
        public function getMessagesOnTask(array $filter = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            $filter['sort'] = empty($filter['sort']) ? 't.'.Globals::FLD_NAME_MSG_ID.' DESC ' : $filter['sort']; 
            $filter['limit'] = empty($filter['limit']) ? '-1' : $filter['limit'];
            $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            $filter[Globals::FLD_NAME_TASK_ID] = empty($filter[Globals::FLD_NAME_TASK_ID]) ? '0' : $filter[Globals::FLD_NAME_TASK_ID];
            $filter[Globals::FLD_NAME_MSG_TYPE] = empty($filter[Globals::FLD_NAME_MSG_TYPE]) ? '' : $filter[Globals::FLD_NAME_MSG_TYPE];
            $filter[Globals::FLD_NAME_FROM_USER_ID] = empty($filter[Globals::FLD_NAME_FROM_USER_ID]) ? '' : $filter[Globals::FLD_NAME_FROM_USER_ID];
             $filter[Globals::FLD_NAME_TO_USER_IDS] = empty($filter[Globals::FLD_NAME_TO_USER_IDS]) ? Yii::app()->user->id : $filter[Globals::FLD_NAME_TO_USER_IDS];
     
		$criteria=new CDbCriteria;
               
            $criteria->with = array("inboxuser" );
            $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
            $criteria->compare("t.".Globals::FLD_NAME_MSG_TYPE , $filter[Globals::FLD_NAME_MSG_TYPE]);
           // $criteria->compare("inboxuser.".Globals::FLD_NAME_USER_ID , Yii::app()->user->id , false , 'OR' );
            $criteria->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            if( $filter[Globals::FLD_NAME_FROM_USER_ID] != '')
            {
//                $criteria2 =new CDbCriteria;
//                $criteria2->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $filter[Globals::FLD_NAME_FROM_USER_ID]);
//               // $criteria2->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
//                $criteria2->compare("t.".Globals::FLD_NAME_FROM_USER_ID , Yii::app()->user->id , false , "OR");
//                $criteria->mergeWith($criteria2, "AND");
                
                
            $criteria2 =new CDbCriteria;
            $criteria2->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $filter[Globals::FLD_NAME_FROM_USER_ID]);
            $criteria2->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            $criteria2->addCondition("t.".Globals::FLD_NAME_FROM_USER_ID." = '".$filter[Globals::FLD_NAME_FROM_USER_ID]."' AND FIND_IN_SET('".$filter[Globals::FLD_NAME_TO_USER_IDS] ."', t.".Globals::FLD_NAME_TO_USER_IDS.")" ,"OR");
            $criteria2->addCondition("t.".Globals::FLD_NAME_FROM_USER_ID." = '". $filter[Globals::FLD_NAME_TO_USER_IDS]."' AND FIND_IN_SET('".$filter[Globals::FLD_NAME_FROM_USER_ID] ."', t.".Globals::FLD_NAME_TO_USER_IDS.")"  ,"OR");

            $criteria->mergeWith($criteria2, "AND");
            
            }
            
            
            $criteria3 =new CDbCriteria;
            $criteria3->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
            //$criteria3->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            $criteria3->compare("t.".Globals::FLD_NAME_MSG_TYPE , $filter[Globals::FLD_NAME_MSG_TYPE]);
            $criteria3->compare("t.".Globals::FLD_NAME_IS_PUBLIC , Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE, false);            //$criteria2->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $filter[Globals::FLD_NAME_CREATER_USER_ID] , false , "OR");
            $criteria->mergeWith($criteria3, "OR");
                
            
            $criteria->order = $filter['sort'];
               
          //print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                                'pageSize'=> $filter['pageSize']
                                            ),
		));
        }
        
        public function getMessagesOnTaskByTasker($user_id , array $filter = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            $filter['sort'] = empty($filter['sort']) ? 't.'.Globals::FLD_NAME_MSG_ID.' DESC ' : $filter['sort']; 
            $filter['limit'] = empty($filter['limit']) ? '-1' : $filter['limit'];
            $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            $filter[Globals::FLD_NAME_TASK_ID] = empty($filter[Globals::FLD_NAME_TASK_ID]) ? '0' : $filter[Globals::FLD_NAME_TASK_ID];
            $filter[Globals::FLD_NAME_MSG_TYPE] = empty($filter[Globals::FLD_NAME_MSG_TYPE]) ? '' : $filter[Globals::FLD_NAME_MSG_TYPE];
            $filter[Globals::FLD_NAME_CREATER_USER_ID] = empty($filter[Globals::FLD_NAME_CREATER_USER_ID]) ? '0' : $filter[Globals::FLD_NAME_CREATER_USER_ID];
            
            $criteria = new CDbCriteria;
              
            $criteria->with = array("inboxuser");
            $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
            $criteria->compare("t.".Globals::FLD_NAME_MSG_TYPE , $filter[Globals::FLD_NAME_MSG_TYPE]);
            $criteria->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
           // $criteria->compare("t.".Globals::FLD_NAME_IS_PUBLIC , Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE);
           // $criteria->compare("inboxuser.".Globals::FLD_NAME_USER_ID , $user_id , false , 'OR' );
            
            $criteria2 = new CDbCriteria;
            $criteria2->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $user_id);
            
            $criteria2->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            $criteria2->addCondition("t.".Globals::FLD_NAME_FROM_USER_ID." = '".$filter[Globals::FLD_NAME_CREATER_USER_ID]."' AND  FIND_IN_SET('".$user_id ."', t.".Globals::FLD_NAME_TO_USER_IDS.")","OR");
            $criteria->mergeWith($criteria2, "AND");
            
            $criteria3 = new CDbCriteria;
            $criteria3->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
           // $criteria3->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            $criteria3->compare("t.".Globals::FLD_NAME_MSG_TYPE , $filter[Globals::FLD_NAME_MSG_TYPE]);
            $criteria3->compare("t.".Globals::FLD_NAME_IS_PUBLIC , Globals::DEFAULT_VAL_MSG_IS_PUBLIC_ACTIVE, false);            //$criteria2->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $filter[Globals::FLD_NAME_CREATER_USER_ID] , false , "OR");
            $criteria->mergeWith($criteria3, "OR");
                
              $criteria->order = $filter['sort'];  
  //print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                                'pageSize'=> $filter['pageSize']
                                            ),
		));
                
        }
        public function getUserRecentMessages($fromUserId , array $filter = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            $filter['sort'] = empty($filter['sort']) ? 't.'.Globals::FLD_NAME_MSG_ID.' DESC ' : $filter['sort']; 
            $filter['limit'] = empty($filter['limit']) ? '-1' : $filter['limit'];
            $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            $filter[Globals::FLD_NAME_TASK_ID] = empty($filter[Globals::FLD_NAME_TASK_ID]) ? '' : $filter[Globals::FLD_NAME_TASK_ID];
            $filter[Globals::FLD_NAME_MSG_TYPE] = empty($filter[Globals::FLD_NAME_MSG_TYPE]) ? '' : $filter[Globals::FLD_NAME_MSG_TYPE];
            $filter[Globals::FLD_NAME_CREATER_USER_ID] = empty($filter[Globals::FLD_NAME_CREATER_USER_ID]) ? '0' : $filter[Globals::FLD_NAME_CREATER_USER_ID];
            $filter[Globals::FLD_NAME_TASK_STATE] = empty($filter[Globals::FLD_NAME_TASK_STATE]) ? '' : $filter[Globals::FLD_NAME_TASK_STATE];
            $filter[Globals::FLD_NAME_TITLE] = empty($filter[Globals::FLD_NAME_TITLE]) ? '' : $filter[Globals::FLD_NAME_TITLE];
            
            
            $inboxTable = Inbox::model()->tableSchema->rawName;
               $inboxUserTable = InboxUser::model()->tableSchema->rawName;
            
            
    //        select * from inbox where (task_id, creation_at) in (select task_id, max(creation_at) from inbox_user u, 
    //        inbox i  where u.msg_id = i.msg_id and user_id=? group by task_id)
                    
//            $criteria = new CDbCriteria;
//           //$criteria->select =  Globals::FLD_NAME_TASK_ID.','.Globals::FLD_NAME_CREATED_AT.' in ( select '.Globals::FLD_NAME_TASK_ID.', max('.Globals::FLD_NAME_CREATED_AT.' from ) )'
//            $criteria->with = array("inboxuser", 'task');
//            $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
//            $criteria->addCondition(" FIND_IN_SET('".$fromUserId ."', t.".Globals::FLD_NAME_TO_USER_IDS.")");
//            $criteria->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            
            
            //
//            
//            $criteria3 = new CDbCriteria;
//            $criteria3->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $fromUserId);
//            $criteria3->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
//
//            
//            $criteria3->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_SENT);
//            $criteria->mergeWith($criteria3, "OR");
            
//            $criteria->addCondition('t.'.Globals::FLD_NAME_TO_USER_IDS.' != ""');
//            if( isset( $filter[Globals::FLD_NAME_TASK_STATE] ) ) 
//            {
//                 $criteria->addSearchCondition( "task.".Globals::FLD_NAME_TASK_STATE , $filter[Globals::FLD_NAME_TASK_STATE]);
//            }
//           $criteria->group = 't.'.Globals::FLD_NAME_TO_USER_IDS.',t.'.Globals::FLD_NAME_FROM_USER_ID.',t.'.Globals::FLD_NAME_TASK_ID ;      
//            $criteria->order = $filter['sort'];  
//           /// print_r($criteria);
            
//            $criteria=new CDbCriteria();
//            $criteria->condition = '('.Globals::FLD_NAME_TASK_ID.', '.Globals::FLD_NAME_FROM_USER_ID.', '.Globals::FLD_NAME_CREATED_AT.') in ( select '.Globals::FLD_NAME_TASK_ID.', '.Globals::FLD_NAME_FROM_USER_ID.', max('.Globals::FLD_NAME_CREATED_AT.') from '.$inboxTable.' where '.Globals::FLD_NAME_TASK_ID.' in (select distinct '.Globals::FLD_NAME_TASK_ID.' from '.$inboxUserTable.' where '.Globals::FLD_NAME_USER_ID.'= :userid )';
//            $criteria->params[':userid'] = $fromUserId;
//            $this->getDbCriteria()->mergeWith($criteria);
            
//            select a.*
//            from
//            gc_dta_inbox a
//            inner join 
//            (select to_user_ids, max(msg_id) as maxid from gc_dta_inbox group by to_user_ids) as b on
//            a.msg_id = b.maxid
               
               $criteria = new CDbCriteria;
               $criteria->with = array("inboxuser", 'task');
               $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
               $criteria->addCondition(" FIND_IN_SET('".$fromUserId ."', t.".Globals::FLD_NAME_TO_USER_IDS.")");
               $criteria->join = 'inner join (select from_user_id,to_user_ids, max(msg_id) as maxid from gc_dta_inbox  group by  task_id, from_user_id ,to_user_ids) as b on t.msg_id = b.maxid ';
              // $criteria->join = 'inner join (select from_user_id,to_user_ids, max(msg_id) as maxid from gc_dta_inbox group by  task_id, from_user_id ,to_user_ids) as b on t.msg_id = b.maxid ';
		if( isset( $filter[Globals::FLD_NAME_TASK_STATE] ) ) 
                {
                     $criteria->addSearchCondition( "task.".Globals::FLD_NAME_TASK_STATE , $filter[Globals::FLD_NAME_TASK_STATE]);
                }
                if( isset( $filter[Globals::FLD_NAME_TITLE] ) ) 
                {
                     $criteria->addSearchCondition( "task.".Globals::FLD_NAME_TITLE , $filter[Globals::FLD_NAME_TITLE]);
                }
              
                
               $criteria->order = 't.msg_id DESC';
               //print_r($criteria);
               
               return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                                'pageSize'=> $filter['pageSize']
                                        ),
		));
                
                
               
//             return new CActiveDataProvider($this, array(
//    'criteria' => array(
//        'with' => array("inboxuser", 'task'),
//        'condition' =>'t.to_user_ids=:id and task.'.Globals::FLD_NAME_TASK_STATE.' = "'.$filter[Globals::FLD_NAME_TASK_STATE].'"',
//        'params' => array(':id'=>$fromUserId),
//        'order' => 't.msg_id DESC',
//        'join' => 'inner join (select from_user_id, max(msg_id) as maxid from gc_dta_inbox group by from_user_id , task_id) as b on t.msg_id = b.maxid ',
//    )
//));
                
               
//             SELECT COUNT(*) FROM `gc_dta_inbox` `t` 
//                WHERE (task_id, from_user_id, created_at) in 
//                        ( select task_id, from_user_id, max(created_at) from `gc_dta_inbox` where task_id in 
//                                (select distinct task_id from `gc_dta_inbox` where from_user_id= '316' ))
               
               
//        $sql =   'select * from '.$inboxTable.' '
//                . 'where ('.Globals::FLD_NAME_TASK_ID.', '.Globals::FLD_NAME_FROM_USER_ID.', '.Globals::FLD_NAME_CREATED_AT.')'
//                . ' in (select '.Globals::FLD_NAME_TASK_ID.', '.Globals::FLD_NAME_FROM_USER_ID.', max('.Globals::FLD_NAME_CREATED_AT.')'
//                . ' from '.$inboxTable.' where '.Globals::FLD_NAME_TASK_ID.' in '
//                . '(select distinct '.Globals::FLD_NAME_TASK_ID.' from '.$inboxUserTable.' where '.Globals::FLD_NAME_USER_ID.'= "'.$fromUserId.'")'
//                . ' group by '.Globals::FLD_NAME_TASK_ID.', '.Globals::FLD_NAME_FROM_USER_ID.')';
// 
//$rawData = Yii::app()->db->createCommand($sql); //or use ->queryAll(); in CArrayDataProvider
//$count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); //the count
// 
// 
//        return new CSqlDataProvider($rawData, array( //or $model=new CArrayDataProvider($rawData, array(... //using with querAll...
//                    //'keyField' => 'msg_id', 
//                  //  'totalItemCount' => $count,
// 
//                    //if the command above use PDO parameters
//                    //'params'=>array(
//                    //':param'=>$param,
//                    //),
// 
// 
////                    'sort' => array(
////                        'attributes' => array(
////                            'MAIN_ID','title', 'type'
////                        ),
////                        'defaultOrder' => array(
////                            'MAIN_ID' => CSort::SORT_ASC, //default sort value
////                        ),
////                    ),
//                    'pagination' => array(
//                        'pageSize' => 10,
//                    ),
//                ));
                
        }
        public function getMessagesThreadOfUser($fromUserId  , $toUserIds , array $filter = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            $filter['sort'] = empty($filter['sort']) ? 't.'.Globals::FLD_NAME_MSG_ID.' DESC ' : $filter['sort']; 
            $filter['limit'] = empty($filter['limit']) ? '-1' : $filter['limit'];
            $filter['pageSize'] = empty($filter['pageSize']) ? Yii::app()->params['defaultPageSize'] : $filter['pageSize'];
            $filter[Globals::FLD_NAME_TASK_ID] = empty($filter[Globals::FLD_NAME_TASK_ID]) ? '' : $filter[Globals::FLD_NAME_TASK_ID];
            $filter[Globals::FLD_NAME_MSG_TYPE] = empty($filter[Globals::FLD_NAME_MSG_TYPE]) ? '' : $filter[Globals::FLD_NAME_MSG_TYPE];
            $filter[Globals::FLD_NAME_CREATER_USER_ID] = empty($filter[Globals::FLD_NAME_CREATER_USER_ID]) ? '0' : $filter[Globals::FLD_NAME_CREATER_USER_ID];
            
            $criteria = new CDbCriteria;
              
          
            $criteria->with = array("inboxuser");
            $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
            $criteria->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $fromUserId);
             $criteria->compare("t.".Globals::FLD_NAME_MSG_TYPE , $filter[Globals::FLD_NAME_MSG_TYPE]);
              $criteria->compare("t.".Globals::FLD_NAME_TO_USER_IDS , $toUserIds);
            //$criteria->addCondition(" FIND_IN_SET('".$toUserIds ."', t.".Globals::FLD_NAME_TO_USER_IDS.")");
          
            $criteria->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_RECEIVED);
            $criteria->compare("inboxuser.".Globals::FLD_NAME_IS_DELETE , Globals::DEFAULT_VAL_IS_DELETE_INACTIVE);
//            
            $criteria3 = new CDbCriteria;
             $criteria3->compare("t.".Globals::FLD_NAME_TASK_ID , $filter[Globals::FLD_NAME_TASK_ID]);
            $criteria3->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $toUserIds);
            $criteria3->compare("t.".Globals::FLD_NAME_TO_USER_IDS , $fromUserId);
            //$criteria3->addCondition(" FIND_IN_SET('".$fromUserId ."', t.".Globals::FLD_NAME_TO_USER_IDS.")");
             $criteria3->compare("t.".Globals::FLD_NAME_MSG_TYPE , $filter[Globals::FLD_NAME_MSG_TYPE]);
            $criteria3->compare("inboxuser.".Globals::FLD_NAME_MSG_FLOW , Globals::DEFAULT_VAL_MSG_FLOW_SENT);
            $criteria3->compare("inboxuser.".Globals::FLD_NAME_IS_DELETE , Globals::DEFAULT_VAL_IS_DELETE_INACTIVE);
            $criteria->mergeWith($criteria3, "OR");
                
            $criteria->order = $filter['sort'];  
  //print_r($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                                'pageSize'=> $filter['pageSize']
                                            ),
		));
                
        }
        public function getHiringMsgFromPoster($taskId , $fromUserId , $toUserId)
        {
            $msgBody = '';
            $criteria = new CDbCriteria;
            $criteria->compare("t.".Globals::FLD_NAME_TASK_ID , $taskId);
            $criteria->compare("t.".Globals::FLD_NAME_FROM_USER_ID , $fromUserId);
            $criteria->compare("t.".Globals::FLD_NAME_MSG_TYPE , Globals::DEFAULT_VAL_MSG_TYPR_HIRING);
            $criteria->compare("t.".Globals::FLD_NAME_TO_USER_IDS , $toUserId);
            $message = Inbox::model()->find($criteria);
            if($message)
            {
                $msgBody = $message->{Globals::FLD_NAME_BODY};
            }
            return $msgBody;
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

		$criteria->compare('msg_id',$this->msg_id,true);
		$criteria->compare('msg_type',$this->msg_type,true);
		$criteria->compare('task_id',$this->task_id,true);
		$criteria->compare('from_user_id',$this->from_user_id,true);
		$criteria->compare('to_user_ids',$this->to_user_ids,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('attachments',$this->attachments,true);
		$criteria->compare('is_public',$this->is_public);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('source_app',$this->source_app,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inbox the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
