<?php

/**
 * This is the model class for table "{{mst_timezone}}".
 *
 * The followings are the available columns in table '{{mst_timezone}}':
 * @property string $timezone
 * @property string $timezone_display
 * @property string $status
 */
class Timezone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_timezone}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('timezone, timezone_display', 'required'),
			array('timezone', 'length', 'max'=>50),
			array('timezone_display', 'length', 'max'=>150),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('timezone, timezone_display, status', 'safe', 'on'=>'search'),*/
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
			'timezone' => Yii::t('label_model', 'lbl_timezone'),
			'timezone_display' => Yii::t('label_model', 'lbl_timezone_display'),
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

		$criteria->compare(Globals::FLD_NAME_TIMEZONE,$this->{Globals::FLD_NAME_TIMEZONE},true);
		$criteria->compare(Globals::FLD_NAME_TIMEZONE_DISPLAY,$this->{Globals::FLD_NAME_TIMEZONE_DISPLAY},true);
		$criteria->compare(Globals::FLD_NAME_STATUS,$this->{Globals::FLD_NAME_STATUS},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTimeZone()
        {
            $criteria = new CDbCriteria();
            $criteria->order = Globals::FLD_NAME_TIMEZONE_DISPLAY.' desc';
            $timezone = Timezone::model()->findAll($criteria);
            //print_r($timezone);exit;
            return $timezone;
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Timezone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
