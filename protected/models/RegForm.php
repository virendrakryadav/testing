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
class RegForm extends CFormModel
{
	//public $maxPriority;
	/**
	 * @return string the associated database table name
	 */
	public $repeatpassword;
	public function tableName()
	{
		return '{{dta_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstname, lastname,email, password, repeatpassword', 'required', 'on'=>'index'),
			array('email', 'unique'),
			//array('firstname, state_name, cou_id, state_priority, state_status, state_addedon, state_updateon', 'safe', 'on'=>'search'),
		);
	}


	/*public function beforeValidate()
	{
		if (parent::beforeValidate()) {
	
			$validator = CValidator::createValidator('unique', $this, 'state_name', array(
				'criteria' => array(
					'condition'=>'cou_id=:cou_id',
					'params'=>array(
						':cou_id'=>$this->cou_id
					)
				)
			));
			$this->getValidatorList()->insertAt(0, $validator); 
	
			return true;
		}
		return false;
	}*/
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'country' => array(self::BELONGS_TO, 'Country', 'cou_id'),
		);
	}
	
	//Validate after Trim
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
			//'state_id' => 'State',
			'firstname' => Yii::t('label_model', 'lbl_firstname'),
			'lastname' => Yii::t('label_model', 'lbl_lastname'),
			'password' => Yii::t('label_model', 'lbl_password'),
			'repeatpassword'=>Yii::t('label_model', 'lbl_repeatpassword'),
			'email' => Yii::t('label_model', 'lbl_email'),
			'mobile' => Yii::t('label_model', 'lbl_mobile'),
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
	/*public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('state_name',$this->state_name,true);
		$criteria->compare('cou_id',$this->cou_id);
		$criteria->compare('state_priority',$this->state_priority);
		$criteria->compare('state_status',$this->state_status);
		$criteria->compare('state_addedon',$this->state_addedon,true);
		$criteria->compare('state_updateon',$this->state_updateon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 //'pagination'=>array(
               //  				'pageSize'=>Yii::app()->user->getState('stateDataSession',Yii::app()->params['defaultPageSize'])
                 //               ),
		));
	}*/

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
