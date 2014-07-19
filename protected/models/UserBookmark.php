<?php

/**
 * This is the model class for table "{{dta_user_bookmark}}".
 *
 * The followings are the available columns in table '{{dta_user_bookmark}}':
 * @property string $bookmark_id
 * @property string $user_id
 * @property string $bookmark_type
 * @property string $bookmark_subtype
 * @property string $task_id
 * @property string $bookmark_user_id
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property string $source_app
 * @property string $status
 */
class UserBookmark extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_bookmark}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('bookmark_type, created_at, created_by', 'required'),
			array('user_id, task_id, bookmark_user_id, created_by, updated_by', 'length', 'max'=>20),
			array('bookmark_subtype, status', 'length', 'max'=>1),
                    array('bookmark_type, status', 'length', 'max'=>30),
                    
			array('source_app', 'length', 'max'=>10),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bookmark_id, user_id, bookmark_type, bookmark_subtype, task_id, bookmark_user_id, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
                         array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
                        array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update')
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bookmark_id' => 'Bookmark',
			'user_id' => 'Bookmark information of which user',
			'bookmark_type' => 'task, tasker, poster',
			'bookmark_subtype' => 'r = mark read, s = mark saved for later selection',
			'task_id' => 'Task',
			'bookmark_user_id' => 'Bookmark User',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
			'source_app' => 'Source App',
			'status' => 'Status',
		);
	}
         public function isBookMarkByUser(array $findattributes = array())
         {
             $isbookmark = false;
             $bookmark = self::model()->findByAttributes($findattributes);
             if($bookmark)
             {
                 $isbookmark = true;
             }
             return $isbookmark;
         }
         public function getpotentialTaskOfUser( $user_id = ''  )
         {
                $user_id = empty($user_id) ? Yii::app()->user->id : $user_id;
                $criteria = new CDbCriteria;
                $criteria->compare(Globals::FLD_NAME_USER_ID,$user_id);
                $criteria->compare(Globals::FLD_NAME_BOOKMARK_TYPE,Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASK);
                $criteria->compare(Globals::FLD_NAME_BOOKMARK_SUBTYPE,Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE);
                $potentialTask = self::model()->findAll($criteria);
                return $potentialTask;
         }
         public function getpotentialTaskerOfUser( $user_id = ''  )
         {
                $user_id = empty($user_id) ? Yii::app()->user->id : $user_id;
                $criteria = new CDbCriteria;
                $criteria->compare(Globals::FLD_NAME_USER_ID,$user_id);
                $criteria->compare(Globals::FLD_NAME_BOOKMARK_TYPE,Globals::DEFAULT_VAL_BOOKMARK_TYPE_TASKER);
                $criteria->compare(Globals::FLD_NAME_BOOKMARK_SUBTYPE,Globals::DEFAULT_VAL_BOOKMARK_SUBTYPE_FAVORITE);
                $potentialTask = self::model()->findAll($criteria);
                return $potentialTask;
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

		$criteria->compare('bookmark_id',$this->bookmark_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('bookmark_type',$this->bookmark_type,true);
		$criteria->compare('bookmark_subtype',$this->bookmark_subtype,true);
		$criteria->compare('task_id',$this->task_id,true);
		$criteria->compare('bookmark_user_id',$this->bookmark_user_id,true);
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
	 * @return UserBookmark the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
