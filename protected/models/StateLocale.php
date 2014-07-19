<?php

/**
 * This is the model class for table "{{mst_state_locale}}".
 *
 * The followings are the available columns in table '{{mst_state_locale}}':
 * @property integer $state_id
 * @property string $language_code
 * @property string $country_code
 * @property string $state_name
 * @property integer $state_status
 * @property integer $state_priority
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 */
class StateLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_state_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                    array('country_code, state_name, state_priority', 'required'),
                    array('state_id, state_status, state_priority, created_by, updated_by', 'numerical', 'integerOnly'=>true),
                    array('language_code', 'length', 'max'=>5),
                    array('state_priority', 'numerical', 'min'=>1),
                    //array('state_name', 'unique', 'criteria'=>array('condition'=>'country_code=:country_code','params'=>array(':country_code'=>$this->{Globals::FLD_NAME_COUNTRY_CODE}))),
                    array('state_name', 'UniqueAttributesValidator', 'with'=>'country_code'),
                    array('country_code', 'length', 'max'=>2),
                    array('state_name', 'length', 'max'=>100,'min'=>2),
                    array('update_timestamp', 'safe'),
                    array('state_name', 'filter', 'filter'=>array( $this, 'filterPostalCode' )),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('state_id, language_code, country_code, state_name, state_status, state_priority, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'state_id' => Yii::t('label_model', 'lbl_state_id'),
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'country_code' => Yii::t('label_model', 'lbl_country_code'),
			'state_name' => Yii::t('label_model', 'lbl_state_name'),
			'state_status' => Yii::t('label_model', 'lbl_state_status'),
			'state_priority' => Yii::t('label_model', 'lbl_state_priority'),
			'create_timestamp' => Yii::t('label_model', 'lbl_create_timestamp'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'update_timestamp' => Yii::t('label_model', 'lbl_update_timestamp'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
		);
	}
        public function filterPostalCode($stringToTrim)
	{
		//strip out non letters and numbers
		$stringToTrim = trim($stringToTrim);
		return $stringToTrim;
	}
        public function getStateList($country_code=NULL)
	{  
            $criteria = new CDbCriteria();
            if($country_code)
            {
              
               $criteria->addCondition(Globals::FLD_NAME_COUNTRY_CODE.' ="'.$country_code.'" ');
             
            }
            $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
            $country = StateLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_STATE_PRIORITY));
            return $country;
        } 
        public function getStatesByCountryCode($country_code=NULL,$language_code=NULL)
	{  
            $criteria = new CDbCriteria();
            if($country_code)
            {
              
               $criteria->addCondition(Globals::FLD_NAME_COUNTRY_CODE.' ="'.$country_code.'" ');
             
            }
            $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.$language_code.'" ');
            $country = StateLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_STATE_PRIORITY));
            return $country;
        } 
        public function getStateCountryId($state_id)
	{  
                $criteria = new CDbCriteria();
                //$criteria->condition = "state_id =:id";
                $criteria->addCondition(Globals::FLD_NAME_STATE_ID.' ="'.$state_id.'" ');
                $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
                $state = StateLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_STATE_PRIORITY));
                return  $country_code = $state[0]->{Globals::FLD_NAME_COUNTRY_CODE};
                        
        } 
        public function getStateById($state_id)
	{  
                $criteria = new CDbCriteria();
                //$criteria->condition = "state_id =:id";
                $criteria->addCondition(Globals::FLD_NAME_STATE_ID.' ="'.$state_id.'" ');
                $criteria->addCondition(Globals::FLD_NAME_LANGUAGE_CODE.' ="'.Yii::app()->user->getState('language').'" ');
                $state = StateLocale::model()->findAll($criteria,array('order' => Globals::FLD_NAME_STATE_PRIORITY));
                return  $state;
                        
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

		$criteria->compare(Globals::FLD_NAME_STATE_ID,$this->{Globals::FLD_NAME_STATE_ID});
		$criteria->compare(Globals::FLD_NAME_LANGUAGE_CODE,$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare(Globals::FLD_NAME_COUNTRY_CODE,$this->{Globals::FLD_NAME_COUNTRY_CODE},true);
		$criteria->compare(Globals::FLD_NAME_STATE_NAME,$this->{Globals::FLD_NAME_STATE_NAME},true);
		$criteria->compare(Globals::FLD_NAME_STATE_STATUS,$this->{Globals::FLD_NAME_STATE_STATUS});
		$criteria->compare(Globals::FLD_NAME_STATE_PRIORITY,$this->{Globals::FLD_NAME_STATE_PRIORITY});
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
	 * @return StateLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
