<?php

/**
 * This is the model class for table "{{dta_user_contact}}".
 *
 * The followings are the available columns in table '{{dta_user_contact}}':
 * @property string $contact_id
 * @property string $contact_type
 * @property string $media_type
 * @property string $user_id
 * @property string $is_primary
 * @property integer $is_login_allowed
 * @property string $created_at
 * @property string $last_updated_at
 * @property string $status
 */
class UserContact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_contact}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
           array('contact_id', 'required', 'on'=>'updateaccount'),   
           array('contact_id', 'unique', 'on'=>'updateaccount'),      
//			array('user_id, is_primary, created_at', 'required'),
//			array('is_login_allowed', 'numerical', 'integerOnly'=>true),
//			array('contact_id', 'length', 'max'=>250),
//			array('contact_type, media_type, status', 'length', 'max'=>1),
//			array('user_id, is_primary', 'length', 'max'=>20),
//			array('last_updated_at', 'safe'),
//			// The following rule is used by search().
//			// @todo Please remove those attributes that should not be searched.
//			array('contact_id, contact_type, media_type, user_id, is_primary, is_login_allowed, created_at, last_updated_at, status', 'safe', 'on'=>'search'),
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
                    'user' => array(self::BELONGS_TO, 'User', Globals::FLD_NAME_USER_ID),
		);
	}
       
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'contact_id' => Yii::t('label_model', 'lbl_contact_id'),
			'contact_type' => Yii::t('label_model', 'lbl_contact_type'),
			'media_type' => Yii::t('label_model', 'lbl_media_type'),
			'user_id' => Yii::t('label_model', 'lbl_user_id'),
			'is_primary' => Yii::t('label_model', 'lbl_is_primary'),
			'is_login_allowed' => Yii::t('label_model', 'lbl_is_login_allowed'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'last_updated_at' => Yii::t('label_model', 'lbl_last_updated_at'),
			'status' => Yii::t('label_model', 'lbl_status'),
		);
	}
        
        public function findByEmailWithdetail($email)
        {            
            
            $criteria = new CDbCriteria();
            $criteria->addCondition('contact_id ="'.$email.'" ');
            $cubecomment = UserContact::model()->with('user')->find($criteria);
            return $cubecomment; 
        }
        
      public function getUserPrimearyContact($id,$type)
      {
            $criteria = new CDbCriteria();
            $criteria->compare(Globals::FLD_NAME_USER_ID,$id);
            $criteria->compare(Globals::FLD_NAME_CONTACT_TYPE, $type);
            $email = UserContact::model()->findAll($criteria);
            return $email[0]->contact_id;
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

		$criteria->compare(Globals::FLD_NAME_CONTACT_ID,$this->{Globals::FLD_NAME_CONTACT_ID},true);
		$criteria->compare(Globals::FLD_NAME_CONTACT_TYPE,$this->{Globals::FLD_NAME_CONTACT_TYPE},true);
		$criteria->compare(Globals::FLD_NAME_MEDIA_TYPE,$this->{Globals::FLD_NAME_MEDIA_TYPE},true);
		$criteria->compare(Globals::FLD_NAME_USER_ID,$this->{Globals::FLD_NAME_USER_ID},true);
		$criteria->compare(Globals::FLD_NAME_IS_PRIMARY,$this->{Globals::FLD_NAME_IS_PRIMARY},true);
		$criteria->compare(Globals::FLD_NAME_IS_LOGIN_ALLOWED,$this->{Globals::FLD_NAME_IS_LOGIN_ALLOWED});
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_LAST_UPDATED_AT,$this->{Globals::FLD_NAME_LAST_UPDATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
