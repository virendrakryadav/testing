<?php

/**
 * This is the model class for table "{{mst_language}}".
 *
 * The followings are the available columns in table '{{mst_language}}':
 * @property string $language_code
 * @property string $language_name
 * @property integer $language_status
 * @property integer $language_priority
 * @property string $create_timestamp
 * @property integer $created_by
 * @property string $update_timestamp
 * @property integer $updated_by
 */
class Language extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_language}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('language_code, language_name, language_priority', 'required'),
			array('language_status, language_priority, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5,'min'=>2),
			array('language_name', 'length', 'max'=>75,'min'=>2),

                        array('language_priority', 'numerical', 'min'=>1),
			array('update_timestamp', 'safe'),
                         array('language_code, language_name', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('language_code, language_name, language_status, language_priority, create_timestamp, created_by, update_timestamp, updated_by', 'safe', 'on'=>'search'),
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
			'language_code' => Yii::t('label_model', 'lbl_language_code'),
			'language_name' => Yii::t('label_model', 'lbl_language_name'),
			'language_status' => Yii::t('label_model', 'lbl_language_status'),
			'language_priority' => Yii::t('label_model', 'lbl_language_priority'),
			'create_timestamp' => Yii::t('label_model', 'lbl_create_timestamp'),
			'created_by' => Yii::t('label_model', 'lbl_created_by'),
			'update_timestamp' => Yii::t('label_model', 'lbl_update_timestamp'),
			'updated_by' => Yii::t('label_model', 'lbl_updated_by'),
		);
	}
   public function getLanguageList()
	{  
	     //Yii::app()->cache->delete('getLanguageList');
     
	  if(CommonUtility::IsProfilingEnabled())
     {
         Yii::beginProfile('Language.getLanguageList','Language.getLanguageList');
     }

     $languages = Yii::app()->cache->get(Globals::$cacheKeys['GET_LANGUAGE_LIST']);     

     if($languages === false)
     {
        $languages = Language::model()->findAll(array('order' => Globals::FLD_NAME_LANGUAGE_PRIORITY));
        Yii::app()->cache->set(Globals::$cacheKeys['GET_LANGUAGE_LIST'], $languages);
     }
         	  
      if(CommonUtility::IsProfilingEnabled())
      {
         Yii::endProfile('Language.getLanguageList');
      }
//CommonUtility::pre($languages);
      return $languages;
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

		$criteria->compare('language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
		$criteria->compare('language_name',$this->{Globals::FLD_NAME_LANGUAGE_NAME},true);
		$criteria->compare('language_status',$this->{Globals::FLD_NAME_LANGUAGE_PRIORITY});
		$criteria->compare('language_priority',$this->{Globals::FLD_NAME_LANGUAGE_PRIORITY});
		$criteria->compare('create_timestamp',$this->{Globals::FLD_NAME_CREATE_TIMESTAMP},true);
		$criteria->compare('created_by',$this->{Globals::FLD_NAME_CREATED_BY});
		$criteria->compare('update_timestamp',$this->{Globals::FLD_NAME_UPDATE_TIMESTAMP},true);
		$criteria->compare('updated_by',$this->{Globals::FLD_NAME_UPDATED_BY});

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                                        'pageSize'=>Yii::app()->user->getState('languageDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Language the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
