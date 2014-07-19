<?php

/**
 * This is the model class for table "{{dta_user_notification_pref}}".
 *
 * The followings are the available columns in table '{{dta_user_notification_pref}}':
 * @property integer $notification_id
 * @property string $user_id
 * @property integer $send_email
 * @property integer $send_sms
 * @property string $create_at
 * @property string $created_by
 * @property string $update_at
 * @property string $updated_by
 */
class UserNotification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_notification_pref}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notification_id, user_id', 'required'),
			array('notification_id, send_email, send_sms', 'numerical', 'integerOnly'=>true),
			array('user_id, created_by, updated_by', 'length', 'max'=>20),
			array('update_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notification_id, user_id, send_email, send_sms, create_at, created_by, update_at, updated_by', 'safe', 'on'=>'search'),
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
                    'notification' => array(self::BELONGS_TO, 'Notification', 'notification_id'),
                    'notificationlocale' => array(self::BELONGS_TO, 'NotificationLocale', 'notification_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notification_id' => 'Notification',
			'user_id' => 'Notification preference',
			'send_email' => 'Send email for this type of notifocation',
			'send_sms' => 'Send SMS for this type of notifocation',
			'create_at' => 'Create At',
			'created_by' => 'Created By',
			'update_at' => 'Update At',
			'updated_by' => 'Updated By',
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

		$criteria->compare('notification_id',$this->notification_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('send_email',$this->send_email);
		$criteria->compare('send_sms',$this->send_sms);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('update_at',$this->update_at,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getNotificationByUserId($user_id)
        {
            $criteria=new CDbCriteria;
            $criteria->with = array('notification','notificationlocale');
            $criteria->addCondition('user_id ='.$user_id);            

            $list = UserNotification::model()->findAll($criteria);
            return $list;
        }
        
       
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
