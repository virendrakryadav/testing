<?php

/**
 * This is the model class for table "{{dat_task_reference}}".
 *
 * The followings are the available columns in table '{{dat_task_reference}}':
 * @property string $task_id
 * @property string $contact_id
 * @property string $name
 * @property string $verification_status
 * @property string $verified_on
 * @property integer $verified_by
 * @property integer $rank
 * @property integer $remarks
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $status
 */
class TaskReference extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_reference}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, ref_phone, ref_email', 'required'),
                         array('rank, remarks', 'required','on'=>'confirmTask'),
			array('verified_by, created_by, updated_by', 'numerical', 'integerOnly'=>true),
                        //array('ref_phone', 'numerical'),
                        array('ref_email', 'email','message'=>'Email is invalid'),
			array('contact_id, name', 'length', 'min'=>2,'max'=>100),
                        array('ref_email,', 'length', 'min'=>3,'max'=>100),
			array('ref_phone', 'length', 'min'=>10,'max'=>20),
                        array('remarks', 'length', 'min'=>10,'max'=>500),
			array('verification_status, status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_id, contact_id, name, verification_status, verified_on, verified_by, rank, remarks, created_at, created_by, updated_at, updated_by, status', 'safe', 'on'=>'search'),
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
			'task_id' => Yii::t('label_model', 'lbl_task_id'),
			'contact_id' => Yii::t('label_model', 'lbl_contact_id'),
			'name' => Yii::t('label_model', 'lbl_name'),
			'ref_email' => Yii::t('label_model', 'lbl_ref_email'),
			'ref_phone' => Yii::t('label_model', 'lbl_ref_phone'),
			'verification_status' => Yii::t('label_model', 'lbl_verification_status'),
			'verified_on' => Yii::t('label_model', 'lbl_verified_on'),
			'verified_by' => Yii::t('label_model', 'lbl_verified_by'),
			'rank' => Yii::t('label_model', 'lbl_rank'),
			'remarks' => Yii::t('label_model', 'lbl_remarks'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
			'status' => Yii::t('label_model', 'lbl_status'),
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

		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);
		$criteria->compare(Globals::FLD_NAME_CONTACT_ID,$this->{Globals::FLD_NAME_CONTACT_ID},true);
		$criteria->compare(Globals::FLD_NAME_NAME,$this->{Globals::FLD_NAME_NAME},true);
		$criteria->compare(Globals::FLD_NAME_VERIFICATION_STATUS,$this->{Globals::FLD_NAME_VERIFICATION_STATUS},true);
		$criteria->compare(Globals::FLD_NAME_VERIFIED_ON,$this->{Globals::FLD_NAME_VERIFIED_ON},true);
		$criteria->compare(Globals::FLD_NAME_VERIFIED_BY,$this->{Globals::FLD_NAME_VERIFIED_BY});
		$criteria->compare(Globals::FLD_NAME_RANK,$this->{Globals::FLD_NAME_RANK});
		$criteria->compare(Globals::FLD_NAME_REMARKS,$this->{Globals::FLD_NAME_REMARKS});
		$criteria->compare(Globals::FLD_NAME_CREATED_AT,$this->{Globals::FLD_NAME_CREATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_AT,$this->{Globals::FLD_NAME_UPDATED_AT},true);
		$criteria->compare(Globals::FLD_NAME_CREATED_BY,$this->{Globals::FLD_NAME_CREATED_BY});
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskReference the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
