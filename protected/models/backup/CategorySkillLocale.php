<?php

/**
 * This is the model class for table "{{mst_category_skill_locale}}".
 *
 * The followings are the available columns in table '{{mst_category_skill_locale}}':
 * @property integer $category_id
 * @property string $language_code
 * @property string $skill_id
 * @property string $skill_desc
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $status
 */
class CategorySkillLocale extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mst_skill_locale}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_id, skill_desc', 'required'),
                        array('skill_desc','unique'),
			array('category_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('language_code', 'length', 'max'=>5),
			array('skill_id', 'length', 'max'=>20),
			array('skill_desc', 'length', 'max'=>200),
			array('status', 'length', 'max'=>1),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('category_id, language_code, skill_id, skill_desc, created_at, created_by, updated_at, updated_by, status', 'safe', 'on'=>'search'),
                        array('created_by','default','value'=>Yii::app()->user->id, 'setOnEmpty'=>false,'on'=>'insert'),
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
		'categorySkill' => array(self::HAS_MANY, 'CategorySkill', 'skill_id'),
		'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', 'category_id'),
//                'categorylocale' => array(self::BELONGS_TO, 'CategoryLocale', array('category_id' => 'category_id'), 'through'=>'categorySkill'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'Category',
			'language_code' => 'Language Code',
			'skill_id' => 'Skill',
			'skill_desc' => 'Skill Desc',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'updated_at' => 'Updated At',
			'updated_by' => 'Updated By',
			'status' => 'Status',
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

		$criteria->compare('category_id',$this->category_id);
//		$criteria->compare('language_code',$this->{Globals::FLD_NAME_LANGUAGE_CODE},true);
//		$criteria->compare('skill_id',$this->skill_id,true);
//		$criteria->compare('skill_desc',$this->skill_desc,true);
//		$criteria->compare('created_at',$this->created_at,true);
//		$criteria->compare('created_by',$this->created_by);
//		$criteria->compare('updated_at',$this->updated_at,true);
//		$criteria->compare('updated_by',$this->updated_by);
//		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CategorySkillLocale the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
