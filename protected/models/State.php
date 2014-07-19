<?php

/**
 * This is the model class for table "{{state}}".
 *
 * The followings are the available columns in table '{{state}}':
 * @property integer $state_id
 * @property string $state_name
 * @property integer $cou_id
 * @property integer $state_priority
 * @property integer $state_status
 * @property string $state_addedon
 * @property string $state_updateon
 */
class State extends CActiveRecord
{
	public $maxPriority;
        public $state_name;
        public $state_priority;
        public $state_status;
        public $language_code;
        public $country_code;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_state}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			
//			array('country_code, state_priority', 'required'),
//			array('country_code, state_priority, state_status', 'numerical', 'integerOnly'=>true),
//                      array('state_name', 'unique', 'criteria'=>array('condition'=>'country_code=:country_code','params'=>array(':country_code'=>$this->{Globals::FLD_NAME_COUNTRY_CODE}))),
//                      array('state_name', 'uniquestate'),
//			array('state_status', 'length', 'max'=>1),
//			array('state_priority', 'length', 'max'=>3),
//			array('country_code', 'comparestate'),			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('state_id, state_name, country_code, state_priority, state_status,language_code', 'safe', 'on'=>'search'),
			
		);
	}


	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
	
			$validator = CValidator::createValidator('unique', $this, Globals::FLD_NAME_STATE_NAME, array(
				'criteria' => array(
					'condition'=>'country_code=:country_code',
					'params'=>array(
						':country_code'=>$this->{Globals::FLD_NAME_COUNTRY_CODE}
					)
				)
			));
			$this->getValidatorList()->insertAt(0, $validator); 
	
			return true;
		}
		return false;
	}
        
      
       
        
        
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    
                    'statelocale' => array(self::BELONGS_TO, 'StateLocale', Globals::FLD_NAME_STATE_ID),
                    'countrylocale' => array(self::BELONGS_TO, 'CountryLocale', array(Globals::FLD_NAME_COUNTRY_CODE => Globals::FLD_NAME_COUNTRY_CODE), 'through'=>'statelocale'),
		);
	}
	

		
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'state_id' => 'State',
			'state_name' => Yii::t('label_model', 'lbl_state_name'),
			'country_code' => Yii::t('label_model', 'lbl_country_name'),
			'state_priority' => Yii::t('label_model', 'lbl_state_priority'),
			'state_status' => Yii::t('label_model', 'lbl_state_status'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			//'state_addedon' => 'State Addedon',
			//'state_updateon' => 'State Updateon',
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
                $criteria->with = array( 'countrylocale', 'statelocale');
                $criteria->compare(Globals::FLD_NAME_STATE_ID,$this->{Globals::FLD_NAME_STATE_ID});
                if(isset($this->{Globals::FLD_NAME_LANGUAGE_CODE}))
                {
                    $criteria->compare('statelocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE});
                }
                else 
                {
                    $criteria->compare('statelocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                    $criteria->compare('countrylocale.'.Globals::FLD_NAME_LANGUAGE_CODE,Yii::app()->user->getState('language'));
                }
		$criteria->compare('statelocale.'.Globals::FLD_NAME_STATE_NAME,$this->{Globals::FLD_NAME_STATE_NAME},true);
		$criteria->compare('statelocale.'.Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE});
		$criteria->compare(Globals::FLD_NAME_STATE_PRIORITY,$this->{Globals::FLD_NAME_STATE_PRIORITY});
		$criteria->compare(Globals::FLD_NAME_STATE_STATUS,$this->{Globals::FLD_NAME_STATE_STATUS});
	

		return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('stateDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
                            'sort'=>array(
                                                'attributes'=>array(
                                                'country_name'=>array(
                                                            'asc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME,
                                                            'desc'=>'countrylocale.'.Globals::FLD_NAME_COUNTRY_NAME.'DESC',
                                                            ),
                                                'state_name'=>array(
                                                            'asc'=>'statelocale.'.Globals::FLD_NAME_STATE_NAME,
                                                            'desc'=>'statelocale.'.Globals::FLD_NAME_STATE_NAME.' DESC',
                                                            ),
                                                'state_priority'=>array(
                                                            'asc'=>'statelocale.'.Globals::FLD_NAME_STATE_PRIORITY,
                                                            'desc'=>'statelocale.'.Globals::FLD_NAME_STATE_PRIORITY.' DESC',
                                                            ),
                                                            '*',
                                            ),
                            'defaultOrder'=>'statelocale.'.Globals::FLD_NAME_STATE_PRIORITY.' ASC',
                            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return State the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
