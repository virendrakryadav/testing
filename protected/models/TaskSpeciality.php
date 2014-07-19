<?php

/**
 * This is the model class for table "{{dat_task_speciality}}".
 *
 * The followings are the available columns in table '{{dat_task_speciality}}':
 * @property string $task_id
 * @property integer $speciality_id
 * @property integer $is_required
 * @property integer $required_rank
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $status
 */
class TaskSpeciality extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_speciality}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('speciality_id, created_at, created_by, updated_at, updated_by', 'required'),
			array('speciality_id, is_required, required_rank, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('task_id, speciality_id, is_required, required_rank, created_at, created_by, updated_at, updated_by, status', 'safe', 'on'=>'search'),
                        
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
			'speciality_id' => Yii::t('label_model', 'lbl_speciality_id'),
			'is_required' => Yii::t('label_model', 'lbl_is_required'),
			'required_rank' => Yii::t('label_model', 'lbl_required_rank'),
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
		$criteria->compare(Globals::FLD_NAME_SPECIALITY_ID,$this->{Globals::FLD_NAME_SPECIALITY_ID});
		$criteria->compare(Globals::FLD_NAME_IS_REQUIRED,$this->{Globals::FLD_NAME_IS_REQUIRED});
		$criteria->compare(Globals::FLD_NAME_REQUIRED_RANK,$this->{Globals::FLD_NAME_REQUIRED_RANK});
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
	 * @return TaskSpeciality the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
