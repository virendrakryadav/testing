<?php

/**
 * This is the model class for table "{{mst_notification_locale}}".
 *
 * The followings are the available columns in table '{{mst_notification_locale}}':
 * @property integer $notification_id
 * @property string $language_code
 * @property string $description
 * @property integer $priority
 * @property string $status
 * @property string $create_at
 * @property string $created_by
 * @property string $update_at
 * @property string $updated_by
 */
class NotificationLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_notification_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notification_id, language_code, description, create_at', 'required'),
			array('notification_id, priority', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5),
			array('description', 'length', 'max'=>200),
			array('status', 'length', 'max'=>1),
			array('created_by, updated_by', 'length', 'max'=>20),
			array('update_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('notification_id, language_code, description, priority, status, create_at, created_by, update_at, updated_by', 'safe', 'on'=>'search'),
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
			'language_code' => 'Language Code',
			'description' => 'Notification desciption',
			'priority' => 'Display order',
			'status' => 'a-active d-deleted',
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
		$criteria->compare('language_code',$this->language_code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('update_at',$this->update_at,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GcMstNotificationLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
