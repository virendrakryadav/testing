<?php

/**
 * This is the model class for table "{{dta_task_location}}".
 *
 * The followings are the available columns in table '{{dta_task_location}}':
 * @property string $id
 * @property string $task_id
 * @property string $is_location_region
 * @property integer $region_id
 * @property string $country_code
 * @property string $location_longitude
 * @property string $location_latitude
 * @property string $location_geo_area
 */
class TaskLocation extends CActiveRecord
{
        public $location_type;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_task_location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('location_geo_area', 'required' on),
                        array('location_geo_area', 'required','on'=>'inpersonTask,instantTask'),
			array('region_id', 'numerical', 'integerOnly'=>true),
			array('id, task_id', 'length', 'max'=>20),
			array('is_location_region', 'length', 'max'=>1),
			array('country_code', 'length', 'max'=>2),
			array('location_longitude, location_latitude', 'length', 'max'=>30),
			array('location_geo_area', 'length', 'max'=>100),
                        ///in-person task ///
                        
                        // end in-person task//
                        // 
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, task_id, is_location_region, region_id, country_code, location_longitude, location_latitude, location_geo_area', 'safe', 'on'=>'search'),
                      
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
                    'task' => array(self::BELONGS_TO, 'Task', Globals::FLD_NAME_TASK_ID),
                    'country' => array(self::BELONGS_TO, 'Country', Globals::FLD_NAME_COUNTRY_CODE),
                    'countrylocale' => array(self::BELONGS_TO, 'CountryLocale', array(Globals::FLD_NAME_COUNTRY_CODE => Globals::FLD_NAME_COUNTRY_CODE), 'through'=>'country'),
                    'region' => array(self::BELONGS_TO, 'Region', Globals::FLD_NAME_REGION_ID),
                    'regionlocale' => array(self::BELONGS_TO, 'RegionLocale', array(Globals::FLD_NAME_REGION_ID => Globals::FLD_NAME_REGION_ID), 'through'=>'region'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('label_model', 'lbl_id'),
			'task_id' => Yii::t('label_model', 'lbl_task_id'),
			'is_location_region' => Yii::t('label_model', 'lbl_is_location_region'),
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'location_longitude' => Yii::t('label_model', 'lbl_location_longitude'),
			'location_latitude' => Yii::t('label_model', 'lbl_location_latitude'),
			'location_geo_area' => Yii::t('label_model', 'lbl_location_geo_area'),
		);
	}

        public function getTaskListAverage($locationRange,$type)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->compare('creator_user_id',Yii::app()->user->id);
		$criteria->compare('task.'.Globals::FLD_NAME_PAYMENT_MODE,$type);
                $criteria->addCondition('t.location_longitude >='.$locationRange['min_lon']);
                $criteria->addCondition('t.location_longitude <='.$locationRange['max_lon']);
                $criteria->addCondition('t.location_latitude  >='.$locationRange['min_lat']);
                $criteria->addCondition('t.location_latitude  <='.$locationRange['max_lat']);
//                $criteria->order = "task_id DESC";
		$taskList = TaskLocation::model()->with('task')->findAll($criteria);
                return $taskList;
//                return $locationRange;
	}

        public function getTaskLocations($task_id)
	{  
        
            $criteria = new CDbCriteria();
            $criteria->condition = "countrylocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->condition = "regionlocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $criteria->condition = "t.".Globals::FLD_NAME_TASK_ID." ='".$task_id."'";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $questions = TaskLocation::model()->with('country','countrylocale','regionlocale')->findAll($criteria);
            return $questions;
                        
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

		$criteria->compare(Globals::FLD_NAME_ID,$this->{Globals::FLD_NAME_ID},true);
		$criteria->compare(Globals::FLD_NAME_TASK_ID,$this->{Globals::FLD_NAME_TASK_ID},true);
		$criteria->compare(Globals::FLD_NAME_IS_LOCATION_REGION,$this->{Globals::FLD_NAME_IS_LOCATION_REGION},true);
		$criteria->compare(Globals::FLD_NAME_REGION_ID,$this->{Globals::FLD_NAME_REGION_ID});
		$criteria->compare(Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE},true);
		$criteria->compare(Globals::FLD_NAME_LOCATION_LONGITUDE,$this->{Globals::FLD_NAME_LOCATION_LONGITUDE},true);
		$criteria->compare(Globals::FLD_NAME_LOCATION_LATITUDE,$this->{Globals::FLD_NAME_LOCATION_LATITUDE},true);
		$criteria->compare(Globals::FLD_NAME_LOCATION_GEO_AREA,$this->{Globals::FLD_NAME_LOCATION_GEO_AREA},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TaskLocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
