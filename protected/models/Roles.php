<?php

/**
 * This is the model class for table "{{roles}}".
 *
 * The followings are the available columns in table '{{roles}}':
 * @property integer $role_id
 * @property string $role_name
 * @property string $role_permission
 *
 * The followings are the available model relations:
 * @property Admin[] $admins
 */
class Roles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_userrole}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_name', 'required','on'=>'insert,update'),
			array('role_name', 'length', 'max'=>20),
                        array('role_name', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('role_id, role_name, role_permission', 'safe', 'on'=>'search'),
                        
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
			'admins' => array(self::HAS_MANY, 'Admin', Globals::FLD_NAME_ROLE_ID),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role_id' => Yii::t('label_model', 'lbl_role_id'),
			'role_name' => Yii::t('label_model', 'lbl_role_name'),
			'role_permission' => Yii::t('label_model', 'lbl_role_permission'),
		);
	}
        public function getmodels()
	{
		$models = Yii::app()->params['rolesModels'];
                foreach ($models as $index => $value) 
                {
                    if(is_array($value))
                       $modelsAssoc[$index] = $index;
                    else
                    $modelsAssoc[$value]=$value;
                }
                return $modelsAssoc;
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
	public function search($isFront = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare(Globals::FLD_NAME_ROLE_ID,$this->{Globals::FLD_NAME_ROLE_ID});
		$criteria->compare(Globals::FLD_NAME_ROLE_NAME,$this->{Globals::FLD_NAME_ROLE_NAME},true);
		$criteria->compare(Globals::FLD_NAME_ROLE_PERMISSION,$this->{Globals::FLD_NAME_ROLE_PERMISSION},true);
                if($isFront)
                {
                    $criteria->compare(Globals::FLD_NAME_IS_FRONT_ROLE,Globals::DEFAULT_VAL_FRONT_ROLE_ACCESS);
                }
                else
                {
                    $criteria->compare(Globals::FLD_NAME_IS_FRONT_ROLE,Globals::DEFAULT_VAL_FRONT_ROLE);
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                       'pagination'=>   array(
                                        'pageSize'=>Yii::app()->user->getState('rolesDataSession',Yii::app()->params['defaultPageSize'])
                                        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Roles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
