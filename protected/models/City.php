<?php

/**
 * This is the model class for table "{{mst_city}}".
 *
 * The followings are the available columns in table '{{mst_city}}':
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $city_status
 * @property integer $city_priority
 *
 * The followings are the available model relations:
 * @property MstState $state
 * @property MstCityLocale[] $mstCityLocales
 */
class City extends CActiveRecord
{
        public $maxPriority;
        public $city_name;
        public $country_code;
        public $state_id;
        public $region_id;
        public $city_priority;
        public $city_status;
        public $language_code;
        
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_city}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
//                    array('country_id, state_id,city_priority', 'required'),
//                    array('country_id,state_id, city_status, city_priority', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
                    array('city_id,city_name,country_code, state_id, city_status, city_priority,language_code,region_id', 'safe', 'on'=>'search'),
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
			
                    'citylocale' => array(self::BELONGS_TO, 'CityLocale', Globals::FLD_NAME_CITY_ID),
                    'regionlocale' => array(self::BELONGS_TO, 'RegionLocale', array(Globals::FLD_NAME_REGION_ID => Globals::FLD_NAME_REGION_ID), 'through'=>'citylocale'),
                    'statelocale' => array(self::BELONGS_TO, 'StateLocale', array(Globals::FLD_NAME_STATE_ID => Globals::FLD_NAME_STATE_ID), 'through'=>'regionlocale'),
                    'countrylocale' => array(self::BELONGS_TO, 'CountryLocale', array(Globals::FLD_NAME_COUNTRY_CODE => Globals::FLD_NAME_COUNTRY_CODE), 'through'=>'statelocale'),
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
                    
			'city_name' => Yii::t('label_model', 'lbl_city_name'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'city_id' => Yii::t('label_model', 'lbl_city_id'),
			'state_id' => Yii::t('label_model', 'lbl_state_id'),
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'city_status' => Yii::t('label_model', 'lbl_city_status'),
			'city_priority' => Yii::t('label_model', 'lbl_city_priority'),
		);
	}
	
    public function getCityList($region_id=NULL)
	{  
            $criteria = new CDbCriteria();
            if($region_id)
            $criteria->addCondition(Globals::FLD_NAME_REGION_ID.' ="'.$region_id.'" ');
            $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            $city = CityLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_CITY_PRIORITY));
            return $city;
     } 
      public function getCity()
        {
//                $ip = $_SERVER['REMOTE_ADDR'];
//                $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
//                if(isset($details->city))
//                {
//                    $criteria = new CDbCriteria();
//                    $criteria->addCondition('citylocale.city_name ="'.trim($details->city).'"');
//                    $criteria->addCondition('citylocale.language_code ="en_us"');
//                    $location = City::model()->with(array('statelocale','regionlocale','countrylocale','citylocale'))->findAll($criteria,array('order' => 'citylocale.city_priority'));
//                    if($location)
//                    {
//                        $data['country_code'] = $location[0]->countrylocale->{Globals::FLD_NAME_COUNTRY_CODE};
//                        $data['state_id'] = $location[0]->statelocale->state_id;
//                        $data['region_id'] = $location[0]->regionlocale->{Globals::FLD_NAME_REGION_ID};
//                        $data['city_id'] = $location[0]->citylocale->city_id;
//                    }
//                }
//                else 
//                {
                    $data='';
//                }
                return $data;
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
                 $criteria->with = array('statelocale','regionlocale','countrylocale','citylocale');
                if(isset($this->{Globals::FLD_NAME_LANGUAGE_CODE}))
                {
                    $criteria->compare('citylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('regionlocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('statelocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                }
                else 
                {
                    $criteria->compare('citylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                    $criteria->compare('regionlocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                    $criteria->compare('statelocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                }
				$criteria->compare(Globals::FLD_NAME_CITY_ID,$this->{Globals::FLD_NAME_CITY_ID});
                $criteria->compare('citylocale.'.Globals::FLD_NAME_CITY_NAME,$this->{Globals::FLD_NAME_CITY_NAME},true);
                $criteria->compare('statelocale.'.Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE});
                $criteria->compare('citylocale.'.Globals::FLD_NAME_REGION_ID,$this->{Globals::FLD_NAME_REGION_ID});
				$criteria->compare('statelocale.'.Globals::FLD_NAME_STATE_ID,$this->{Globals::FLD_NAME_STATE_ID});
				$criteria->compare(Globals::FLD_NAME_CITY_STATUS,$this->{Globals::FLD_NAME_CITY_STATUS});
				$criteria->compare(Globals::FLD_NAME_CITY_PRIORITY,$this->{Globals::FLD_NAME_CITY_PRIORITY});

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('cityDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                                      'sort'=>array(
                                            'attributes'=>array(
                                                'country_name'=>array(
                                                            'asc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME,
                                                            'desc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME.' DESC',
                                                            ),
                                                'state_name'=>array(
                                                            'asc'=>'statelocale.'.Globals::FLD_NAME_STATE_NAME,
                                                            'desc'=>'statelocale.'.Globals::FLD_NAME_STATE_NAME.' DESC',
                                                            ),
                                                'region_name'=>array(
                                                            'asc'=>'regionlocale.'.Globals::FLD_NAME_REGION_NAME,
                                                            'desc'=>'regionlocale.'.Globals::FLD_NAME_REGION_NAME.' DESC',
                                                            ),
                                                'city_name'=>array(
                                                            'asc'=>'citylocale.'.Globals::FLD_NAME_CITY_NAME,
                                                            'desc'=>'citylocale.'.Globals::FLD_NAME_CITY_NAME.' DESC',
                                                            ),
                                                'city_priority'=>array(
                                                            'asc'=>'citylocale.'.Globals::FLD_NAME_CITY_PRIORITY,
                                                            'desc'=>'citylocale.'.Globals::FLD_NAME_CITY_PRIORITY.' DESC',
                                                            ),
                                                            '*',
                                            ),
                                  'defaultOrder'=>'citylocale.'.Globals::FLD_NAME_CITY_PRIORITY.' ASC',
                            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
