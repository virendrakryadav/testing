<?php

/**
 * This is the model class for table "{{mst_region_locale}}".
 *
 * The followings are the available columns in table '{{mst_region_locale}}':
 * @property integer $region_id
 * @property string $language_code
 * @property integer $state_id
 * @property string $region_name
 * @property integer $region_status
 * @property integer $region_priority
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 */
class RegionLocale extends CActiveRecord
{
    
        public $country_code;
	/**
	 * @return string the associated database table name
	 */
    
	public function tableName()
	{
		return '{{mst_region_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state_id, region_name, region_priority,country_code', 'required'),
			array('region_id, state_id, region_status, region_priority, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5),

                        array('region_priority', 'numerical', 'min'=>1),
			array('region_name', 'length', 'max'=>100),
			array('update_timestamp', 'safe'),
                        array('region_name', 'UniqueAttributesValidator', 'with'=>'state_id'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('region_id, language_code, state_id, region_name, region_status, region_priority, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
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
        public function getStateIdCountryIdByRegionId($region_id)
	{  
                $criteria = new CDbCriteria();
                //$criteria->condition = "state_id =:id";
                $criteria->addCondition('regionlocale.'.Globals::FLD_NAME_REGION_ID.' ="'.$region_id.'" ');
                $criteria->addCondition('regionlocale.'.Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
                $regionData = Region::model()->with(array('statelocale','regionlocale','countrylocale'))->findAll($criteria,array('order' => 'regionlocale.'.Globals::FLD_NAME_REGION_PRIORITY));
//               echo "<pre>";
//                print_r($regionData);
                
                $data['country_code'] = $regionData[0]->countrylocale->{Globals::FLD_NAME_COUNTRY_CODE};
                $data['state_id'] = $regionData[0]->statelocale->{Globals::FLD_NAME_STATE_ID};
                return $data;
        } 
        public function getRegionByID( $id )
	{  
            $criteria = new CDbCriteria();
            $criteria->addCondition(Globals::FLD_NAME_REGION_ID.' ="'.$id.'" ');
            $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            $region = RegionLocale::model()->findAll($criteria);
            return $region;
        }
        public function getRegionList( $state_id = '' )
	{  
        
            $criteria = new CDbCriteria();
          
            if($state_id)
            {
                 $criteria->addCondition(Globals::FLD_NAME_STATE_ID.' ="'.$state_id.'" ');
            }
             $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            $regions = RegionLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_REGION_PRIORITY));
            return $regions;
        } 
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'region_id' => Yii::t('label_model', 'lbl_region_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'state_id' => Yii::t('label_model', 'lbl_state_id'),
			'region_name' => Yii::t('label_model', 'lbl_region_name'),
			'region_status' => Yii::t('label_model', 'lbl_region_status'),
			'region_priority' => Yii::t('label_model', 'lbl_region_priority'),
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

		$criteria->compare(Globals::FLD_NAME_REGION_ID,$this->{Globals::FLD_NAME_REGION_ID});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_STATE_ID,$this->{Globals::FLD_NAME_STATE_ID});
		$criteria->compare(Globals::FLD_NAME_REGION_NAME,$this->{Globals::FLD_NAME_REGION_NAME},true);
		$criteria->compare(Globals::FLD_NAME_REGION_STATUS,$this->{Globals::FLD_NAME_REGION_STATUS});
		$criteria->compare(Globals::FLD_NAME_REGION_PRIORITY,$this->{Globals::FLD_NAME_REGION_PRIORITY});
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
	 * @return RegionLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
