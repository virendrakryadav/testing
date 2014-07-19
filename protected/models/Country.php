<?php

/**
 * This is the model class for table "{{country}}".
 *
 * The followings are the available columns in table '{{country}}':
 * @property integer $cou_id
 * @property string $cou_code
 * @property string $cou_name
 * @property integer $cou_priority
 * @property integer $cou_addedby
 * @property string $cou_addedon
 * @property string $cou_updateon
 * @property integer $cou_updatedby
 */
class Country extends CActiveRecord
{
	public $maxPriority;
        public $country_name;
        public $country_priority;
        public $country_status;
        public $language_code;
	/** 
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_country}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_code', 'required'),
			
			array('country_code', 'filter', 'filter'=>array( $this, 'filterPostalCodeForCode' )),
                        
//			array('country_priority', 'numerical', 'integerOnly'=>true),
			//array('country_code', 'length', 'max'=>2, 'min'=>2),
//			array('country_status', 'length', 'max'=>1),
//			array('country_priority', 'length', 'max'=>3),
			
			array('country_code', 'unique'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('country_code,country_priority,country_status,country_name,language_code', 'safe', 'on'=>'search'),
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
			'countrylocale' => array(self::BELONGS_TO, 'CountryLocale', Globals::FLD_NAME_COUNTRY_CODE),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	 
	//Validate after Trim
	
	  
	  public function filterPostalCodeForCode($stringToTrim)
	  {
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return strtoupper($stringToTrim);
	  }
	
	 
	public function attributeLabels()
	{
		return array(
			//'country_id' => 'Country Id',
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
//			'country_name' => 'Country Name',
			'country_priority' => Yii::t('label_model', 'lbl_country_priority'),
			'country_status' => Yii::t('label_model', 'lbl_country_status'),
//			'country_addedby' => 'Country Addedby',
//			'country_addedon' => 'Country Addedon',
//			'country_updateon' => 'Country Updateon',
//			'country_updatedby' => 'Country Updatedby',
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
    public function getCountryListWithoutCache($defaultLang = null)
	{  
            $criteria = new CDbCriteria();
            $criteria->condition = "countrylocale.language_code =:language";
            if(!empty($defaultLang)){
               $criteria->params = array(':language' => $defaultLang );
            }else{
               $criteria->params = array(':language' => Yii::app()->user->getState('language') );   
            }
            
            $criteria->order = "countrylocale.".Globals::FLD_NAME_COUNTRY_PRIORITY;
            $country = Country::model()->with('countrylocale')->findAll($criteria);
            
            return $country;
            
            //$country =  self::getCountryListFromDB();
            //return $country;
                        
        }  
        
        
   public function getCountryList($defaultLang = null)
	{
	  //$userLang = Yii::app()->user->getState('language');
	  //Yii::app()->cache->delete('getCountryList_'.$userLang);
     
	  if(CommonUtility::IsProfilingEnabled())
     {
         //Yii::beginProfile('GetRequest.getCountryList',Yii::app()->controller->id.'.'.Yii::app()->action->id);
         Yii::beginProfile('Country.getCountryList','Country.getCountryList');
     }
     $userLang = Yii::app()->user->getState('language');
     $countries = Yii::app()->cache->get(Globals::$cacheKeys['GET_COUNTRY_LIST'].'_'.$userLang);     
     //CommonUtility::pre($countries);
     if($countries === false)
     {
         $criteria = new CDbCriteria();
         $criteria->condition = "countrylocale.language_code =:language";
         if(!empty($defaultLang))
         {
            $criteria->params = array(':language' => $defaultLang );
         }else
         {
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );   
         }
         
         $criteria->order = "countrylocale.".Globals::FLD_NAME_COUNTRY_PRIORITY;
         $countries = Country::model()->with('countrylocale')->findAll($criteria);
      /*   
         $countries = array();
         $i = 0;
         foreach($cc as $cnt){
            $countries[$i]['countrylocale']['country_code'] = $cc[$i]['countrylocale']['country_code'];
            $countries[$i]['countrylocale']['language_code'] = $cc[$i]['countrylocale']['language_code'];
            $countries[$i]['countrylocale']['country_name'] = $cc[$i]['countrylocale']['country_name'];
            $countries[$i]['countrylocale']['country_status'] = $cc[$i]['countrylocale']['country_status'];
            $countries[$i]['countrylocale']['country_priority'] = $cc[$i]['countrylocale']['country_priority'];
            $countries[$i]['countrylocale']['create_timestamp'] = $cc[$i]['countrylocale']['create_timestamp'];
            $countries[$i]['countrylocale']['created_by'] = $cc[$i]['countrylocale']['created_by'];
            $countries[$i]['countrylocale']['update_timestamp'] = $cc[$i]['countrylocale']['update_timestamp'];
            $countries[$i]['countrylocale']['updated_by'] = $cc[$i]['countrylocale']['updated_by'];
            $i++;
         }
$countries=json_encode($countries);*/
        Yii::app()->cache->set(Globals::$cacheKeys['GET_COUNTRY_LIST'].'_'.$userLang, $countries);
     }
       
        if(empty($countries))
        {
            $defaultLang = GLOBALS::DEFAULT_LANGUAGE;
            $criteria = new CDbCriteria();
            $criteria->condition = "countrylocale.language_code =:language";
            $criteria->params = array(':language' => $defaultLang );
            $criteria->order = "countrylocale.".Globals::FLD_NAME_COUNTRY_PRIORITY;
            $countries = Country::model()->with('countrylocale')->findAll($criteria);
            Yii::app()->cache->set(Globals::$cacheKeys['GET_COUNTRY_LIST'].'_'.$defaultLang, $countries);
        }
                    	  
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('Country.getCountryList');
      }
            
      return $countries;
            
            //$country =  self::getCountryListFromDB();
            //return $country;
                        
   }  
    /*    public function getCountryListFromDB()
	{  
        
            $criteria = new CDbCriteria();
            $criteria->condition = "countrylocale.language_code =:language";
            $criteria->params = array(':language' => Yii::app()->user->getState('language') );
            $criteria->order = "countrylocale.".Globals::FLD_NAME_COUNTRY_PRIORITY;
            $country = Country::model()->with('countrylocale')->findAll($criteria);
            
            return $country;
                        
        } */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
            //echo $this->country_name;
		$criteria=new CDbCriteria;
                $criteria->with = array( 'countrylocale' );
		//$criteria->compare('countrylocale.country_id',$this->country_id);
		$criteria->compare('t.'.Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE},true);
                
                if(isset($this->{Globals::FLD_NAME_LANGUAGE_CODE}))
                {
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                }
                else 
                {
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                }
                        
		
                $criteria->compare('countrylocale.'.Globals::FLD_NAME_COUNTRY_PRIORITY,$this->{Globals::FLD_NAME_COUNTRY_PRIORITY});
		$criteria->compare('countrylocale.'.Globals::FLD_NAME_COUNTRY_STATUS,$this->{Globals::FLD_NAME_COUNTRY_STATUS});
                
		$criteria->addCondition('countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME.' like "%'.$this->{Globals::FLD_NAME_COUNTRY_NAME}.'%" ');
                
		return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=> array(
                                        'pageSize'=>Yii::app()->user->getState('countryDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                            'sort'=>array(
                                            'attributes'=>array(
                                            'country_name'=>array(
                                                            'asc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME,
                                                            'desc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME.' DESC',
                                                            ),
                                            'country_priority'=>array(
                                                            'asc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_PRIORITY,
                                                            'desc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_PRIORITY.' DESC',
                                                            ),
                                                
                                                            '*',
                                            ),
                         'defaultOrder'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_PRIORITY.' ASC',
                            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Country the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
