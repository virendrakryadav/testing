<?php

/**
 * This is the model class for table "{{dta_user_attrib}}".
 *
 * The followings are the available columns in table '{{dta_user_attrib}}':
 * @property string $user_id
 * @property string $attrib_type
 * @property string $attrib_desc
 * @property string $val_bigint
 * @property integer $val_int
 * @property string $val_real
 * @property string $val_str
 * @property string $val_dt
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 * @property string $source_app
 * @property string $status
 */
class UserAttrib extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{dta_user_attrib}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attrib_desc,', 'required', 'on'=>'savefilter' , 'message' => 'Filter description cannot be blank.'),
			array('val_int', 'numerical', 'integerOnly'=>true),
			array('user_id, val_bigint, created_by, updated_by', 'length', 'max'=>20),
			array('attrib_type, attrib_desc', 'length', 'max'=>30),
			array('val_real', 'length', 'max'=>15),
			array('val_str', 'length', 'max'=>8000),
			array('source_app', 'length', 'max'=>10),
			array('status', 'length', 'max'=>1),
			array('val_dt, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, attrib_type, attrib_desc, val_bigint, val_int, val_real, val_str, val_dt, created_at, created_by, updated_at, updated_by, source_app, status', 'safe', 'on'=>'search'),
                        
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert,savefilter'),
                        array('updated_at','default', 'value'=>new CDbExpression('NOW()'),'on'=>'update'),
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
			'user_id' => 'attribute related to which user?',
			'attrib_type' => 'attribute type such as preference, filter_task, filter_tasker, filter_poster, credit_card, fb, tw auth details etc.',
			'attrib_desc' => 'attribute sub type such as filter name or sub type under attrib_type e.g. filter1',
			'val_bigint' => 'Long integer value',
			'val_int' => 'Integer value',
			'val_real' => 'real value',
			'val_str' => 'string value, for example filter and preferences related data',
			'val_dt' => 'date value',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
			'source_app' => 'Source App',
			'status' => 'Status',
		);
	}
        public function getUserSavedFilters($attribType)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare(Globals::FLD_NAME_USER_ID,Yii::app()->user->id);
		$criteria->compare(Globals::FLD_NAME_ATTRIB_TYPE,$attribType);
                  
                $criteria->order = Globals::FLD_NAME_CREATED_AT." DESC";
                $criteria->limit = Globals::FILTERS_TASK_LIMIT;
		$filtersList = UserAttrib::model()->findAll($criteria);
                //print_r($criteria);
                return $filtersList;
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('attrib_type',$this->attrib_type,true);
		$criteria->compare('attrib_desc',$this->attrib_desc,true);
		$criteria->compare('val_bigint',$this->val_bigint,true);
		$criteria->compare('val_int',$this->val_int);
		$criteria->compare('val_real',$this->val_real,true);
		$criteria->compare('val_str',$this->val_str,true);
		$criteria->compare('val_dt',$this->val_dt,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('source_app',$this->source_app,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserAttrib the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
