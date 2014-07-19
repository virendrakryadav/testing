<?php

/**
 * This is the model class for table "{{dta_user_alert}}".
 *
 * The followings are the available columns in table '{{dta_user_alert}}':
 * @property string $alert_id
 * @property string $alert_type
 * @property string $alert_desc
 * @property string $for_user_id
 * @property string $by_user_id
 * @property string $task_tasker_id
 * @property integer $is_seen
 * @property string $seen_at
 * @property string $seen_from_source_app
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property string $source_app
 * @property string $status
 */
class UserAlert extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_alert}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//			array('alert_type, for_user_id, seen_at, created_at, created_by, updated_by', 'required'),
//			array('is_seen', 'numerical', 'integerOnly'=>true),
//			array('alert_type, for_user_id, by_user_id, task_tasker_id, created_by, updated_by', 'length', 'max'=>20),
//			array('alert_desc', 'length', 'max'=>100),
//			array('seen_from_source_app, source_app', 'length', 'max'=>10),
//			array('status', 'length', 'max'=>1),
//			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alert_id, alert_type, alert_desc, for_user_id, by_user_id, task_tasker_id, is_seen, seen_at, seen_from_source_app, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
                            
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
                        array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update'),
                        array('seen_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'seentrue'),
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
                    'userforuser' => array(self::BELONGS_TO, 'User', Globals::FLD_NAME_FOR_USER_ID ),
                    'userbyuser' => array(self::BELONGS_TO, 'User', Globals::FLD_NAME_BY_USER_ID ),
                    'tasktasker' => array(self::BELONGS_TO, 'TaskTasker', Globals::FLD_NAME_TASK_TASKER_ID ),
                    'task' => array(self::BELONGS_TO, 'Task',array(Globals::FLD_NAME_TASK_ID => Globals::FLD_NAME_TASK_ID), 'through'=>'tasktasker'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alert_id' => 'Alert',
			'alert_type' => 'Alert Type',
			'alert_desc' => 'if required to set description of an alert, otherwise, based on alert_type, desc can be generated',
			'for_user_id' => 'alter is for which user',
			'by_user_id' => 'alert caused by some user like viewed for_user_id profile  ',
			'task_tasker_id' => 'can be available, if alert is related to task such as bid received, task invitation, task allocation, task_rejection, profile viewed by etc',
			'is_seen' => 'false means \'for_user_id\' has not seen the alert yet',
			'seen_at' => 'when \'for_user_id\' has seen the alert?',
			'seen_from_source_app' => 'from where \'for_user_id\' has seen it',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
			'source_app' => 'Source App',
			'status' => 'Status',
		);
	}
        public function getAllNotification($sort = '')
	{
		$criteria=new CDbCriteria;
                $sort = empty($sort) ? 't.created_at DESC' : $sort;
                $criteria->with = array('userforuser','userbyuser','tasktasker','task');
		$criteria->compare(Globals::FLD_NAME_FOR_USER_ID,Yii::app()->user->id);
                $criteria->addCondition(Globals::FLD_NAME_BY_USER_ID.' !='.Yii::app()->user->id); 
//		$criteria->compare(Globals::FLD_NAME_ALERT_TYPE,Globals::ALERT_TYPE_INSTANT);
//                $criteria->limit = Globals::TASK_LIMIT;
//                $criteria->group = "t.created_at DESC";
//                $criteria->order = "t.alert_id DESC";
                $criteria->order = $sort;
//                echo"<pre>";
//                print_r($criteria);
//                exit;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getInstantTaskNotification()
	{
		$criteria=new CDbCriteria;
                $criteria->with = array('userforuser','userbyuser','tasktasker','task');
		$criteria->compare(Globals::FLD_NAME_FOR_USER_ID,Yii::app()->user->id);
		$criteria->compare(Globals::FLD_NAME_ALERT_TYPE,Globals::ALERT_TYPE_INSTANT);
//                $criteria->limit = Globals::TASK_LIMIT;
//                $criteria->order = "t.task_id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getVirtualTaskNotification()
	{
		$criteria=new CDbCriteria;
                $criteria->with = array('userforuser','userbyuser','tasktasker','task');
		$criteria->compare(Globals::FLD_NAME_FOR_USER_ID,Yii::app()->user->id);
		$criteria->compare(Globals::FLD_NAME_ALERT_TYPE,Globals::ALERT_TYPE_VIRTUAL);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function getInpersonTaskNotification()
	{
		$criteria=new CDbCriteria;
                $criteria->with = array('userforuser','userbyuser','tasktasker','task');
		$criteria->compare(Globals::FLD_NAME_FOR_USER_ID,Yii::app()->user->id);
		$criteria->compare(Globals::FLD_NAME_ALERT_TYPE,Globals::ALERT_TYPE_INPERSON);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

		$criteria->compare('alert_id',$this->alert_id,true);
		$criteria->compare('alert_type',$this->alert_type,true);
		$criteria->compare('alert_desc',$this->alert_desc,true);
		$criteria->compare('for_user_id',$this->for_user_id,true);
		$criteria->compare('by_user_id',$this->by_user_id,true);
		$criteria->compare('task_tasker_id',$this->task_tasker_id,true);
		$criteria->compare('is_seen',$this->is_seen);
		$criteria->compare('seen_at',$this->seen_at,true);
		$criteria->compare('seen_from_source_app',$this->seen_from_source_app,true);
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
        
        public function getNotificationByUserIdForPopOver($user_id)
        {
            $criteria=new CDbCriteria;
            $criteria->with = 'tasktasker';
            $criteria->addCondition(Globals::FLD_NAME_FOR_USER_ID.' ='.$user_id);  
            $criteria->addCondition(Globals::FLD_NAME_IS_SEEN.' = 0');  
//            $criteria->addCondition('tasktasker.'.Globals::FLD_NAME_TASKER_STATUS.' = "'.Globals::DEFAULT_VAL_TASK_STATUS_ACTIVE.'"');
            $criteria->order = 'alert_id DESC';
            $criteria->limit = 5;
            
            return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false
            ));
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAlert the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
