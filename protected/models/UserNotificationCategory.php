<?php

/**
 * This is the model class for table "{{dta_user_notification_pref_catg}}".
 *
 * The followings are the available columns in table '{{dta_user_notification_pref_catg}}':
 * @property integer $notification_id
 * @property integer $category_id
 * @property string $user_id
 * @property integer $send_email
 * @property integer $send_sms
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 */
class UserNotificationCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_notification_pref_catg}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notification_id, category_id, user_id, created_at', 'required'),
			array('notification_id, category_id, send_email, send_sms', 'numerical', 'integerOnly'=>true),
			array('user_id, created_by, updated_by', 'length', 'max'=>20),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notification_id, category_id, user_id, send_email, send_sms, created_at, created_by, updated_at, updated_by', 'safe', 'on'=>'search'),
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
			'notification_id' => 'Notification',
			'category_id' => 'Preferred category under that if any task is posted then notify. In case user selects top category only then all sub category items are added in this table',
			'user_id' => 'Notification preference',
			'send_email' => 'Send Email',
			'send_sms' => 'Send Sms',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
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
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('send_email',$this->send_email);
		$criteria->compare('send_sms',$this->send_sms);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserNotificationCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
