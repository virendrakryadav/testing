<?php

/**
 * This is the model class for table "{{mst_country_locale}}".
 *
 * The followings are the available columns in table '{{mst_country_locale}}':
 * @property string $country_code
 * @property string $language_code
 * @property string $country_name
 * @property integer $country_status
 * @property integer $country_priority
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 */
class CountryLocale extends CActiveRecord
{
	/*public function init()
  	{
    	$this->getMetaData()->tableSchema->primaryKey = array('language_code', 'country_code');
  	}
        
	public function primaryKey()
	{
		return array('language_code', 'country_code');
	}*/

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_country_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_name, country_priority', 'required'),
			array('country_status, country_priority, created_by, updated_by', 'numerical', 'integerOnly'=>true),
		//	array('country_code', 'length', 'max'=>2),
                        array('country_priority', 'numerical', 'min'=>1),
			array('language_code', 'length', 'max'=>5),
                        array('country_priority', 'length', 'max'=>3),
			array('country_name', 'length', 'max'=>100),
                        array('country_name', 'filter', 'filter'=>array( $this, 'filterPostalCode' )),
			array('update_timestamp', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('country_code, language_code, country_name, country_status, country_priority, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert,hasRoleInsert'),
                        array('update_timestamp','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update,hasRoleUpdate'),
                        array('updated_by','default', 'value'=>Yii::app()->user->id,'on'=>'update,hasRoleUpdate')
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
                    'country' => array(self::BELONGS_TO, 'Country', Globals::FLD_NAME_COUNTRY_CODE),
					'language' => array(self::BELONGS_TO, 'Language', Globals::FLD_NAME_LANGUAGE_CODE),
		);
	}
        public function getCountryByID( $countryCode , $defaultLang = null)
	{
            $criteria = new CDbCriteria();
            $criteria->condition = "t.language_code =:language";
            if(!empty($defaultLang)){
               $criteria->params = array(':language' => $defaultLang );
            }else{
               $criteria->params = array(':language' => Yii::app()->user->getState('language') );   
            }
            $criteria->compare('t.'.Globals::FLD_NAME_COUNTRY_CODE, $countryCode );
           
            $country = CountryLocale::model()->findAll($criteria);
            return $country;
        }
        public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'country_name' => Yii::t('label_model', 'lbl_country_name'),
			'country_priority' => Yii::t('label_model', 'lbl_country_priority'),
			'country_status' => Yii::t('label_model', 'lbl_country_status'),
			'create_timestamp' => Yii::t('label_model', 'lbl_create_timestamp'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'update_timestamp' => Yii::t('label_model', 'lbl_update_timestamp'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
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

		$criteria->compare(Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE},true);
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_COUNTRY_NAME,$this->{Globals::FLD_NAME_COUNTRY_NAME},true);
		$criteria->compare(Globals::FLD_NAME_COUNTRY_STATUS,$this->{Globals::FLD_NAME_COUNTRY_STATUS});
		$criteria->compare(Globals::FLD_NAME_COUNTRY_PRIORITY,$this->{Globals::FLD_NAME_COUNTRY_PRIORITY});
		$criteria->compare(Globals::FLD_NAME_CREATE_TIMESTAMP,$this->{Globals::FLD_NAME_CREATE_TIMESTAMP},true);
		$criteria->compare(Globals::FLD_NAME_CREATE_BY,$this->{Globals::FLD_NAME_CREATE_BY});
		$criteria->compare(Globals::FLD_NAME_UPDATE_TIMESTAMP,$this->{Globals::FLD_NAME_UPDATE_TIMESTAMP},true);
		$criteria->compare(Globals::FLD_NAME_UPDATED_BY,$this->{Globals::FLD_NAME_UPDATED_BY});

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getLoactionByArray($location)
        {       
            $criteria = new CDbCriteria();      
            $criteria->addInCondition(Globals::FLD_NAME_COUNTRY_CODE, $location);           
            $catIds = CountryLocale::model()->findAll($criteria);
            $data = "";
            foreach($catIds as $val)
            {         
                $data.= $val->{Globals::FLD_NAME_COUNTRY_NAME}.',';
            }
            return $data;
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CountryLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
