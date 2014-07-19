<?php

/**
 * This is the model class for table "{{mst_setting}}".
 *
 * The followings are the available columns in table '{{mst_setting}}':
 * @property integer $setting_id
 * @property string $setting_type
 * @property string $setting_key
 * @property string $setting_value
 * @property string $setting_label
 * @property string $created_at
 * @property string $updated_at
 */
class Setting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_setting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('setting_type, setting_key, setting_value, setting_label', 'required'),
			array('setting_type', 'length', 'max'=>50),
			array('setting_key, setting_label', 'length', 'max'=>500),
                        array('setting_key','match', 'not' => true, 'pattern' => '/[^a-z_]/','message' => 'Spaces not allowed. (Small letters only. Try using underscore).'),
			array('setting_key', 'UniqueAttributesValidator', 'with'=>'setting_type'),
                        array('setting_label','match', 'not' => true, 'pattern' => '/[^A-Z a-z()]/'),
                        array('setting_value', 'length', 'max'=>1000),
                        //array('setting_value', 'numerical', 'integerOnly'=>true),
                        //array('setting_key', 'checkUniqueSettingValue'),
                        array('created_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'insert'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('setting_id, setting_type, setting_key, setting_value, setting_label, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'setting_id' => Yii::t('label_model', 'lbl_setting_id'),
			'setting_type' => Yii::t('label_model', 'lbl_setting_type'),
			'setting_key' => Yii::t('label_model', 'lbl_setting_key'),
			'setting_value' => Yii::t('label_model', 'lbl_setting_value'),
			'setting_label' => Yii::t('label_model', 'lbl_setting_label'),
			'created_at' => Yii::t('label_model', 'lbl_created_at'),
			'updated_at' => Yii::t('label_model', 'lbl_updated_at'),
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
		$criteria->compare(Globals::FLD_NAME_SETTING_TYPE,$this->{Globals::FLD_NAME_SETTING_TYPE},true);
		$criteria->compare(Globals::FLD_NAME_SETTING_KEY,$this->{Globals::FLD_NAME_SETTING_KEY},true);
		$criteria->compare(Globals::FLD_NAME_SETTING_VALUE,$this->{Globals::FLD_NAME_SETTING_VALUE},true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=> array(
                                        'pageSize'=>Yii::app()->user->getState('settingDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
		));
	}
        
        public function siteSettingType($setting_type)
        {
            $model = new Setting;
            $criteria = new CDbCriteria();
            $criteria->compare('t.'.Globals::FLD_NAME_SETTING_TYPE,$setting_type);
            $siteSettingType = Setting::model()->findAll($criteria);
            return $siteSettingType;
         }
        
        public function checkUniqueSettingValue($attribute,$params)
	{                
            if(isset($_POST['Setting']['setting_type']) && isset($_POST['Setting']['setting_key']))
            {
                $criteria = new CDbCriteria(); 
                $criteria->addCondition('t.setting_type ="'.$_POST['Setting']['setting_type'].'"');
                $criteria->addCondition('t.setting_key ="'.$_POST['Setting']['setting_key'].'"');
                $questions = Setting::model()->findAll($criteria);                
                $ratingcount = count($questions);                
                if($ratingcount>0)
                {
                    $this->addError($attribute, 'Name "'.$_POST['Setting']['setting_key'].'" has already been taken.');
                }
            }
         }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Setting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
