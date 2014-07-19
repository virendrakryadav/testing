<?php

/**
 * This is the model class for table "{{mst_city_locale}}".
 *
 * The followings are the available columns in table '{{mst_city_locale}}':
 * @property integer $city_id
 * @property string $language_code
 * @property integer $region_id
 * @property string $city_name
 * @property integer $city_status
 * @property integer $city_priority
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 */
class CityLocale extends CActiveRecord
{
        public $country_code;
        public $state_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_city_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_code, state_id,region_id, city_id', 'required','on' => 'updateprofile'),
			array('region_id, city_name, city_priority,country_code,state_id', 'required','on'=>'insert,update'),
			array('city_id, region_id, city_status, city_priority, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5),
                        array('city_priority', 'numerical', 'min'=>1),
                        array('city_name', 'length', 'max'=>100,'min'=>2),
			array('update_timestamp', 'safe'),
                        array('city_name', 'UniqueAttributesValidator', 'with'=>'region_id'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, language_code, region_id, city_name, city_status, city_priority, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_timestamp','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
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
			'city_id' => Yii::t('label_model', 'lbl_city_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'state_id' => Yii::t('label_model', 'lbl_state_id'),
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'city_name' => Yii::t('label_model', 'lbl_city_name'),
			'city_status' => Yii::t('label_model', 'lbl_city_status'),
			'city_priority' => Yii::t('label_model', 'lbl_city_priority'),
			'create_timestamp' => Yii::t('label_model', 'lbl_create_timestamp'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'update_timestamp' => Yii::t('label_model', 'lbl_update_timestamp'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
		);
	}
        public function getCityByID($city_id)
	{  
            $criteria = new CDbCriteria();
            $criteria->addCondition(Globals::FLD_NAME_CITY_ID.' ="'.$city_id.'" ');
            $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            $city = CityLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_CITY_PRIORITY));
            return $city;
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

		$criteria->compare(Globals::FLD_NAME_CITY_ID,$this->{Globals::FLD_NAME_CITY_ID});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_REGION_ID,$this->{Globals::FLD_NAME_REGION_ID});
		$criteria->compare(Globals::FLD_NAME_CITY_NAME,$this->{Globals::FLD_NAME_CITY_NAME},true);
		$criteria->compare(Globals::FLD_NAME_CITY_STATUS,$this->{Globals::FLD_NAME_CITY_STATUS});
		$criteria->compare(Globals::FLD_NAME_CITY_PRIORITY,$this->{Globals::FLD_NAME_CITY_PRIORITY});
		$criteria->compare(Globals::FLD_NAME_CREATE_TIMESTAMP,$this->{Globals::FLD_NAME_CREATE_TIMESTAMP},true);
		$criteria->compare(Globals::FLD_NAME_CREATE_BY,$this->{Globals::FLD_NAME_CREATE_BY});
		$criteria->compare(Globals::FLD_NAME_UPDATE_TIMESTAMP,$this->{Globals::FLD_NAME_UPDATE_TIMESTAMP},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CityLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
