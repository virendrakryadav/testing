<?php

/**
 * This is the model class for table "{{dta_user_activity}}".
 *
 * The followings are the available columns in table '{{dta_user_activity}}':
 * @property string $activity_id
 * @property string $by_user_id
 * @property string $activity_type
 * @property string $activity_subtype
 * @property string $comments
 * @property string $created_at
 * @property string $source_app
 */
class UserActivity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_activity}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('by_user_id, activity_type', 'required'),
                        array('comments', 'required','on'=>'suspanded'),
			array('by_user_id, activity_type', 'length', 'max'=>20),
			array('activity_subtype', 'length', 'max'=>100),
			array('comments', 'length', 'max'=>1000),
			array('source_app', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('activity_id, by_user_id, activity_type, activity_subtype, comments, created_at, source_app', 'safe', 'on'=>'search'),
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
			'activity_id' => Yii::t('label_model', 'lbl_activity_id'),
			'by_user_id' => Yii::t('label_model', 'lbl_by_user_id'),
			'activity_type' => Yii::t('label_model', 'lbl_user_activity_type'),
			'activity_subtype' => Yii::t('label_model', 'lbl_user_activity_subtype'),
			'comments' => Yii::t('label_model', 'lbl_user_comments'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'source_app' => Yii::t('label_model', 'lbl_source_app'),
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

		$criteria->compare(Globals::FLD_NAME_ACTIVITY_ID,$this->{Globals::FLD_NAME_ACTIVITY_ID},true);
		$criteria->compare(Globals::FLD_NAME_BY_USER_ID,$this->{Globals::FLD_NAME_BY_USER_ID},true);
		$criteria->compare(Globals::FLD_NAME_ACTIVITY_TYPE,$this->{Globals::FLD_NAME_ACTIVITY_TYPE},true);
		$criteria->compare(Globals::FLD_NAME_ACTIVITY_SUBTYPE,$this->{Globals::FLD_NAME_ACTIVITY_SUBTYPE},true);
		$criteria->compare(Globals::FLD_NAME_COMMENTS,$this->{Globals::FLD_NAME_COMMENTS},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_SOURCE_APP,$this->{Globals::FLD_NAME_SOURCE_APP},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserActivity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
