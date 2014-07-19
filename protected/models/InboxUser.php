<?php

/**
 * This is the model class for table "{{dta_inbox_user}}".
 *
 * The followings are the available columns in table '{{dta_inbox_user}}':
 * @property string $user_id
 * @property string $msg_flow
 * @property string $msg_id
 * @property integer $is_read
 */
class InboxUser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_inbox_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('msg_flow', 'required'),
			array('is_read', 'numerical', 'integerOnly'=>true),
			array('user_id, msg_id', 'length', 'max'=>20),
			array('msg_flow', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, msg_flow, msg_id, is_read', 'safe', 'on'=>'search'),
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
                    'inbox' => array(self::BELONGS_TO, 'Inbox', array(Globals::FLD_NAME_MSG_ID => Globals::FLD_NAME_MSG_ID)),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'inbox of which user?',
			'msg_flow' => 's= means sent r= means received',
			'msg_id' => 'reference to gc_dta_inbox.msg_id',
			'is_read' => 'Is message read by the user. Set default value 1 for msg_flow=s',
		);
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
               $criteria->join = 'inner join (select from_user_id,to_user_ids, max(msg_id) as maxid from gc_dta_inbox group by  task_id, from_user_id ,to_user_ids) as b on t.msg_id = b.maxid ';
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('msg_flow',$this->msg_flow,true);
		$criteria->compare('msg_id',$this->msg_id,true);
		$criteria->compare('is_read',$this->is_read);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InboxUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
