<?php

/**
 * This is the model class for table "{{mst_region}}".
 *
 * The followings are the available columns in table '{{mst_region}}':
 * @property integer $region_id
 */
class Region extends CActiveRecord
{
        public $maxPriority;
        public $region_name;
        public $country_code;
        public $state_id;
        public $region_priority;
        public $region_status;
        public $language_code;
        
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_region}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('region_id,region_name,country_code,state_id,language_code,region_status', 'safe', 'on'=>'search'),
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
                    
                    'regionlocale' => array(self::BELONGS_TO, 'RegionLocale', Globals::FLD_NAME_REGION_ID),
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
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'region_name' => Yii::t('label_model', 'lbl_region_name'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'state_id'	=>Yii::t('label_model', 'lbl_state_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
                    
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
        
        public function getRegionList()
	{  
            $return= array();
            $locationData = CommonUtility::getAddressAndLatLngFromIp();
            $criteria = new CDbCriteria();
            $criteria->condition = "regionlocale.".Globals::FLD_NAME_LANGUAGE_CODE." =:language";
            $model=User::model()->findByPk(Yii::app()->user->id);
            if(isset($model->{Globals::FLD_NAME_COUNTRY_CODE}))
            {
                $country = $model->{Globals::FLD_NAME_COUNTRY_CODE};
            }
            elseif($locationData)
            {
                $country =  $locationData["country_code"];
                
            }
            else 
            {
                $country = Globals::DEFAULT_VAL_COUNTRY_CODE;
            }
            $criteria->condition = "countrylocale.".Globals::FLD_NAME_COUNTRY_CODE." ='".$country."'";
            $criteria->params = array(':language' => Yii::app()->user->getState('language'));
            $regions = Region::model()->with('regionlocale','countrylocale')->findAll($criteria,array('order' => Globals::FLD_NAME_REGION_PRIORITY));
            if($regions)
            {
                $return = $regions;
            }
            return $return;
        }    
        
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('statelocale','regionlocale','countrylocale');
                if(isset($this->{Globals::FLD_NAME_LANGUAGE_CODE}))
                {
                    $criteria->compare('regionlocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('statelocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                }
                else 
                {
                    $criteria->compare('regionlocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                    $criteria->compare('statelocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                }
                $criteria->compare('regionlocale.'.Globals::FLD_NAME_REGION_NAME,$this->{Globals::FLD_NAME_REGION_NAME},true);
                $criteria->compare('regionlocale.'.Globals::FLD_NAME_STATE_ID,$this->{Globals::FLD_NAME_STATE_ID},true);
		$criteria->compare('statelocale.'.Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE});
		$criteria->compare('regionlocale.'.Globals::FLD_NAME_REGION_PRIORITY,$this->{Globals::FLD_NAME_REGION_PRIORITY});
		$criteria->compare('regionlocale.'.Globals::FLD_NAME_REGION_STATUS,$this->{Globals::FLD_NAME_REGION_STATUS});
		$criteria->compare(Globals::FLD_NAME_REGION_ID,$this->{Globals::FLD_NAME_REGION_ID});

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('regionDataSession',Yii::app()->params['defaultPageSize'])
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
                                                'region_priority'=>array(
                                                            'asc'=>'regionlocale.'.Globals::FLD_NAME_REGION_PRIORITY,
                                                            'desc'=>'regionlocale.'.Globals::FLD_NAME_REGION_PRIORITY.' DESC',
                                                            ),
                                                'region_name'=>array(
                                                            'asc'=>'regionlocale.'.Globals::FLD_NAME_REGION_NAME,
                                                            'desc'=>'regionlocale.'.Globals::FLD_NAME_REGION_NAME.' DESC',
                                                            ),
                                                            '*',
                                            ),
                            'defaultOrder'=>'regionlocale.'.Globals::FLD_NAME_REGION_PRIORITY.' ASC',
                                ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Region the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
