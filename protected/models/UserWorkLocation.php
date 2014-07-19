<?php

/**
 * This is the model class for table "{{dta_user_speciality}}".
 *
 * The followings are the available columns in table '{{dta_user_speciality}}':
 * @property string $user_id
 * @property integer $skill_id
 * @property string $country_code
 * @property integer $state_id
 * @property integer $region_id
 * @property integer $city_id
 * @property string $created_at
 * @property string $status
 */
class UserWorkLocation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_work_location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			/*array('user_id, category_id, created_at', 'required'),
			array('category_id, state_id, region_id, city_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			array('country_code', 'length', 'max'=>2),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, category_id, country_code, state_id, region_id, city_id, created_at, status', 'safe', 'on'=>'search'),*/
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
			'countryLocale' => array(self::BELONGS_TO, 'CountryLocale', Globals::FLD_NAME_COUNTRY_CODE),
                   
		);
	}
    public function getUserLocation($id)
	{
                $locationArray = "";
                $criteria=new CDbCriteria;
                $criteria->compare('t.'.Globals::FLD_NAME_USER_ID,$id);
                $locations = self::model()->with("countryLocale")->findAll($criteria);
				//echo '<pre>';
				//print_r($locations);
                if(!empty($locations))
                {
                    foreach ($locations  as $locations)
                    {
                        $locationArray[] = $locations->countryLocale[Globals::FLD_NAME_COUNTRY_CODE];
                    }                                        
                }
                    return $locationArray;
        }
        
        public function getUserLocationName($id)
	{
                $locationArray = "";
                $criteria=new CDbCriteria;
                $criteria->compare('t.'.Globals::FLD_NAME_USER_ID,$id);
                $locations = self::model()->with("countryLocale")->findAll($criteria);
				//echo '<pre>';
				//print_r($locations);
                if(!empty($locations))
                {
                    foreach ($locations  as $locations)
                    {
                        $locationArray[] = $locations->countryLocale[Globals::FLD_NAME_COUNTRY_NAME];
                    }                                        
                }
                    return $locationArray;
        }
   
  
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'user_id' => Yii::t('label_model', 'lbl_user_id'),
			
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

		//$criteria->compare(Globals::FLD_NAME_USER_ID,$this->{Globals::FLD_NAME_USER_ID},true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserSpeciality the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
